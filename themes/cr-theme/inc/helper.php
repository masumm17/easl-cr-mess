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

/**
 * Returns global mods
 *
 * @since 1.0
 */
if(!function_exists('crt_get_mods')):
	function crt_get_mods() {
		global $crt_theme_mods;
		return $crt_theme_mods;
	}
endif;;