<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
return array(
	'name' => __( 'Allora Integration', 'crvc_extension' ),
	'base' => 'cr_allora_integration',
	'is_container' => false,
	'show_settings_on_create' => false,
	'category' => __( 'Cheval Residences', 'crvc_extension' ),
	'description' => __( 'Allora Integration.', 'crvc_extension' ),
	'params' => array_merge(
		array(
			array(
				'type' => 'dropdown',
				'heading' => __( 'Client Type', 'crvc_extension' ),
				'param_name' => 'client_type',
				'value' => array(
					__( 'Default', 'crvc_extension' ) => '',
					__( 'Portal', 'crvc_extension' ) => 'portal',
					__( 'Single Site', 'crvc_extension' ) => 'site'
				),
				'description' => __( 'Select client type.', 'crvc_extension' ),
				'admin_label' => true,
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Client ID', 'crvc_extension' ),
				'param_name' => 'client_id',
				'value' => '',
				'description' => __( 'Enter client ID. Leave empty to use default client ID set on module settings.', 'crvc_extension' ),
				'admin_label' => true,
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Limit', 'crvc_extension' ),
				'param_name' => 'limit',
				'value' => '',
				'description' => __( 'Enter number of items to fetch. Leave empty to use default limit set on module settings.', 'crvc_extension' ),
				'admin_label' => true,
			),
		),
		cr_vce_paramps_common_group()
	),
	'php_class_name' => 'CR_VcE_Sc_Allora_Integration'
);
