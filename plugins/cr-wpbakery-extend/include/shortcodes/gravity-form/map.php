<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
$gravity_forms_array[ __( 'No Gravity forms found.', 'crvc_extension' ) ] = '';
if ( class_exists( 'RGFormsModel' ) ) {
	$gravity_forms = RGFormsModel::get_forms( 1, 'title' );
	if ( $gravity_forms ) {
		$gravity_forms_array = array( __( 'Select a form to display.', 'crvc_extension' ) => '' );
		foreach ( $gravity_forms as $gravity_form ) {
			$gravity_forms_array[ $gravity_form->title ] = $gravity_form->id;
		}
	}
}
return array(
	'name' => __( 'Gravity Form', 'crvc_extension' ),
	'base' => 'cr_gravity_form',
	'icon' => 'icon-wpb-vc_gravityform',
	'is_container' => false,
	'show_settings_on_create' => false,
	'category' => __( 'Cheval Residences', 'crvc_extension' ),
	'description' => __( 'Display gravity form.', 'crvc_extension' ),
	'params' => array_merge(
		array(
			array(
				'type' => 'dropdown',
				'heading' => __( 'Form', 'crvc_extension' ),
				'param_name' => 'id',
				'value' => $gravity_forms_array,
				'save_always' => true,
				'description' => __( 'Select a form to add it to your post or page.', 'crvc_extension' ),
				'admin_label' => true,
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Enable AJAX?', 'crvc_extension' ),
				'param_name' => 'ajax',
				'value' => array(
					__( 'No', 'crvc_extension' ) => 'false',
					__( 'Yes', 'crvc_extension' ) => 'true',
				),
				'save_always' => true,
				'description' => __( 'Enable AJAX submission?', 'crvc_extension' ),
				'dependency' => array(
					'element' => 'id',
					'not_empty' => true,
				),
			)
			
		),
		cr_vce_paramps_common_group()
	),
	'php_class_name' => 'CR_VcE_Sc_Gravity_Form'
);
