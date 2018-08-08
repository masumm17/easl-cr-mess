<?php
if (!defined('ABSPATH')) die('-1');

$wp_customize->add_section( 'crt_header', array(
	'panel' => 'module_settings',
	'title' => __( 'Header', 'crt' ),
	'priority' => 160,
	'capability' => 'edit_theme_options',
) );
$wp_customize->add_setting( 'site_main_logo', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
//$wp_customize->add_setting( 'fixed_header_logo', array(
//	'type' => 'theme_mod',
//	'capability' => 'edit_theme_options',
//	'default' => '',
//	'transport' => 'refresh',
//) );
$wp_customize->add_setting( 'search_availabilty_link', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'search_availabilty_title', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'search_availabilty_nt', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'enable_enquire_button', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'fixed_header_logo', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'site_main_logo', array(
	'label' => __( 'Site Main Logo', 'crt' ),
	'section' => 'crt_header',
) ) );
//$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fixed_header_logo', array(
//	'label' => __( 'Fixed Header Logo', 'crt' ),
//	'section' => 'crt_header',
//) ) );
 
$wp_customize->add_control( 'enable_enquire_button', array(
	'type' => 'checkbox',
	'label' => __( 'Enable Enquire Now', 'crt' ),
	'section' => 'crt_header',
) );
$wp_customize->add_control( 'search_availabilty_title', array(
	'type' => 'text',
	'label' => __( 'Search Availabilty / Enquire Now  Title', 'crt' ),
	'section' => 'crt_header',
) );
$wp_customize->add_control( 'search_availabilty_link', array(
	'type' => 'url',
	'label' => __( 'Enquire Now Link', 'crt' ),
	'section' => 'crt_header',
) );
$wp_customize->add_control( 'search_availabilty_nt', array(
	'type' => 'checkbox',
	'label' => __( 'Enquire Now New Tab', 'crt' ),
	'section' => 'crt_header',
) );