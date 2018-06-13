<?php
/**
 * Template parts for blog listing page layout
 */
?>
<div class="cr-container">
	<div class="cr-row">
		<div class="cr-blog-wrapper <?php if(!is_active_sidebar( 'sidebar-blog' ) ){ echo 'no-sidebar';} ?>">
			<main id="main" class="site-main cr-blog-main">
				<div class="cr-blog-articles">
					<?php 
					while( have_posts()){
						the_post();
						get_template_part('template-parts/content-single');
					}
					?>
				</div>
				<?php 
				$prev_page_link = get_previous_posts_link(__('<span>&laquo;</span> Newer Posts', 'crt'));
				$next_page_link = get_next_posts_link(__('Older Posts <span>&raquo;</span>', 'crt'));

				if(!is_single() && ($prev_page_link || $next_page_link)):
				?>
				<div class="cr-blog-navigation">
					<?php if($prev_page_link): ?>
					<p class="cr-blog-navigation-prev"><?php echo $prev_page_link; ?></p>
					<?php endif; ?> 
					<?php if($next_page_link): ?>
					<p class="cr-blog-navigation-next"><?php echo $next_page_link; ?></p>
					<?php endif; ?> 
				</div>
				<?php endif; ?> 
			</main>
			<?php get_sidebar('blog'); ?>
		</div>
	</div>
</div>