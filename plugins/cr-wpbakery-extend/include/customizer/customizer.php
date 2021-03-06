<?php
if (!defined('ABSPATH')) die('-1');
class CR_VcE_Customizer {
	private $settings_path;
	private $manager;
	/**
	 * Start things up
	 *
	 * @since 1.0
	 */
	function __construct($root_path) {
		$this->settings_path = $root_path . '/modules-settings/';
		add_action( 'customize_register', array( $this, 'include_controls' ) );
		add_action( 'customize_register', array( $this, 'add_modules_sections' ));
		add_action( 'customize_controls_print_styles', array( $this, 'print_styles' ), 21 );
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
				'title' => __( 'Modules Settings', 'crvc_extension' ),
				'description' => __( 'Module settings','crvc_extension'),
				'priority' => 180,
			) );
		}
		$this->add_section_settings('title_icons', $wp_customize);
		$this->add_section_settings('mini_grid_gallery', $wp_customize);
		$this->add_section_settings('map', $wp_customize);
		$this->add_section_settings('property_slider', $wp_customize);
		$this->add_section_settings('enquiry_form', $wp_customize);
		$this->add_section_settings('allora_integration', $wp_customize);
   }
   public function add_section_settings($sectiono_id, $wp_customize) {
	   require_once  $this->settings_path . str_replace( '_', '-', $sectiono_id ).'.php';
		
   }
   public function print_styles() {
	?> 
<style type="text/css" id="wpex-customizer-controls-css">
	#_customize-input-cr_enquiry_form_code {
		font-size: 11px;
		font-family: monospace;
		line-height: 1.5em;
		height: 400px;
	}
</style>
	<?php
   }
}