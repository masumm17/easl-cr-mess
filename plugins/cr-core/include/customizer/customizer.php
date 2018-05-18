<?php
if (!defined('ABSPATH')) die('-1');
class CRT_Customizer {
	private $settings_path;
	/**
	 * Start things up
	 *
	 * @since 1.0
	 */
	function __construct($root_path) {
		$this->settings_path = $root_path . '/modules-settings/';
		add_action( 'customize_register', array( $this, 'include_controls' ) );
		add_action( 'customize_register', array( $this, 'add_modules_sections' ));
		add_action( 'customize_register', array( $this, 'remove_core_sections' ), 21 );
	}
	
	public function remove_core_sections( $wp_customize ) {
		// Remove core sections
		//$wp_customize->remove_section( 'title_tagline' );
		$wp_customize->remove_section( 'colors' );
		$wp_customize->remove_section( 'header_image' );
		$wp_customize->remove_control( 'background_image' );
		$wp_customize->remove_section( 'nav_menus' );
		$wp_customize->remove_section( 'widgets' );
		$wp_customize->remove_section( 'static_front_page' );
		$wp_customize->remove_section( 'custom_css' );
		//$wp_customize->remove_section( 'themes' );

		// Remove core controls
//		$wp_customize->remove_control( 'blogdescription' );
//
//		$wp_customize->remove_control( 'header_textcolor' );
//		$wp_customize->remove_control( 'background_color' );
//
//		// Remove default settings
//		$wp_customize->remove_setting( 'background_color' );
//		$wp_customize->remove_setting( 'background_image' );


	}
	
	/**
	 * Adds custom controls
	 *
	 * @since 1.0
	 */
	public function include_controls() {
		
	}

	/**
	 * Registers new controls
	 * Removes default customizer sections and settings
	 * Adds new customizer sections, settings & controls
	 *
	 * @since 1.0
	*/
   public function add_modules_sections( $wp_customize ) {
		$panel_id = $wp_customize->get_panel('module_settings');
		if(empty($panel_id)){
			$wp_customize->add_panel( 'module_settings', array(
				'title' => __( 'Modules Settings', 'crt' ),
				'description' => __( 'Module settings','crt'),
				'priority' => 180,
			) );
		}
		$this->add_section_settings('general', $wp_customize);
		$this->add_section_settings('header', $wp_customize);
		$this->add_section_settings('footer', $wp_customize);
   }
   public function add_section_settings($sectiono_id, $wp_customize) {
	   require_once  $this->settings_path . str_replace( '_', '-', $sectiono_id ).'.php';
		
   }
}