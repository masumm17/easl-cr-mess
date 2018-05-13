<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

return array(
	'name' => __( 'Fixed Width Grid Item', 'crvc_extension' ),
	'base' => 'cr_fixed_width_grid_item',
	'class' => 'vc_col-sm-4',
	'icon' => 'icon-wpb-ui-accordion',
	'is_container' => false,
	'show_settings_on_create' => false,
	'as_child' => array(
		'only' => 'cr_fixed_width_grid',
	),
	'category' => __( 'Cheval Residences', 'crvc_extension' ),
	'description' => __( 'Fixed Width Grid Item', 'crvc_extension' ),
	'params' => array_merge(
		array(
			array(
				'type' => 'attach_image',
				'heading' => __( 'Image', 'crvc_extension' ),
				'param_name' => 'image',
				'value' => '',
				'param_holder_class' => 'vc_col-sm-6',
				'description' => __( 'Select image from media library.', 'crvc_extension' ),
				'admin_label' => false,
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Overlay Title', 'crvc_extension' ),
				'param_name' => 'overlay_title',
				'value' => '',
				'description' => __( 'Set overlay title.', 'crvc_extension' ),
				'admin_label' => true
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Overlay Subtitle', 'crvc_extension' ),
				'param_name' => 'overlay_subtitle',
				'value' => '',
				'description' => __( 'Set overlay title.', 'crvc_extension' ),
				'admin_label' => true
			),
			array(
				'type' => 'textarea_html',
				'heading' => __( 'Overlay Description', 'crvc_extension' ),
				'param_name' => 'content',
				'value' => '',
				'description' => __( 'Set overlay description.', 'crvc_extension' ),
			),
			array(
				'type' => 'vc_link',
				'heading' => __( 'Call to Action Button', 'crvc_extension' ),
				'param_name' => 'cta_button',
				'value' => '',
				'description' => __( 'Set call to action button link.', 'crvc_extension' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Disable Overlay Transparency', 'crvc_extension' ),
				'param_name' => 'overlay_trans_disable',
				'std' => 'no',
				'value' => array(
					__( 'No', 'crvc_extension' ) => 'no',
					__( 'Yes', 'crvc_extension' ) => 'yes',
				),
				'description' => __( 'Disable semi transperent overly background.', 'crvc_extension' ),
			),
		),
		cr_vce_paramps_common_group()
	),
	'js_view' => 'CrScFixedWidthGridItemView',
	'php_class_name' => 'CR_VcE_Sc_Fixed_Width_Grid_Item'
);
