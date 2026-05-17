<?php
/**
 * RACBCONSULTING — functions.php
 * Theme setup, asset loading, custom post types, widgets
 */

if ( ! defined( 'ABSPATH' ) ) exit;

require_once get_template_directory() . '/includes/racb-governance.php';

/* ============================================================
   1. THEME SETUP
   ============================================================ */
function racb_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'gallery', 'caption' ] );
    add_theme_support( 'custom-logo', [
        'height'      => 132,
        'width'       => 267,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    load_theme_textdomain( 'racbconsulting', get_template_directory() . '/languages' );

    register_nav_menus([
        'primary' => __( 'Menú Principal', 'racbconsulting' ),
        'footer'  => __( 'Menú Footer',    'racbconsulting' ),
    ]);
}
add_action( 'after_setup_theme', 'racb_theme_setup' );


/* ============================================================
   2. ENQUEUE STYLES & SCRIPTS
   ============================================================ */
function racb_enqueue_assets() {
  $theme_uri = get_template_directory_uri();
  $theme_dir = get_template_directory();

  // Main stylesheet (cache-busted)
  $style_path = $theme_dir . '/style.css';
  $style_ver  = file_exists($style_path) ? filemtime($style_path) : wp_get_theme()->get('Version');
  wp_enqueue_style('racb-style', $theme_uri . '/style.css', array(), $style_ver);

  // Google Fonts for theme typography
  wp_enqueue_style(
    'racb-fonts',
    'https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Playfair+Display:wght@700;900&display=swap',
    array(),
    null
  );

  // Main JS (cache-busted, loaded in footer)
  $js_path = $theme_dir . '/assets/racb-main.js';
  $js_ver  = file_exists($js_path) ? filemtime($js_path) : wp_get_theme()->get('Version');
  wp_enqueue_script('racb-main', $theme_uri . '/assets/racb-main.js', array(), $js_ver, true);
  wp_localize_script('racb-main', 'racbAjax', array(
    'ajax_url' => admin_url('admin-ajax.php'),
    'nonce'    => wp_create_nonce('racb_nonce'),
  ));
}
add_action('wp_enqueue_scripts', 'racb_enqueue_assets');

/**
 * Add defer to our main JS for better performance.
 */
function racb_defer_scripts($tag, $handle, $src) {
  if ($handle === 'racb-main') {
    // Keep type attribute default, add defer.
    return '<script src="' . esc_url($src) . '" defer></script>';
  }
  return $tag;
}
add_filter('script_loader_tag', 'racb_defer_scripts', 10, 3);

/**
 * Resource hints: preconnect for Google Fonts.
 */
function racb_resource_hints($hints, $relation_type) {
  if ($relation_type === 'preconnect') {
    $hints[] = 'https://fonts.googleapis.com';
    $hints[] = 'https://fonts.gstatic.com';
  }
  return $hints;
}
add_filter('wp_resource_hints', 'racb_resource_hints', 10, 2);



/* ============================================================
   3. CUSTOM POST TYPE — Casos de Éxito
   ============================================================ */
function racb_register_cpt() {
    // Casos de Éxito
    register_post_type( 'casos_exito', [
        'labels' => [
            'name'          => __( 'Casos de Éxito', 'racbconsulting' ),
            'singular_name' => __( 'Caso de Éxito',  'racbconsulting' ),
            'add_new_item'  => __( 'Añadir Caso',    'racbconsulting' ),
            'edit_item'     => __( 'Editar Caso',     'racbconsulting' ),
        ],
        'public'       => true,
        'has_archive'  => true,
        'menu_icon'    => 'dashicons-awards',
        'menu_position'=> 5,
        'supports'     => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
        'rewrite'      => [ 'slug' => 'casos-de-exito' ],
        'show_in_rest' => true,
    ]);

    // Taxonomía: Industria
    register_taxonomy( 'industria', 'casos_exito', [
        'labels' => [
            'name'          => __( 'Industrias',  'racbconsulting' ),
            'singular_name' => __( 'Industria',   'racbconsulting' ),
        ],
        'hierarchical'  => true,
        'public'        => true,
        'rewrite'       => [ 'slug' => 'industria' ],
        'show_in_rest'  => true,
    ]);

    // Servicios CPT (opcional — para páginas de servicios dinámicas)
    register_post_type( 'servicio', [
        'labels' => [
            'name'          => __( 'Servicios',  'racbconsulting' ),
            'singular_name' => __( 'Servicio',   'racbconsulting' ),
        ],
        'public'        => true,
        'has_archive'   => false,
        'menu_icon'     => 'dashicons-hammer',
        'menu_position' => 6,
        'supports'      => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
        'rewrite'       => [ 'slug' => 'servicios' ],
        'show_in_rest'  => true,
    ]);
}
add_action( 'init', 'racb_register_cpt' );


/* ============================================================
   4. THEME OPTIONS PAGE (contacto, redes sociales, WhatsApp)
   ============================================================ */
function racb_add_options_page() {
    add_menu_page(
        'RACB Ajustes',
        'RACB Ajustes',
        'manage_options',
        'racb-options',
        'racb_options_page_html',
        'dashicons-admin-site-alt3',
        80
    );
}
add_action( 'admin_menu', 'racb_add_options_page' );

function racb_options_page_html() {
    if ( ! current_user_can( 'manage_options' ) ) return;
    if ( isset( $_POST['racb_save_options'] ) ) {
        check_admin_referer( 'racb_options_save' );
        $fields = [
            'racb_phone', 'racb_whatsapp', 'racb_email', 'racb_calendly',
            'racb_linkedin', 'racb_x', 'racb_youtube', 'racb_instagram',
            'racb_tiktok', 'racb_threads',
        ];
        foreach ( $fields as $field ) {
            update_option( $field, sanitize_text_field( $_POST[ $field ] ?? '' ) );
        }
        echo '<div class="notice notice-success"><p>✅ Opciones guardadas.</p></div>';
    }
    ?>
    <div class="wrap">
        <h1>⚙️ RACBCONSULTING — Ajustes del Sitio</h1>
        <form method="post">
            <?php wp_nonce_field( 'racb_options_save' ); ?>
            <table class="form-table">
                <tr><th>Teléfono / WhatsApp número</th>
                    <td><input type="text" name="racb_phone" value="<?php echo esc_attr(get_option('racb_phone')); ?>" class="regular-text" placeholder="+52 55 1234 5678"></td></tr>
                <tr><th>WhatsApp link (wa.me/...)</th>
                    <td><input type="text" name="racb_whatsapp" value="<?php echo esc_attr(get_option('racb_whatsapp')); ?>" class="regular-text" placeholder="https://wa.me/521234567890"></td></tr>
                <tr><th>Email de contacto</th>
                    <td><input type="email" name="racb_email" value="<?php echo esc_attr(get_option('racb_email', 'hello@racbconsulting.com')); ?>" class="regular-text"></td></tr>
                <tr><th>URL Calendly</th>
                    <td><input type="url" name="racb_calendly" value="<?php echo esc_attr(get_option('racb_calendly')); ?>" class="regular-text" placeholder="https://calendly.com/racbconsulting"></td></tr>
                <tr><th colspan="2"><hr><h3>Redes Sociales</h3></th></tr>
                <tr><th>LinkedIn URL</th>
                    <td><input type="url" name="racb_linkedin" value="<?php echo esc_attr(get_option('racb_linkedin')); ?>" class="regular-text" placeholder="https://linkedin.com/company/racbconsulting"></td></tr>
                <tr><th>X / Twitter URL</th>
                    <td><input type="url" name="racb_x" value="<?php echo esc_attr(get_option('racb_x')); ?>" class="regular-text" placeholder="https://x.com/racbconsulting"></td></tr>
                <tr><th>YouTube URL</th>
                    <td><input type="url" name="racb_youtube" value="<?php echo esc_attr(get_option('racb_youtube')); ?>" class="regular-text" placeholder="https://youtube.com/@racbconsulting"></td></tr>
                <tr><th>Instagram URL</th>
                    <td><input type="url" name="racb_instagram" value="<?php echo esc_attr(get_option('racb_instagram')); ?>" class="regular-text" placeholder="https://instagram.com/racbconsulting"></td></tr>
                <tr><th>TikTok URL</th>
                    <td><input type="url" name="racb_tiktok" value="<?php echo esc_attr(get_option('racb_tiktok')); ?>" class="regular-text" placeholder="https://tiktok.com/@racbconsulting"></td></tr>
                <tr><th>Threads URL</th>
                    <td><input type="url" name="racb_threads" value="<?php echo esc_attr(get_option('racb_threads')); ?>" class="regular-text" placeholder="https://threads.net/@racbconsulting"></td></tr>
            </table>
            <p><input type="submit" name="racb_save_options" class="button button-primary button-large" value="💾 Guardar Cambios"></p>
        </form>
    </div>
    <?php
}


/* ============================================================
   5. SCHEMA.ORG — LocalBusiness + ProfessionalService
   ============================================================ */
function racb_schema_markup() {
    if ( ! is_front_page() && ! is_home() ) return;
    $schema = [
        '@context'    => 'https://schema.org',
        '@type'       => [ 'ProfessionalService', 'LocalBusiness' ],
        'name'        => 'RACBCONSULTING',
        'description' => 'Soluciones de Inteligencia Artificial para PYMEs y profesionales. Chatbots GPT, automatización de procesos y desarrollo web con IA.',
        'url'         => get_site_url(),
        'logo'        => get_template_directory_uri() . '/assets/logo.png',
        'email'       => get_option( 'racb_email', 'hello@racbconsulting.com' ),
        'telephone'   => get_option( 'racb_phone', '' ),
        'areaServed'  => 'Latinoamérica',
        'serviceType' => [ 'Consultoría IA', 'Chatbots GPT', 'Automatización de Procesos', 'Desarrollo Web con IA' ],
        'sameAs'      => array_filter([
            get_option('racb_linkedin'),
            get_option('racb_x'),
            get_option('racb_youtube'),
            get_option('racb_instagram'),
        ]),
    ];
    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
add_action( 'wp_head', 'racb_schema_markup' );



/* ============================================================
   6. MINI-CRM — Leads (Custom Post Type)
   ============================================================ */
function racb_register_lead_cpt() {
    $labels = [
        'name'               => 'Leads',
        'singular_name'      => 'Lead',
        'menu_name'          => 'Leads',
        'add_new'            => 'Añadir lead',
        'add_new_item'       => 'Añadir nuevo lead',
        'edit_item'          => 'Editar lead',
        'new_item'           => 'Nuevo lead',
        'view_item'          => 'Ver lead',
        'search_items'       => 'Buscar leads',
        'not_found'          => 'No se encontraron leads',
        'not_found_in_trash' => 'No hay leads en la papelera',
    ];

    register_post_type('racb_lead', [
        'labels'             => $labels,
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-id-alt',
        'supports'           => [ 'title', 'editor' ],
        'capability_type'    => 'post',
        'map_meta_cap'       => true,
    ]);
}
add_action('init', 'racb_register_lead_cpt');


// ===== RACB LEADS: STATUS + SERVICES TAXONOMIES =====
function racb_register_lead_taxonomies() {
    // Status pipeline
    register_taxonomy('racb_lead_status', array('racb_lead'), array(
        'labels' => array(
            'name' => 'Lead Status',
            'singular_name' => 'Lead Status',
        ),
        'public' => false,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => false,
        'show_tagcloud' => false,
        'hierarchical' => false,
        'rewrite' => false,
    ));

    // Service tags
    register_taxonomy('racb_lead_service', array('racb_lead'), array(
        'labels' => array(
            'name' => 'Services',
            'singular_name' => 'Service',
        ),
        'public' => false,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => false,
        'show_tagcloud' => true,
        'hierarchical' => false,
        'rewrite' => false,
    ));
}
add_action('init', 'racb_register_lead_taxonomies', 20);

// Create default pipeline terms (idempotent)
function racb_seed_lead_status_terms() {
    if ( ! taxonomy_exists('racb_lead_status') ) return;

    $defaults = array(
        'new'        => 'New',
        'contacted'  => 'Contacted',
        'qualified'  => 'Qualified',
        'proposal'   => 'Proposal Sent',
        'won'        => 'Won',
        'lost'       => 'Lost',
    );

    foreach ($defaults as $slug => $name) {
        if ( ! term_exists($slug, 'racb_lead_status') ) {
            wp_insert_term($name, 'racb_lead_status', array('slug' => $slug));
        }
    }
}
add_action('init', 'racb_seed_lead_status_terms', 30);

// Ensure every lead has a status (default: New)
function racb_default_lead_status($post_id, $post, $update) {
    if ( wp_is_post_revision($post_id) || defined('DOING_AUTOSAVE') ) return;
    if ( $post->post_type !== 'racb_lead' ) return;

    $terms = wp_get_post_terms($post_id, 'racb_lead_status', array('fields' => 'ids'));
    if ( empty($terms) ) {
        $t = term_exists('new', 'racb_lead_status');
        if ($t && ! is_wp_error($t)) {
            wp_set_post_terms($post_id, array(intval($t['term_id'])), 'racb_lead_status', false);
        }
    }
}
add_action('save_post', 'racb_default_lead_status', 10, 3);



function racb_lead_columns($cols) {
    $new = [];
    $new['cb'] = $cols['cb'] ?? '';
    $new['title'] = 'Lead';
    $new['racb_email'] = 'Email';
    $new['racb_phone'] = 'Phone';
    $new['racb_company'] = 'Company';
    $new['racb_service'] = 'Service';
    $new['racb_status'] = 'Status';
    $new['racb_form'] = 'Form';
    $new['date'] = $cols['date'] ?? 'Date';
    return $new;
}
add_filter('manage_racb_lead_posts_columns', 'racb_lead_columns');

function racb_lead_column_content($col, $post_id) {
    if ($col === 'racb_email') {
        $email = get_post_meta($post_id, 'email', true);
        if ($email) echo '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>';
    }
    if ($col === 'racb_phone')   echo esc_html(get_post_meta($post_id, 'phone', true));
    if ($col === 'racb_company') echo esc_html(get_post_meta($post_id, 'company', true));

    if ($col === 'racb_service') {
        $terms = get_the_terms($post_id, 'racb_lead_service');
        if ($terms && ! is_wp_error($terms)) {
            echo esc_html(join(', ', wp_list_pluck($terms, 'name')));
        } else {
            echo esc_html(get_post_meta($post_id, 'service', true));
        }
    }

    if ($col === 'racb_status') {
        $terms = get_the_terms($post_id, 'racb_lead_status');
        if ($terms && ! is_wp_error($terms)) echo esc_html($terms[0]->name);
    }

    if ($col === 'racb_form')    echo esc_html(get_post_meta($post_id, 'form_type', true));
}
add_action('manage_racb_lead_posts_custom_column', 'racb_lead_column_content', 10, 2);


/* Admin filters for Lead Status / Service */
function racb_lead_filters() {
    global $typenow;
    if ($typenow !== 'racb_lead') return;

    foreach (array(
        'racb_lead_status' => 'All statuses',
        'racb_lead_service' => 'All services',
    ) as $tax => $label) {
        $selected = isset($_GET[$tax]) ? sanitize_text_field($_GET[$tax]) : '';
        wp_dropdown_categories(array(
            'show_option_all' => $label,
            'taxonomy' => $tax,
            'name' => $tax,
            'orderby' => 'name',
            'selected' => $selected,
            'hierarchical' => false,
            'show_count' => false,
            'hide_empty' => false,
            'value_field' => 'slug',
        ));
    }
}
add_action('restrict_manage_posts', 'racb_lead_filters');

function racb_lead_filter_query($query) {
    global $pagenow;
    if (!is_admin() || $pagenow !== 'edit.php') return;
    if (empty($query->query['post_type']) || $query->query['post_type'] !== 'racb_lead') return;

    foreach (array('racb_lead_status', 'racb_lead_service') as $tax) {
        if (!empty($_GET[$tax])) {
            $query->query_vars[$tax] = sanitize_text_field($_GET[$tax]);
        }
    }
}
add_action('pre_get_posts', 'racb_lead_filter_query');


/* Meta box simple para ver datos extra */
function racb_lead_meta_box() {
    add_meta_box('racb_lead_meta', 'Detalles del lead', 'racb_render_lead_meta', 'racb_lead', 'side', 'high');
}
add_action('add_meta_boxes', 'racb_lead_meta_box');

function racb_render_lead_meta($post) {
    $fields = [
        'email' => 'Email',
        'company' => 'Empresa',
        'phone' => 'Teléfono',
        'service' => 'Servicio',
        'form_type' => 'Formulario',
        'lang' => 'Idioma',
        'page' => 'Página',
        'utm_source' => 'UTM Source',
        'utm_medium' => 'UTM Medium',
        'utm_campaign' => 'UTM Campaign',
        'user_agent' => 'User-Agent',
    ];
    echo '<div style="font-size:12px; line-height:1.4;">';
    foreach ($fields as $k => $label) {
        $v = get_post_meta($post->ID, $k, true);
        if (!empty($v)) {
            echo '<p style="margin:0 0 8px;"><strong>' . esc_html($label) . ':</strong><br>' . esc_html($v) . '</p>';
        }
    }
    echo '</div>';
}

/* ============================================================
   6. AJAX — Contact Form Handler
   ============================================================ */
function racb_handle_contact_form() {
    check_ajax_referer( 'racb_nonce', 'nonce' );

    // Basic rate limit (per IP)
    $ip = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field($_SERVER['REMOTE_ADDR']) : 'unknown';
    $rate_key = 'racb_lead_rl_' . md5($ip);
    $count = (int) get_transient($rate_key);
    if ($count > 12) {
        wp_send_json_error([ 'message' => 'Demasiadas solicitudes. Intenta en unos minutos.' ]);
    }
    set_transient($rate_key, $count + 1, 15 * MINUTE_IN_SECONDS);

    $name    = sanitize_text_field( $_POST['name'] ?? '' );
    $email   = sanitize_email( $_POST['email'] ?? '' );
    $company = sanitize_text_field( $_POST['company'] ?? '' );
    $phone   = sanitize_text_field( $_POST['phone'] ?? '' );
    $service = sanitize_text_field( $_POST['service'] ?? '' );
    $message = sanitize_textarea_field( $_POST['message'] ?? '' );

    // Optional fields
    $form_type = sanitize_text_field( $_POST['form_type'] ?? 'contact' );
    $page      = sanitize_text_field( $_POST['page'] ?? '' );
    $lang      = sanitize_text_field( $_POST['lang'] ?? '' );
    $utm_source   = sanitize_text_field( $_POST['utm_source'] ?? '' );
    $utm_medium   = sanitize_text_field( $_POST['utm_medium'] ?? '' );
    $utm_campaign = sanitize_text_field( $_POST['utm_campaign'] ?? '' );

    // Honeypot (bots usually fill it)
    $hp = sanitize_text_field( $_POST['website'] ?? '' );
    if ( ! empty($hp) ) {
        wp_send_json_success([ 'message' => 'OK' ]);
    }

    if ( empty($name) || empty($email) || empty($message) || ! is_email($email) ) {
        wp_send_json_error( [ 'message' => 'Datos incompletos o email inválido.' ] );
    }

    // --- Save to mini-CRM (Lead CPT) ---
    $title = $name . ' — ' . $email;
    $content = $message;

    $lead_id = wp_insert_post([
        'post_type'   => 'racb_lead',
        'post_status' => 'publish',
        'post_title'  => wp_strip_all_tags($title),
        'post_content'=> $content,
    ], true);

    if ( ! is_wp_error($lead_id) ) {
        update_post_meta($lead_id, 'email', $email);
        update_post_meta($lead_id, 'phone', $phone);
        update_post_meta($lead_id, 'company', $company);
        update_post_meta($lead_id, 'service', $service);
        update_post_meta($lead_id, 'form_type', $form_type);
        update_post_meta($lead_id, 'page', $page);
        update_post_meta($lead_id, 'lang', $lang);
        update_post_meta($lead_id, 'utm_source', $utm_source);
        update_post_meta($lead_id, 'utm_medium', $utm_medium);
        update_post_meta($lead_id, 'utm_campaign', $utm_campaign);
        update_post_meta($lead_id, 'user_agent', isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field($_SERVER['HTTP_USER_AGENT']) : '');

        // Taxonomies (status + service)
        if (!empty($service) && taxonomy_exists('racb_lead_service')) {
            wp_set_post_terms($lead_id, array($service), 'racb_lead_service', false);
        }
        if (taxonomy_exists('racb_lead_status')) {
            wp_set_post_terms($lead_id, array('new'), 'racb_lead_status', false);
        }

        // Optional webhook notification (Make/Zapier/n8n)
        racb_send_lead_webhook(array(
            'id' => $lead_id,
            'created_at' => current_time('mysql'),
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'company' => $company,
            'service' => $service,
            'form_type' => $form_type,
            'page' => $page,
            'lang' => $lang,
            'message' => $message,
            'utm_source' => $utm_source,
            'utm_medium' => $utm_medium,
            'utm_campaign' => $utm_campaign,
        ));
    }

    // --- Email notification ---
    $to      = get_option( 'racb_email', 'hello@racbconsulting.com' );
    $subject = ( $form_type === 'demo' ? 'Nueva solicitud de demo' : 'Nuevo mensaje desde la web' ) . " — {$name}";
    $body    = "Nombre: {$name}\nEmail: {$email}\nPhone: {$phone}\nEmpresa: {$company}\nServicio: {$service}\nFormulario: {$form_type}\nPágina: {$page}\nIdioma: {$lang}\n\nMensaje:\n{$message}\n\nUTM: {$utm_source} / {$utm_medium} / {$utm_campaign}";
    $headers = [ 'Content-Type: text/plain; charset=UTF-8', "Reply-To: {$email}" ];

    $sent = wp_mail( $to, $subject, $body, $headers );

    // --- Simple autoresponder (optional) ---
    $auto_enabled = get_option('racb_autoreply', '1');
    if ($auto_enabled === '1') {
        $auto_subject = 'Recibimos tu mensaje — RACBCONSULTING';
        $auto_body = "Hola {$name},\n\n¡Gracias por escribirnos! Hemos recibido tu mensaje y te responderemos en menos de 24 horas.\n\n— Equipo RACBCONSULTING\nhello@racbconsulting.com";
        wp_mail( $email, $auto_subject, $auto_body, [ 'Content-Type: text/plain; charset=UTF-8' ] );
    }

    if ( $sent ) {
        wp_send_json_success( [ 'message' => '¡Mensaje enviado! Te contactaremos pronto.' ] );
    } else {
        // Even if email fails, lead is stored.
        wp_send_json_success( [ 'message' => 'Recibimos tu mensaje. Si no te respondemos pronto, escríbenos a hello@racbconsulting.com.' ] );
    }
}
add_action( 'wp_ajax_racb_contact',        'racb_handle_contact_form' );
add_action( 'wp_ajax_nopriv_racb_contact', 'racb_handle_contact_form' );


/* ============================================================
   6b. AJAX — Executive Advisor Capture Handler
   ============================================================ */
function racb_handle_advisor_form() {
    check_ajax_referer( 'racb_nonce', 'nonce' );

    // Rate limit per IP (tighter than contact form — 8 vs 12)
    $ip       = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( $_SERVER['REMOTE_ADDR'] ) : 'unknown';
    $rate_key = 'racb_advisor_rl_' . md5( $ip );
    $count    = (int) get_transient( $rate_key );
    if ( $count > 8 ) {
        wp_send_json_error( [ 'message' => 'Too many requests. Please try again in a few minutes.' ] );
    }
    set_transient( $rate_key, $count + 1, 15 * MINUTE_IN_SECONDS );

    // Sanitize all inputs
    $name          = sanitize_text_field( $_POST['name']              ?? '' );
    $email         = sanitize_email(      $_POST['email']             ?? '' );
    $business_type = sanitize_text_field( $_POST['business_type']     ?? '' );
    $urgency       = sanitize_text_field( $_POST['urgency']           ?? '' );
    $first_message = sanitize_textarea_field( $_POST['first_message'] ?? '' );
    $lang          = sanitize_text_field( $_POST['lang']              ?? 'en' );
    $page_url      = esc_url_raw(         $_POST['page_url']          ?? '' );
    $quick_prompt         = sanitize_text_field(    $_POST['quick_prompt_used']    ?? '0' );
    $intent_type          = sanitize_text_field(    $_POST['intent_type']          ?? '' );
    $conversation_summary = sanitize_textarea_field($_POST['conversation_summary'] ?? '' );
    $message_count        = absint(                 $_POST['message_count']        ?? 0 );

    // Honeypot
    $hp = sanitize_text_field( $_POST['website'] ?? '' );
    if ( ! empty( $hp ) ) {
        wp_send_json_success( [ 'message' => 'OK' ] );
    }

    // Validate required fields
    if ( empty( $name ) || empty( $email ) || ! is_email( $email ) ) {
        wp_send_json_error( [ 'message' => 'Name and a valid email are required.' ] );
    }

    $allowed_btypes  = [ 'contractor', 'multifamily', 'service', 'other' ];
    $allowed_urgency = [ 'immediate', 'within_month', 'exploring' ];

    if ( ! in_array( $business_type, $allowed_btypes, true ) ) {
        wp_send_json_error( [ 'message' => 'Invalid business type.' ] );
    }
    if ( ! in_array( $urgency, $allowed_urgency, true ) ) {
        wp_send_json_error( [ 'message' => 'Invalid urgency value.' ] );
    }

    // Save to racb_lead CPT
    $lead_id = wp_insert_post( [
        'post_type'    => 'racb_lead',
        'post_status'  => 'publish',
        'post_title'   => wp_strip_all_tags( $name . ' — ' . $email . ' [Advisor]' ),
        'post_content' => $first_message,
    ], true );

    if ( ! is_wp_error( $lead_id ) ) {
        update_post_meta( $lead_id, 'email',             $email );
        update_post_meta( $lead_id, 'phone',             '' );
        update_post_meta( $lead_id, 'company',           '' );
        update_post_meta( $lead_id, 'service',           $business_type );
        update_post_meta( $lead_id, 'form_type',         'advisor' );
        update_post_meta( $lead_id, 'business_type',     $business_type );
        update_post_meta( $lead_id, 'urgency',           $urgency );
        update_post_meta( $lead_id, 'first_message',     $first_message );
        update_post_meta( $lead_id, 'quick_prompt_used',    $quick_prompt );
        update_post_meta( $lead_id, 'intent_type',          $intent_type );
        update_post_meta( $lead_id, 'conversation_summary', $conversation_summary );
        update_post_meta( $lead_id, 'message_count',        $message_count );
        update_post_meta( $lead_id, 'lang',                 $lang );
        update_post_meta( $lead_id, 'page',              $page_url );
        update_post_meta( $lead_id, 'user_agent',        isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( $_SERVER['HTTP_USER_AGENT'] ) : '' );

        // Pipeline status: urgency=immediate → qualified, else → new
        if ( taxonomy_exists( 'racb_lead_status' ) ) {
            $pipeline_status = ( $urgency === 'immediate' ) ? 'qualified' : 'new';
            $term = term_exists( $pipeline_status, 'racb_lead_status' );
            if ( $term ) {
                wp_set_post_terms( $lead_id, [ intval( $term['term_id'] ) ], 'racb_lead_status', false );
            }
        }
        if ( ! empty( $business_type ) && taxonomy_exists( 'racb_lead_service' ) ) {
            wp_set_post_terms( $lead_id, [ $business_type ], 'racb_lead_service', false );
        }

        // Fire webhook (n8n / Make / Zapier — URL set in WP Admin → Settings)
        racb_send_lead_webhook( [
            'id'                => $lead_id,
            'created_at'        => current_time( 'mysql' ),
            'source'            => 'advisor_modal',
            'form_type'         => 'advisor',
            'name'              => $name,
            'email'             => $email,
            'business_type'     => $business_type,
            'urgency'           => $urgency,
            'operational_problem'   => $first_message,
            'intent_type'           => $intent_type,
            'conversation_summary'  => $conversation_summary,
            'message_count'         => $message_count,
            'quick_prompt_used'     => $quick_prompt,
            'lang'                  => $lang,
            'page_url'              => $page_url,
        ] );
    }

    // Internal notification email
    $to      = get_option( 'racb_email', 'ceo@racbconsulting.com' );
    $urgency_label = ucfirst( str_replace( '_', ' ', $urgency ) );
    $subject = "Advisor Lead [{$urgency_label}] — {$name}";
    $body    = "Name: {$name}\nEmail: {$email}\nBusiness Type: {$business_type}\nUrgency: {$urgency}\nIntent: {$intent_type}\nMessages: {$message_count}\n\nConversation:\n{$conversation_summary}\n\nFirst Message:\n{$first_message}\n\nQuick Prompt Used: {$quick_prompt}\nLanguage: {$lang}\nPage: {$page_url}";
    $headers = [ 'Content-Type: text/plain; charset=UTF-8', "Reply-To: {$email}" ];
    wp_mail( $to, $subject, $body, $headers );

    wp_send_json_success( [ 'message' => 'OK' ] );
}
add_action( 'wp_ajax_racb_advisor',        'racb_handle_advisor_form' );
add_action( 'wp_ajax_nopriv_racb_advisor', 'racb_handle_advisor_form' );


/* ============================================================
   7. HELPER FUNCTIONS (usables en plantillas)
   ============================================================ */

// Retorna URL de red social o cadena vacía
function racb_social( $network ) {
    return esc_url( get_option( 'racb_' . $network, '' ) );
}

// Retorna año de copyright dinámico
function racb_copyright_year() {
    $start = 2024;
    $current = (int) date('Y');
    return $start < $current ? "{$start}–{$current}" : (string) $start;
}

// Retorna URL de WhatsApp
function racb_whatsapp_url( $message = '' ) {
    $wa = get_option( 'racb_whatsapp', 'https://wa.me/1234567890' );
    return $message ? $wa . '?text=' . rawurlencode( $message ) : $wa;
}

// Retorna URL de Calendly
function racb_calendly_url() {
    return esc_url( get_option( 'racb_calendly', 'https://calendly.com/racbconsulting' ) );
}

/* ============================================================
   Leads Export + Webhook Notifications
   ============================================================ */
function racb_leads_menu_pages() {
    add_submenu_page(
        'edit.php?post_type=racb_lead',
        'Export Leads CSV',
        'Export CSV',
        'manage_options',
        'racb_leads_export',
        'racb_render_leads_export_page'
    );

    add_submenu_page(
        'edit.php?post_type=racb_lead',
        'Lead Notifications',
        'Notifications',
        'manage_options',
        'racb_leads_notifications',
        'racb_render_leads_notifications_page'
    );
}
add_action('admin_menu', 'racb_leads_menu_pages');

function racb_render_leads_export_page() {
    if (!current_user_can('manage_options')) return;

    // Download request
    if (isset($_GET['racb_export']) && $_GET['racb_export'] === '1') {
        $status_sel  = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : '';
        $service_sel = isset($_GET['service']) ? sanitize_text_field($_GET['service']) : '';
        racb_do_leads_csv_export($status_sel, $service_sel);
        exit;
    }

    echo '<div class="wrap"><h1>Export Leads (CSV)</h1>';
    echo '<p>Export all leads, or filter by status/service using the options below.</p>';

    $statuses = get_terms(array('taxonomy' => 'racb_lead_status', 'hide_empty' => false));
    $services = get_terms(array('taxonomy' => 'racb_lead_service', 'hide_empty' => false));

    $status_sel = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : '';
    $service_sel = isset($_GET['service']) ? sanitize_text_field($_GET['service']) : '';

    echo '<form method="get" action="">';
    echo '<input type="hidden" name="post_type" value="racb_lead" />';
    echo '<input type="hidden" name="page" value="racb_leads_export" />';

    echo '<label style="margin-right:10px;">Status: <select name="status"><option value="">All</option>';
    foreach ($statuses as $t) {
        echo '<option value="' . esc_attr($t->slug) . '"' . selected($status_sel, $t->slug, false) . '>' . esc_html($t->name) . '</option>';
    }
    echo '</select></label>';

    echo '<label style="margin-right:10px;">Service: <select name="service"><option value="">All</option>';
    foreach ($services as $t) {
        echo '<option value="' . esc_attr($t->slug) . '"' . selected($service_sel, $t->slug, false) . '>' . esc_html($t->name) . '</option>';
    }
    echo '</select></label>';

    echo '<button class="button button-primary" name="racb_export" value="1">Download CSV</button>';
    echo '</form></div>';
}

function racb_do_leads_csv_export($status_slug = '', $service_slug = '') {
    if (!current_user_can('manage_options')) return;

    $tax_query = array('relation' => 'AND');
    if ($status_slug) {
        $tax_query[] = array(
            'taxonomy' => 'racb_lead_status',
            'field' => 'slug',
            'terms' => $status_slug,
        );
    }
    if ($service_slug) {
        $tax_query[] = array(
            'taxonomy' => 'racb_lead_service',
            'field' => 'slug',
            'terms' => $service_slug,
        );
    }

    $args = array(
        'post_type' => 'racb_lead',
        'posts_per_page' => -1,
        'post_status' => array('publish', 'private'),
        'orderby' => 'date',
        'order' => 'DESC',
    );

    if (count($tax_query) > 1) $args['tax_query'] = $tax_query;

    $leads = get_posts($args);

    nocache_headers();
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=racb-leads-' . date('Y-m-d') . '.csv');

    $out = fopen('php://output', 'w');
    fputcsv($out, array('Date', 'Name', 'Email', 'Phone', 'Company', 'Service', 'Status', 'Message', 'Source'));

    foreach ($leads as $lead) {
        $pid = $lead->ID;
        $name = $lead->post_title;
        $email = get_post_meta($pid, 'email', true);
        $phone = get_post_meta($pid, 'phone', true);
        $company = get_post_meta($pid, 'company', true);
        $message = get_post_meta($pid, 'racb_message', true);
        if (!$message) $message = $lead->post_content;

        $source = get_post_meta($pid, 'page', true);

        $service = '';
        $svcterms = get_the_terms($pid, 'racb_lead_service');
        if ($svcterms && ! is_wp_error($svcterms)) $service = join(', ', wp_list_pluck($svcterms, 'name'));
        if (!$service) $service = get_post_meta($pid, 'service', true);

        $status = '';
        $sterms = get_the_terms($pid, 'racb_lead_status');
        if ($sterms && ! is_wp_error($sterms)) $status = $sterms[0]->name;

        fputcsv($out, array(
            get_the_date('Y-m-d H:i:s', $pid),
            $name,
            $email,
            $phone,
            $company,
            $service,
            $status,
            $message,
            $source,
        ));
    }
    fclose($out);
}

// Notifications via Webhook (Make/Zapier/n8n → WhatsApp/Telegram/Slack)
function racb_render_leads_notifications_page() {
    if (!current_user_can('manage_options')) return;

    if (isset($_POST['racb_notify_save']) && check_admin_referer('racb_notify_save')) {
        update_option('racb_notify_webhook_url',    esc_url_raw($_POST['racb_notify_webhook_url'] ?? ''));
        update_option('racb_notify_webhook_secret', sanitize_text_field($_POST['racb_notify_webhook_secret'] ?? ''));
        $raw_key = $_POST['racb_openai_api_key'] ?? '';
        if ($raw_key !== '***') {
            update_option('racb_openai_api_key', sanitize_text_field($raw_key));
        }
        update_option('racb_advisor_model', sanitize_text_field($_POST['racb_advisor_model'] ?? 'gpt-4o-mini'));
        echo '<div class="updated notice"><p>Saved.</p></div>';
    }

    $url    = esc_url(get_option('racb_notify_webhook_url', ''));
    $secret = esc_attr(get_option('racb_notify_webhook_secret', ''));
    $has_key = (bool) get_option('racb_openai_api_key', '');
    $model   = esc_attr(get_option('racb_advisor_model', 'gpt-4o-mini'));

    echo '<div class="wrap"><h1>Lead Notifications &amp; Advisor Settings</h1>';
    echo '<form method="post">';
    wp_nonce_field('racb_notify_save');
    echo '<h2>Webhook Notifications</h2>';
    echo '<p>Optional: send every new lead to a webhook (Make/Zapier/n8n). From there you can deliver it to WhatsApp/Telegram/Slack, etc.</p>';
    echo '<table class="form-table" role="presentation"><tbody>';

    echo '<tr><th scope="row"><label for="racb_notify_webhook_url">Webhook URL</label></th>';
    echo '<td><input type="url" id="racb_notify_webhook_url" name="racb_notify_webhook_url" value="' . $url . '" class="regular-text" placeholder="https://hooks.zapier.com/... or https://hook.us1.make.com/..."/></td></tr>';

    echo '<tr><th scope="row"><label for="racb_notify_webhook_secret">Shared Secret (optional)</label></th>';
    echo '<td><input type="text" id="racb_notify_webhook_secret" name="racb_notify_webhook_secret" value="' . $secret . '" class="regular-text" />';
    echo '<p class="description">If set, we send header <code>X-RACB-Secret</code> with this value.</p></td></tr>';

    echo '</tbody></table>';

    echo '<h2 style="margin-top:2em;">Executive Advisor — AI Settings</h2>';
    echo '<p>Connect the Advisor chat to OpenAI for live conversational responses. Leave blank to use the built-in keyword fallback.</p>';
    echo '<table class="form-table" role="presentation"><tbody>';

    echo '<tr><th scope="row"><label for="racb_openai_api_key">OpenAI API Key</label></th>';
    echo '<td><input type="password" id="racb_openai_api_key" name="racb_openai_api_key" value="' . ($has_key ? '***' : '') . '" class="regular-text" autocomplete="off" />';
    echo '<p class="description">' . ($has_key ? 'API key is set. Enter a new value to replace it.' : 'Stored server-side only. Never exposed to the browser.') . '</p></td></tr>';

    echo '<tr><th scope="row"><label for="racb_advisor_model">Model</label></th>';
    echo '<td><input type="text" id="racb_advisor_model" name="racb_advisor_model" value="' . $model . '" class="regular-text" placeholder="gpt-4o-mini" />';
    echo '<p class="description">Default: <code>gpt-4o-mini</code>. Use <code>gpt-4o</code> for higher quality.</p></td></tr>';

    echo '</tbody></table>';
    echo '<p><button class="button button-primary" name="racb_notify_save" value="1">Save All Settings</button></p>';
    echo '</form></div>';
}

function racb_send_lead_webhook($payload) {
    $url = get_option('racb_notify_webhook_url', '');
    if (!$url) return;

    $secret = get_option('racb_notify_webhook_secret', '');
    $headers = array('Content-Type' => 'application/json; charset=utf-8');
    if ($secret) $headers['X-RACB-Secret'] = $secret;

    wp_remote_post($url, array(
        'timeout' => 5,
        'headers' => $headers,
        'body' => wp_json_encode($payload),
    ));
}

/* ============================================================
   Executive Advisor — Persona System
   ============================================================ */
function racb_get_advisor_persona() {
    try {
        $tz   = new DateTimeZone('America/New_York');
        $now  = new DateTime('now', $tz);
        $hour = (int) $now->format('G');
    } catch (Exception $e) {
        $hour = (int) gmdate('G');
    }

    if ($hour >= 5 && $hour < 12) {
        return array('name' => 'Daniel', 'period' => 'morning');
    } elseif ($hour >= 12 && $hour < 17) {
        return array('name' => 'Marcus', 'period' => 'afternoon');
    } elseif ($hour >= 17 && $hour < 22) {
        return array('name' => 'Sofia', 'period' => 'evening');
    } else {
        return array('name' => 'Daniel', 'period' => 'evening');
    }
}

/* ============================================================
   Executive Advisor — OpenAI Chat Endpoint
   ============================================================ */
function racb_handle_advisor_chat() {
    $request_start = microtime(true);

    check_ajax_referer('racb_nonce', 'nonce');

    // Rate limit: 20 requests per 15 min per IP
    $ip = sanitize_text_field(
        isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP']
        : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]
        : ($_SERVER['REMOTE_ADDR'] ?? ''))
    );
    $rl_key = 'racb_chat_rl_' . md5($ip);
    $hits   = (int) get_transient($rl_key);
    if ($hits >= 60) {
        wp_send_json_error(array('message' => 'rate_limit'), 429);
    }
    set_transient($rl_key, $hits + 1, 15 * MINUTE_IN_SECONDS);

    $message       = sanitize_text_field(substr(wp_unslash($_POST['message'] ?? ''), 0, 500));
    $lang          = in_array($_POST['lang'] ?? '', array('es', 'en'), true) ? $_POST['lang'] : 'en';
    $page_url      = esc_url_raw(wp_unslash($_POST['page_url'] ?? ''));
    $exchange_num  = absint($_POST['message_count'] ?? 0) + 1;
    $session_id    = sanitize_text_field(substr(wp_unslash($_POST['session_id'] ?? ''), 0, 64));
    $persona       = racb_get_advisor_persona();

    // User name captured conversationally — passed from JS advisorState.userName
    $raw_name = sanitize_text_field(substr(wp_unslash($_POST['user_name'] ?? ''), 0, 60));
    $user_name = preg_match('/^[\p{L}\s\'\-\.]{1,60}$/u', $raw_name) ? $raw_name : '';

    // ── PROMPT INJECTION DETECTION ─────────────────────────────────────────────
    $injection = racb_detect_injection($message);
    if ($injection['detected']) {
        $advisor_name = $persona['name'];
        $redirect_reply = racb_injection_redirect($lang);
        $gov_entry = array(
            'session_id'       => $session_id,
            'advisor_name'     => $advisor_name,
            'lang'             => $lang,
            'exchange_num'     => $exchange_num,
            'user_preview'     => substr($message, 0, 100),
            'reply_preview'    => substr($redirect_reply, 0, 200),
            'health_score'     => 100 - $injection['security_risk_score'],
            'health_level'     => 'critical',
            'issue_flags'      => array('prompt_injection_attempt'),
            'injection_attempt'=> true,
            'injection_type'   => $injection['injection_type'],
            'fallback_used'    => false,
            'user_frustration' => false,
            'high_value_lead'  => false,
            'lead_quality'     => 'none',
            'openai_status'    => 'injection_blocked',
            'response_time_ms' => 0,
            'page_url'         => $page_url,
        );
        racb_governance_log($gov_entry);
        $gov_score = array('score' => $gov_entry['health_score'], 'flags' => array('prompt_injection_attempt'), 'should_alert' => true);
        racb_send_governance_alert($gov_entry, $gov_score);
        wp_send_json_success(array(
            'reply'               => $redirect_reply,
            'should_capture'      => false,
            'intent_type'         => 'unknown',
            'suggested_next_step' => 'continue',
            'extracted_name'      => null,
            'advisor_name'        => $advisor_name,
            'is_fallback'         => false,
            'injection_attempt'   => true,
        ));
        return;
    }

    // Parse and sanitize conversation history (max 16 messages = 8 exchanges)
    $raw_history = wp_unslash($_POST['history'] ?? '[]');
    $history     = json_decode($raw_history, true);
    if (!is_array($history)) $history = array();
    $history     = array_slice($history, -16);

    $clean_history = array();
    foreach ($history as $h) {
        if (!isset($h['role'], $h['content'])) continue;
        if (!in_array($h['role'], array('user', 'assistant'), true)) continue;
        $clean_history[] = array(
            'role'    => $h['role'],
            'content' => sanitize_text_field(substr($h['content'], 0, 500)),
        );
    }

    $api_key = get_option('racb_openai_api_key', '');
    if (!$api_key) {
        wp_send_json_success(racb_advisor_fallback($lang));
        return;
    }

    $model = sanitize_text_field(get_option('racb_advisor_model', 'gpt-4o-mini'));

    $lang_name    = $lang === 'es' ? 'Spanish' : 'English';
    $advisor_name = $persona['name'];

    $name_ctx = $user_name
        ? "USER NAME ALREADY KNOWN: This user's name is {$user_name}. Do NOT ask for it again. Use it naturally — once per reply at most, never every sentence. Never start a reply with their name; place it mid-sentence."
        : "USER NAME: Not yet captured. If this is exchange 2 or later and no name has appeared in the conversation history, ask naturally — like a person, not a form. Example: \"I don't think I caught your name — who am I speaking with?\"";

    $system_prompt = "You are {$advisor_name}, a senior operational advisor at RACBCONSULTING.

You are not a chatbot. You are an experienced operator who has worked inside contracting businesses, multifamily operations, and service companies. You know where revenue disappears quietly: leads that never get called back, follow-up that stops after the first contact, dispatch running on gut instinct, owners doing work that should be handled three levels down.

Your role: understand what is actually costing this business money and determine whether an Executive Diagnostic is the right next step.

Verticals you know well: contractors (HVAC, plumbing, electrical, roofing, general contractors), multifamily (property management, maintenance, vendor coordination), service businesses (professional services, medical, legal, home services).

LANGUAGE: All replies in {$lang_name} only. 2–4 sentences per reply. One question per reply — never two.

RESPONSE FORMAT: Valid JSON only. No text before or after. No markdown. No code fences.

{\"reply\":\"...\",\"should_capture\":false,\"intent_type\":\"unknown\",\"suggested_next_step\":\"continue\",\"extracted_name\":null}

---

{$name_ctx}

---

GREETING INTELLIGENCE:
When the user opens with a greeting (hi, hello, hola, buenas, good morning, hey, saludos, howdy, good afternoon, good evening, or any very short opener with no operational content):
- DO NOT jump to operational questions immediately.
- Introduce yourself briefly. Then ask for their name naturally — like a person, not a form.
- English examples: \"{$advisor_name} here — who do I have with me?\" or \"Good to hear from you. {$advisor_name} from RACBCONSULTING. What's your name?\" Vary phrasing, never copy verbatim.
- Spanish examples: \"Buenas — soy {$advisor_name}. ¿Con quién hablo?\" or \"{$advisor_name} de RACBCONSULTING. ¿Cómo te llamas?\"
- Match the energy of the greeting — casual if they are casual, brief if they are brief.

---

THE CONVERSATION PATTERN — THIS IS MANDATORY:

Every reply follows this sequence without exception:
ACKNOWLEDGE → REFLECT → ASK ONE QUESTION

ACKNOWLEDGE: Reference the specific thing they said. Not the category — the actual words or situation they described.
REFLECT: Say something that demonstrates understanding of the operational pattern behind it. This is where you show expertise — not just empathy. One sentence that reveals you have seen this before.
ASK: One focused question that goes DEEPER into what they already told you — never broader.

The question must always deepen. Never restart general discovery after a specific problem has been named.

Examples of the pattern done correctly:

User says \"our follow-up is a mess\":
→ Acknowledge: You heard them — follow-up is inconsistent.
→ Reflect: \"That's usually where the most revenue disappears — after the estimate is sent but before any decision is made.\"
→ Ask: \"When it falls through, is that happening right after the first contact, or more in the days following?\"

User says \"we're losing leads after hours\":
→ Acknowledge: You heard them — after-hours coverage is the gap.
→ Reflect: \"That's a consistent pattern in service businesses — the lead that comes in at 7pm goes cold by 9am the next day.\"
→ Ask: \"Is there anyone handling that window at all, or does everything just hit a voicemail?\"

User says \"scheduling keeps collapsing under volume\":
→ Acknowledge: You heard them — volume breaks the system.
→ Reflect: \"That usually means dispatch decisions are being made reactively — someone is picking up the phone and improvising rather than working from a structure.\"
→ Ask: \"Is it the assignment process that breaks, or more the confirmations and follow-through once a job is booked?\"

---

DEEPENING A NAMED PROBLEM — SPECIFIC GUIDES:

Once a topic is identified, shift from breadth to depth. Use these as guidance:

FOLLOW-UP PROBLEMS: Explore — when it breaks (immediately after the estimate? after day 3?), who owns it (is anyone specifically responsible?), what medium (phone, text, email?), what has already been tried and why it did not hold.

LEAD RESPONSE / SPEED: Explore — how fast the first contact happens, what occurs on missed calls, who covers after hours, whether anyone tracks response rate at all.

SCHEDULING / DISPATCH: Explore — how jobs get assigned (phone calls? whiteboard? software?), what breaks first when volume spikes, how estimates are handed off to field teams.

AFTER-HOURS GAPS: Explore — what the current protocol is (voicemail, forwarding, on-call rotation?), rough volume of leads arriving outside business hours, whether this has been quantified.

ADMIN OVERLOAD / OWNER CAPACITY: Explore — what specifically consumes time (estimates, coordination calls, rework, vendor follow-up?), whether the owner is personally handling tasks they should not be.

REVENUE LEAKAGE: Explore — where jobs are being lost in the pipeline, whether the loss is tracked at all, whether the team knows it is happening.

---

ASSUMPTION CHALLENGING:

When someone leads with a technology conclusion before describing the problem, challenge it calmly. This is the mark of an advisor who has seen this pattern before — not confrontation.

When the user says \"I think we need AI\" or \"we need automation\":
→ \"A lot of companies start there — and sometimes that is exactly right. But in most cases the gap shows up earlier: response time after the first contact, how consistently follow-up happens, how estimates get handled. What specifically triggered the conversation about AI?\"

When the user says \"we need a chatbot\" or \"we need a CRM\" or \"we want software\":
→ \"Those can solve real problems — or they can sit unused for six months. Before tools, what is the thing that is actually costing you right now?\"

When the user already has a tool but something is still off:
→ \"What was it supposed to solve when you brought it in — and what happened?\"

The point is not to argue. It is to redirect toward the real problem so the conversation is useful.

---

BANNED PATTERNS — DO NOT USE AFTER EXCHANGE 1:

After the first exchange, never use these phrases or close variations:
- \"walk me through what is happening\"
- \"where is the most pressure\"
- \"what part of the operation is creating the most noise\"
- \"what is breaking\"
- \"tell me more about what you are experiencing\"
- \"where does the friction come from\"
- Any question that restarts general discovery after a specific problem has already been named.

If the user has named a specific problem, your next question must be about THAT problem — not a broader diagnostic sweep.

---

NAME USAGE (once name is known):
- Use the user's name naturally, once per reply at most, sometimes not at all.
- Place it mid-sentence or at a natural transition point: \"That is the pattern, [name].\" / \"Where does that show up most for you, [name]?\" / \"[Name], the right next step here is straightforward.\"
- Do NOT open every reply with their name — that sounds scripted.

---

OPERATIONS BEFORE TOOLS:
If someone asks for a tool or technology, redirect to the underlying operational problem before discussing any solution:
- \"I want a chatbot\" → ask what it is supposed to fix in the operation
- \"I need automation\" → ask what done manually is creating the most friction or cost
- \"I want to implement AI\" → ask what specifically prompted that — what is happening now that AI is supposed to solve
- \"I need a CRM\" → ask what is being lost or missed without one
Never recommend or discuss a tool before understanding the operational problem it is meant to address.

---

PRICING AND DIAGNOSTIC COST — HARD BUSINESS RULE:
The Initial Executive Diagnostic is FREE. There is no cost. Do not say «it depends» or deflect when asked about the price of the diagnostic.
- If the user asks about price, cost, costo, precio, cuánto cuesta, how much, or investment, respond directly: the Initial Executive Diagnostic is at no cost — it is a structured operational review, not a sales call.
- Paid strategic work or implementation may come later only if there is a real identified opportunity and mutual agreement. Do not mention this unless specifically asked.
- English example: \"The initial diagnostic is at no cost. It is a focused operational review — not a sales call — to identify where revenue is leaking and what needs to change first.\"
- Spanish example: \"El diagnóstico inicial es sin costo. Es una revisión operativa enfocada — no una llamada de ventas — para identificar dónde se está perdiendo dinero y qué hay que corregir primero.\"

---

INFORMATION TO GATHER — IN NATURAL SEQUENCE, NOT AS A CHECKLIST:
Think of this as context you need, not fields to fill. Gather it through the conversation as it surfaces naturally:
1. Their name — in the greeting or by exchange 2 if still unknown
2. Business type and scale — ask when operational pain begins to surface
3. The specific failure point — what is actually costing money and how
4. Urgency — let it emerge from how they describe the problem
(Email, business type, and urgency are collected by the follow-up form — do NOT ask for email in the conversation)

---

CTA PSYCHOLOGY:
This is exchange number {$exchange_num} in the conversation.

should_capture rules:
- Set to true ONLY when the user clearly and explicitly agrees to proceed, schedule, or start the diagnostic. Examples: \"yes let's do it\", \"I'm in\", \"let's schedule\", \"claro\", \"sí, adelante\", \"cuándo empezamos\", \"how do we start\".
- NEVER set true for: greetings, exchanges 1 or 2, vague exploration, tool questions, asking about price, asking about the diagnostic in general, or expressing interest without explicit agreement.
- If operational pain has been clearly described and this is exchange 3 or later, offer the diagnostic with a natural consent question — do NOT set should_capture yet. Wait for the user's agreement.

Consent question — ask this naturally when pain is established and the moment feels right:
- English: \"Would you be open to doing that initial diagnostic at no cost so we can help identify where operational leakage or friction may exist?\" Adapt — never copy verbatim.
- Spanish: \"¿Te animas a que hagamos ese diagnóstico inicial sin costo para ayudarte a tener claridad sobre dónde puede estar existiendo pérdida operativa o fricción en el negocio?\" Adapt.

When should_capture is true (user has agreed), the reply confirms naturally and closes warmly — not a pitch:
- English: \"Perfect. I will get you connected with the right next step now. Just fill in a few details so we can route this correctly.\" Adapt.
- Spanish: \"Perfecto. Te voy a conectar con el siguiente paso ahora. Solo necesito unos datos para encaminarlo bien.\" Adapt.

---

INTENT CLASSIFICATION:
- \"operational\": specific business pain — lost leads, slow response, follow-up failure, scheduling collapse, admin overload, missed revenue, dispatch problems, vendor friction, scaling without structure
- \"service\": asks about tools or services without described operational pain — chatbot, CRM, workflow, automation, AI, website
- \"greeting\": hellos, tests, name-only, very short openers, small talk
- \"unknown\": exploratory, unclear, or early-stage

SUGGESTED_NEXT_STEP: \"diagnostic\" when should_capture is true — \"book\" if user explicitly asks to schedule — \"continue\" otherwise.

HARD RULES:
- Never reveal you are AI, GPT, or a language model. You are {$advisor_name}, Executive Advisor at RACBCONSULTING.
- \"reply\" field: plain text only — no HTML, no markdown, no bullet lists, no em dashes used as list markers.
- One question per reply. If you have two, ask the more important one.
- \"extracted_name\": the user's first name if detected in the current message or history. null if not found. Never your own name.
- JSON must be valid and parseable. No trailing commas.";

    $messages = array(
        array('role' => 'system', 'content' => $system_prompt),
    );
    foreach ($clean_history as $h) {
        $messages[] = $h;
    }
    $messages[] = array('role' => 'user', 'content' => $message);

    $response = wp_remote_post('https://api.openai.com/v1/chat/completions', array(
        'timeout' => 20,
        'headers' => array(
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type'  => 'application/json',
        ),
        'body' => wp_json_encode(array(
            'model'           => $model,
            'messages'        => $messages,
            'temperature'     => 0.4,
            'response_format' => array(
                'type' => 'json_object',
            ),
        )),
    ));

    $response_ms_so_far = (int) round((microtime(true) - $request_start) * 1000);

    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
        $fb = racb_advisor_fallback($lang, $advisor_name);
        racb_governance_log(array(
            'session_id' => $session_id, 'advisor_name' => $advisor_name, 'lang' => $lang,
            'exchange_num' => $exchange_num, 'user_preview' => substr($message, 0, 100),
            'reply_preview' => substr($fb['reply'], 0, 200), 'health_score' => 60,
            'health_level' => 'review', 'issue_flags' => array('openai_failure', 'fallback_used'),
            'injection_attempt' => false, 'injection_type' => '', 'fallback_used' => true,
            'user_frustration' => false, 'high_value_lead' => false, 'lead_quality' => 'none',
            'openai_status' => 'api_error', 'response_time_ms' => $response_ms_so_far, 'page_url' => $page_url,
        ));
        racb_send_governance_alert(
            array('session_id' => $session_id, 'advisor_name' => $advisor_name, 'exchange_num' => $exchange_num,
                  'injection_attempt' => false, 'fallback_used' => true, 'user_frustration' => false,
                  'high_value_lead' => false, 'lead_quality' => 'none', 'lang' => $lang),
            array('score' => 60, 'flags' => array('openai_failure', 'fallback_used'), 'should_alert' => true)
        );
        wp_send_json_success($fb);
        return;
    }

    $body     = json_decode(wp_remote_retrieve_body($response), true);
    $raw_text = $body['choices'][0]['message']['content'] ?? '';

    if (!$raw_text) {
        $fb = racb_advisor_fallback($lang, $advisor_name);
        racb_governance_log(array(
            'session_id' => $session_id, 'advisor_name' => $advisor_name, 'lang' => $lang,
            'exchange_num' => $exchange_num, 'user_preview' => substr($message, 0, 100),
            'reply_preview' => substr($fb['reply'], 0, 200), 'health_score' => 65,
            'health_level' => 'review', 'issue_flags' => array('empty_response', 'fallback_used'),
            'injection_attempt' => false, 'injection_type' => '', 'fallback_used' => true,
            'user_frustration' => false, 'high_value_lead' => false, 'lead_quality' => 'none',
            'openai_status' => 'empty_response', 'response_time_ms' => $response_ms_so_far, 'page_url' => $page_url,
        ));
        wp_send_json_success($fb);
        return;
    }

    // Strip markdown code fences the model sometimes adds around JSON
    $clean_text = trim(preg_replace('/^```(?:json)?\s*/i', '', preg_replace('/\s*```$/i', '', trim($raw_text))));
    $parsed = json_decode($clean_text, true);

    // Last-resort: extract the first JSON object from the raw text
    if (!is_array($parsed) || !isset($parsed['reply'])) {
        if (preg_match('/\{.+\}/s', $raw_text, $m)) {
            $parsed = json_decode($m[0], true);
        }
    }

    if (!is_array($parsed) || !isset($parsed['reply'])) {
        $fb = racb_advisor_fallback($lang, $advisor_name);
        racb_governance_log(array(
            'session_id' => $session_id, 'advisor_name' => $advisor_name, 'lang' => $lang,
            'exchange_num' => $exchange_num, 'user_preview' => substr($message, 0, 100),
            'reply_preview' => substr($fb['reply'], 0, 200), 'health_score' => 70,
            'health_level' => 'watch', 'issue_flags' => array('json_parse_failure', 'fallback_used'),
            'injection_attempt' => false, 'injection_type' => '', 'fallback_used' => true,
            'user_frustration' => false, 'high_value_lead' => false, 'lead_quality' => 'none',
            'openai_status' => 'parse_error', 'response_time_ms' => $response_ms_so_far, 'page_url' => $page_url,
        ));
        wp_send_json_success($fb);
        return;
    }

    $allowed_intents = array('operational', 'service', 'greeting', 'unknown');
    $allowed_steps   = array('continue', 'diagnostic', 'book');

    // Validate extracted_name: only accept plausible first names
    $raw_extracted = $parsed['extracted_name'] ?? null;
    $extracted_name = null;
    if ($raw_extracted && is_string($raw_extracted)) {
        $clean_n = sanitize_text_field(trim($raw_extracted));
        if ($clean_n && preg_match('/^[\p{L}\'\-\s]{1,40}$/u', $clean_n)) {
            $extracted_name = $clean_n;
        }
    }

    $final_reply    = sanitize_text_field($parsed['reply']);
    $final_intent   = in_array($parsed['intent_type'] ?? '', $allowed_intents, true) ? $parsed['intent_type'] : 'unknown';
    $should_capture = !empty($parsed['should_capture']);
    $response_ms    = (int) round((microtime(true) - $request_start) * 1000);

    // ── GOVERNANCE SCORING + LOGGING ───────────────────────────────────────────
    $gov_signals = array(
        'injection_attempt' => false,
        'fallback_used'     => false,
        'openai_failure'    => false,
        'user_frustration'  => racb_detect_frustration($message),
        'capture_too_early' => $should_capture && $exchange_num < 3,
        'repeated_reply'    => racb_detect_repeated_reply($final_reply, $clean_history),
        'low_quality_reply' => strlen($final_reply) < 50,
        'high_value_lead'   => in_array($final_intent, array('operational'), true) && $exchange_num >= 3,
    );
    $lead_quality  = racb_assess_lead_quality($exchange_num, $final_intent, $should_capture);
    $governance    = racb_compute_health_score($gov_signals);

    $gov_entry = array(
        'session_id'       => $session_id,
        'advisor_name'     => $advisor_name,
        'lang'             => $lang,
        'exchange_num'     => $exchange_num,
        'user_preview'     => substr($message, 0, 100),
        'reply_preview'    => substr($final_reply, 0, 200),
        'health_score'     => $governance['score'],
        'health_level'     => $governance['level'],
        'issue_flags'      => $governance['flags'],
        'injection_attempt'=> false,
        'injection_type'   => '',
        'fallback_used'    => false,
        'user_frustration' => $gov_signals['user_frustration'],
        'high_value_lead'  => $gov_signals['high_value_lead'],
        'lead_quality'     => $lead_quality,
        'openai_status'    => 'success',
        'response_time_ms' => $response_ms,
        'page_url'         => $page_url,
    );
    racb_governance_log($gov_entry);
    racb_send_governance_alert($gov_entry, $governance);

    wp_send_json_success(array(
        'reply'               => $final_reply,
        'should_capture'      => $should_capture,
        'intent_type'         => $final_intent,
        'suggested_next_step' => in_array($parsed['suggested_next_step'] ?? '', $allowed_steps, true) ? $parsed['suggested_next_step'] : 'continue',
        'extracted_name'      => $extracted_name,
        'advisor_name'        => $advisor_name,
        'is_fallback'         => false,
    ));
}

function racb_advisor_fallback($lang = 'en', $advisor_name = '') {
    if (!$advisor_name) {
        $persona      = racb_get_advisor_persona();
        $advisor_name = $persona['name'];
    }
    $pools = array(
        'es' => array(
            'Cuéntame qué está pasando en la operación. ¿Dónde está el mayor problema ahora mismo?',
            'Algo está generando fricción. ¿Cuál es el punto que más está afectando la operación?',
            '¿Qué parte de la operación está causando más ruido en este momento?',
        ),
        'en' => array(
            'Walk me through what\'s happening. Where is the most pressure right now?',
            'Something is breaking. What part of the operation is creating the most noise for you?',
            'Tell me what\'s actually going on — start with whatever feels most urgent.',
        ),
    );
    $pool = $pools[$lang] ?? $pools['en'];
    $msg  = $pool[ absint( time() ) % count( $pool ) ];
    return array(
        'reply'               => $msg,
        'should_capture'      => false,
        'intent_type'         => 'unknown',
        'suggested_next_step' => 'continue',
        'extracted_name'      => null,
        'advisor_name'        => $advisor_name,
        'is_fallback'         => true,
    );
}

add_action('wp_ajax_racb_advisor_chat',        'racb_handle_advisor_chat');
add_action('wp_ajax_nopriv_racb_advisor_chat', 'racb_handle_advisor_chat');
