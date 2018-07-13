<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

return array(
	'name' => __( 'Mini Gallery', 'crvc_extension' ),
	'base' => 'cr_mini_grid_gallery',
	'icon' => 'icon-cr-mini-grid-gallery',
	'is_container' => false,
	'show_settings_on_create' => false,
	'category' => __( 'Cheval Residences', 'crvc_extension' ),
	'description' => __( 'Mini Grid Gallery.', 'crvc_extension' ),
	'params' => array_merge(
		array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Module Title', 'crvc_extension' ),
				'param_name' => 'title',
				'value' => '',
				'description' => __( 'Enter optional module title.', 'crvc_extension' ),
				'admin_label' => false,
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Module Subtitle', 'crvc_extension' ),
				'param_name' => 'subtitle',
				'value' => '',
				'description' => __( 'Enter optional module subtitle', 'crvc_extension' ),
				'admin_label' => false,
			),
			array(
				'type' => 'attach_images',
				'heading' => __( 'Images', 'crvc_extension' ),
				'param_name' => 'column1_images',
				'value' => '',
				'description' => __( 'Select image from media library. Maximum 10 images will be shown.', 'crvc_extension' ),
				'admin_label' => true,
				'group' => __( 'Column 1', 'crvc_extension' ),
			),
			array(
				'type' => 'attach_image',
				'heading' => __( 'Image', 'crvc_extension' ),
				'param_name' => 'column2_image',
				'value' => '',
				'param_holder_class' => 'vc_col-sm-6',
				'description' => __( 'Select image from media library.', 'crvc_extension' ),
				'admin_label' => false,
				'group' => __( 'Column 2', 'crvc_extension' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Column 2 Blur Amount', 'crvc_extension' ),
				'param_name' => 'col2_blur',
				'value' => '',
				'param_holder_class' => 'vc_col-sm-6',
				'description' => __( 'Set column 2 Image blur amount in px. Default 5.', 'crvc_extension' ),
				'admin_label' => false,
				'group' => __( 'Column 2', 'crvc_extension' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Column 2 Title', 'crvc_extension' ),
				'param_name' => 'col2_title',
				'value' => '',
				'description' => __( 'Enter column 2 title.', 'crvc_extension' ),
				'admin_label' => true,
				'group' => __( 'Column 2', 'crvc_extension' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Column 2 Subtitle', 'crvc_extension' ),
				'param_name' => 'col2_subtitle',
				'value' => '',
				'description' => __( 'Enter column 2 subtitle.', 'crvc_extension' ),
				'admin_label' => false,
				'group' => __( 'Column 2', 'crvc_extension' ),
			),
			array(
				'type' => 'vc_link',
				'heading' => __( 'Call to Action Button', 'crvc_extension' ),
				'param_name' => 'col2_cta',
				'value' => '',
				'admin_label' => false,
				'description' => __( 'Set column 2 call to action button link.', 'crvc_extension' ),
				'group' => __( 'Column 2', 'crvc_extension' ),
			),
			array(
				'type' => 'attach_images',
				'heading' => __( 'Column 2 Images', 'crvc_extension' ),
				'param_name' => 'column3_images',
				'value' => '',
				'description' => __( 'Select image from media library. Maximum 10 images will be shown.', 'crvc_extension' ),
				'admin_label' => true,
				'group' => __( 'Column 3', 'crvc_extension' ),
			),
		),
		cr_vce_paramps_common_group()
	),
	'php_class_name' => 'CR_VcE_Sc_Mini_Grid_Gallery'
);
