<?php
/*
Plugin Name: Cheval Resdences Theme Core
Description: Core fetures for Cheval Resdences Theme
Version: 1.0
Author: Soto
Author URI: http://www.gosoto.co/
License: GPLv2 or later
*/
// don't load directly
if (!defined('ABSPATH')) die('-1');

define('CR_CORE_VERSION', '1.0');

final class CR_Core {
	/**
	 * Core singleton class
	 * @var self - pattern realization
	 */
	private static $_instance;
	
	private $custom_types;
	
	private $customizer;
	
	/**
	 * Constructor loads API functions, defines paths and adds required wp actions
	 *
	 * @since  1.0
	 */
	private function __construct() {
		$dir = dirname( __FILE__ );
		$this->set_paths( array(
			'ROOT' => $dir,
			'INC_DIR' => $dir . '/include',
			'HELPERS_DIR' => $dir . '/include/helpers',
		) );
		// Include files
		require_once $this->path('INC_DIR', 'helpers.php');
		require_once $this->path('INC_DIR', 'classs-custom-types.php');
		require_once $this->path('INC_DIR', 'customizer/customizer.php');
		
		$this->custom_types = CR_Custom_types::instance();
		// Add hooks
		add_action( 'plugins_loaded', array(
			$this,
			'plugins_loaded',
		), 9 );
		register_activation_hook( __FILE__, array(
			$this,
			'activation_hook',
		) );
		add_action( 'init', array(
			$this,
			'init',
		), 8 );
		add_filter( 'body_class', array(
			$this,
			'body_class',
		), 8 );
		
	}
	/**
	 * Get the instance of CR_VCE_Manager
	 *
	 * @return self
	 */
	public static function get_instance() {
		if ( ! ( self::$_instance instanceof self ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Callback function WP plugin_loaded action hook. Loads locale
	 *
	 * @since  1.0
	 * @access public
	 */
	public function plugins_loaded() {
		// Setup locale
		load_plugin_textdomain( 'crt', false, $this->path( 'APP_DIR', 'locale' ) );
		// Set up Customizer
		$this->customizer = new CRT_Customizer($this->path('INC_DIR', 'customizer/'));
	}
	/**
	 * Callback function for WP init action hook. Sets Vc mode and loads required objects.
	 *
	 * @since  1.0
	 * @access public
	 *
	 * @return void
	 */
	public function init() {
		$this->custom_types();
		
	}
	
	public function custom_types() {
		
	}
	
	public function body_class($classes) {
		if('with_hero_slider' == $this->get_page_type()){
			$classes[] = 'fixed-header';
		}else{
			$classes[] = 'scroll-header';
		}
		$classes[] = $this->get_color_theme();
		return $classes;
	}
	
	public function get_page_type() {
		$page_type = '';
		if ( is_singular() ) {
			$page_type = function_exists('get_field') ? get_field('page_type', get_queried_object_id()) : get_post_meta(get_queried_object_id(), 'page_type', true);
		}
		if(!$page_type) {
			$page_type = crt_get_theme_mode('default_page_types', 'minimal');
		}
		return $page_type;
	}
	
	public function get_color_theme() {
		if(!empty($_GET['color_theme'])){
			return 'theme-' . sanitize_key($_GET['color_theme']);
		}
		$color_theme = '';
		if ( is_singular() ) {
			$color_theme = function_exists('get_field') ? get_field('color_theme', get_queried_object_id()) : get_post_meta(get_queried_object_id(), 'color_theme', true);
		}
		if(!$color_theme || 'default' == $color_theme) {
			$color_theme = crt_get_theme_mode('color_theme', '');
		}
		
		if(!$color_theme) {
			$color_theme = 'theme-base';
		}else{
			$color_theme = 'theme-' . $color_theme;
		}
		
		return $color_theme;
	}

	/**
	 * Enables to add hooks in activation process.
	 * @since 1.0
	 *
	 * @param $networkWide
	 */
	public function activation_hook( $networkWide = false ) {
		flush_rewrite_rules();
	}

	/**
	 * Setter for paths
	 *
	 * @since  1.0
	 * @access protected
	 *
	 * @param $paths
	 */
	protected function set_paths( $paths ) {
		$this->paths = $paths;
	}

	/**
	 * Gets absolute path for file/directory in filesystem.
	 *
	 * @since  1.0
	 * @access public
	 *
	 * @param $name - name of path dir
	 * @param string $file - file name or directory inside path
	 *
	 * @return string
	 */
	public function path( $name, $file = '' ) {
		$path = $this->paths[ $name ] . ( strlen( $file ) > 0 ? '/' . preg_replace( '/^\//', '', $file ) : '' );
		
		return $path;
	}
	
}
if(!isset($crt_theme_mods)){
	$crt_theme_mods = get_theme_mods();
}
function crt_get_core() {
	return CR_Core::get_instance();
}
// Finally initialize code
CR_Core::get_instance();