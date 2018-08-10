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
$wp_customize->add_setting( 'footer_telephone_label', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'footer_telephone_title', array(
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
$wp_customize->add_setting( 'footer_fax_label', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'footer_fax_title', array(
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
$wp_customize->add_setting( 'footer_email_label', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'footer_email_title', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'footer_website_label', array(
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
$wp_customize->add_setting( 'footer_website_url', array(
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
$wp_customize->add_setting( 'footer_reservation_label', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'footer_reservation_title', array(
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
	'label' => __( 'Telephone Number', 'crt' ),
	'section' => 'crt_footer',
) );
$wp_customize->add_control( 'footer_telephone_title', array(
	'type' => 'text',
	'label' => __( 'Telephone Title', 'crt' ),
	'section' => 'crt_footer',
) );
$wp_customize->add_control( 'footer_telephone_label', array(
	'type' => 'text',
	'label' => __( 'Telephone Label', 'crt' ),
	'section' => 'crt_footer',
) );
$wp_customize->add_control( 'footer_fax', array(
	'type' => 'text',
	'label' => __( 'Fax Number', 'crt' ),
	'section' => 'crt_footer',
) );
$wp_customize->add_control( 'footer_fax_title', array(
	'type' => 'text',
	'label' => __( 'Fax Title', 'crt' ),
	'section' => 'crt_footer',
) );
$wp_customize->add_control( 'footer_fax_label', array(
	'type' => 'text',
	'label' => __( 'Fax Label', 'crt' ),
	'section' => 'crt_footer',
) );
$wp_customize->add_control( 'footer_email', array(
	'type' => 'text',
	'label' => __( 'Email Address', 'crt' ),
	'section' => 'crt_footer',
) );
$wp_customize->add_control( 'footer_email_title', array(
	'type' => 'text',
	'label' => __( 'Email Title', 'crt' ),
	'section' => 'crt_footer',
) );
$wp_customize->add_control( 'footer_email_label', array(
	'type' => 'text',
	'label' => __( 'Email Label', 'crt' ),
	'section' => 'crt_footer',
) );
$wp_customize->add_control( 'footer_website_url', array(
	'type' => 'text',
	'label' => __( 'Website URL', 'crt' ),
	'section' => 'crt_footer',
	'description' => __('Please leave empty to use home page url.', 'crt'),
) );
$wp_customize->add_control( 'footer_website', array(
	'type' => 'text',
	'label' => __( 'Website Title', 'crt' ),
	'section' => 'crt_footer',
) );
$wp_customize->add_control( 'footer_website_label', array(
	'type' => 'text',
	'label' => __( 'Website Label', 'crt' ),
	'section' => 'crt_footer',
) );
$wp_customize->add_control( 'footer_website_nt', array(
	'type' => 'checkbox',
	'label' => __( 'Open website in new tab', 'crt' ),
	'section' => 'crt_footer',
	'description' => __('If Website URL is empty it will have no effect.', 'crt'),
) );
$wp_customize->add_control( 'footer_reservation', array(
	'type' => 'text',
	'label' => __( 'Reservation Email', 'crt' ),
	'section' => 'crt_footer',
) );
$wp_customize->add_control( 'footer_reservation_title', array(
	'type' => 'text',
	'label' => __( 'Reservation Title', 'crt' ),
	'section' => 'crt_footer',
) );
$wp_customize->add_control( 'footer_reservation_label', array(
	'type' => 'text',
	'label' => __( 'Reservation Label', 'crt' ),
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