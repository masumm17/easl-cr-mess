<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$url = function_exists('get_field') ? get_field('link') : get_post_meta( get_the_ID(), 'link', true);
$subtitle = function_exists('get_field') ? get_field('subtitle') : get_post_meta( get_the_ID(), 'subtitle', true);
if(!$url) {
	$url = get_permalink();
}

?>

<li class="accommodations-item cr-animate-when-visible">
	<a class="accommodations-item-inner" href="<?php esc_url($url); ?>">
		<div class="accommodations-item-text">
			<h3 class="accommodations-item-title"><?php echo cr_vce_truncate( get_the_title(), 80); ?></h3>
			<?php if($subtitle): ?>
			<h4 class="accommodations-item-subtitle"><?php echo cr_vce_truncate($subtitle, 80); ?></h4>
			<?php endif; ?>
		</div>
		<?php if(has_post_thumbnail()) {the_post_thumbnail('fw2-3_col1-3_x', array('class' => 'accommodations-item-image'));} ?>
	</a>
</li>