<?php

function cr_vce_get_manager() {
	return CR_VcE_Manager::get_instance();
}

function cr_get_template_dir($filename = '') {
	return cr_vce_get_manager()->path('TEMPLATES_DIR') . '/' . $filename;
}
function cr_get_asset_url($filename = '') {
	return cr_vce_get_manager()->asset_url($filename);
}

function cr_vce_paramps_common_group($label = true) {
	$animation = vc_map_add_css_animation($label);
	$animation['group'] = __('Extra Options', 'crvc_extension');
	return array(
		array(
			'type' => 'dropdown',
			'heading' => __( 'Disabled', 'crvc_extension' ),
			'param_name' => 'sc_disabled',
			'std' => 'no',
			'value' => array(
				__( 'No', 'crvc_extension' ) => 'no',
				__( 'Yes', 'crvc_extension' ) => 'yes',
			),
			'description' => __( 'Disable this item on frontend.', 'crvc_extension' ),
			'group' => __( 'Extra Options', 'crvc_extension' ),
		),
		$animation,
		array(
			'type' => 'el_id',
			'heading' => __( 'Element ID', 'crvc_extension' ),
			'param_name' => 'el_id',
			'group' => __( 'Extra Options', 'crvc_extension' ),
			'description' => sprintf( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'crvc_extension' ), 'http://www.w3schools.com/tags/att_global_id.asp' ),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'crvc_extension' ),
			'param_name' => 'el_class',
			'group' => __( 'Extra Options', 'crvc_extension' ),
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'crvc_extension' ),
		),
		array(
			'type' => 'css_editor',
			'heading' => __( 'CSS box', 'crvc_extension' ),
			'param_name' => 'css',
			'group' => __( 'Design Options', 'crvc_extension' ),
		),
	);
}

function get_title_icons_template($title_override = '') {
	include cr_get_template_dir('non-shortcodes/title-icons.php');
}

/**
 * 
 * @param type $str
 * @param type $len
 * @param type $trail
 * @param type $word_wrap
 * @return type
 */
function cr_vce_truncate($str, $len = 200, $trail = '', $word_wrap = true) {
    // Strip all html tags
    $str = strip_tags($str);
    // Strip Shortcodes
    $str = strip_shortcodes($str);
    // And the boundary spaces
    $str = trim($str);
    // No need to trancate if string length is lesser
    if (strlen($str) < $len) {
        return $str;
    }
    // Do the truncate magic
    if ($word_wrap)
        $str = substr($str, 0, strrpos(substr($str, 0, $len), ' '));
    else
        $str = substr($str, 0, $len);
    return $str . $trail;
}