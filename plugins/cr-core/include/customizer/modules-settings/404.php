<?php
if (!defined('ABSPATH')) die('-1');

$wp_customize->add_section( 'crt_404_page', array(
	'panel' => 'module_settings',
	'title' => __( '404 Page', 'crt' ),
	'priority' => 199,
	'capability' => 'edit_theme_options',
) );
$wp_customize->add_setting( '404_doc_title', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( '404_page_title', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( '404_page_subtitle', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );
$wp_customize->add_setting( '404_page_content', array(
	'type' => 'theme_mod',
	'capability' => 'edit_theme_options',
	'default' => '',
	'transport' => 'refresh',
) );


$wp_customize->add_control( '404_doc_title', array(
	'type' => 'text',
	'label' => __( 'Document Title', 'crt' ),
	'description' => __('Enter document title for 404 page.', 'crt'),
	'section' => 'crt_404_page',
) );
$wp_customize->add_control( '404_page_title', array(
	'type' => 'text',
	'label' => __( 'Title', 'crt' ),
	'description' => __('Enter title for 404 page.', 'crt'),
	'section' => 'crt_404_page',
) );
$wp_customize->add_control( '404_page_subtitle', array(
	'type' => 'text',
	'label' => __( 'Subtitle', 'crt' ),
	'description' => __('Enter subtitle for 404 page.', 'crt'),
	'section' => 'crt_404_page',
) );

$wp_customize->add_control( '404_page_content', array(
	'type' => 'textarea',
	'label' => __( 'Content', 'crt' ),
	'description' => __('Add a bit of content to disply on 404 page.', 'crt'),
	'section' => 'crt_404_page',
) );