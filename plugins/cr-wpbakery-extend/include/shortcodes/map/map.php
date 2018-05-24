<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

return array(
	'name' => __( 'Map', 'crvc_extension' ),
	'base' => 'cr_map',
	'icon' => 'icon-wpb-map-pin',
	'is_container' => false,
	'show_settings_on_create' => false,
	'category' => __( 'Cheval Residences', 'crvc_extension' ),
	'description' => __( 'Map.', 'crvc_extension' ),
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
		),
		cr_vce_paramps_common_group()
	),
	'php_class_name' => 'CR_VcE_Map'
);
