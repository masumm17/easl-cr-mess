<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cheval_Residences_theme
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="cr-container">
	<div class="cr-row">
		<?php if( has_post_thumbnail()): ?>
		<figure class="entry-featured-image cr-animate-when-visible">
			<?php cr_theme_post_thumbnail('fw2-3_x'); ?>
		</figure>
		<?php endif; ?>
		<div class="entry-content-wrap">
			<header class="entry-header cr-module-wrap cr-title-subtitle-wrapper">
				<h1 class="cr-sc-title"><span class="cr-title-inner cr-animate-when-visible"><?php the_title(); ?></span></h1>
			</header>
			<div class="entry-content cr-animate-when-visible">
				<?php
				the_content();
				?>
			</div>
			<footer class="entry-footer">
			</footer>
		</div>
			
	</div>
</div>
</article>