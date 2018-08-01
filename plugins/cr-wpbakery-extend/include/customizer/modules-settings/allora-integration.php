<?php
if (!defined('ABSPATH')) die('-1');

$wp_customize->add_section( 'cr_allora', array(
	'panel' => 'module_settings',
	'title' => __( 'Allora Integration', 'crvc_extension' ),
	'priority' => 182,
	'capability' => 'edit_theme_options',
) );
$wp_customize->add_setting( 'cr_allora_url', array(
	'type' => 'option',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'cr_allora_client_type', array(
	'type' => 'option',
	'capability' => 'edit_theme_options',
	'default' => 'portal',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'cr_allora_template', array(
	'type' => 'option',
	'capability' => 'edit_theme_options',
	'default' => 'Custom',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'cr_allora_limit', array(
	'type' => 'option',
	'capability' => 'edit_theme_options',
	'default' => '3',
	'transport' => 'refresh',
) );

$wp_customize->add_setting( 'cr_allora_client_id', array(
	'type' => 'option',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_control( 'cr_allora_url', array(
	'type' => 'text',
	'label' => __( 'API Base URL', 'crvc_extension' ),
	'section' => 'cr_allora',
) );
$wp_customize->add_control( 'cr_allora_template', array(
	'type' => 'text',
	'label' => __( 'Template', 'crvc_extension' ),
	'section' => 'cr_allora',
) );
$wp_customize->add_control( 'cr_allora_client_type', array(
	'type' => 'select',
	'label' => __( 'Client Type', 'crvc_extension' ),
	'section' => 'cr_allora',
	'choices' => array(
		'portal' => __('Portal', 'crvc_extension'),
		'site' => __('Single Site', 'crvc_extension'),
	),
) );
$wp_customize->add_control( 'cr_allora_client_id', array(
	'type' => 'text',
	'label' => __( 'Client ID', 'crvc_extension' ),
	'section' => 'cr_allora',
) );
$wp_customize->add_control( 'cr_allora_limit', array(
	'type' => 'text',
	'label' => __( 'Limit', 'crvc_extension' ),
	'section' => 'cr_allora',
) );