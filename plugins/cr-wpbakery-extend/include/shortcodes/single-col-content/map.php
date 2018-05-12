<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

return array(
	'name' => __( 'Single Column Content', 'crvc_extension' ),
	'base' => 'cr_single_col_content',
	'icon' => 'icon-wpb-layer-shape-text',
	'is_container' => false,
	'show_settings_on_create' => false,
	'category' => __( 'Cheval Residences', 'crvc_extension' ),
	'description' => __( 'Single Column Content.', 'crvc_extension' ),
	'params' => array_merge(
		array(
			array(
				'type' => 'textarea_html',
				'heading' => __( 'Content', 'crvc_extension' ),
				'param_name' => 'content',
				'value' => '',
				'description' => __( 'Set Content.', 'crvc_extension' ),
			),
			array(
				'type' => 'param_group',
				'heading' => __( 'Buttons', 'crvc_extension' ),
				'param_name' => 'buttons',
				'value' => urlencode( json_encode( array(
					array(
						'button' => '',
					),
					array(
						'button' => '',
					),
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
			),
		),
		cr_vce_paramps_common_group()
	),
	'php_class_name' => 'CR_VcE_Sc_Single_Col_Content'
);
