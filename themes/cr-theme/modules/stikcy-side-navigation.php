<?php
if (!defined('ABSPATH')) die('-1');

$items = crt_get_theme_mode( 'stikcy_side_navigation_items', '');
if($items){
	$items = json_decode($items);
}
if(!empty($items) && is_array($items) && count($items) > 0) {
?>
<div class="sticky-side-nav">
	<ul class="sticky-side-nav-items">
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
						$classes[] = 'sticky-side-nav-item-tel';
					}
					break;
				case 'email':
					if($item['link']){
						$attributes[] = 'href="mailto:'. esc_attr($item['link']) .'"';
						$classes[] = 'sticky-side-nav-item-email';
					}
					break;
				case 'livechat':
					$attributes[] = 'href="#livechat"';
					$classes[] = 'sticky-side-nav-item-livechat';
					break;
				case 'link':
				default:
					if($item['link']){
						$attributes[] = 'href="'. esc_url($item['link']) .'"';
						$classes[] = 'sticky-side-nav-item-link';
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
		<li class="sticky-side-nav-item <?php echo $classes; ?>">
			<a<?php echo $attributes; ?>>
				<?php if($item['icon']): ?><span class="sticky-side-nav-item-icon"><img alt="" src="<?php echo esc_url($item['icon']); ?>"/></span><?php endif; ?>
				<span class="sticky-side-nav-item-text"><?php echo esc_html($item['title']); ?></span>
			</a>
		</li>
		<?php endforeach; ?>
		<li class="sticky-side-nav-item sticky-side-nav-item-ls"><?php echo do_shortcode('[wpml_language_switcher][/wpml_language_switcher]'); ?></li>
	</ul>
</div>
<?php
}

