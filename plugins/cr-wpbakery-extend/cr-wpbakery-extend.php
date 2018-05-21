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
			'ASSETS_DIR' => $dir . '/assets',
			'ASSETS_DIR_NAME' => 'assets',
		) );
		//Load files
		require $this->path('HELPERS_DIR', 'helper.php');
		require $this->path('APP_ROOT', 'include/customizer/customizer.php');
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
		load_plugin_textdomain( 'crvc_extension', false, $this->path( 'APP_DIR', 'locale' ) );
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
		
		wp_register_script('js-img-slider', $this->asset_url( 'library/js-img-slider/js-img-slider.min.js' ), array('jquery'), NULL, true);
		
		wp_register_script('cr-wpb', $this->asset_url( 'js/frontend.min.js' ), array('jquery', 'slider-revolution', 'waypoints', 'slick', 'js-img-slider'), NULL, true);
		wp_register_style('cr-wpb', $this->asset_url( 'css/frontend.min.css' ), array('slider-revolution', 'slick'), NULL);
		
		wp_enqueue_style('cr-wpb');
		wp_enqueue_script('cr-wpb');
		
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
		);
	}
	
	public function map_shortcodes() {
		foreach ($this->registered_shortcodes as $tag => $settings) {
			if(!in_array( $tag, $this->active_shortcodes )) {
				continue;
			}
			require_once $settings['file'];
		}
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
			  <p>' . sprintf( __( '<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'vc_extend' ), $plugin_data[ 'Name' ] ) . '</p>
			</div>';
		}
	}
}
// Finally initialize code
CR_VCE_Manager::get_instance();