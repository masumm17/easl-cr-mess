<?php
/*
Plugin Name: WPBakery Page Builder Extension for Cheval Residences 
Plugin URI: http://wpbakery.com/vc
Description: Extension pacakge for CR.
Version: 1.0
Author: Soto
Author URI: http://www.gosoto.co/
License: GPLv2 or later
*/


// don't load directly
if (!defined('ABSPATH')) die('-1');

define('CR_VCE_VERSION', '1.0');

class CR_VcE_Manager {
	/**
	 * Core singleton class
	 * @var self - pattern realization
	 */
	private static $_instance;
	
	private $customizer;
	
	/** 
	 * List of paths.
	 *
	 * @since 1.0
	 * @var array
	 */
	private $paths = array();
	
	/** 
	 * List of registered shortcodes.
	 *
	 * @since 1.0
	 * @var array
	 */
	private $registered_shortcodes = array();
	/** 
	 * List of active shortcodes.
	 *
	 * @since 1.0
	 * @var array
	 */
	private $active_shortcodes = array();
	
	/**
	 * Constructor loads API functions, defines paths and adds required wp actions
	 *
	 * @since  1.0
	 */
	private function __construct() {
		$dir = dirname( __FILE__ );
		/**
		 * Define path settings for WPBakery Page Builder.
		 *
		 * APP_ROOT        - plugin directory.
		 * HELPERS_DIR     - directory with helpers functions files.
		 * SHORTCODES_DIR  - shortcodes classes.
		 * TEMPLATES_DIR   - directory where all html templates are hold.
		 * PARAMS_DIR      - complex params for shortcodes editor form.
		 * ASSETS_DIR      - asset directory full path.
		 * ASSETS_DIR_NAME - directory name for assets. Used from urls creating.
		 */
		$this->set_paths( array(
			'APP_ROOT' => $dir,
			'CORE_DIR' => $dir . '/include/core',
			'PARAMS_DIR' => $dir . '/include/params',
			'SHORTCODES_DIR' => $dir . '/include/shortcodes',
			'HELPERS_DIR' => $dir . '/include/helpers',
			'TEMPLATES_DIR' => $dir . '/include/templates',
			'THIRD_PARTY' => $dir . '/include/third-party',
			'ASSETS_DIR' => $dir . '/assets',
			'ASSETS_DIR_NAME' => 'assets',
		) );
		//Load files
		require $this->path('HELPERS_DIR', 'helper.php');
		require $this->path('APP_ROOT', 'include/customizer/customizer.php');
		require $this->path('APP_ROOT', 'include/map-builder/map-builder.php');
		require $this->path('THIRD_PARTY', 'gravity-form/gravity-form.php');
		// Add hooks
		add_action( 'plugins_loaded', array(
			$this,
			'plugins_loaded',
		), 9 );
		register_activation_hook( __FILE__, array(
			$this,
			'activation_hook',
		) );
		if(!$this->VC_installed()) {
			add_action( 'admin_notices', array( 
				$this, 
				'vc_map_dependencies' 
			) );
		}
		add_action( 'init', array(
			$this,
			'init',
		), 8 );
		
	}
	/**
	 * Include files those are dependent on VC
	 */
	private function include_vc_dependencies() {
		require $this->path('CORE_DIR', 'cr-shortcodes.php');
		require $this->path('CORE_DIR', 'class-cr-scbase.php');
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
		load_plugin_textdomain( 'crvc_extension', false, $this->path( 'APP_ROOT', 'locale' ) );
		// Set up Customizer
		$this->customizer = new CR_VcE_Customizer($this->path('APP_ROOT', 'include/customizer/'));
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
		if(!$this->VC_installed()) {
			return;
		}
		$this->include_vc_dependencies();
		$this->load_registered_shortcodes();
		// Allow to add shortcodes
		do_action('cr_register_tags');
		$this->load_custom_params();
		// Get active shortcodes
		$this->load_active_shortcodes();
		// Map shortcodes
		add_action('vc_after_mapping', array(
			$this,
			'map_shortcodes'
		));
		
		add_action('vc_backend_editor_enqueue_js_css', array(
			$this,
			'backend_enqueue_editor_css_js'
		));
		add_action('vc_frontend_editor_enqueue_js_css', array(
			$this,
			'frontend_enqueue_editor_css_js'
		));
		
		add_action('wp_enqueue_scripts', array(
			$this,
			'frontend_enqueue_css_js'
		));
		add_action('wp_enqueue_scripts', array(
			$this,
			'vc_scripts_override'
		), 101);
		
		add_action('cr_before_footer', array(
			$this,
			'cr_before_footer'
		));
		
	}
	
	/**
	 * Enqueue required javascript libraries and css files for backend editor.
	 *
	 * @since  1.0
	 * @access public
	 */
	public function backend_enqueue_editor_css_js() {
		wp_enqueue_script('crvc-backend', $this->asset_url( 'js/backend-editor.js' ), array(), CR_VCE_VERSION, true);
		wp_enqueue_style('crvc-backend', $this->asset_url( 'css/backend-editor.css' ), array(), CR_VCE_VERSION);
	}
	
	/**
	 * Enqueue required javascript libraries and css files for frontend editor.
	 *
	 * @since  1.0
	 * @access public
	 */
	public function frontend_enqueue_editor_css_js() {
		wp_enqueue_script('crvc-frontend-editor', $this->asset_url( 'js/frontend-editor.js' ), array(), CR_VCE_VERSION, true);
		wp_enqueue_style('crvc-frontend-editor', $this->asset_url( 'css/frontend-editor.css'), array(), CR_VCE_VERSION);
	}
	/**
	 * Enqueue required javascript libraries and css files for frontend.
	 *
	 * @since  1.0
	 * @access public
	 */
	public function frontend_enqueue_css_js() {
		wp_register_script('slider-revolution', $this->asset_url( 'library/slider-revolution/js/jquery.themepunch.revolution.min.js' ), array('jquery'), NULL, true);
		wp_register_style('slider-revolution', $this->asset_url( 'library/slider-revolution/css/combined.css'), array(), NULL);
		
		wp_register_script('slick', $this->asset_url( 'library/slick/slick.min.js' ), array('jquery'), NULL, true);
		wp_register_style('slick', $this->asset_url( 'library/slick/slick.css'), array(), NULL);
		
		wp_register_script('fancybox', $this->asset_url( 'library/fancybox/jquery.fancybox.min.js' ), array('jquery'), NULL, true);
		wp_register_style('fancybox', $this->asset_url( 'library/fancybox/jquery.fancybox.css'), array(), NULL);
		
		wp_register_script('js-img-slider', $this->asset_url( 'library/js-img-slider/js-img-slider.min.js' ), array('jquery'), NULL, true);
		
		wp_register_script('waitforimages', $this->asset_url( 'library/jquery.waitforimages.min.js' ), array('jquery'), NULL, true);
		wp_register_script('cr-masonry', $this->asset_url( 'library/masonry.pkgd.min.js' ), array('jquery'), NULL, true);
		
		wp_register_script('cr-wpb', $this->asset_url( 'js/frontend.min.js' ), array('jquery', 'waitforimages', 'fancybox', 'slider-revolution', 'waypoints', 'slick', 'js-img-slider', 'cr-masonry'), NULL, true);
		wp_register_style('cr-wpb', $this->asset_url( 'css/frontend.min.css' ), array('fancybox', 'slider-revolution', 'slick'), NULL);
		
		$script_data = array(
			'ajaxURL' => admin_url( '/admin-ajax.php' ),
			'siteURL' => get_site_url(),
		);
		
		wp_localize_script('cr-wpb', 'crSettings', $script_data);
		
		wp_enqueue_style('cr-wpb');
		wp_enqueue_script('cr-wpb');
		
	}
	
	public function vc_scripts_override(){
		if( is_admin() || vc_is_frontend_editor()){
			return;
		}
		wp_deregister_script( 'waypoints' );
		wp_dequeue_script( 'waypoints' );
		wp_register_script('waypoints', $this->asset_url( 'library/waypoints/jquery.waypoints.min.js' ), array('jquery'), '4.0.1', true);
		
	}

	/**
	 * Enables to add hooks in activation process.
	 * @since 1.0
	 *
	 * @param $networkWide
	 */
	public function activation_hook( $networkWide = false ) {
		// Functions on activation
	}
	/**
	 * Load registered shortcodes
	 */
	public function load_registered_shortcodes() {
		$sc_dir = $this->path('SHORTCODES_DIR');
		$this->registered_shortcodes['cr_hero_slider'] = array(
			'name' => __('Hero Image/Video Slider', 'crvc_extension'),
			'file' => $sc_dir . '/hero-slider/class-hero-slider.php',
		);
		$this->registered_shortcodes['cr_hero_slider_item'] = array(
			'name' => __('Hero Image/Video Slider Item', 'crvc_extension'),
			'file' => $sc_dir . '/hero-slider-item/class-hero-slider-item.php',
		);
		$this->registered_shortcodes['cr_title_subtitle'] = array(
			'name' => __('Title & Subtitle', 'crvc_extension'),
			'file' => $sc_dir . '/title-subtitle/class-title-subtitle.php',
		);
		$this->registered_shortcodes['cr_single_col_content'] = array(
			'name' => __('Single Column Content', 'crvc_extension'),
			'file' => $sc_dir . '/single-col-content/class-single-col-content.php',
		);
		$this->registered_shortcodes['cr_title_icons'] = array(
			'name' => __('Title & Icons', 'crvc_extension'),
			'file' => $sc_dir . '/title-icons/class-title-icons.php',
		);
		$this->registered_shortcodes['cr_two_col_content'] = array(
			'name' => __('Two Column Content', 'crvc_extension'),
			'file' => $sc_dir . '/two-col-content/class-two-col-content.php',
		);
		$this->registered_shortcodes['cr_property_slider'] = array(
			'name' => __('Property Slider', 'crvc_extension'),
			'file' => $sc_dir . '/property-slider/class-property-slider.php',
		);
		$this->registered_shortcodes['cr_property_slider_item'] = array(
			'name' => __('Property Slider Item', 'crvc_extension'),
			'file' => $sc_dir . '/property-slider-item/class-property-slider-item.php',
		);
		$this->registered_shortcodes['cr_fixed_width_grid'] = array(
			'name' => __('Fixed Width Grid', 'crvc_extension'),
			'file' => $sc_dir . '/fixed-width-grid/class-fixed-width-grid.php',
		);
		$this->registered_shortcodes['cr_fixed_width_grid_item'] = array(
			'name' => __('Fixed Width Grid Item', 'crvc_extension'),
			'file' => $sc_dir . '/fixed-width-grid-item/class-fixed-width-grid-item.php',
		);
		$this->registered_shortcodes['cr_full_width_grid'] = array(
			'name' => __('Full Width Grid', 'crvc_extension'),
			'file' => $sc_dir . '/full-width-grid/class-full-width-grid.php',
		);
		$this->registered_shortcodes['cr_full_width_grid_item'] = array(
			'name' => __('Full Width Grid Item', 'crvc_extension'),
			'file' => $sc_dir . '/full-width-grid-item/class-full-width-grid-item.php',
		);
		$this->registered_shortcodes['cr_expanding_images'] = array(
			'name' => __('Expanding Images', 'crvc_extension'),
			'file' => $sc_dir . '/expanding-images/class-expanding-images.php',
		);
		$this->registered_shortcodes['cr_expanding_image_item'] = array(
			'name' => __('Expanding Image Item', 'crvc_extension'),
			'file' => $sc_dir . '/expanding-image-item/class-expanding-image-item.php',
		);
		$this->registered_shortcodes['cr_mini_grid_gallery'] = array(
			'name' => __('Mini Grid Gallery', 'crvc_extension'),
			'file' => $sc_dir . '/mini-grid-gallery/class-mini-grid-gallery.php',
		);
		$this->registered_shortcodes['cr_map'] = array(
			'name' => __('Map', 'crvc_extension'),
			'file' => $sc_dir . '/map/class-map.php',
		);
		$this->registered_shortcodes['cr_gallery'] = array(
			'name' => __('Gallery', 'crvc_extension'),
			'file' => $sc_dir . '/gallery/class-gallery.php',
		);
		$this->registered_shortcodes['cr_gallery_item'] = array(
			'name' => __('Gallery Item', 'crvc_extension'),
			'file' => $sc_dir . '/gallery-item/class-gallery-item.php',
		);
		$this->registered_shortcodes['cr_accommodations'] = array(
			'name' => __('Accommodations', 'crvc_extension'),
			'file' => $sc_dir . '/accommodations/class-accommodations.php',
		);
		$this->registered_shortcodes['cr_enquiry_form'] = array(
			'name' => __('Enquiry Form', 'crvc_extension'),
			'file' => $sc_dir . '/enquiry-form/class-enquiry-form.php',
		);
		$this->registered_shortcodes['cr_sitemap'] = array(
			'name' => __('Sitemap', 'crvc_extension'),
			'file' => $sc_dir . '/sitemap/class-sitemap.php',
		);
		$this->registered_shortcodes['cr_instagram_feed'] = array(
			'name' => __('Instagram Feed', 'crvc_extension'),
			'file' => $sc_dir . '/instagram-feed/class-instagram-feed.php',
		);
		$this->registered_shortcodes['cr_virtual_tour'] = array(
			'name' => __('Embed Virtual Tour', 'crvc_extension'),
			'file' => $sc_dir . '/virtual-tour/class-virtual-tour.php',
		);
		$this->registered_shortcodes['cr_allora_integration'] = array(
			'name' => __('Allora Integration', 'crvc_extension'),
			'file' => $sc_dir . '/allora-integration/class-allora-integration.php',
		);
		$this->registered_shortcodes['cr_gravity_form'] = array(
			'name' => __('Gravity Form', 'crvc_extension'),
			'file' => $sc_dir . '/gravity-form/class-gravity-form.php',
		);
		$this->registered_shortcodes['cr_advent_calendar'] = array(
			'name' => __('Advent Calendar', 'crvc_extension'),
			'file' => $sc_dir . '/advent-calendar/class-advent-calendar.php',
		);
	}
	/**
	 * Load active shortcodes
	 * @since 1.0
	 */
	public function load_active_shortcodes() {
		$this->active_shortcodes = array(
			'cr_hero_slider', 
			'cr_hero_slider_item',
			'cr_title_subtitle',
			'cr_single_col_content',
			'cr_title_icons',
			'cr_two_col_content',
			'cr_property_slider',
			'cr_property_slider_item',
			'cr_fixed_width_grid',
			'cr_fixed_width_grid_item',
			'cr_full_width_grid',
			'cr_full_width_grid_item',
			'cr_expanding_images',
			'cr_expanding_image_item',
			'cr_mini_grid_gallery',
			'cr_map',
			'cr_gallery',
			'cr_gallery_item',
			'cr_accommodations',
			'cr_enquiry_form',
			'cr_sitemap',
			'cr_instagram_feed',
			'cr_virtual_tour',
			'cr_allora_integration',
			'cr_gravity_form',
			'cr_advent_calendar',
		);
	}
	
	public function map_shortcodes() {
		foreach ($this->registered_shortcodes as $tag => $settings) {
			if(!in_array( $tag, $this->active_shortcodes )) {
				continue;
			}
			if( file_exists($settings['file'])){
				require_once $settings['file'];
			}
		}
		vc_remove_element( 'gravityform' );
	}
	
	public function load_custom_params() {
		require $this->path('PARAMS_DIR', 'posts-dropdown.php');
	}
	/**
	 * Display global footer modules
	 */
	public function cr_before_footer() {
		$this->footer_dispaly_stay_connected();
	}
	
	public function footer_dispaly_stay_connected() {
		$enabled = '';
		if ( is_singular() ) {
			$enabled = function_exists('get_field') ? get_field('stay_con_mod', get_queried_object_id()) : get_post_meta(get_queried_object_id(), 'stay_con_mod', true);
		}
		
		if(!$enabled || 'default' == $enabled) {
			$enabled = crt_get_theme_mode('stay_con_mod', 'enabled');
		}
		if('enabled' != $enabled) {
			return;
		}
		
		include $this->path('TEMPLATES_DIR', '/non-shortcodes/footer-stay-connected.php');
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

	/**
	 * Get absolute url for VC asset file.
	 *
	 * Assets are css, javascript, less files and images.
	 *
	 * @since 1.0
	 *
	 * @param $file
	 *
	 * @return string
	 */
	public function asset_url( $file ) {
		return preg_replace( '/\s/', '%20', plugins_url( $this->path( 'ASSETS_DIR_NAME', $file ), __FILE__ ) );
	}
	/**
	 * Check if VC is installed and active.
	 *
	 * @since 1.0
	 *
	 * @return bool
	 */
	public function VC_installed() {
		return defined( 'WPB_VC_VERSION' );
	}
	/**
	 * Show admin notice that VC is not installed.
	 *
	 * @since 1.0
	 *
	 * @return bool
	 */
	public function vc_map_dependencies() {
		if ( !$this->VC_installed() ) {
			$plugin_data = get_plugin_data( __FILE__ );
			echo '
			<div class="updated">
			  <p>' . sprintf( __( '<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'crvc_extension' ), $plugin_data[ 'Name' ] ) . '</p>
			</div>';
		}
	}
}
// Finally initialize code
CR_VCE_Manager::get_instance();