<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Define globals
global $crt_theme_mods; // Store theme mods to prevent extra db checks and filter checks

// Gets all theme mods and stores them in an easily accessable global var to limit DB requests & filter checks
$crt_theme_mods = get_theme_mods();


require get_template_directory() . '/inc/helper.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/class-nav-walker.php';

if ( ! function_exists( 'crt_setup' ) ) :
	function crt_setup() {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		register_nav_menus( array(
			'header_menu' => esc_html__( 'Header', 'cr-theme' ),
			'footer_menu' => esc_html__( 'Footer', 'cr-theme' ),
		) );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
	}
endif;
add_action( 'after_setup_theme', 'crt_setup' );

function crt_content_width() {
	$GLOBALS['content_width'] = NULL;
}
add_action( 'after_setup_theme', 'crt_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function crt_scripts() {
	wp_enqueue_style('crt-google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700');
	wp_enqueue_style( 'crt-main-style', get_template_directory_uri() . '/assets/css/main.min.css' );
	wp_enqueue_script( 'crt-main-script', get_template_directory_uri() . '/assets/js/main.min.js', array('jquery'), NULL, true );
}
add_action( 'wp_enqueue_scripts', 'crt_scripts', 20);

