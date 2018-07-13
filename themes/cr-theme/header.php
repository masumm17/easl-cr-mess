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
		<img src="<?php echo esc_url($preloaer_image); ?>" alt="<?php _e('Loading...', 'crt'); ?>"/>
	</div>
	<?php endif; ?>
	<div id="cr-wrap">
		<header id="masthead" class="site-header">
			<div class="site-branding">
				<a class="site-logo" href="<?php echo home_url( '/' ); ?>" title="">
					<img class="site-main-logo" alt="" src="<?php echo crt_header_logo_img(); ?>"/>
					<img class="scroll-header-logo" alt="" src="<?php echo crt_scroll_header_logo_img(); ?>"/>
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
			<nav class="site-mobile-navigation">
				<?php 
				$items = crt_get_theme_mode( 'stikcy_side_navigation_items', '');
				if($items){
					$items = json_decode($items);
				}
				if(!empty($items) && is_array($items) && count($items) > 0):
				?>
				
				<div class="site-mobile-navigation-sticky">
					<ul class="mobile-sticky-items">
					<?php
					foreach($items as $item): 
						$item = wp_parse_args($item, array(
							'title' => '',
							'icon' => '',
							'type' => 'link',
							'link' => '',
							'newtab' => 'no'

						));
						if(!$item['title']) {
							continue;
						}
						$attributes = array();
						$classes = [];
						switch($item['type']) {
							case 'tel':
								if($item['link']){
									$attributes[] = 'href="tel:'. esc_attr($item['link']) .'"';
									$classes[] = 'mobile-sticky-item-tel';
								}
								break;
							case 'email':
								if($item['link']){
									$attributes[] = 'href="mailto:'. esc_attr($item['link']) .'"';
									$classes[] = 'mobile-sticky-item-email';
								}
								break;
							case 'livechat':
								$attributes[] = 'href="#livechat"';
								$classes[] = 'mobile-sticky-item-livechat';
								break;
							case 'link':
							default:
								if($item['link']){
									$attributes[] = 'href="'. esc_url($item['link']) .'"';
									$classes[] = 'mobile-sticky-item-link';
								}
								break;
						}
						if(count($classes) > 0) {
							$classes = join( ' ', $classes );
						} else {
							$classes = '';
						}
						if(count($attributes) > 0) {
							$attributes = ' ' . join( ' ', $attributes );
						} else {
							$attributes = '';
						}

					?> 
						<li class="mobile-sticky-item <?php echo $classes; ?>">
							<a<?php echo $attributes; ?>>
								<?php if($item['icon']): ?><img alt="" src="<?php echo esc_url($item['icon']); ?>"/></span><?php endif; ?>
							</a>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php endif; ?>
				<div class="header-mobile-menu-wrap">
					<?php 
					wp_nav_menu( array(
						'theme_location' => 'header_menu',
						'menu_class'     => 'header-mobile-menu',
						'container'      => false,
						'fallback_cb'    => false,
						'before'		 => '<span class="mobile-nav-arrow"></span>',
						'link_before'    => '<span class="link-inner">',
						'link_after'     => '</span>',
					) );
					wp_nav_menu( array(
						'theme_location' => 'footer_menu',
						'menu_class'     => 'header-mobile-menu',
						'container'      => false,
						'fallback_cb'    => false,
						'before'		 => '<span class="mobile-nav-arrow"></span>',
						'link_before'    => '<span class="link-inner">',
						'link_after'     => '</span>',
					) );
					?>
				</div>
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
			<div class="mobile-menu-humburger cr-humburger">
				<div class="cr-humburger-box">
					<div class="cr-humburger-inner"></div>
				</div>
			</div>
			<?php if(defined('ICL_SITEPRESS_VERSION')):?>
			<div class="mobile-language-selector">
				<?php echo do_shortcode('[wpml_language_switcher][/wpml_language_switcher]'); ?>
			</div>
			<?php endif; ?>
		</header>
		<div id="primary" class="content-area">