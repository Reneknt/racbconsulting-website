<?php
/**
 * RACBCONSULTING — functions.php
 * Theme setup, asset loading, custom post types, widgets
 */

if ( ! defined( 'ABSPATH' ) ) exit;

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

  // Google Fonts (kept as-is)
  wp_enqueue_style('racb-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap', array(), null);

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
        update_option('racb_notify_webhook_url', esc_url_raw($_POST['racb_notify_webhook_url'] ?? ''));
        update_option('racb_notify_webhook_secret', sanitize_text_field($_POST['racb_notify_webhook_secret'] ?? ''));
        echo '<div class="updated notice"><p>Saved.</p></div>';
    }

    $url = esc_url(get_option('racb_notify_webhook_url', ''));
    $secret = esc_attr(get_option('racb_notify_webhook_secret', ''));

    echo '<div class="wrap"><h1>Lead Notifications</h1>';
    echo '<p>Optional: send every new lead to a webhook (Make/Zapier/n8n). From there you can deliver it to WhatsApp/Telegram/Slack, etc.</p>';
    echo '<form method="post">';
    wp_nonce_field('racb_notify_save');
    echo '<table class="form-table" role="presentation"><tbody>';

    echo '<tr><th scope="row"><label for="racb_notify_webhook_url">Webhook URL</label></th>';
    echo '<td><input type="url" id="racb_notify_webhook_url" name="racb_notify_webhook_url" value="' . $url . '" class="regular-text" placeholder="https://hooks.zapier.com/... or https://hook.us1.make.com/..."/></td></tr>';

    echo '<tr><th scope="row"><label for="racb_notify_webhook_secret">Shared Secret (optional)</label></th>';
    echo '<td><input type="text" id="racb_notify_webhook_secret" name="racb_notify_webhook_secret" value="' . $secret . '" class="regular-text" />';
    echo '<p class="description">If set, we send header <code>X-RACB-Secret</code> with this value.</p></td></tr>';

    echo '</tbody></table>';
    echo '<p><button class="button button-primary" name="racb_notify_save" value="1">Save</button></p>';
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
