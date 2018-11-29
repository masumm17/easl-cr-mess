<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

return array(
	'name' => __( 'Accommodations', 'crvc_extension' ),
	'base' => 'cr_accommodations',
	'icon' => 'vc_icon-vc-media-grid',
	'is_container' => false,
	'show_settings_on_create' => false,
	'category' => __( 'Cheval Residences', 'crvc_extension' ),
	'description' => __( 'Accommodations', 'crvc_extension' ),
	'params' => array_merge(
		array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Title', 'crvc_extension' ),
				'param_name' => 'title',
				'value' => '',
				'description' => __( 'Enter optional title.', 'crvc_extension' ),
				'admin_label' => true,
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Subtitle', 'crvc_extension' ),
				'param_name' => 'subtitle',
				'value' => '',
				'description' => __( 'Enter optional subtitle', 'crvc_extension' ),
				'admin_label' => true,
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Element tag', 'crvc_extension' ),
				'param_name' => 'element_tag',
				'std' => 'h1',
				'value' => array(
					__( 'h1', 'crvc_extension' ) => 'h1',
					__( 'h2', 'crvc_extension' ) => 'h2',
					__( 'h3', 'crvc_extension' ) => 'h3',
					__( 'h4', 'crvc_extension' ) => 'h4',
					__( 'h5', 'crvc_extension' ) => 'h5',
					__( 'h6', 'crvc_extension' ) => 'h6',
					__( 'div', 'crvc_extension' ) => 'div',
				),
				'description' => __( 'Select the type of the slide item.', 'crvc_extension' ),
			),
		),
		cr_vce_paramps_common_group()
	),
	'php_class_name' => 'CR_VcE_Sc_Accommodations'
);
