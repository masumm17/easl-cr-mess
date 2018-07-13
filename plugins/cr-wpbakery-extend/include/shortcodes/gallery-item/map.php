<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

return array(
	'name' => __( 'Gallery Item', 'crvc_extension' ),
	'base' => 'cr_gallery_item',
	'class' => 'vc_col-sm-3',
	'icon' => 'icon-wpb-images-stack',
	'is_container' => false,
	'show_settings_on_create' => false,
	'as_child' => array(
		'only' => 'cr_gallery',
	),
	'category' => __( 'Cheval Residences', 'crvc_extension' ),
	'description' => __( 'Gallery Item', 'crvc_extension' ),
	'params' => array_merge(
		array(
			array(
				'type' => 'attach_image',
				'heading' => __( 'Image', 'crvc_extension' ),
				'param_name' => 'image',
				'value' => '',
				'param_holder_class' => 'vc_col-sm-6',
				'description' => __( 'Select image from media library. This field is mandatory.', 'crvc_extension' ),
				'admin_label' => false,
			),
//			array(
//				'type' => 'attach_image',
//				'heading' => __( 'Landscape Image', 'crvc_extension' ),
//				'param_name' => 'image_landscape',
//				'value' => '',
//				'param_holder_class' => 'vc_col-sm-6',
//				'description' => __( 'Select image from media library.', 'crvc_extension' ),
//				'admin_label' => false,
//			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Overlay Title', 'crvc_extension' ),
				'param_name' => 'overlay_title',
				'value' => '',
				'description' => __( 'Set overlay title.', 'crvc_extension' ),
				'admin_label' => true,
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Lightbox Title', 'crvc_extension' ),
				'param_name' => 'lightbox_title',
				'value' => '',
				'description' => __( 'Set lightbox title. This field is mandatory.', 'crvc_extension' ),
				'group' => __( 'Lightbox', 'crvc_extension' ),
				'admin_label' => false,
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Lightbox Subitle', 'crvc_extension' ),
				'param_name' => 'lightbox_subtitle',
				'value' => '',
				'description' => __( 'Set lightbox subtitle.', 'crvc_extension' ),
				'group' => __( 'Lightbox', 'crvc_extension' ),
				'admin_label' => false,
			),
			array(
				'type' => 'param_group',
				'heading' => __( 'Lightbox Buttons', 'crvc_extension' ),
				'param_name' => 'lightbox_ctas',
				'value' => urlencode( json_encode( array(
					array(
						'button' => '',
					),
				) ) ),
				'params' => array(
						array(
							'type' => 'vc_link',
							'value' => '',
							'param_name' => 'button',
							'heading' => __( 'Button data', 'crvc_extension' ),
							'admin_label' => true,
						),
				),
				'group' => __( 'Lightbox', 'crvc_extension' ),
				'admin_label' => false,
			),
		),
		cr_vce_paramps_common_group()
	),
	'js_view' => 'CrScGalleryItemView',
	'php_class_name' => 'CR_VcE_Sc_Gallery_Item'
);
