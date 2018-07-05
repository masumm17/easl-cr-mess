<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

return array(
	'name' => __( 'Property Slider Item', 'crvc_extension' ),
	'base' => 'cr_property_slider_item',
	'class' => 'vc_col-sm-4',
	'icon' => 'icon-wpb-ui-accordion',
	'is_container' => false,
	'show_settings_on_create' => false,
	'as_child' => array(
		'only' => 'cr_property_slider',
	),
	'category' => __( 'Cheval Residences', 'crvc_extension' ),
	'description' => __( 'Property Slider', 'crvc_extension' ),
	'params' => array_merge(
		array(
			array(
				'type' => 'dropdown',
				'heading' => __( 'Data Source', 'crvc_extension' ),
				'param_name' => 'data_source',
				'std' => 'manual',
				'value' => array(
					__( 'Manual', 'crvc_extension' ) => 'manual',
					__( 'Offers', 'crvc_extension' ) => 'offers',
					__( 'Apartments', 'crvc_extension' ) => 'room_types',
				),
				'description' => __( 'Set data source for image, title, subtitle, description, CTA.', 'crvc_extension' ),
				'admin_label' => true,
				'param_holder_class' => 'vc_col-sm-6',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Select an Offer', 'crvc_extension' ),
				'param_name' => 'offer_id',
				'value' => cr_vce_post_type_dropdown_data('offer', __('Select an offer', 'crvc_extension')),
				'description' => __( 'Select an Offer.', 'crvc_extension' ),
				'dependency' => array(
					'element' => 'data_source',
					'value' => array('offers',),
				),
				'param_holder_class' => 'vc_col-sm-6 cr-padding-top-0',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Select an Apartment', 'crvc_extension' ),
				'param_name' => 'room_type_id',
				'value' => cr_vce_post_type_dropdown_data('apartment', __('Select an apartment', 'crvc_extension')),
				'description' => __( 'Select an Apartment.', 'crvc_extension' ),
				'dependency' => array(
					'element' => 'data_source',
					'value' => array('room_types',),
				),
				'param_holder_class' => 'vc_col-sm-6 cr-padding-top-0',
			),
			array(
				'type' => 'attach_image',
				'heading' => __( 'Image', 'crvc_extension' ),
				'param_name' => 'image',
				'value' => '',
				'param_holder_class' => 'vc_col-sm-12',
				'description' => __( 'Select image from media library.', 'crvc_extension' ),
				'admin_label' => false,
				'dependency' => array(
					'element' => 'data_source',
					'value' => array('manual',),
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Overlay Title', 'crvc_extension' ),
				'param_name' => 'overlay_title',
				'value' => '',
				'description' => __( 'Set overlay title.', 'crvc_extension' ),
				'dependency' => array(
					'element' => 'data_source',
					'value' => array('manual',),
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Overlay Subtitle', 'crvc_extension' ),
				'param_name' => 'overlay_subtitle',
				'value' => '',
				'description' => __( 'Set overlay subtitle.', 'crvc_extension' ),
				'dependency' => array(
					'element' => 'data_source',
					'value' => array('manual',),
				),
			),
			array(
				'type' => 'textarea_html',
				'heading' => __( 'Overlay Description', 'crvc_extension' ),
				'param_name' => 'content',
				'value' => '',
				'description' => __( 'Set overlay description.', 'crvc_extension' ),
				'dependency' => array(
					'element' => 'data_source',
					'value' => array('manual',),
				),
			),
			array(
				'type' => 'vc_link',
				'heading' => __( 'Call to Action Button', 'crvc_extension' ),
				'param_name' => 'cta_button',
				'value' => '',
				'description' => __( 'Set call to action button link.', 'crvc_extension' ),
				'dependency' => array(
					'element' => 'data_source',
					'value' => array('manual',),
				),
			),
		),
		cr_vce_paramps_common_group()
	),
	'js_view' => 'CrScPropertySliderItemView',
	'php_class_name' => 'CR_VcE_Sc_Property_Slider_Item'
);
