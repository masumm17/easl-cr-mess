<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

return array(
	'name' => __( 'Virtual Tour', 'crvc_extension' ),
	'base' => 'cr_virtual_tour',
	'icon' => 'icon-crwpb-form-icons',
	'is_container' => false,
	'show_settings_on_create' => false,
	'category' => __( 'Cheval Residences', 'crvc_extension' ),
	'description' => __( 'Embed virtual tour.', 'crvc_extension' ),
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
				'type' => 'textfield',
				'heading' => __( 'Width', 'crvc_extension' ),
				'param_name' => 'width',
				'value' => '',
				'description' => __( 'Enter width of the tour. Example: 80vw, 75%, 1200px. Default is 100%. ', 'crvc_extension' ),
				'admin_label' => true,
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Height', 'crvc_extension' ),
				'param_name' => 'height',
				'value' => '',
				'description' => __( 'Enter height of the tour. Example: 50vh, 600px. Default is 768px. ', 'crvc_extension' ),
				'admin_label' => true,
			),
			array(
				'type' => 'textarea_raw_html',
				'heading' => __( 'Embed Code', 'crvc_extension' ),
				'param_name' => 'content',
				'value' => '',
				'description' => __( 'Enter raw iframe embed code. It supports any html code. So be carefull.', 'crvc_extension' ),
				'admin_label' => false,
			),
		),
		cr_vce_paramps_common_group()
	),
	'php_class_name' => 'CR_VcE_Sc_Virtual_Tour'
);
