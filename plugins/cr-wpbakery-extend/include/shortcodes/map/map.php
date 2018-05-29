<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
$maps_dropdown = array('Select a map' => '');
$map_posts = get_posts(array(
	'post_type' => 'cr_map',
	'posts_per_page' => -1,
	'orderby' => 'title',
	'order' => 'ASC',
));

if($map_posts){
	foreach ($map_posts as $map) {
		$maps_dropdown[ get_the_title($map)] = $map->ID;
	}
}
return array(
	'name' => __( 'Map', 'crvc_extension' ),
	'base' => 'cr_map',
	'icon' => 'icon-wpb-map-pin',
	'is_container' => false,
	'show_settings_on_create' => false,
	'category' => __( 'Cheval Residences', 'crvc_extension' ),
	'description' => __( 'Map.', 'crvc_extension' ),
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
			array(
				'type' => 'dropdown',
				'heading' => __( 'Select a Map', 'crvc_extension' ),
				'param_name' => 'map',
				'value' => $maps_dropdown,
				'description' => __( 'Select a map.', 'crvc_extension' ),
			),
		),
		cr_vce_paramps_common_group()
	),
	'php_class_name' => 'CR_VcE_Sc_Map'
);