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
		//'container'      => 'div',
				//'container_class'      => 'cr-site-map-menu-wrap',
		$all_menu_html = '';
		foreach($menu_locations as $menu_loc) {
			$menu_html = wp_nav_menu( array(
				'theme_location' => $menu_loc,
				'menu_class'     => '',
				'id' => '',
				'container'      => '',
				'container_class'      => '',
				'fallback_cb'    => false,
				'link_before'    => '',
				'link_after'     => '',
				'echo' => false,
			) );
			$menu_html = trim($menu_html);
			$menu_html = preg_replace('/<\/ul>$/', '', $menu_html);
			$menu_html = preg_replace('/^<ul[^>]+>/', '', $menu_html);
			$all_menu_html .= $menu_html;
		}
		if($all_menu_html){
			echo '<div class="cr-site-map-menu-wrap"><ul class="cr-site-map-menu">' . $all_menu_html . '</ul></div>';
		}
		?>
	</div>
</div>

<?php endif; ?>




