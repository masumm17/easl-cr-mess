<?php
if (!defined('ABSPATH')) die('-1');

$wp_customize->add_section( 'mini_grid_gallery', array(
	'panel' => 'module_settings',
	'title' => __( 'Mini Grid Gallery', 'crvc_extension' ),
	'priority' => 180,
	'capability' => 'edit_theme_options',
) );
$wp_customize->add_setting( 'mini_grid_gallery_speed', array(
	'type' => 'option',
	'capability' => 'edit_theme_options',
	'default' => '4000',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'mini_grid_gallery_transition', array(
	'type' => 'option',
	'capability' => 'edit_theme_options',
	'default' => 'fade',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'mini_grid_gallery_pagination', array(
	'type' => 'option',
	'capability' => 'edit_theme_options',
	'default' => '1',
	'transport' => 'refresh',
) );

$wp_customize->add_control( 'mini_grid_gallery_speed', array(
	'type' => 'text',
	'label' => __( 'Slideshow Speed', 'crvc_extension' ),
	'section' => 'mini_grid_gallery',
) );
$wp_customize->add_control( 'mini_grid_gallery_transition', array(
	'type' => 'select',
	'label' => __( 'Transition Type', 'crvc_extension' ),
	'section' => 'mini_grid_gallery',
	'choices' => array(
		'random' => __('Random', 'crvc_extension'),
		'fade' => __('Fade', 'crvc_extension'),
		'box_fade' => __('Box Fade', 'crvc_extension'),
		'box_right' => __('Box Right', 'crvc_extension'),
		'fold_left' => __('Fold Left', 'crvc_extension'),
	),
) );
$wp_customize->add_control( 'mini_grid_gallery_pagination', array(
	'type' => 'checkbox',
	'label' => __( 'Enable Pagination', 'crvc_extension' ),
	'section' => 'mini_grid_gallery',
) );