<?php
if (!defined('ABSPATH')) die('-1');

$wp_customize->add_section( 'crt_general', array(
	'panel' => 'module_settings',
	'title' => __( 'General', 'crt' ),
	'priority' => 159,
	'capability' => 'edit_theme_options',
) );
$wp_customize->add_setting( 'color_theme', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => 'base',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'default_page_types', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => 'minimal',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'enable_stay_connected', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => 'enabled',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'enable_sticky_side_nav', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => 'enabled',
	'transport' => 'refresh',
) );
$wp_customize->add_control( 'color_theme', array(
	'type' => 'select',
	'label' => __( 'Color Theme', 'crt' ),
	'section' => 'crt_general',
	'choices' => array(
		'base' => 'Cheval Residences',
		'ctq' => 'Cheval Three Quays',
		'ctc' => 'Cheval Thorney Court',
		'chc' => 'Cheval Harrington Court',
		'ckb' => 'Cheval Knightsbridge',
		'cph' => 'Cheval Phoenix House',
		'cch' => 'Cheval Calico House',
		'chpg' => 'Cheval Hyde Park Gate',
		'cgp' => 'Cheval Gloucester Park',
	),
) );
$wp_customize->add_control( 'default_page_types', array(
	'type' => 'select',
	'label' => __( 'Color Theme', 'crt' ),
	'section' => 'crt_general',
	'choices' => array(
		'with_hero_slider' => 'With Hero Slider',
		'minimal' => 'Minimal Page Type',
		'gallery' => 'Gallery',
	),
) );
$wp_customize->add_control( 'enable_stay_connected', array(
	'type' => 'select',
	'label' => __( 'Enable Stay Connected Module', 'crt' ),
	'section' => 'crt_general',
	'choices' => array(
		'enabled' => 'Enabled',
		'disabled' => 'Disabled',
	),
) );
$wp_customize->add_control( 'enable_sticky_side_nav', array(
	'type' => 'select',
	'label' => __( 'Enable Sticky Side Navigation', 'crt' ),
	'section' => 'crt_general',
	'choices' => array(
		'enabled' => 'Enabled',
		'disabled' => 'Disabled',
	),
) );