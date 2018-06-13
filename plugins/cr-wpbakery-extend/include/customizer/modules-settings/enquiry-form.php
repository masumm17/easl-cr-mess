<?php
if (!defined('ABSPATH')) die('-1');

$wp_customize->add_section( 'cr_enquiry_form', array(
	'panel' => 'module_settings',
	'title' => __( 'Enquiry Form', 'crvc_extension' ),
	'priority' => 181,
	'capability' => 'edit_theme_options',
) );
$wp_customize->add_setting( 'cr_enquiry_form_code', array(
	'type' => 'option',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );

$wp_customize->add_control( 'cr_enquiry_form_code', array(
	'type' => 'textarea',
	'label' => __( 'Enquiry Form Embed Code', 'crvc_extension' ),
	'section' => 'cr_enquiry_form',
) );