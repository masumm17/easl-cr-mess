<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Returns theme mod from global var
 *
 * @since 1.0
 */
if(!function_exists('crt_get_theme_mode')):
function crt_get_theme_mode($id, $default = '') {
	// Return get_theme_mod on customize_preview => IMPORTANT !!!
	if ( is_customize_preview() ) {
		return get_theme_mod( $id, $default );
	}

	// Get global object
	global $crt_theme_mods;

	// Return data from global object
	if ( ! empty( $crt_theme_mods ) ) {

		// Return value
		if ( isset( $crt_theme_mods[$id] ) ) {
			return $crt_theme_mods[$id];
		}

		// Return default
		else {
			return $default;
		}

	}

	// Global object not found return using get_theme_mod
	else {

		return get_theme_mod( $id, $default );

	}
}
endif;
if(!function_exists('cr_truncate')):
/**
 * 
 * @param type $str
 * @param type $len
 * @param type $trail
 * @param type $word_wrap
 * @return type
 */
function cr_truncate($str, $len = 200, $trail = '', $word_wrap = true) {
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
endif;

function cr_settings_section_custom_scripts($args) {
	echo '<p id="'. esc_attr( $args['id'] ) .'">Add custom scripts.</p>';
}

function cr_setting_field_textarea($args) {
	$settings = get_option( 'cr_settings' );
	$field_setting = isset($settings[$args['label_for']]) ? $settings[$args['label_for']] : '';
	echo '<textarea id="'. esc_attr($args['label_for']) .'" name="cr_settings['. $args['label_for'] .']">'. esc_textarea($field_setting) .'</textarea>';
}