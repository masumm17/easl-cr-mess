<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function cr_vce_param_posts_dropdown( $settings, $value ) {
	$post_type = !empty($settings['options']['post_type']) ? $settings['options']['post_type'] : '';
	$empty_option = !empty($settings['options']['post_type']) ? $settings['options']['empty_option'] : '';

	$dropdown =  wp_dropdown_pages(array(
		'depth' => 0,
		'selected' => $value,
		'echo' => false,
		'name' => $settings['param_name'],
		'class' => 'wpb_vc_param_value wpb-input wpb-select '. $settings['param_name'] . ' ' . $settings['type'],
		'show_option_none' => $empty_option,
		'option_none_value' => '',
		'sort_order' => 'ASC',
		'sort_column'  => 'modified',
		'hierarchical' => 1,
		'post_type' => $post_type,
	));
	if( !$dropdown ||  (false === strpos($dropdown, 'wpb_vc_param_value' )) ){
		$dropdown = "<select name='{$settings['param_name']}' class='wpb_vc_param_value wpb-input wpb-select {$settings['param_name']} {$settings['type']}' id='{$settings['param_name']}'>";
		$dropdown .= '<option value="">'. $empty_option .'</option>';
		$dropdown .= '</select>';
	}
	return $dropdown;

}
vc_add_shortcode_param( 'cr_posts_dropdown', 'cr_vce_param_posts_dropdown' );