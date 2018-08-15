<?php
/**
 * The template for displaying the footer
 *
 *
 * @package Cheval_Residences_theme
 */

?> 
		</div>
		<div id="footer-before-content">
			<?php do_action('cr_before_footer'); ?>
		</div>
		<div class="cr-scroll-up-wrap">
			<span class="cr-scroll-up"><span></span><span></span><span></span></span>
		</div>
	</div>
	
<?php
$footer_logo = crt_footer_logo_img();
$footer_company_name = crt_get_theme_mode('footer_company_name');
$footer_company_addess = crt_get_theme_mode('footer_company_addess');
$footer_telephone = crt_get_theme_mode('footer_telephone');
$footer_telephone_title = crt_get_theme_mode('footer_telephone_title');
$footer_telephone_title = $footer_telephone_title ? $footer_telephone_title : $footer_telephone;
$footer_telephone_label = crt_get_theme_mode('footer_telephone_label');
$footer_fax = crt_get_theme_mode('footer_fax');
$footer_fax_title = crt_get_theme_mode('footer_fax_title');
$footer_fax_title = $footer_fax_title ? $footer_fax_title : $footer_fax;
$footer_fax_label = crt_get_theme_mode('footer_fax_label');
$footer_email = crt_get_theme_mode('footer_email');
$footer_email_title = crt_get_theme_mode('footer_email_title');
$footer_email_title = $footer_email_title ? $footer_email_title : $footer_email;
$footer_email_label = crt_get_theme_mode('footer_email_label');
$footer_website_title = crt_get_theme_mode('footer_website');
$footer_website_label = crt_get_theme_mode('footer_website_label');
$footer_website_url = trim(crt_get_theme_mode('footer_website_url'));
$footer_website_nt = crt_get_theme_mode('footer_website_nt');
$footer_reservation = crt_get_theme_mode('footer_reservation');
$footer_reservation_title = crt_get_theme_mode('footer_reservation_title');
$footer_reservation_title = $footer_reservation_title ? $footer_reservation_title : $footer_reservation;
$footer_reservation_label = crt_get_theme_mode('footer_reservation_label');

$footer_mobile_nl_title = crt_get_theme_mode('footer_mobile_nl_title');
$footer_mobile_nl_link = crt_get_theme_mode('footer_mobile_nl_link');
$footer_mobile_nl_nt = crt_get_theme_mode('footer_mobile_nl_nt');

$footer_company_addess = str_replace( "\n", '<br/>', strip_tags($footer_company_addess));

if(!$footer_website_url) {
	$footer_website_url = home_url();
	$footer_website_nt = false;
}


?>
<footer id="site-footer" class="site-footer">
	<div class="footer-top">
		<div class="footer-widgets">
			<div class="footer-container footer-cols">
				<div class="footer-col footer-left">
					<div class="footer-col-inner">
						<?php if($footer_telephone): ?><p><?php if($footer_telephone_label): ?><span class="footer-links-label"><?php echo $footer_telephone_label; ?></span><?php endif; ?><a class="footer-link-title" href="tel:<?php echo esc_attr($footer_telephone); ?>"><?php echo esc_html($footer_telephone_title); ?></a></p><?php endif;?> 
						<?php if($footer_fax): ?><p><?php if($footer_fax_label): ?><span class="footer-links-label"><?php echo $footer_fax_label; ?></span><?php endif; ?><span class="footer-link-title"><?php echo esc_html($footer_fax_title); ?></span></p><?php endif;?> 
					</div>
				</div>
				<div class="footer-col footer-center cr-animate-when-visible cr-animate-bothway">
					<div class="footer-center-wrap">
						<div class="footer-col-inner">
							<?php if($footer_logo): ?><p class="footer-logo"><img alt="Cheval Residences Logo" src="<?php echo esc_url($footer_logo); ?>"/></p><?php endif; ?> 
							<?php if($footer_company_name): ?><h4 class="footer-company-name"><?php echo esc_html($footer_company_name); ?></h4><?php endif;?> 
							<?php if($footer_company_addess): ?><h4 class="footer-company-address"><?php echo $footer_company_addess; ?></h4><?php endif;?> 
							<?php if($footer_mobile_nl_title && $footer_mobile_nl_link): ?>
							<div class="footer-newsletter">
								<a class="cr-button-secondary-bordered" href="<?php echo esc_url($footer_mobile_nl_link); ?>"<?php if($footer_mobile_nl_nt){ echo ' target="_blank"';} ?>><?php echo $footer_mobile_nl_title; ?></a>
							</div>
							<?php  endif; ?>
						</div>
						<p class="footer-avvio"><a href="https://www.avvio.com/" target="_blank"><?php _e('an avvio solution', 'crt') ?></a></p>
					</div>
				</div>
				<div class="footer-col footer-right">
					<div class="footer-col-inner">
						<?php if($footer_reservation): ?><p><?php if($footer_reservation_label): ?><span class="footer-links-label"><?php echo $footer_reservation_label; ?></span><?php endif; ?><a class="footer-link-title" href="mailto:<?php echo esc_attr($footer_reservation); ?>"><?php echo esc_html($footer_reservation_title); ?></a></p><?php endif;?> 
						<?php if($footer_email): ?><p><?php if($footer_email_label): ?><span class="footer-links-label"><?php echo $footer_email_label; ?></span><?php endif; ?><a class="footer-link-title" href="mailto:<?php echo esc_attr($footer_email); ?>"><?php echo esc_html($footer_email_title); ?></a></p><?php endif;?> 
						<?php if($footer_website_url): ?><p><?php if($footer_website_label): ?><span class="footer-links-label"><?php echo $footer_website_label; ?></span><?php endif; ?><a class="footer-link-title" href="<?php echo esc_url($footer_website_url); ?>"<?php if($footer_website_nt){ echo ' target="_blank"';} ?>><?php echo esc_html($footer_website_title); ?></a></p><?php endif;?> 
					</div>
				</div>
			</div>
			<div class="footer-container footer-mobile-content">
				<div class="footer-social-links">
					<?php 
					if( function_exists('get_title_icons_template')) {
						get_title_icons_template(false, false);
					}
					?>
				</div>
				<?php if($footer_mobile_nl_title && $footer_mobile_nl_link): ?>
				<div class="footer-newsletter-link">
					<a class="cr-button-secondary-bordered" href="<?php echo esc_url($footer_mobile_nl_link); ?>"<?php if($footer_mobile_nl_nt){ echo ' target="_blank"';} ?>><?php echo $footer_mobile_nl_title; ?></a>
				</div>
				<?php  endif; ?>
				<p class="footer-avvio"><a href="https://www.avvio.com/" target="_blank"><?php _e('an avvio solution', 'crt') ?></a></p>
			</div>
		</div>
		<div class="footer-menu-wrap">
			<div class="footer-container">
				<?php 
				wp_nav_menu( array(
					'theme_location' => 'footer_menu',
					'menu_class'     => 'footer-menu',
					'container'      => false,
					'fallback_cb'    => false,
					'link_before'    => '<span class="link-inner">',
					'link_after'     => '</span>',
				) );
				?>
			</div>
		</div>
	</div>
	<div id="footer-logos" class="footer-bottom">
		<div class="footer-container">
			
		</div>
	</div>
</footer>	
</div>
<div class="mobile-menu-humburger cr-humburger" onclick="return true;">
	<div class="cr-humburger-box">
		<div class="cr-humburger-inner"></div>
	</div>
</div>
<div class="site-mobile-navigation-bg"></div>
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
				'newtab' => 'no',
				'class' => '',

			));
			if(!$item['title']) {
				continue;
			}
			$attributes = array();
			if($item['class']) {
				$classes = explode(' ', $item['class']);
			}else{
				$classes = [];
			}
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
				<a<?php echo $attributes; ?>><?php if($item['icon']): ?><img alt="" src="<?php echo esc_url($item['icon']); ?>"/><?php endif; ?></a>
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
			'before'		 => '<span class="mobile-nav-arrow" onclick="return true;"></span>',
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
<div class="mobile-fixed-menu-wrap">
	<?php 
	wp_nav_menu( array(
		'theme_location' => 'mobile_fixed_menu',
		'menu_class'     => 'mobile-fixed-menu',
		'container'      => false,
		'fallback_cb'    => false,
		'link_before'    => '<span class="link-inner">',
		'link_after'     => '</span>',
		'depth'			 => 1,
	) );
	?>
</div>
<?php 
$enquire_now_enabled = crt_get_theme_mode( 'enable_enquire_button', '');
if(!$enquire_now_enabled) {
	get_template_part('modules/booking-panel');
}
?>
<?php wp_footer(); ?>
</body>
</html>
