<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

return array(
	'name' => __( 'Gallery', 'crvc_extension' ),
	'base' => 'cr_gallery',
	'icon' => 'vc_icon-vc-masonry-media-grid',
	'is_container' => true,
	'show_settings_on_create' => false,
	'as_parent' => array(
		'only' => 'cr_gallery_item',
	),
	'category' => __( 'Cheval Residences', 'crvc_extension' ),
	'description' => __( 'Gallery', 'crvc_extension' ),
	'params' => array_merge(
		array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Title', 'crvc_extension' ),
				'param_name' => 'title',
				'value' => '',
				'description' => __( 'Enter optional title.', 'crvc_extension' ),
				'admin_label' => true,
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Subtitle', 'crvc_extension' ),
				'param_name' => 'subtitle',
				'value' => '',
				'description' => __( 'Enter optional subtitle', 'crvc_extension' ),
				'admin_label' => true,
			),
		),
		cr_vce_paramps_common_group()
	),
	'js_view' => 'CrScGalleryView',
	'php_class_name' => 'CR_VcE_Sc_Gallery'
);
