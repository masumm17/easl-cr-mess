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
	<header class="cr-blog-entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="cr-blog-entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="cr-blog-entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="cr-blog-entry-meta">
				<ul>
					<li class="cr-posted-on"><?php cr_theme_posted_on();?></li>
					<li class="cr-comments-link"><?php comments_popup_link('0', '1', '%');?></li>
				</ul>
			</div>
		<?php endif; ?>
	</header>

	<?php if(has_post_thumbnail): ?>
	<figure class="cr-blog-entry-thumbnail">
		<a href="<?php the_permalink(); ?>" aria-hidden="true">
			<?php
			the_post_thumbnail( 'fw2-3_x', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>
	</figure>
	<?php endif;?>
	<div class="cr-blog-entry-content">
		<?php
		if(!is_single()) {
			$content = has_excerpt() ? get_the_excerpt() : get_the_content();
			echo '<p>' . cr_truncate($content, 420, '...', true) . '</p>';
			echo '<p class="cr-blog-entry-readmore"><a class="cr-button" href="'. get_the_permalink() .'">'. __("Read More") .'</a></p>';
		}else{
			the_content();
		}
		?>
	</div>
	<?php if( is_single()): ?>
	<footer class="cr-blog-entry-footer">
		<?php 
		$categories_list = get_the_category_list( esc_html__( ', ', 'crt' ) );
		if ( $categories_list ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'crt' ) . '</span>', $categories_list );
		}
		?>
	</footer>
	<?php if( comments_open()) { comments_template(); }; ?>
	<?php endif; ?>
</article>
