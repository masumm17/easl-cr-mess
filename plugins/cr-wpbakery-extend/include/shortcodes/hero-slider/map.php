<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

return array(
	'name' => __( 'Hero Image/Video Slider', 'crvc_extension' ),
	'base' => 'cr_hero_slider',
	'icon' => 'icon-wpb-ui-accordion',
	'is_container' => true,
	'show_settings_on_create' => false,
	'as_parent' => array(
		'only' => 'cr_hero_slider_item',
	),
	'category' => __( 'Cheval Residences', 'crvc_extension' ),
	'description' => __( 'Hero Image/Video Slider', 'crvc_extension' ),
	'params' => array_merge(
		array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Duration', 'crvc_extension' ),
				'param_name' => 'duration',
				'value' => '4000',
				'description' => __( 'Set slide duration in ms.', 'crvc_extension' ),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Background Color', 'crvc_extension' ),
				'param_name' => 'bg_color',
				'value' => '',
				'description' => __( 'Set slider container background color.', 'crvc_extension' ),
			),
		),
		cr_vce_paramps_common_group()
	),
	'js_view' => 'CrScHeroSliderView',
	'php_class_name' => 'CR_VcE_Sc_Hero_Slider'
);
