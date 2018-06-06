<?php
/**
 * The template for displaying all pages
 *
 * @package Cheval_Residences_theme
 */

get_header();
?>

	
		<main id="main" class="site-main">
		<?php
		while ( have_posts() ) :
			the_post();
			get_template_part('template-parts/content', 'single');
		endwhile;
		?>
		</main>
	

<?php
get_footer();
