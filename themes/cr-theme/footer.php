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
	</div>
	
<?php
$footer_logo = crt_footer_logo_img();
$footer_company_name = crt_get_theme_mode('footer_company_name');
$footer_company_addess = crt_get_theme_mode('footer_company_addess');
$footer_telephone = crt_get_theme_mode('footer_telephone');
$footer_fax = crt_get_theme_mode('footer_fax');
$footer_email = crt_get_theme_mode('footer_email');
$footer_website = crt_get_theme_mode('footer_website');
$footer_website_nt = crt_get_theme_mode('footer_website_nt');
$footer_reservation = crt_get_theme_mode('footer_reservation');

$footer_company_addess = str_replace( "\n", '<br/>', strip_tags($footer_company_addess));


?>
	<div id="footer-top-line"></div>
<footer id="site-footer" class="site-footer">
	<div class="footer-top">
		<div class="footer-widgets">
			<div class="footer-container">
				<div class="footer-left">
					<div class="footer-col-inner">
						<?php if($footer_telephone): ?><p><?php _e('T', 'crt');?>: <a href="tel:<?php echo esc_attr($footer_telephone); ?>"><?php echo esc_html($footer_telephone); ?></a></p><?php endif;?> 
						<?php if($footer_telephone): ?><p><?php _e('F', 'crt');?>: <a href="tel:<?php echo esc_attr($footer_telephone); ?>"><?php echo esc_html($footer_fax); ?></a></p><?php endif;?> 
					</div>
				</div>
				<div class="footer-center">
					<div class="footer-centerwrap">
						<div class="footer-col-inner">
							<?php if($footer_logo): ?><p class="footer-logo"><img alt="Cheval Residences Logo" src="<?php echo esc_url($footer_logo); ?>"/></p><?php endif; ?> 
							<?php if($footer_company_name): ?><h4 class="footer-company-name"><?php echo esc_html($footer_company_name); ?></h4><?php endif;?> 
							<?php if($footer_company_addess): ?><h4 class="footer-company-address"><?php echo $footer_company_addess; ?></h4><?php endif;?> 
							<div class="footer-newsletter">
								<form action="" method="get">
									<p class="footer-nl-field">
										<input type="email" name="footer_nl_email" id="footer_nl_email" placeholder="Enter your email"/>
										<button class="footer-nl-submit">sign up &gt;</button>
									</p>
								</form>
							</div>
						</div>
						<p class="footer-avvio"><a href="" target="_blank"><?php _e('an avvio solution', 'crt') ?></a></p>
					</div>
				</div>
				<div class="footer-right">
					<div class="footer-col-inner">
						<?php if($footer_reservation): ?><p><?php _e('Reservations', 'crt');?>: <a href="mailto:<?php echo esc_attr($footer_reservation); ?>"><?php echo esc_html($footer_reservation); ?></a></p><?php endif;?> 
						<?php if($footer_email): ?><p><?php _e('E', 'crt');?>: <a href="mailto:<?php echo esc_attr($footer_email); ?>"><?php echo esc_html($footer_email); ?></a></p><?php endif;?> 
						<?php if($footer_website): ?><p><?php _e('W', 'crt');?>: <a href="<?php echo esc_url($footer_website); ?>"<?php if($footer_website_nt){ echo ' target="_blank"';} ?>><?php echo esc_html($footer_website); ?></a></p><?php endif;?> 
					</div>
				</div>
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
<?php 
$enquire_now_enabled = crt_get_theme_mode( 'enable_enquire_button', '');
if(!$enquire_now_enabled) {
	get_template_part('modules/booking-panel');
}
?>
<?php wp_footer(); ?>
<?php if(isset($_SERVER['SERVER_NAME']) && 'cheval-residences.local' != $_SERVER['SERVER_NAME']): ?>
	<script type="text/javascript"> (function (d, t) { var pp = d.createElement(t), s = d.getElementsByTagName(t)[0]; pp.src = '//app.pageproofer.com/overlay/js/3037/1254'; pp.type = 'text/javascript'; pp.async = true; s.parentNode.insertBefore(pp, s); })(document, 'script'); </script>
<?php endif; ?>
</body>
</html>
