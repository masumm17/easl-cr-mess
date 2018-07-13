<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Define globals
global $crt_theme_mods; // Store theme mods to prevent extra db checks and filter checks

// Gets all theme mods and stores them in an easily accessable global var to limit DB requests & filter checks
if(!isset($crt_theme_mods)){
	$crt_theme_mods = get_theme_mods();
}


require get_template_directory() . '/inc/helper.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/class-nav-walker.php';

if ( ! function_exists( 'crt_setup' ) ) :
	function crt_setup() {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		register_nav_menus( array(
			'header_menu' => esc_html__( 'Header', 'crt' ),
			'footer_menu' => esc_html__( 'Footer', 'crt' ),
			'mobile_fixed_menu' => esc_html__( 'Mobile Fixed Menu', 'crt' ),
		) );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
		$image_sizes = crt_get_images_sizes();
		add_image_size('cr_default', 1360);
		foreach ($image_sizes as $size_name => $size_data ) {
			add_image_size($size_name, $size_data['width'], $size_data['height']);
			if(empty($size_data['nocrop'])){
				add_image_size($size_name . '_x', $size_data['width'], $size_data['height'], true);
			}
		}
	}
endif;
add_action( 'after_setup_theme', 'crt_setup' );

function crt_content_width() {
	$GLOBALS['content_width'] = NULL;
}
add_action( 'after_setup_theme', 'crt_content_width', 0 );

add_filter( 'image_size_names_choose', 'crt_custom_image_sizes', 20 );
 
function crt_custom_image_sizes( $sizes ) {
	$image_sizes = crt_get_images_sizes();
	$image_sizes_labels = array();
	foreach ($image_sizes as $size_name => $size_data ) {
		$image_sizes_labels[$size_name] = $size_data['name'];
		$image_sizes_labels[$size_name. '_x'] = $size_data['name'] . ' Cropped';
	}
	$image_sizes_labels['cr_default'] = 'CR Default';
    return array_merge( $sizes, $image_sizes_labels);
}

/**
 * Enqueue scripts and styles.
 */
function crt_scripts() {
	wp_enqueue_style('crt-google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700|Playfair+Display:400');
	wp_enqueue_style( 'crt-main-style', get_template_directory_uri() . '/assets/css/main.min.css' );
	wp_enqueue_style( 'crt-custom-style', get_stylesheet_directory_uri() . '/assets/css/custom.css' );
	wp_enqueue_script( 'crt-modernizr', get_template_directory_uri() . '/assets/library/modernizr-custom.js', array(), NULL, true );
	if(!crt_get_theme_mode( 'enable_enquire_button', '')) {
		wp_enqueue_script( 'mCustomScrollbar', get_template_directory_uri() . '/assets/library/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js', array('jquery'), NULL, true  );
		wp_enqueue_style( 'mCustomScrollbar', get_template_directory_uri() . '/assets/library/mCustomScrollbar/jquery.mCustomScrollbar.min.css' );
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script('jquery-ui-autocomplete');
	}
	$script_data = array(
		'ajaxURL' => admin_url( '/admin-ajax.php' ),
	);
	wp_enqueue_script( 'crt-main-script', get_template_directory_uri() . '/assets/js/main.min.js', array('jquery', 'crt-modernizr'), NULL, true );
	wp_enqueue_script( 'crt-custom-script', get_stylesheet_directory_uri() . '/assets/js/custom.js', array('jquery'), NULL, true );
	wp_localize_script('crt-main-script', 'CRTSettings', $script_data);
	
	// Seasonal Styles
	$seasonal_styles = crt_get_theme_mode('seasonal_styles', 'none');
	if($seasonal_styles && ('none' != $seasonal_styles)) {
		$seasonal_stylesheet_url = get_stylesheet_directory_uri() . '/assets/css/season-' . $seasonal_styles .'.css';
		wp_enqueue_style( 'crt-seasonal-style', $seasonal_stylesheet_url );
	}
}
add_action( 'wp_enqueue_scripts', 'crt_scripts', 20);

/**
 * Register themes sidbars
 */
function crt_register_sidebars() {
	register_sidebar( array(
        'name' => __( 'Blog Sidebar', 'crt' ),
        'id' => 'sidebar-blog',
        'description' => __( 'Widgets in this area will be shown on blog page and single blog article.', 'crt' ),
        'before_widget' => '<div id="%1$s" class="cr-blog-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="cr-blog-widget-title">',
		'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'crt_register_sidebars' );

function crt_page_title($title) {
	$custom_title = '';
	if ( is_404() ) {
		$custom_title = crt_get_theme_mode( '404_doc_title', '');
	}
	if($custom_title){
		$title['title'] = $custom_title;
	}
	return $title;
}
add_filter('document_title_parts', 'crt_page_title');
