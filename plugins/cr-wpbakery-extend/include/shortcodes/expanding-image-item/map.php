<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

return array(
	'name' => __( 'Expanding Image Item', 'crvc_extension' ),
	'base' => 'cr_expanding_image_item',
	'class' => 'vc_col-sm-4',
	'icon' => 'icon-wpb-ui-accordion',
	'is_container' => false,
	'show_settings_on_create' => false,
	'as_child' => array(
		'only' => 'cr_expanding_images',
	),
	'category' => __( 'Cheval Residences', 'crvc_extension' ),
	'description' => __( 'Expanding Image Item', 'crvc_extension' ),
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
				'heading' => __( 'CTA Title', 'crvc_extension' ),
				'param_name' => 'cta_title',
				'value' => '',
				'description' => __( 'Set call to action title.', 'crvc_extension' ),
				'admin_label' => true,
			),
			array(
				'type' => 'vc_link',
				'heading' => __( 'Call to Action Button', 'crvc_extension' ),
				'param_name' => 'cta_button',
				'value' => '',
				'description' => __( 'Set call to action button link.', 'crvc_extension' ),
			),
		),
		cr_vce_paramps_common_group()
	),
	'js_view' => 'CrScExpandingImageItemView',
	'php_class_name' => 'CR_VcE_Sc_Expanding_Image_Item'
);
