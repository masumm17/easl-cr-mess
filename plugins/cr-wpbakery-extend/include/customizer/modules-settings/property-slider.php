<?php
if (!defined('ABSPATH')) die('-1');

$wp_customize->add_section( 'cr_property_slider', array(
	'panel' => 'module_settings',
	'title' => __( 'Property Slider', 'crvc_extension' ),
	'priority' => 181,
	'capability' => 'edit_theme_options',
) );
$wp_customize->add_setting( 'property_slider_title_length', array(
	'type' => 'option',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'property_slider_subtitle_length', array(
	'type' => 'option',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'property_slider_content_length', array(
	'type' => 'option',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );

$wp_customize->add_control( 'property_slider_title_length', array(
	'type' => 'text',
	'label' => __( 'Title Length', 'crvc_extension' ),
	'section' => 'cr_property_slider',
) );
$wp_customize->add_control( 'property_slider_subtitle_length', array(
	'type' => 'text',
	'label' => __( 'Subtitle Length', 'crvc_extension' ),
	'section' => 'cr_property_slider',
) );
$wp_customize->add_control( 'property_slider_content_length', array(
	'type' => 'text',
	'label' => __( 'Content Length', 'crvc_extension' ),
	'section' => 'cr_property_slider',
) );