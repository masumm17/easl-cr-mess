<?php
if (!defined('ABSPATH')) die('-1');

$wp_customize->add_section( 'crt_instagram_feed', array(
	'panel' => 'module_settings',
	'title' => __( 'Instagram Feed', 'crt' ),
	'priority' => 161,
	'capability' => 'edit_theme_options',
) );

$wp_customize->add_setting( 'instagram_feed_footer_enable', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => 'disabled',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'instagram_feed_secretkey', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'instagram_feed_username', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'instagram_feed_cache_expiration', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'instagram_feed_number', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'instagram_feed_cc_enable', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'instagram_feed_cc_pos', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'instagram_feed_cc_text', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'instagram_feed_cc_link_title', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'instagram_feed_cc_link_url', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'instagram_feed_cc_link_nt', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );

$wp_customize->add_control( 'instagram_feed_footer_enable', array(
	'type' => 'select',
	'label' => __( 'Display on Footer', 'crt' ),
	'section' => 'crt_instagram_feed',
	'choices' => array(
		'enabled' => __('Enabled', 'crt' ),
		'disabled' => __('Disabled', 'crt' ),
	),
) );
$wp_customize->add_control( 'instagram_feed_secretkey', array(
	'type' => 'text',
	'label' => __('Access Token', 'crt'),
	'section' => 'crt_instagram_feed',
) );
$wp_customize->add_control( 'instagram_feed_username', array(
	'type' => 'text',
	'label' => __('User Name', 'crt'),
	'section' => 'crt_instagram_feed',
) );
$wp_customize->add_control( 'instagram_feed_cache_expiration', array(
	'type' => 'select',
	'label' => __('Cache for', 'crt'),
	'section' => 'crt_instagram_feed',
	'choices' => array(
		'2' => __('2 Hours', 'crt' ),
		'4' => __('4 Hours', 'crt' ),
		'6' => __('6 Hours', 'crt' ),
		'8' => __('8 Hours', 'crt' ),
		'12' => __('12 Hours', 'crt' ),
		'24' => __('24 Hours', 'crt' ),
		'48' => __('48 Hours', 'crt' ),
	),
) );

$wp_customize->add_control( 'instagram_feed_number', array(
	'type' => 'text',
	'label' => __('Number of items to display.', 'crt'),
	'section' => 'crt_instagram_feed',
) );
$wp_customize->add_control( 'instagram_feed_cc_enable', array(
	'type' => 'checkbox',
	'label' => __( 'Enable Custom Content', 'crt' ),
	'section' => 'crt_instagram_feed',
) );
$wp_customize->add_control( 'instagram_feed_cc_pos', array(
	'type' => 'text',
	'label' => __('Custom Content Position', 'crt'),
	'section' => 'crt_instagram_feed',
) );
$wp_customize->add_control( 'instagram_feed_cc_text', array(
	'type' => 'textarea',
	'label' => __('Custom Content Text', 'crt'),
	'section' => 'crt_instagram_feed',
) );
$wp_customize->add_control( 'instagram_feed_cc_link_title', array(
	'type' => 'text',
	'label' => __('Custom Content Link Title', 'crt'),
	'section' => 'crt_instagram_feed',
) );
$wp_customize->add_control( 'instagram_feed_cc_link_url', array(
	'type' => 'text',
	'label' => __('Custom Content Link Url', 'crt'),
	'section' => 'crt_instagram_feed',
) );
$wp_customize->add_control( 'instagram_feed_cc_link_nt', array(
	'type' => 'checkbox',
	'label' => __( 'Custom Content Link Newtab', 'crt' ),
	'section' => 'crt_instagram_feed',
) );