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
		require_once $this->path('INC_DIR', 'class-custom-types.php');
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
		
		add_action('cr_before_footer', array(
			$this,
			'before_footer'
		), 20);
		add_action('wp_ajax_cr_update_instagram_feed_cache', array(
			$this,
			'update_instagram_feed_cache'
		));
		add_action('wp_ajax_nopriv_cr_update_instagram_feed_cache', array(
			$this,
			'update_instagram_feed_cache'
		));
		if(!defined('ICL_SITEPRESS_VERSION')){
			add_filter('posts_join', array(
				$this,
				'hide_wpml_translations_join'
			), 10, 2);
			add_filter('posts_where', array(
				$this,
				'hide_wpml_translations_where'
			), 10, 2);
		}
		
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
		if(!crt_get_theme_mode( 'enable_enquire_button', '')) {
			$classes[] = $this->get_booking_panel_class();
		}
		return $classes;
	}
	public function get_booking_panel_class() {
		$panel_color = crt_get_theme_mode( 'booking_panel_color', '');
		if(!in_array($panel_color, array('white', 'black'))) {
			$panel_color = 'white';
		}
		return 'bp-color-' . $panel_color;
	}
	public function get_page_type() {
		$page_type = '';
		if( is_home() && !is_front_page() && ($page_for_posts = get_option ( 'page_for_posts' )) ){
			$page_type = function_exists('get_field') ? get_field('page_type', $page_for_posts) : get_post_meta($page_for_posts, 'page_type', true);
		}elseif ( is_singular() ) {
			$page_type = function_exists('get_field') ? get_field('page_type', get_queried_object_id()) : get_post_meta(get_queried_object_id(), 'page_type', true);
		}
		if(!$page_type || 'default' == $page_type) {
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
	
	public function before_footer() {
		$this->footer_instragram_feed();
	}
	
	public function footer_instragram_feed() {
		$enabled = '';
		if ( is_singular() ) {
			$enabled = function_exists('get_field') ? get_field('footer_instagram_feed', get_queried_object_id()) : get_post_meta(get_queried_object_id(), 'footer_instagram_feed', true);
		}
		if(!$enabled || 'default' == $enabled) {
			$enabled = crt_get_theme_mode('instagram_feed_footer_enable', 'disabled');
		}
		$enabled = 'enabled' == $enabled ? true : false;
		if(!$enabled) {
			return '';
		}
		get_template_part('modules/instagram-feed/instagram-feed');
	}
	
	public function update_instagram_feed_cache() {
		if(empty($_POST['feeds']) || !is_array($_POST['feeds']) || count($_POST['feeds']) < 1){
			return;
		}
		// Validate the feed
		$instagram_user_name = crt_get_theme_mode('instagram_feed_username', '');
		$expiration = crt_get_theme_mode('instagram_feed_cache_expiration', '');
		$expiration = absint($expiration);
		if(!$expiration) {
			$expiration = 2;
		}
		$validated_feeds = array();
		$valid = true;
		
		foreach ($_POST['feeds'] as $feed) {
			$feed = wp_parse_args($feed, array(
				'id' => '',
				'camption' => '',
				'url' => '',
				'likes' => 0,
				'comments' => 0,
				'plink'	   => '',
				'username' => '',
			));
			if($feed['username'] != $instagram_user_name) {
				continue;
			}
			$validated_feeds[] = $feed;
		}
		
		if(count($validated_feeds) > 0) {
			set_transient('cr_instagram_feed', $validated_feeds, $expiration * HOUR_IN_SECONDS);
		}else{
			wp_send_json(array(
				'status' => 'NOTOK',
			));
		}
		$number = crt_get_theme_mode( 'instagram_feed_number', '');
		$cc_enabled = crt_get_theme_mode( 'instagram_feed_cc_enable', '');
		$cc_position = crt_get_theme_mode( 'instagram_feed_cc_pos', '');
		$cc_text = crt_get_theme_mode( 'instagram_feed_cc_text', '');
		$cc_link_title = crt_get_theme_mode( 'instagram_feed_cc_link_title', '');
		$cc_link_url = crt_get_theme_mode( 'instagram_feed_cc_link_url', '');
		$cc_link_nt = crt_get_theme_mode( 'instagram_feed_cc_link_nt', '');

		$number = absint($number);
		if(!$number) {
			$number = 13;
		}
		$cc_position = absint($cc_position);
		if(!$cc_position) {
			$cc_position = 7;
		}
		$output = '';
		ob_start();
		$count = 0;
		$custom_content_shown = false;
		foreach($validated_feeds as $item){
			$count++;
			if($count > $number){
				break;
			}
			if($cc_enabled && $count == $cc_position ){
				$custom_content_shown = true;
				include locate_template('modules/instagram-feed/instagram-feed-custom-item.php');
			}
			include locate_template('modules/instagram-feed/instagram-feed-item.php');
			
		}
		if(!$custom_content_shown) {
			$custom_content_shown = true;
			include locate_template('modules/instagram-feed/instagram-feed-custom-item.php');
		}
		$output = ob_get_clean();
		if(!$output) {
			wp_send_json(array(
				'status' => 'NOTOK',
			));
		}
		wp_send_json(array(
			'status' => 'OK',
			'html' => $output,
		));
	}
	
	public function hide_wpml_translations_join($join, $query) {
		global $wpdb;
		$join .= " LEFT JOIN {$wpdb->postmeta} AS cr_wpml_meta ON ( cr_wpml_meta.post_id = {$wpdb->posts}.ID AND cr_wpml_meta.meta_key = 'wpml_media_processed' )";
		return $join;
	}
	
	public function hide_wpml_translations_where($where, $query) {
		global $wpdb;
		$where .= " AND (cr_wpml_meta.post_id IS NULL) ";
		return $where;
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