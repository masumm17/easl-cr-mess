<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

return array(
	'name' => __( 'Sitemap', 'crvc_extension' ),
	'base' => 'cr_sitemap',
	'icon' => 'icon-crwpb-title-icons',
	'is_container' => false,
	'show_settings_on_create' => false,
	'category' => __( 'Cheval Residences', 'crvc_extension' ),
	'description' => __( 'Output sitemap.', 'crvc_extension' ),
	'params' => array_merge(
		array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Title', 'crvc_extension' ),
				'param_name' => 'title',
				'value' => '',
				'description' => __( 'Enter sitemap module title.', 'crvc_extension' ),
				'admin_label' => true,
			),
		),
		cr_vce_paramps_common_group()
	),
	'php_class_name' => 'CR_VcE_Sc_Sitemap'
);
