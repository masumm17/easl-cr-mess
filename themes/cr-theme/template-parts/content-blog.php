<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cheval_Residences_theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('cr-blog-hentry'); ?>>
	<header class="cr-entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="cr-entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="cr-entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				cr_theme_posted_on();
				cr_theme_posted_by();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php if(has_post_thumbnail): ?>
	<figure class="cr-blog-thumbnail">
		<a href="<?php the_permalink(); ?>" aria-hidden="true">
			<?php
			the_post_thumbnail( 'cr_default', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>
	</figure>
	<?php endif;?>
	<div class="entry-content">
		<?php
		the_content( sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'crt' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'crt' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php cr_theme_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
