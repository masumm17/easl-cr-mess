<?php
if (!defined('ABSPATH')) die('-1');

$wp_customize->add_section( 'crt_stikcy_side_navigation', array(
	'panel' => 'module_settings',
	'title' => __( 'Sticky Side Navigation', 'crt' ),
	'priority' => 162,
	'capability' => 'edit_theme_options',
) );

$wp_customize->add_setting( 'stikcy_side_navigation_enable', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => 'enabled',
	'transport' => 'refresh',
) );

$wp_customize->add_setting( 'stikcy_side_navigation_items', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_control( 'stikcy_side_navigation_enable', array(
	'type' => 'select',
	'label' => __( 'Enable', 'crt' ),
	'section' => 'crt_stikcy_side_navigation',
	'choices' => array(
		'enabled' => __('Enabled', 'crt' ),
		'disabled' => __('Disabled', 'crt' ),
	),
) );
$wp_customize->add_control( 'stikcy_side_navigation_items', array(
	'type' => 'textarea',
	'label' => __( 'Items', 'crt' ),
	'description' => __('Add items as a JSON format. For example: [{"title":"CONTACT","icon":"url","type":"link/tel/email/livechat","link":"tel/link/email","newtab":"yes/no"}]', 'crt'),
	'section' => 'crt_stikcy_side_navigation',
) );