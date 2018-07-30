<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cheval_Residences_theme
 */

get_header();

// Get Blog page template
if( is_home() && !is_front_page() ) {
	get_template_part( 'template-parts/blog' );
}

get_footer();
?>