<?php
if (!defined('ABSPATH')) die('-1');

$wp_customize->add_section( 'cr_map', array(
	'panel' => 'module_settings',
	'title' => __( 'Map', 'crvc_extension' ),
	'priority' => 181,
	'capability' => 'edit_theme_options',
) );
$wp_customize->add_setting( 'cr_map_api_key', array(
	'type' => 'option',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );

$wp_customize->add_control( 'cr_map_api_key', array(
	'type' => 'text',
	'label' => __( 'Google Map API KEY', 'crvc_extension' ),
	'section' => 'cr_map',
) );