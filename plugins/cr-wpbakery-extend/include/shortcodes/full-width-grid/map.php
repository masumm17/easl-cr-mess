<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

return array(
	'name' => __( 'Full Width Grid', 'crvc_extension' ),
	'base' => 'cr_full_width_grid',
	'icon' => 'icon-wpb-ui-accordion',
	'is_container' => true,
	'show_settings_on_create' => false,
	'as_parent' => array(
		'only' => 'cr_full_width_grid_item',
	),
	'category' => __( 'Cheval Residences', 'crvc_extension' ),
	'description' => __( 'Full Width Grid', 'crvc_extension' ),
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
	'js_view' => 'CrScFullWidthGridView',
	'php_class_name' => 'CR_VcE_Sc_Full_Width_Grid'
);
