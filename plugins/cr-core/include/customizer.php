<?php
if (!defined('ABSPATH')) die('-1');
class CRT_Customizer {
	/**
	 * Start things up
	 *
	 * @since 1.0
	 */
	function __construct() {
		add_action( 'customize_register', array( $this, 'include_controls' ) );
		add_action( 'customize_register', array( $this, 'remove_core_sections' ), 21 );
		add_action( 'customize_register', array( $this, 'add_sections_panel_settings' ));
	}
	
	/**
	 * Adds custom controls
	 *
	 * @since 1.0
	 */
	public function include_controls() {
		
	}

	/**
	 * Removes core modules
	 *
	 * @since 1.0
	 */
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
	 * Registers new controls
	 * Removes default customizer sections and settings
	 * Adds new customizer sections, settings & controls
	 *
	 * @since 1.0
	*/
   public function add_sections_panel_settings( $wp_customize ) {
		$wp_customize->add_section( 'crt_header', array(
			'title' => __( 'Header', 'crt' ),
			'priority' => 160,
			'capability' => 'edit_theme_options',
		) );
		$wp_customize->add_setting( 'site_main_logo', array(
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default' => '',
			'transport' => 'refresh',
		) );
		$wp_customize->add_setting( 'fixed_header_logo', array(
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default' => '',
			'transport' => 'refresh',
		) );
		$wp_customize->add_setting( 'search_availabilty_link', array(
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default' => '',
			'transport' => 'refresh',
		) );
		$wp_customize->add_setting( 'search_availabilty_title', array(
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default' => '',
			'transport' => 'refresh',
		) );
		$wp_customize->add_setting( 'search_availabilty_nt', array(
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default' => '',
			'transport' => 'refresh',
		) );
		$wp_customize->add_setting( 'fixed_header_logo', array(
			'type' => 'theme_mod',
			'capability' => 'edit_theme_options',
			'default' => '',
			'transport' => 'refresh',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'site_main_logo', array(
			'label' => __( 'Site Main Logo', 'crt' ),
			'section' => 'crt_header',
		) ) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fixed_header_logo', array(
			'label' => __( 'Fixed Header Logo', 'crt' ),
			'section' => 'crt_header',
		) ) );
		$wp_customize->add_control( 'search_availabilty_link', array(
			'type' => 'url',
			'label' => __( 'Search Availabilty Link', 'crt' ),
			'section' => 'crt_header',
		) );
		$wp_customize->add_control( 'search_availabilty_title', array(
			'type' => 'text',
			'label' => __( 'Search Availabilty Title', 'crt' ),
			'section' => 'crt_header',
		) );
		$wp_customize->add_control( 'search_availabilty_nt', array(
			'type' => 'checkbox',
			'label' => __( 'Search Availabilty New Tab', 'crt' ),
			'section' => 'crt_header',
		) );
   }
}