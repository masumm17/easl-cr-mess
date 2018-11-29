<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

return array(
	'name' => __( 'Advent Calendar', 'crvc_extension' ),
	'base' => 'cr_advent_calendar',
	'icon' => 'vc_icon-vc-media-grid',
	'is_container' => false,
	'show_settings_on_create' => false,
	'category' => __( 'Cheval Residences', 'crvc_extension' ),
	'description' => __( 'Embed advent calendar.', 'crvc_extension' ),
	'params' => array_merge(
		array(
			array(
				'type' => 'dropdown',
				'heading' => __( 'Size', 'crvc_extension' ),
				'param_name' => 'size',
				'std' => 'full_screen',
				'value' => array(
					__( 'Full Browser Width', 'crvc_extension' ) => 'full_width',
					__( 'Full Container Width', 'crvc_extension' ) => 'full_con_width',
					__( 'Full Screen', 'crvc_extension' ) => 'full_screen',
					__( 'Custom', 'crvc_extension' ) => 'custom',
				),
				'description' => __( 'Set size of the advent calendar.', 'crvc_extension' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Width', 'crvc_extension' ),
				'param_name' => 'width',
				'value' => '',
				'description' => __( 'Enter width of the advent calendar. Example: 80vw, 75%, 1200px. Default is 100%. ', 'crvc_extension' ),
				'admin_label' => false,
				'admin_label' => false,
				'dependency' => array(
					'element' => 'size',
					'value' => array('custom'),
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Height', 'crvc_extension' ),
				'param_name' => 'height',
				'value' => '768px',
				'description' => __( 'Enter height of the advent calendar. Example: 50vh, 600px. Default is 768px. ', 'crvc_extension' ),
				'admin_label' => false,
				'dependency' => array(
					'element' => 'size',
					'value' => array('full_width', 'full_con_width', 'custom'),
				),
			),
			array(
				'type' => 'textarea_raw_html',
				'heading' => __( 'Embed Code', 'crvc_extension' ),
				'param_name' => 'content',
				'value' => '',
				'description' => __( 'Enter raw iframe embed code. It supports any html code. So be carefull.', 'crvc_extension' ),
				'admin_label' => false,
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Scroll Down Arrow', 'crvc_extension' ),
				'param_name' => 'scroll_down_arrow',
				'std' => 'yes',
				'value' => array(
					__( 'No', 'crvc_extension' ) => 'no',
					__( 'Yes', 'crvc_extension' ) => 'yes',
				),
				'description' => __( 'Enable/disable scroll down arrow.', 'crvc_extension' ),
			),
		),
		cr_vce_paramps_common_group()
	),
	'php_class_name' => 'CR_VcE_Sc_Advent_Calendar'
);
