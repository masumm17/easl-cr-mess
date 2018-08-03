<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$url = function_exists('get_field') ? get_field('link') : get_post_meta( get_the_ID(), 'link', true);
$link_nt = function_exists('get_field') ? get_field('link_nt') : get_post_meta( get_the_ID(), 'link_nt', true);
$subtitle = function_exists('get_field') ? get_field('subtitle') : get_post_meta( get_the_ID(), 'subtitle', true);
if(!$url) {
	$url = get_permalink();
}

?>

<li class="accommodations-item cr-animate-when-visible" onClick="return true">
	<a class="accommodations-item-inner" href="<?php echo esc_url($url); ?>"<?php if($link_nt){echo ' target="_blank"';} ?>>
		<div class="accommodations-item-text">
			<h3 class="accommodations-item-title"><?php echo cr_vce_truncate( get_the_title(), 80); ?></h3>
			<?php if($subtitle): ?>
			<h4 class="accommodations-item-subtitle"><?php echo cr_vce_truncate($subtitle, 80); ?></h4>
			<?php endif; ?>
		</div>
		<?php 
		if(has_post_thumbnail()) :
			$item_thumb_src = get_the_post_thumbnail_url(get_the_ID(), 'fw2-3_col1-3_x');
			?>
			<div class="accommodations-item-imagebg" style="background-image: url('<?php echo esc_url($item_thumb_src); ?>');"></div>
			<?php the_post_thumbnail('fw2-3_col1-3_x', array('class' => 'accommodations-item-image')); ?>
		<?php endif; ?>
	</a>
</li>