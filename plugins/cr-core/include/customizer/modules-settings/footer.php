<?php
if (!defined('ABSPATH')) die('-1');

$wp_customize->add_section( 'crt_footer', array(
	'panel' => 'module_settings',
	'title' => __( 'Footer', 'crt' ),
	'priority' => 200,
	'capability' => 'edit_theme_options',
) );
$wp_customize->add_setting( 'footer_logo', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'footer_company_name', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'footer_company_addess', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'footer_telephone', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'footer_fax', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'footer_email', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'footer_website', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'footer_website_nt', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'footer_reservation', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );

$wp_customize->add_setting( 'footer_mobile_nl_title', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'footer_mobile_nl_link', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'footer_mobile_nl_nt', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'footer_logo', array(
	'label' => __( 'Footer Logo', 'crt' ),
	'section' => 'crt_footer',
) ) );
$wp_customize->add_control( 'footer_company_name', array(
	'type' => 'text',
	'label' => __( 'Company Name', 'crt' ),
	'section' => 'crt_footer',
) );
$wp_customize->add_control( 'footer_company_addess', array(
	'type' => 'textarea',
	'label' => __( 'Company Address', 'crt' ),
	'section' => 'crt_footer',
) );
$wp_customize->add_control( 'footer_telephone', array(
	'type' => 'text',
	'label' => __( 'Telephone', 'crt' ),
	'section' => 'crt_footer',
) );
$wp_customize->add_control( 'footer_fax', array(
	'type' => 'text',
	'label' => __( 'Fax', 'crt' ),
	'section' => 'crt_footer',
) );
$wp_customize->add_control( 'footer_email', array(
	'type' => 'text',
	'label' => __( 'Email', 'crt' ),
	'section' => 'crt_footer',
) );
$wp_customize->add_control( 'footer_website', array(
	'type' => 'text',
	'label' => __( 'website', 'crt' ),
	'section' => 'crt_footer',
) );
$wp_customize->add_control( 'footer_website_nt', array(
	'type' => 'checkbox',
	'label' => __( 'Open website in new tab', 'crt' ),
	'section' => 'crt_footer',
) );
$wp_customize->add_control( 'footer_reservation', array(
	'type' => 'text',
	'label' => __( 'Reservation', 'crt' ),
	'section' => 'crt_footer',
) );


$wp_customize->add_control( 'footer_mobile_nl_title', array(
	'type' => 'text',
	'label' => __( 'Mobile Newsletter link Title', 'crt' ),
	'section' => 'crt_footer',
) );
$wp_customize->add_control( 'footer_mobile_nl_link', array(
	'type' => 'text',
	'label' => __( 'Mobile Newsletter link url', 'crt' ),
	'section' => 'crt_footer',
) );
$wp_customize->add_control( 'footer_mobile_nl_nt', array(
	'type' => 'checkbox',
	'label' => __( 'Open Mobile Newsletter link in new tab', 'crt' ),
	'section' => 'crt_footer',
) );