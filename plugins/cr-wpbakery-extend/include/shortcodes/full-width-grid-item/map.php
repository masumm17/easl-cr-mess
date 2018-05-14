<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

return array(
	'name' => __( 'Full Width Grid Item', 'crvc_extension' ),
	'base' => 'cr_full_width_grid_item',
	'class' => 'vc_col-sm-4',
	'icon' => 'icon-wpb-ui-accordion',
	'is_container' => false,
	'show_settings_on_create' => false,
	'as_child' => array(
		'only' => 'cr_full_width_grid',
	),
	'category' => __( 'Cheval Residences', 'crvc_extension' ),
	'description' => __( 'Full Width Grid Item', 'crvc_extension' ),
	'params' => array_merge(
		array(
			array(
				'type' => 'dropdown',
				'heading' => __( 'Grid Size', 'crvc_extension' ),
				'param_name' => 'grid_size',
				'std' => '1_3',
				'value' => array(
					__( 'One Third', 'crvc_extension' ) => '1_3',
					__( 'Two Third', 'crvc_extension' ) => '2_3',
					__( 'Full Width', 'crvc_extension' ) => '3_3',
				),
				'description' => __( 'Set the size of grid item.', 'crvc_extension' ),
				'admin_label' => false,
				'param_holder_class' => 'vc_col-sm-6',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Display Option', 'crvc_extension' ),
				'param_name' => 'display_option',
				'std' => 'no_text',
				'value' => array(
					__( 'No Text', 'crvc_extension' ) => 'no_text',
					__( 'No Image', 'crvc_extension' ) => 'no_image',
					__( 'Title Only', 'crvc_extension' ) => 'title_only',
					__( 'All Text on Hover', 'crvc_extension' ) => 'text_hover',
					__( 'Always Display text', 'crvc_extension' ) => 'text_always',
				),
				'description' => __( 'Set the display option grid item.', 'crvc_extension' ),
				'admin_label' => true,
				'param_holder_class' => 'vc_col-sm-6',
			),
			array(
				'type' => 'attach_image',
				'heading' => __( 'Image', 'crvc_extension' ),
				'param_name' => 'image',
				'value' => '',
				'param_holder_class' => 'vc_col-sm-6',
				'description' => __( 'Select image from media library.', 'crvc_extension' ),
				'admin_label' => false,
				'dependency' => array(
					'element' => 'display_option',
					'value' => array('no_text', 'title_only', 'text_hover', 'text_always'),
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Title', 'crvc_extension' ),
				'param_name' => 'title',
				'value' => '',
				'description' => __( 'Set title.', 'crvc_extension' ),
				'admin_label' => true,
				'dependency' => array(
					'element' => 'display_option',
					'value' => array( 'title_only', 'text_hover', 'text_always', 'no_image'),
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Subtitle', 'crvc_extension' ),
				'param_name' => 'subtitle',
				'value' => '',
				'description' => __( 'Set subtitle.', 'crvc_extension' ),
				'admin_label' => false,
				'dependency' => array(
					'element' => 'display_option',
					'value' => array( 'text_hover', 'text_always', 'no_image'),
				),
			),
			array(
				'type' => 'textarea_html',
				'heading' => __( 'Description', 'crvc_extension' ),
				'param_name' => 'content',
				'value' => '',
				'description' => __( 'Set description.', 'crvc_extension' ),
				'dependency' => array(
					'element' => 'display_option',
					'value' => array( 'text_hover', 'text_always', 'no_image'),
				),
			),
			array(
				'type' => 'vc_link',
				'heading' => __( 'Call to Action Button', 'crvc_extension' ),
				'param_name' => 'cta_button',
				'value' => '',
				'description' => __( 'Set call to action button link.', 'crvc_extension' ),
				'dependency' => array(
					'element' => 'display_option',
					'value' => array( 'text_hover', 'text_always', 'no_image'),
				),
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
				'param_holder_class' => 'vc_col-sm-6',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Text Align', 'crvc_extension' ),
				'param_name' => 'text_align',
				'std' => 'center',
				'value' => array(
					__( 'Left', 'crvc_extension' ) => 'left',
					__( 'Center', 'crvc_extension' ) => 'center',
					__( 'Right', 'crvc_extension' ) => 'right',
				),
				'description' => __( 'Set text alignment for this grid item.', 'crvc_extension' ),
				'dependency' => array(
					'element' => 'display_option',
					'value' => array( 'title_only', 'text_hover', 'text_always', 'no_image'),
				),
				'param_holder_class' => 'vc_col-sm-6',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Enable Video', 'crvc_extension' ),
				'param_name' => 'enable_video',
				'std' => 'no',
				'value' => array(
					__( 'No', 'crvc_extension' ) => 'no',
					__( 'Yes', 'crvc_extension' ) => 'yes',
				),
				'description' => __( 'Enable video.', 'crvc_extension' ),
				'param_holder_class' => 'vc_col-sm-6',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Youtube Video ID', 'crvc_extension' ),
				'param_name' => 'video_id',
				'value' => '',
				'description' => __( 'Set youtub video ID.', 'crvc_extension' ),
				'admin_label' => false,
				'dependency' => array(
					'element' => 'enable_video',
					'value' => array( 'yes' ),
				),
				'param_holder_class' => 'vc_col-sm-6',
			),
		),
		cr_vce_paramps_common_group()
	),
	'js_view' => 'CrScFullWidthGridItemView',
	'php_class_name' => 'CR_VcE_Sc_Full_Width_Grid_Item'
);
