<?php
if (!defined('ABSPATH')) die('-1');
$menu_locations = array(
	'header_menu',
	'footer_menu',
);
if(count($menu_locations) > 0):
?>

<div class="cr-site-map-wrap">
	<div class="cr-site-map-inner">
		<?php 
		foreach($menu_locations as $menu_loc) {
			wp_nav_menu( array(
				'theme_location' => $menu_loc,
				'menu_class'     => 'cr-site-map-menu',
				'container'      => 'div',
				'container_class'      => 'cr-site-map-menu-wrap',
				'fallback_cb'    => false,
				'link_before'    => '',
				'link_after'     => '',
			) );
		}
		?>
	</div>
</div>

<?php endif; ?>




