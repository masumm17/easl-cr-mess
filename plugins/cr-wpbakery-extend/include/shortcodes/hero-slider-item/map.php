<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

return array(
	'name' => __( 'Hero Image/Video Slider Item', 'crvc_extension' ),
	'base' => 'cr_hero_slider_item',
	'class' => 'vc_col-sm-4',
	'icon' => 'icon-wpb-ui-accordion',
	'is_container' => false,
	'show_settings_on_create' => false,
	'as_child' => array(
		'only' => 'cr_hero_slider',
	),
	'category' => __( 'Cheval Residences', 'crvc_extension' ),
	'description' => __( 'Hero Image/Video Slider', 'crvc_extension' ),
	'params' => array_merge(
		array(
			array(
				'type' => 'dropdown',
				'heading' => __( 'Type', 'crvc_extension' ),
				'param_name' => 'type',
				'std' => 'image',
				'value' => array(
					__( 'Image', 'crvc_extension' ) => 'image',
					__( 'Video', 'crvc_extension' ) => 'video',
				),
				'description' => __( 'Select the type of the slide item.', 'crvc_extension' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Youtube Video ID', 'crvc_extension' ),
				'param_name' => 'yt_video_id',
				'value' => '',
				'description' => __( 'Set youtube video.', 'crvc_extension' ),
				'dependency' => array(
					'element' => 'type',
					'value' => array('video')
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Youtube Video Aspect Ratio', 'crvc_extension' ),
				'param_name' => 'yt_video_ar',
				'value' => '16:9',
				'description' => __( 'Set youtube video aspect ratio.', 'crvc_extension' ),
				'dependency' => array(
					'element' => 'type',
					'value' => array('video')
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Youtube Video Start Time', 'crvc_extension' ),
				'param_name' => 'yt_video_start',
				'value' => '00:00',
				'description' => __( 'Set youtube video start time in this format mm:ss.', 'crvc_extension' ),
				'dependency' => array(
					'element' => 'type',
					'value' => array('video')
				),
			),
			array(
				'type' => 'attach_image',
				'heading' => __( 'Image Large', 'crvc_extension' ),
				'param_name' => 'image_large',
				'value' => '',
				'param_holder_class' => 'vc_col-sm-6',
				'description' => __( 'Select image from media library for desktop version.', 'crvc_extension' ),
				'admin_label' => false,
			),
			array(
				'type' => 'attach_image',
				'heading' => __( 'Image Small', 'crvc_extension' ),
				'param_name' => 'image_small',
				'value' => '',
				'param_holder_class' => 'vc_col-sm-6',
				'description' => __( 'Select image from media library for smaller version.', 'crvc_extension' ),
				'admin_label' => false,
			),
			// Tagline fields
			array(
				'type' => 'dropdown',
				'heading' => __( 'Tagline Type', 'crvc_extension' ),
				'param_name' => 'tagline_type',
				'std' => 'image',
				'value' => array(
					__( 'None', 'crvc_extension' ) => 'none',
					__( 'Type 1', 'crvc_extension' ) => 'type1',
					__( 'Type 2', 'crvc_extension' ) => 'type2',
					__( 'Type 3', 'crvc_extension' ) => 'type3',
					__( 'Type 4', 'crvc_extension' ) => 'type4',
				),
				'description' => __( 'Select the type of the slide tagline.', 'crvc_extension' ),
				'group' => __( 'Tagline Options', 'crvc_extension' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Title', 'crvc_extension' ),
				'param_name' => 'tagline_title',
				'value' => '',
				'description' => __( 'Set tagline title.', 'crvc_extension' ),
				'dependency' => array(
					'element' => 'tagline_type',
					'value' => array('type1', 'type2', 'type3', 'type4')
				),
				'group' => __( 'Tagline Options', 'crvc_extension' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Subtitle', 'crvc_extension' ),
				'param_name' => 'tagline_subtitle',
				'value' => '',
				'description' => __( 'Set tagline subtitle.', 'crvc_extension' ),
				'dependency' => array(
					'element' => 'tagline_type',
					'value' => array('type1', 'type2', 'type3', 'type4')
				),
				'group' => __( 'Tagline Options', 'crvc_extension' ),
			),
			array(
				'type' => 'textarea_html',
				'heading' => __( 'Description', 'crvc_extension' ),
				'param_name' => 'content',
				'value' => '',
				'description' => __( 'Set tagline description.', 'crvc_extension' ),
				'dependency' => array(
					'element' => 'tagline_type',
					'value' => array('type2', 'type4')
				),
				'group' => __( 'Tagline Options', 'crvc_extension' ),
			),
			array(
				'type' => 'vc_link',
				'heading' => __( 'Call to Action Button', 'crvc_extension' ),
				'param_name' => 'cta_button',
				'value' => '',
				'description' => __( 'Set call to action button link.', 'crvc_extension' ),
				'dependency' => array(
					'element' => 'tagline_type',
					'value' => array('type1', 'type2', 'type4')
				),
				'group' => __( 'Tagline Options', 'crvc_extension' ),
			),
			array(
				'type' => 'attach_image',
				'heading' => __( 'Image', 'crvc_extension' ),
				'param_name' => 'tagline_image',
				'value' => '',
				'param_holder_class' => 'vc_col-sm-6',
				'description' => __( 'Select image from media library for tagline.', 'crvc_extension' ),
				'dependency' => array(
					'element' => 'tagline_type',
					'value' => array('type1'),
				),
				'admin_label' => false,
				'group' => __( 'Tagline Options', 'crvc_extension' ),
			),
		),
		cr_vce_paramps_common_group()
	),
	'js_view' => 'CrScHeroSliderItemView',
	'php_class_name' => 'CR_VcE_Sc_Hero_Slider_Item'
);
