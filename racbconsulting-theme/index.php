<?php
/**
 * RACBCONSULTING — index.php
 * Template principal — carga el SPA desde page-home.php si no hay template específico
 */
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
get_template_part( 'template-parts/spa-shell' );
get_footer();
