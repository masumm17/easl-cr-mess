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
$wp_customize->add_setting( 'preloader_enabled', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => 'disabled',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'preloader_image', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'transport' => 'refresh',
) );
$wp_customize->add_control( 'color_theme', array(
	'type' => 'select',
	'label' => __( 'Color Theme', 'crt' ),
	'section' => 'crt_general',
	'choices' => array(
		'base' => __('Cheval Residences', 'crt' ),
		'ctq' => __('Cheval Three Quays', 'crt' ),
		'ctc' => __('Cheval Thorney Court', 'crt' ),
		'chc' => __('Cheval Harrington Court', 'crt' ),
		'ckb' => __('Cheval Knightsbridge', 'crt' ),
		'cph' => __('Cheval Phoenix House', 'crt' ),
		'cch' => __('Cheval Calico House', 'crt' ),
		'chpg' => __('Cheval Hyde Park Gate', 'crt' ),
		'cgp' => __('Cheval Gloucester Park', 'crt' ),
	),
) );
$wp_customize->add_control( 'default_page_types', array(
	'type' => 'select',
	'label' => __( 'Color Theme', 'crt' ),
	'section' => 'crt_general',
	'choices' => array(
		'with_hero_slider' => __('With Hero Slider', 'crt'),
		'minimal' => __('Minimal Page Type', 'crt' ),
		'gallery' => __('Gallery', 'crt' ),
	),
) );
$wp_customize->add_control( 'enable_stay_connected', array(
	'type' => 'select',
	'label' => __( 'Enable Stay Connected Module', 'crt' ),
	'section' => 'crt_general',
	'choices' => array(
		'enabled' => __('Enabled', 'crt' ),
		'disabled' => __('Disabled', 'crt' ),
	),
) );
$wp_customize->add_control( 'preloader_enabled', array(
	'type' => 'select',
	'label' => __( 'Enable Preloading Animation', 'crt' ),
	'section' => 'crt_general',
	'choices' => array(
		'enabled' => __('Enabled', 'crt' ),
		'disabled' => __('Disabled', 'crt' ),
	),
) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'preloader_image', array(
	'label' => __( 'Preloader Image', 'crt' ),
	'section' => 'crt_general',
) ) );