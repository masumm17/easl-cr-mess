<?php
if (!defined('ABSPATH')) die('-1');

$wp_customize->add_section( 'crt_booking_panel', array(
	'panel' => 'module_settings',
	'title' => __( 'Booking Panel', 'crt' ),
	'priority' => 163,
	'capability' => 'edit_theme_options',
) );
$wp_customize->add_setting( 'booking_panel_title', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'booking_panel_color', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => 'white',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'booking_panel_bg_image', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );

$wp_customize->add_setting( 'booking_panel_cl_url', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'booking_panel_cl_title', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'booking_panel_cl_nt', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );

$wp_customize->add_setting( 'booking_panel_rac_url', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'booking_panel_rac_title', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'booking_panel_rac_nt', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );

$wp_customize->add_setting( 'booking_panel_brg_url', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'booking_panel_brg_title', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'booking_panel_brg_nt', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );

$wp_customize->add_setting( 'booking_panel_kewords', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'booking_panel_dropdown_cols', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'booking_panel_filter_error', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );

$wp_customize->add_control( 'booking_panel_title', array(
	'type' => 'text',
	'label' => __( 'Booking Panel Title', 'crt' ),
	'section' => 'crt_booking_panel',
) );
$wp_customize->add_control( 'booking_panel_color', array(
	'type' => 'select',
	'label' => __( 'Select Color', 'crt' ),
	'section' => 'crt_booking_panel',
	'choices' => array(
		'white' => __('White', 'crt' ),
		'black' => __('Black', 'crt' ),
	),
) );
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'booking_panel_bg_image', array(
	'label' => __( 'Background Image', 'crt' ),
	'section' => 'crt_booking_panel',
) ) );

$wp_customize->add_control( 'booking_panel_cl_url', array(
	'type' => 'url',
	'label' => __( 'Customer Login Link', 'crt' ),
	'section' => 'crt_booking_panel',
) );
$wp_customize->add_control( 'booking_panel_cl_title', array(
	'type' => 'text',
	'label' => __( 'Customer Login Title', 'crt' ),
	'section' => 'crt_booking_panel',
) );
$wp_customize->add_control( 'booking_panel_cl_nt', array(
	'type' => 'checkbox',
	'label' => __( 'Customer Login New Tab', 'crt' ),
	'section' => 'crt_booking_panel',
) );

$wp_customize->add_control( 'booking_panel_rac_url', array(
	'type' => 'url',
	'label' => __( 'Request a Callback Link', 'crt' ),
	'section' => 'crt_booking_panel',
) );
$wp_customize->add_control( 'booking_panel_rac_title', array(
	'type' => 'text',
	'label' => __( 'Request a Callback Title', 'crt' ),
	'section' => 'crt_booking_panel',
) );
$wp_customize->add_control( 'booking_panel_rac_nt', array(
	'type' => 'checkbox',
	'label' => __( 'Request a Callback New Tab', 'crt' ),
	'section' => 'crt_booking_panel',
) );

$wp_customize->add_control( 'booking_panel_brg_url', array(
	'type' => 'url',
	'label' => __( 'Best rate Guaranteed Link', 'crt' ),
	'section' => 'crt_booking_panel',
) );
$wp_customize->add_control( 'booking_panel_brg_title', array(
	'type' => 'text',
	'label' => __( 'Best rate Guaranteed Title', 'crt' ),
	'section' => 'crt_booking_panel',
) );
$wp_customize->add_control( 'booking_panel_brg_nt', array(
	'type' => 'checkbox',
	'label' => __( 'Best rate Guaranteed New Tab', 'crt' ),
	'section' => 'crt_booking_panel',
) );
$wp_customize->add_control( 'booking_panel_kewords', array(
	'type' => 'textarea',
	'label' => __( 'Kewords', 'crt' ),
	'description' => __('Add keywords in a JSON format', 'crt'),
	'section' => 'crt_booking_panel',
) );
$wp_customize->add_control( 'booking_panel_dropdown_cols', array(
	'type' => 'text',
	'label' => __( 'Residences Dropdown Columns', 'crt' ),
	'description' => __('Add columns in this format: group1,group2|group3,group4', 'crt'),
	'section' => 'crt_booking_panel',
) );

$wp_customize->add_control( 'booking_panel_filter_error', array(
	'type' => 'textarea',
	'label' => __( 'Keyword Error Message', 'crt' ),
	'description' => __('Add a message to display when keyword does not match.', 'crt'),
	'section' => 'crt_booking_panel',
) );