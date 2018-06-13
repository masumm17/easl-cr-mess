<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Cheval_Residences_theme
 */

get_header();

$title = crt_get_theme_mode( '404_page_title', '');
$subtitle = crt_get_theme_mode( '404_page_subtitle', '');
$content = crt_get_theme_mode( '404_page_content', '');
?>
		<main id="main" class="site-main">
			<div class="cr-container">
				<div class="cr-row">
					<div class="cr-404-container">
						<section class="cr-module-wrap cr-404-wrap">
							<?php if($title || $subtitle): ?> 
							<div class="cr-title-subtitle-wrapper <?php if($subtitle){ echo 'cr-title-has-subtitle'; } ?>">
								<h2 class="cr-sc-title"><span class="cr-title-inner cr-animate-when-visible"><?php echo esc_html($title); ?></span></h2>
								<?php if ($subtitle): ?>
								<h2 class="cr-sc-subtitle"><span class="cr-subtitle-inner cr-animate-when-visible"><?php echo esc_html($subtitle); ?></span></h2>
								<?php endif; ?>
							</div>
							<div class="cr-404-text cr-animate-when-visible">
								<?php echo do_shortcode( $content ) ?>
							</div>
							<?php endif; ?>
							<div class="cr-404-sitemap cr-animate-when-visible">
								<?php get_template_part('template-parts/sitemap'); ?>
							</div>
						</section>
					</div>
				</div>
			</div>
		</main>
<?php
get_footer();
