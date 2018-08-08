<?php
/**
 * The header for our theme
 *
 * @package Cheval_Residences_theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php 
	$preloaer_eanbled = crt_get_theme_mode('preloader_enabled'); 
	$preloaer_image = crt_get_mode_img('preloader_image'); 
	?>
	<?php if($preloaer_eanbled && $preloaer_image): ?>
	<div class="loading-animation">
		<div class="loading-image-con"><img src="<?php echo esc_url($preloaer_image); ?>" alt="<?php _e('Loading...', 'crt'); ?>"/></div>
	</div>
	<?php endif; ?>
	
	<header id="masthead" class="site-header">
		<div class="site-branding">
			<a class="site-logo" href="<?php echo home_url( '/' ); ?>" title="">
				<img class="site-main-logo" alt="" src="<?php echo crt_header_logo_img(); ?>"/>
			</a>
		</div>
		<nav class="site-primary-navigation">
			<?php 
			wp_nav_menu( array(
				'theme_location' => 'header_menu',
				'menu_class'     => 'header-primary-menu',
				'container'      => false,
				'fallback_cb'    => false,
				'link_before'    => '<span class="link-inner">',
				'link_after'     => '</span>',
				'walker'		 => new CR_Dropdown_Walker_Nav_Menu,
			) );
			?>
		</nav>
		<?php 
		$header_highlight_button = crt_header_highlighted_butotn();
		if($header_highlight_button):
		?>
		<div class="section-header-highlight">
			<?php echo $header_highlight_button; ?>
		</div>
		<?php endif; ?>
		<?php 
		if(crt_sticky_nav_enabled()) {
			get_template_part('modules/stikcy-side-navigation');
		}
		?> 
		<?php if(defined('ICL_SITEPRESS_VERSION')):?>
		<div class="mobile-language-selector">
			<?php echo do_shortcode('[wpml_language_switcher][/wpml_language_switcher]'); ?>
		</div>
		<?php endif; ?>
	</header>
	<div id="cr-page-wrap">
		<div id="cr-wrap">
			<div id="primary" class="content-area">