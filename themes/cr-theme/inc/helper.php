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
endif;

if(!function_exists('crt_get_images_sizes')):
function crt_get_images_sizes() {
	$max_width = 1920;
	$max_height = 1080;
	
	$cols = array(
		// 2 cols
		array(1,2),
		// 3 cols
		array(1,3),
		array(2,3),
		// 4 cols
		array(1,4),
		// don't 2,4 as it is 1,2
		//array(2,4),
		array(3,4),
		// 5 cols
//		array(1,5),
//		array(2,5),
//		array(3,5),
//		array(4,5),
	);
	$sizes = array();
	
	$sizes['cr_fw'] = array(
		'width' => $max_width,
		'height' => $max_height,
		'name' => 'Full Width'
	);
	
	$base = 'cr_';
	// Default
	
	// Full width row
	$row_height = $max_height;
	$row_base = "fw";
	foreach ($cols as $col) {
		$sizes[$row_base . "_col{$col[0]}-{$col[1]}"] = array(
			'width' => absint(ceil($col[0] * $max_width / $col[1] )),
			'height' => $row_height,
			'name' => "Full Width Column {$col[0]}/$col[1]",
		);
	}
	// Full width half hieght row
	$row_height = absint(ceil($max_height / 2));
	$row_base = "fw1-2";
	$sizes[$row_base] = array(
		'width' => $max_width,
		'height' => $row_height,
		'name' => "Full Width 1/2",
	);
	foreach ($cols as $col) {
		$sizes[$row_base . "_col{$col[0]}-{$col[1]}"] = array(
			'width' => absint(ceil($col[0] * $max_width / $col[1] )),
			'height' => $row_height,
			'name' => "Full Width 1/2 Column {$col[0]}/$col[1]",
		);
	}
	// Full width 2/3 row
	$row_height = absint(ceil(2 * $max_height / 3));
	$row_base = "fw2-3";
	$sizes[$row_base] = array(
		'width' => $max_width,
		'height' => $row_height,
		'name' => "Full Width 2/3",
	);
	foreach ($cols as $col) {
		$sizes[$row_base . "_col{$col[0]}-{$col[1]}"] = array(
			'width' => absint(ceil($col[0] * $max_width / $col[1] )),
			'height' => $row_height,
			'name' => "Full Width 2/3 Column {$col[0]}/$col[1]",
		);
	}
	
	return $sizes;
}
endif;