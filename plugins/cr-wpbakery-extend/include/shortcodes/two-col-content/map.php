<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

return array(
	'name' => __( 'Two Column Content', 'crvc_extension' ),
	'base' => 'cr_two_col_content',
	'icon' => 'icon-wpb-layer-shape-text',
	'is_container' => false,
	'show_settings_on_create' => false,
	'category' => __( 'Cheval Residences', 'crvc_extension' ),
	'description' => __( 'Two Column Content.', 'crvc_extension' ),
	'params' => array_merge(
		array(
			array(
				'type' => 'dropdown',
				'heading' => __( 'Enable Bottom Button', 'crvc_extension' ),
				'param_name' => 'enable_button',
				'std' => 'no',
				'value' => array(
					__( 'No', 'crvc_extension' ) => 'no',
					__( 'Yes', 'crvc_extension' ) => 'yes',
				),
				'description' => __( 'Enable button at bottom.', 'crvc_extension' ),
			),
			array(
				'type' => 'vc_link',
				'heading' => __( 'Button', 'crvc_extension' ),
				'param_name' => 'button',
				'value' => '',
				'description' => __( 'This is shown at the bottom the module if enabled.', 'crvc_extension' ),
				'dependency' => array(
					'element' => 'enable_button',
					'value' => array('yes'),
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Column 1 Title', 'crvc_extension' ),
				'param_name' => 'col_1_title',
				'value' => '',
				'description' => __( 'Enter column 1 title.', 'crvc_extension' ),
				'admin_label' => true,
				'group' => __( 'Column 1 Options', 'crvc_extension' ),
			),
			array(
				'type' => 'textarea',
				'heading' => __( 'Column 1 Note', 'crvc_extension' ),
				'param_name' => 'col_1_note',
				'value' => '',
				'description' => __( 'Enter column 1 note.', 'crvc_extension' ),
				'admin_label' => false,
				'group' => __( 'Column 1 Options', 'crvc_extension' ),
			),
			array(
				'type' => 'autocomplete',
				'heading' => __( 'Amenities', 'crvc_extension' ),
				'param_name' => 'amenity_ids',
				'value' => '',
				'description' => __( 'Select amenities.', 'crvc_extension' ),
				'settings' => array(
					'multiple' => true,
					'min_length' => 1,
					'groups' => false,
					'unique_values' => true,
					'display_inline' => true,
					'delay' => 0,
					'auto_focus' => true,
					'sortable' => true,
				),
				'admin_label' => false,
				'group' => __( 'Column 1 Options', 'crvc_extension' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Disable Column 2', 'crvc_extension' ),
				'param_name' => 'disable_col2',
				'std' => 'no',
				'group' => __( 'Column 2 Options', 'crvc_extension' ),
				'value' => array(
					__( 'No', 'crvc_extension' ) => 'no',
					__( 'Yes', 'crvc_extension' ) => 'yes',
				),
				'description' => __( 'Disable column two.', 'crvc_extension' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Column 2 Title', 'crvc_extension' ),
				'param_name' => 'col_2_title',
				'value' => '',
				'description' => __( 'Enter column 1 title.', 'crvc_extension' ),
				'admin_label' => true,
				'group' => __( 'Column 2 Options', 'crvc_extension' ),
				'dependency' => array(
					'element' => 'disable_col2',
					'value' => array('no'),
				),
			),
			array(
				'type' => 'param_group',
				'heading' => __( 'Floor Plans', 'crvc_extension' ),
				'param_name' => 'floorplans',
				'description' => __( 'You can add maximum 3 floorplans. Only first 3 will be displayed.', 'crvc_extension' ),
				'dependency' => array(
					'element' => 'disable_col2',
					'value' => array('no'),
				),
				'value' => urlencode( json_encode( array(
					array(
						'thumb' => '',
						'url' => '',
					),
				) ) ),
				'group' => __( 'Column 2 Options', 'crvc_extension' ),
				'params' => array(
						array(
							'type' => 'attach_image',
							'heading' => __( 'Floorplan Thumb', 'crvc_extension' ),
							'param_name' => 'thumb',
							'value' => '',
							'description' => __( 'Add floor plan thmbnail.', 'crvc_extension' ),
							'admin_label' => true,
						),
						array(
							'type' => 'vc_link',
							'value' => '',
							'param_name' => 'url',
							'heading' => __( 'Url', 'crvc_extension' ),
							'admin_label' => true,
						),
				),
			),
			array(
				'type' => 'textarea',
				'heading' => __( 'Column 2 Note', 'crvc_extension' ),
				'param_name' => 'col_2_note',
				'value' => '',
				'description' => __( 'Enter column 2 note.', 'crvc_extension' ),
				'admin_label' => false,
				'group' => __( 'Column 2 Options', 'crvc_extension' ),
				'dependency' => array(
					'element' => 'disable_col2',
					'value' => array('no'),
				),
			),
		),
		cr_vce_paramps_common_group()
	),
	'php_class_name' => 'CR_VcE_Sc_Two_Col_Content'
);
