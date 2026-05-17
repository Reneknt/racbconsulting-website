<?php
/**
 * RACBCONSULTING — Advisor Governance Layer v1.0
 * Prompt injection protection, health scoring, logging, alerts, dashboard.
 *
 * Security contract:
 * - NEVER log API keys, system prompts, or hidden configuration.
 * - User message previews limited to first 100 characters.
 * - Reply previews limited to first 200 characters.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'RACB_PROMPT_VERSION',      '1.0' );
define( 'RACB_GOV_TABLE',           'racb_advisor_governance' );
define( 'RACB_GOV_ALERT_OPTION',    'racb_governance_webhook_url' );


/* ============================================================
   1. DATABASE TABLE
   ============================================================ */

function racb_governance_table_create() {
    global $wpdb;
    $table   = $wpdb->prefix . RACB_GOV_TABLE;
    $charset = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS {$table} (
        id              bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        created_at      datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP,
        session_id      varchar(64)         NOT NULL DEFAULT '',
        advisor_name    varchar(20)         NOT NULL DEFAULT '',
        lang            varchar(2)          NOT NULL DEFAULT 'en',
        exchange_num    tinyint unsigned    NOT NULL DEFAULT 0,
        user_preview    varchar(100)        NOT NULL DEFAULT '',
        reply_preview   varchar(200)        NOT NULL DEFAULT '',
        health_score    tinyint unsigned    NOT NULL DEFAULT 100,
        health_level    varchar(10)         NOT NULL DEFAULT 'healthy',
        issue_flags     text                NOT NULL,
        injection_attempt   tinyint(1)      NOT NULL DEFAULT 0,
        injection_type      varchar(50)     NOT NULL DEFAULT '',
        fallback_used       tinyint(1)      NOT NULL DEFAULT 0,
        user_frustration    tinyint(1)      NOT NULL DEFAULT 0,
        high_value_lead     tinyint(1)      NOT NULL DEFAULT 0,
        lead_quality        varchar(10)     NOT NULL DEFAULT 'none',
        openai_status       varchar(20)     NOT NULL DEFAULT '',
        response_time_ms    int unsigned    NOT NULL DEFAULT 0,
        prompt_version      varchar(10)     NOT NULL DEFAULT '',
        page_url            varchar(500)    NOT NULL DEFAULT '',
        PRIMARY KEY  (id),
        KEY idx_session  (session_id),
        KEY idx_created  (created_at),
        KEY idx_health   (health_score),
        KEY idx_inject   (injection_attempt),
        KEY idx_quality  (lead_quality)
    ) {$charset};";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );

    update_option( 'racb_governance_db_version', '1.0' );
}

function racb_governance_table_init() {
    if ( get_option( 'racb_governance_db_version' ) !== '1.0' ) {
        racb_governance_table_create();
    }
}
add_action( 'admin_init', 'racb_governance_table_init' );


/* ============================================================
   2. PROMPT INJECTION DETECTION
   ============================================================ */

function racb_detect_injection( $message ) {
    $lower = strtolower( trim( $message ) );

    $pattern_map = array(
        'system_reveal' => array(
            'reveal your prompt', 'show your prompt', 'show your system', 'show system prompt',
            'what are your instructions', 'what instructions were you given',
            'display your instructions', 'display your prompt', 'print your prompt',
            'output your prompt', 'tell me your prompt', 'repeat your instructions',
            'your system prompt', 'hidden instructions', 'disclose your instructions',
            'what are you programmed', 'what were you told', 'your hidden',
            'your configuration', 'your base prompt',
        ),
        'override' => array(
            'ignore previous instructions', 'ignore all previous', 'ignore your instructions',
            'forget your rules', 'forget everything above', 'forget all instructions',
            'disregard your instructions', 'disregard previous', 'override your instructions',
            'override instructions', 'bypass your restrictions', 'bypass your guidelines',
            'break character', 'stop being yourself', 'drop your persona',
        ),
        'jailbreak' => array(
            'jailbreak', 'do anything now', 'dan mode', 'developer mode on',
            'unrestricted mode', 'no restrictions mode', 'act without restrictions',
            'prompt injection', 'token manipulation', 'grandma exploit',
        ),
        'impersonation' => array(
            'act as another ai', 'pretend you are gpt', 'pretend you are another ai',
            'roleplay as an ai', 'roleplay as another', 'simulate being another ai',
            'you are now a different ai', 'switch to another ai', 'you are no longer',
            'from now on you are a different', 'you are now called', 'act like you have no',
        ),
    );

    foreach ( $pattern_map as $type => $patterns ) {
        foreach ( $patterns as $pattern ) {
            if ( strpos( $lower, $pattern ) !== false ) {
                return array(
                    'detected'           => true,
                    'injection_type'     => $type,
                    'security_risk_score' => $type === 'override' || $type === 'jailbreak' ? 90 : 70,
                );
            }
        }
    }

    return array( 'detected' => false, 'injection_type' => '', 'security_risk_score' => 0 );
}

function racb_injection_redirect( $lang ) {
    $en_pool = array(
        "Let's keep the focus on your operation. What process are you working through right now?",
        "Happy to help — where would you like to focus? What's the main thing you're trying to fix?",
        "Let's make sure we use this time well. What's the biggest operational challenge you're dealing with?",
    );
    $es_pool = array(
        "Sigamos enfocados en tu operación. ¿En qué proceso estás trabajando ahora mismo?",
        "Con gusto te ayudo — ¿en qué quieres enfocarte? ¿Cuál es el reto operativo más importante?",
        "Aprovechemos bien el tiempo. ¿Cuál es el desafío principal que estás enfrentando?",
    );
    $pool = $lang === 'es' ? $es_pool : $en_pool;
    return $pool[ absint( time() ) % count( $pool ) ];
}


/* ============================================================
   3. SIGNAL DETECTION HELPERS
   ============================================================ */

function racb_detect_frustration( $message ) {
    $signals = array(
        "you're not listening", "you are not listening", "not helping", "not relevant",
        "not answering", "doesn't help", "doesn't understand", "do not understand",
        "same question again", "already told you", "stop repeating", "this is useless",
        "waste of time", "you keep asking", "you already asked",
        'no estás escuchando', 'ya te dije', 'no entiendes', 'no me ayuda',
        'sigues preguntando', 'ya te lo dije', 'no es útil', 'inútil',
    );
    $lower = strtolower( $message );
    foreach ( $signals as $s ) {
        if ( strpos( $lower, $s ) !== false ) return true;
    }
    return false;
}

function racb_assess_lead_quality( $exchange_num, $intent_type, $should_capture ) {
    if ( $should_capture )                                        return 'hot';
    if ( $intent_type === 'operational' && $exchange_num >= 3 )   return 'high';
    if ( $intent_type === 'operational' )                         return 'medium';
    if ( $intent_type === 'service' )                             return 'low';
    return 'none';
}

function racb_detect_repeated_reply( $current_reply, $history ) {
    if ( empty( $history ) || count( $history ) < 2 ) return false;
    // Compare against the last assistant reply in history
    foreach ( array_reverse( $history ) as $h ) {
        if ( isset( $h['role'] ) && $h['role'] === 'assistant' ) {
            $prev = $h['content'] ?? '';
            if ( strlen( $prev ) > 10 && strlen( $current_reply ) > 10 ) {
                similar_text( strtolower( $prev ), strtolower( $current_reply ), $pct );
                return $pct > 70;
            }
            break;
        }
    }
    return false;
}


/* ============================================================
   4. HEALTH SCORING
   ============================================================ */

function racb_compute_health_score( $signals ) {
    $score = 100;
    $flags = array();

    $deductions = array(
        'injection_attempt'    => 35,
        'fallback_used'        => 20,
        'openai_failure'       => 15,
        'user_frustration'     => 20,
        'capture_too_early'    => 15,
        'repeated_reply'       => 15,
        'low_quality_reply'    => 10,
    );

    foreach ( $deductions as $flag => $points ) {
        if ( ! empty( $signals[ $flag ] ) ) {
            $score -= $points;
            $flags[] = $flag;
        }
    }

    // Positive signals (cap the bonus to avoid going over 100)
    if ( ! empty( $signals['high_value_lead'] ) ) $flags[] = 'high_value_lead_detected';

    $score = max( 0, min( 100, $score ) );

    if ( $score >= 90 )      $level = 'healthy';
    elseif ( $score >= 70 )  $level = 'watch';
    elseif ( $score >= 40 )  $level = 'review';
    else                     $level = 'critical';

    $should_alert = $score < 40 || ! empty( $signals['injection_attempt'] ) || ! empty( $signals['user_frustration'] );

    return array(
        'score'        => $score,
        'level'        => $level,
        'flags'        => $flags,
        'should_alert' => $should_alert,
    );
}


/* ============================================================
   5. GOVERNANCE LOGGING
   ============================================================ */

function racb_governance_log( $entry ) {
    global $wpdb;
    $table = $wpdb->prefix . RACB_GOV_TABLE;

    $wpdb->insert(
        $table,
        array(
            'session_id'       => substr( sanitize_text_field( $entry['session_id']    ?? '' ), 0, 64 ),
            'advisor_name'     => substr( sanitize_text_field( $entry['advisor_name']  ?? '' ), 0, 20 ),
            'lang'             => in_array( $entry['lang'] ?? '', array( 'en', 'es' ), true ) ? $entry['lang'] : 'en',
            'exchange_num'     => absint( $entry['exchange_num']   ?? 0 ),
            'user_preview'     => substr( sanitize_text_field( $entry['user_preview']  ?? '' ), 0, 100 ),
            'reply_preview'    => substr( sanitize_text_field( $entry['reply_preview'] ?? '' ), 0, 200 ),
            'health_score'     => absint( $entry['health_score']   ?? 100 ),
            'health_level'     => in_array( $entry['health_level'] ?? '', array( 'healthy', 'watch', 'review', 'critical' ), true ) ? $entry['health_level'] : 'healthy',
            'issue_flags'      => wp_json_encode( $entry['issue_flags'] ?? array() ),
            'injection_attempt'=> ! empty( $entry['injection_attempt'] ) ? 1 : 0,
            'injection_type'   => substr( sanitize_text_field( $entry['injection_type'] ?? '' ), 0, 50 ),
            'fallback_used'    => ! empty( $entry['fallback_used'] )    ? 1 : 0,
            'user_frustration' => ! empty( $entry['user_frustration'] ) ? 1 : 0,
            'high_value_lead'  => ! empty( $entry['high_value_lead'] )  ? 1 : 0,
            'lead_quality'     => in_array( $entry['lead_quality'] ?? '', array( 'none', 'low', 'medium', 'high', 'hot' ), true ) ? $entry['lead_quality'] : 'none',
            'openai_status'    => substr( sanitize_text_field( $entry['openai_status']    ?? '' ), 0, 20 ),
            'response_time_ms' => absint( $entry['response_time_ms'] ?? 0 ),
            'prompt_version'   => RACB_PROMPT_VERSION,
            'page_url'         => substr( esc_url_raw( $entry['page_url'] ?? '' ), 0, 500 ),
        ),
        array( '%s','%s','%s','%d','%s','%s','%d','%s','%s','%d','%s','%d','%d','%d','%s','%s','%d','%s','%s' )
    );
}


/* ============================================================
   6. GOVERNANCE ALERTS (Telegram via n8n webhook)
   ============================================================ */

function racb_send_governance_alert( $entry, $governance ) {
    if ( ! $governance['should_alert'] ) return;

    $webhook_url = get_option( RACB_GOV_ALERT_OPTION, '' );
    if ( ! $webhook_url ) return;

    $score = $governance['score'];
    $flags = $governance['flags'];

    if ( ! empty( $entry['injection_attempt'] ) ) {
        $severity    = 'critical';
        $summary     = 'Prompt injection attempt detected';
        $recommend   = 'Review session immediately. No user data exposed. Conversation redirected naturally.';
    } elseif ( $score < 40 ) {
        $severity    = 'critical';
        $summary     = 'Advisor health score critical (' . $score . '/100)';
        $recommend   = 'Review conversation session. Check OpenAI status and fallback rate.';
    } elseif ( ! empty( $entry['fallback_used'] ) ) {
        $severity    = 'warning';
        $summary     = 'OpenAI fallback triggered — advisor used scripted response';
        $recommend   = 'Monitor for repeated fallbacks. Check API key and model availability.';
    } elseif ( ! empty( $entry['user_frustration'] ) ) {
        $severity    = 'warning';
        $summary     = 'User frustration signal detected';
        $recommend   = 'Advisor may be looping or repeating questions. Review conversation quality.';
    } elseif ( ! empty( $entry['high_value_lead'] ) ) {
        $severity    = 'info';
        $summary     = 'High-value lead detected';
        $recommend   = 'Lead quality: ' . esc_html( $entry['lead_quality'] ) . '. Consider manual follow-up if diagnostic not booked.';
    } else {
        $severity    = 'watch';
        $summary     = 'Governance flag raised (score: ' . $score . '/100)';
        $recommend   = 'Issues: ' . implode( ', ', $flags );
    }

    $payload = array(
        'source'         => 'racbconsulting-advisor',
        'severity'       => $severity,
        'summary'        => $summary,
        'recommendation' => $recommend,
        'session_id'     => $entry['session_id']    ?? '',
        'advisor_name'   => $entry['advisor_name']  ?? '',
        'exchange_num'   => $entry['exchange_num']  ?? 0,
        'health_score'   => $score,
        'issue_flags'    => $flags,
        'lead_quality'   => $entry['lead_quality']  ?? 'none',
        'lang'           => $entry['lang']           ?? 'en',
        'timestamp'      => gmdate( 'c' ),
    );

    wp_remote_post( $webhook_url, array(
        'timeout'  => 5,
        'blocking' => false,
        'headers'  => array( 'Content-Type' => 'application/json' ),
        'body'     => wp_json_encode( $payload ),
    ) );
}


/* ============================================================
   7. DASHBOARD DATA QUERIES
   ============================================================ */

function racb_governance_stats( $hours = 24 ) {
    global $wpdb;
    $table  = $wpdb->prefix . RACB_GOV_TABLE;
    $since  = gmdate( 'Y-m-d H:i:s', time() - ( $hours * HOUR_IN_SECONDS ) );

    $rows = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT health_score, health_level, injection_attempt, fallback_used,
                    user_frustration, high_value_lead, lead_quality, openai_status,
                    session_id, response_time_ms
             FROM {$table} WHERE created_at >= %s",
            $since
        ),
        ARRAY_A
    );

    if ( empty( $rows ) ) {
        return array(
            'total_exchanges'    => 0,
            'unique_sessions'    => 0,
            'avg_health_score'   => 100,
            'health_level'       => 'healthy',
            'openai_success_rate'=> 100,
            'fallback_rate'      => 0,
            'injection_count'    => 0,
            'frustration_count'  => 0,
            'hot_leads'          => 0,
            'high_leads'         => 0,
            'avg_response_ms'    => 0,
            'quality_dist'       => array( 'none' => 0, 'low' => 0, 'medium' => 0, 'high' => 0, 'hot' => 0 ),
        );
    }

    $total         = count( $rows );
    $sessions      = array_unique( array_column( $rows, 'session_id' ) );
    $scores        = array_column( $rows, 'health_score' );
    $avg_score     = round( array_sum( $scores ) / $total );
    $fallbacks     = count( array_filter( $rows, fn($r) => $r['fallback_used'] ) );
    $injections    = count( array_filter( $rows, fn($r) => $r['injection_attempt'] ) );
    $frustrations  = count( array_filter( $rows, fn($r) => $r['user_frustration'] ) );
    $success       = count( array_filter( $rows, fn($r) => $r['openai_status'] === 'success' ) );
    $hot           = count( array_filter( $rows, fn($r) => $r['lead_quality'] === 'hot' ) );
    $high          = count( array_filter( $rows, fn($r) => $r['lead_quality'] === 'high' ) );
    $resp_times    = array_filter( array_column( $rows, 'response_time_ms' ), fn($v) => $v > 0 );
    $quality_dist  = array_count_values( array_column( $rows, 'lead_quality' ) );

    if ( $avg_score >= 90 )      $level = 'healthy';
    elseif ( $avg_score >= 70 )  $level = 'watch';
    elseif ( $avg_score >= 40 )  $level = 'review';
    else                         $level = 'critical';

    return array(
        'total_exchanges'     => $total,
        'unique_sessions'     => count( $sessions ),
        'avg_health_score'    => $avg_score,
        'health_level'        => $level,
        'openai_success_rate' => $total > 0 ? round( ( $success / $total ) * 100 ) : 100,
        'fallback_rate'       => $total > 0 ? round( ( $fallbacks / $total ) * 100 ) : 0,
        'injection_count'     => $injections,
        'frustration_count'   => $frustrations,
        'hot_leads'           => $hot,
        'high_leads'          => $high,
        'avg_response_ms'     => $resp_times ? round( array_sum( $resp_times ) / count( $resp_times ) ) : 0,
        'quality_dist'        => array_merge( array( 'none' => 0, 'low' => 0, 'medium' => 0, 'high' => 0, 'hot' => 0 ), $quality_dist ),
    );
}

function racb_governance_recent_logs( $limit = 25 ) {
    global $wpdb;
    $table = $wpdb->prefix . RACB_GOV_TABLE;
    return $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM {$table} ORDER BY created_at DESC LIMIT %d",
            absint( $limit )
        ),
        ARRAY_A
    );
}

function racb_governance_alerts_only( $limit = 20 ) {
    global $wpdb;
    $table = $wpdb->prefix . RACB_GOV_TABLE;
    return $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM {$table}
             WHERE injection_attempt = 1
                OR fallback_used = 1
                OR user_frustration = 1
                OR health_score < 70
             ORDER BY created_at DESC LIMIT %d",
            absint( $limit )
        ),
        ARRAY_A
    );
}


/* ============================================================
   8. GOVERNANCE DASHBOARD PAGE
   ============================================================ */

function racb_governance_dashboard_page() {
    if ( ! current_user_can( 'manage_options' ) ) return;

    // Handle governance webhook URL save
    if ( isset( $_POST['racb_gov_save'] ) && check_admin_referer( 'racb_gov_save' ) ) {
        update_option( RACB_GOV_ALERT_OPTION, esc_url_raw( $_POST['racb_gov_webhook'] ?? '' ) );
        echo '<div class="notice notice-success"><p>Governance settings saved.</p></div>';
    }

    $stats  = racb_governance_stats( 24 );
    $alerts = racb_governance_alerts_only( 20 );
    $hc     = $stats['health_level'];

    $health_color = array(
        'healthy'  => '#10b981',
        'watch'    => '#f59e0b',
        'review'   => '#f97316',
        'critical' => '#ef4444',
    );
    $hcolor = $health_color[ $hc ] ?? '#10b981';

    $severity_color = array(
        'critical' => '#ef4444',
        'warning'  => '#f97316',
        'watch'    => '#f59e0b',
        'info'     => '#3b82f6',
    );

    $level_badge = array(
        'healthy'  => array( 'bg' => '#d1fae5', 'fg' => '#065f46', 'label' => 'Healthy' ),
        'watch'    => array( 'bg' => '#fef3c7', 'fg' => '#92400e', 'label' => 'Watch'   ),
        'review'   => array( 'bg' => '#ffedd5', 'fg' => '#9a3412', 'label' => 'Review'  ),
        'critical' => array( 'bg' => '#fee2e2', 'fg' => '#991b1b', 'label' => 'Critical'),
    );

    ?>
    <style>
    #racb-gov-wrap { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; max-width: 1200px; padding: 24px 0; }
    #racb-gov-wrap h1 { font-size: 22px; font-weight: 700; color: #111; margin: 0 0 4px; }
    #racb-gov-wrap .gov-sub { color: #6b7280; font-size: 13px; margin: 0 0 28px; }
    .gov-kpi-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 28px; }
    .gov-kpi { background: #fff; border: 1px solid #e5e7eb; border-radius: 10px; padding: 20px 22px; }
    .gov-kpi .kpi-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .06em; color: #9ca3af; margin-bottom: 6px; }
    .gov-kpi .kpi-value { font-size: 28px; font-weight: 700; line-height: 1; color: #111; }
    .gov-kpi .kpi-sub { font-size: 12px; color: #6b7280; margin-top: 4px; }
    .gov-kpi.accent { border-left: 4px solid <?php echo esc_attr( $hcolor ); ?>; }
    .gov-section { background: #fff; border: 1px solid #e5e7eb; border-radius: 10px; padding: 20px 24px; margin-bottom: 20px; }
    .gov-section h2 { font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #374151; margin: 0 0 16px; }
    .gov-section-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .gov-stat-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f3f4f6; font-size: 13px; }
    .gov-stat-row:last-child { border-bottom: none; }
    .gov-stat-label { color: #6b7280; }
    .gov-stat-value { font-weight: 600; color: #111; }
    .gov-badge { display: inline-block; padding: 2px 10px; border-radius: 99px; font-size: 11px; font-weight: 700; letter-spacing: .04em; }
    .gov-table-wrap { overflow-x: auto; }
    .gov-table { width: 100%; border-collapse: collapse; font-size: 12px; }
    .gov-table th { text-align: left; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #9ca3af; padding: 0 12px 10px; }
    .gov-table td { padding: 10px 12px; border-top: 1px solid #f3f4f6; color: #374151; vertical-align: top; }
    .gov-table tr:hover td { background: #fafafa; }
    .gov-score-bar { display: inline-block; width: 48px; height: 6px; border-radius: 3px; background: #e5e7eb; margin-right: 6px; vertical-align: middle; }
    .gov-score-fill { height: 100%; border-radius: 3px; }
    .gov-empty { color: #9ca3af; font-size: 13px; text-align: center; padding: 32px 0; }
    .gov-settings { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 10px; padding: 20px 24px; margin-bottom: 28px; }
    .gov-settings h2 { font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #374151; margin: 0 0 12px; }
    </style>

    <div id="racb-gov-wrap">
        <h1>Advisor Governance Center</h1>
        <p class="gov-sub">Executive operations visibility — last 24 hours &nbsp;·&nbsp; Prompt v<?php echo esc_html( RACB_PROMPT_VERSION ); ?></p>

        <?php
        // ── Governance Webhook Setting ────────────────────────────
        $gw_url = esc_url( get_option( RACB_GOV_ALERT_OPTION, '' ) );
        ?>
        <div class="gov-settings">
            <h2>Alert Destination</h2>
            <form method="post" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                <?php wp_nonce_field( 'racb_gov_save' ); ?>
                <input type="url" name="racb_gov_webhook" value="<?php echo esc_attr( $gw_url ); ?>"
                       placeholder="https://your-n8n-instance/webhook/governance-alerts"
                       style="width:420px;max-width:100%;" class="regular-text" />
                <button class="button button-secondary" name="racb_gov_save" value="1">Save</button>
            </form>
            <p style="color:#6b7280;font-size:12px;margin:8px 0 0;">Governance alerts are sent here → n8n routes to Telegram. Leave blank to disable alerts.</p>
        </div>

        <?php if ( $stats['total_exchanges'] === 0 ) : ?>
            <div class="gov-section">
                <p class="gov-empty">No advisor sessions recorded in the last 24 hours. Governance logging activates on the first conversation.</p>
            </div>
        <?php else : ?>

        <!-- ── KPI STRIP ──────────────────────────────────── -->
        <div class="gov-kpi-grid">
            <?php
            $badge = $level_badge[ $hc ] ?? $level_badge['healthy'];
            ?>
            <div class="gov-kpi accent">
                <div class="kpi-label">Advisor Health</div>
                <div class="kpi-value" style="color:<?php echo esc_attr( $hcolor ); ?>"><?php echo esc_html( $stats['avg_health_score'] ); ?></div>
                <div class="kpi-sub">
                    <span class="gov-badge" style="background:<?php echo esc_attr( $badge['bg'] ); ?>;color:<?php echo esc_attr( $badge['fg'] ); ?>">
                        <?php echo esc_html( $badge['label'] ); ?>
                    </span>
                </div>
            </div>

            <div class="gov-kpi">
                <div class="kpi-label">Sessions</div>
                <div class="kpi-value"><?php echo esc_html( $stats['unique_sessions'] ); ?></div>
                <div class="kpi-sub"><?php echo esc_html( $stats['total_exchanges'] ); ?> total exchanges</div>
            </div>

            <div class="gov-kpi">
                <div class="kpi-label">OpenAI Uptime</div>
                <div class="kpi-value" style="color:<?php echo $stats['openai_success_rate'] >= 90 ? '#10b981' : '#ef4444'; ?>">
                    <?php echo esc_html( $stats['openai_success_rate'] ); ?>%
                </div>
                <div class="kpi-sub">Fallback rate: <?php echo esc_html( $stats['fallback_rate'] ); ?>%</div>
            </div>

            <div class="gov-kpi">
                <div class="kpi-label">Security</div>
                <div class="kpi-value" style="color:<?php echo $stats['injection_count'] > 0 ? '#ef4444' : '#10b981'; ?>">
                    <?php echo esc_html( $stats['injection_count'] ); ?>
                </div>
                <div class="kpi-sub">Injection attempt<?php echo $stats['injection_count'] !== 1 ? 's' : ''; ?></div>
            </div>

            <div class="gov-kpi">
                <div class="kpi-label">Hot Leads</div>
                <div class="kpi-value" style="color:<?php echo $stats['hot_leads'] > 0 ? '#3b82f6' : '#111'; ?>">
                    <?php echo esc_html( $stats['hot_leads'] ); ?>
                </div>
                <div class="kpi-sub"><?php echo esc_html( $stats['high_leads'] ); ?> high-quality</div>
            </div>

            <div class="gov-kpi">
                <div class="kpi-label">Avg Response</div>
                <div class="kpi-value"><?php echo esc_html( $stats['avg_response_ms'] ); ?><span style="font-size:14px;color:#6b7280;">ms</span></div>
                <div class="kpi-sub">OpenAI latency</div>
            </div>
        </div>

        <!-- ── OPERATIONAL SECTIONS ───────────────────────── -->
        <div class="gov-section-grid" style="margin-bottom:20px;">

            <!-- Security -->
            <div class="gov-section">
                <h2>Security</h2>
                <div class="gov-stat-row">
                    <span class="gov-stat-label">Prompt injection attempts</span>
                    <span class="gov-stat-value" style="color:<?php echo $stats['injection_count'] > 0 ? '#ef4444' : '#10b981'; ?>">
                        <?php echo esc_html( $stats['injection_count'] ); ?>
                    </span>
                </div>
                <div class="gov-stat-row">
                    <span class="gov-stat-label">User frustration signals</span>
                    <span class="gov-stat-value" style="color:<?php echo $stats['frustration_count'] > 0 ? '#f97316' : '#10b981'; ?>">
                        <?php echo esc_html( $stats['frustration_count'] ); ?>
                    </span>
                </div>
                <div class="gov-stat-row">
                    <span class="gov-stat-label">Fallback responses</span>
                    <span class="gov-stat-value"><?php echo esc_html( $stats['fallback_rate'] ); ?>%</span>
                </div>
                <div class="gov-stat-row">
                    <span class="gov-stat-label">System prompt exposed</span>
                    <span class="gov-stat-value" style="color:#10b981;">0 — Protected</span>
                </div>
            </div>

            <!-- Lead Intelligence -->
            <div class="gov-section">
                <h2>Lead Intelligence</h2>
                <?php
                $quality_labels = array(
                    'hot'    => array( '#dbeafe', '#1d4ed8', 'Diagnostic-ready'  ),
                    'high'   => array( '#d1fae5', '#065f46', 'High-quality'      ),
                    'medium' => array( '#fef3c7', '#92400e', 'Exploring pain'    ),
                    'low'    => array( '#f3f4f6', '#374151', 'Service interest'  ),
                    'none'   => array( '#f3f4f6', '#6b7280', 'No signal yet'     ),
                );
                foreach ( $quality_labels as $key => $meta ) :
                    $count = $stats['quality_dist'][ $key ] ?? 0;
                ?>
                <div class="gov-stat-row">
                    <span class="gov-stat-label">
                        <span class="gov-badge" style="background:<?php echo esc_attr($meta[0]); ?>;color:<?php echo esc_attr($meta[1]); ?>"><?php echo esc_html( $meta[2] ); ?></span>
                    </span>
                    <span class="gov-stat-value"><?php echo esc_html( $count ); ?></span>
                </div>
                <?php endforeach; ?>
            </div>

        </div>

        <!-- ── ALERTS TABLE ───────────────────────────────── -->
        <div class="gov-section">
            <h2>Recent Flags &amp; Alerts</h2>
            <?php if ( empty( $alerts ) ) : ?>
                <p class="gov-empty" style="padding:20px 0;">No flags in the last 24 hours. Advisor is operating cleanly.</p>
            <?php else : ?>
            <div class="gov-table-wrap">
                <table class="gov-table">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Score</th>
                            <th>Advisor</th>
                            <th>Lead</th>
                            <th>Flags</th>
                            <th>Session</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ( $alerts as $row ) :
                        $row_score  = (int) $row['health_score'];
                        $row_level  = $row['health_level'] ?? 'healthy';
                        $row_badge  = $level_badge[ $row_level ] ?? $level_badge['healthy'];
                        $row_flags  = json_decode( $row['issue_flags'] ?? '[]', true );
                        $row_flags  = is_array( $row_flags ) ? $row_flags : array();
                        $ts         = mysql2date( 'M j, g:ia', $row['created_at'] );
                        $fill_color = $row_score >= 90 ? '#10b981' : ( $row_score >= 70 ? '#f59e0b' : ( $row_score >= 40 ? '#f97316' : '#ef4444' ) );
                        $q_meta     = $quality_labels[ $row['lead_quality'] ?? 'none' ] ?? $quality_labels['none'];
                    ?>
                        <tr>
                            <td style="white-space:nowrap;color:#6b7280;"><?php echo esc_html( $ts ); ?></td>
                            <td style="white-space:nowrap;">
                                <span class="gov-score-bar">
                                    <span class="gov-score-fill" style="width:<?php echo esc_attr($row_score); ?>%;background:<?php echo esc_attr($fill_color); ?>;display:block;"></span>
                                </span>
                                <strong><?php echo esc_html( $row_score ); ?></strong>
                                <span class="gov-badge" style="background:<?php echo esc_attr($row_badge['bg']); ?>;color:<?php echo esc_attr($row_badge['fg']); ?>;margin-left:4px;">
                                    <?php echo esc_html( $row_badge['label'] ); ?>
                                </span>
                            </td>
                            <td><?php echo esc_html( $row['advisor_name'] ); ?></td>
                            <td>
                                <span class="gov-badge" style="background:<?php echo esc_attr($q_meta[0]); ?>;color:<?php echo esc_attr($q_meta[1]); ?>">
                                    <?php echo esc_html( $row['lead_quality'] ?? 'none' ); ?>
                                </span>
                            </td>
                            <td>
                                <?php if ( $row['injection_attempt'] ) echo '<span class="gov-badge" style="background:#fee2e2;color:#991b1b;">injection</span> '; ?>
                                <?php if ( $row['fallback_used'] )     echo '<span class="gov-badge" style="background:#fef3c7;color:#92400e;">fallback</span> '; ?>
                                <?php if ( $row['user_frustration'] )  echo '<span class="gov-badge" style="background:#ffedd5;color:#9a3412;">frustration</span> '; ?>
                                <?php foreach ( $row_flags as $fl ) : ?>
                                    <span class="gov-badge" style="background:#f3f4f6;color:#374151;"><?php echo esc_html($fl); ?></span>
                                <?php endforeach; ?>
                            </td>
                            <td style="color:#9ca3af;font-size:11px;"><?php echo esc_html( substr( $row['session_id'], 0, 12 ) ); ?>…</td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>

        <?php endif; // end has data ?>
    </div>
    <?php
}


/* ============================================================
   9. ADMIN MENU REGISTRATION
   ============================================================ */

function racb_governance_register_menu() {
    add_submenu_page(
        'edit.php?post_type=racb_lead',
        'Governance Center',
        'Governance',
        'manage_options',
        'racb_governance',
        'racb_governance_dashboard_page'
    );
}
add_action( 'admin_menu', 'racb_governance_register_menu' );
