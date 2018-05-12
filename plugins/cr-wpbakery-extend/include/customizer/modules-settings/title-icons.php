<?php
if (!defined('ABSPATH')) die('-1');

$wp_customize->add_section( 'crt_title_icons', array(
	'panel' => 'module_settings',
	'title' => __( 'Title & Icons', 'crvc_extension' ),
	'priority' => 180,
	'capability' => 'edit_theme_options',
) );
$wp_customize->add_setting( 'site_social_icons_enabled', array(
	'type' => 'option',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( 'site_social_icons_title', array(
	'type' => 'option',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_control( 'site_social_icons_enabled', array(
	'type' => 'checkbox',
	'label' => __( 'Display above footer area', 'crvc_extension' ),
	'section' => 'crt_title_icons',
) );
$wp_customize->add_control( 'site_social_icons_title', array(
	'type' => 'text',
	'label' => __( 'Title above the icon list', 'crvc_extension' ),
	'section' => 'crt_title_icons',
) );

$social_icons = array(
	'facebook' => array(
		'label' => __( 'Facebook', 'crvc_extension' ),
	),
	'twitter' => array(
		'label' => __( 'Twitter', 'crvc_extension' ),
	),
	'youtube' => array(
		'label' => __( 'youtube', 'crvc_extension' ),
	),
	'instagram' => array(
		'label' => __( 'Instagram', 'crvc_extension' ),
	),
	'pinterest' => array(
		'label' => __( 'Pinterest', 'crvc_extension' ),
	),
	'linkedin' => array(
		'label' => __( 'Linkedin', 'crvc_extension' ),
	),
);
$label_link = __( '%s profile url', 'crvc_extension' );
$label_icon = __( '%s icon image', 'crvc_extension' );
foreach($social_icons as $icon_key => $icon_settings){
	$link_key = 'site_social_icons_'. $icon_key .'_link';
	$icon_key = 'site_social_icons_'. $icon_key .'_icon';
	$wp_customize->add_setting( $link_key, array(
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => 'refresh',
	) );
	$wp_customize->add_setting( $icon_key, array(
		'type' => 'option',
		'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => 'refresh',
	) );
	$wp_customize->add_control( $link_key, array(
		'type' => 'url',
		'label' => sprintf($label_link, $icon_settings['label']),
		'section' => 'crt_title_icons',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $icon_key, array(
		'label' => sprintf($label_icon, $icon_settings['label']),
		'section' => 'crt_title_icons',
	) ) );
}