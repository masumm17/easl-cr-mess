<?php
if (!defined('ABSPATH')) die('-1');

?>
<div class="cr-instagram-feed-item cr-instagram-feed-item-custom">
	<div class="cr-instagram-feed-custom-text">
		<?php
		if($cc_text){
			echo wpautop(trim($cc_text));
		}
		if($cc_link_title):
		?> 
		<h5>
			<a href="<?php echo esc_url($cc_link_url); ?>" <?php if($cc_link_nt){echo 'target="_blank"';} ?>><?php echo esc_html($cc_link_title);?></a>
		</h5>
		<?php endif; ?>
	</div>
	<div class="cr-instagram-feed-grid-sizer"></div>
</div>

