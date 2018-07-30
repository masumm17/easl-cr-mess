<?php
if (!defined('ABSPATH')) die('-1');

$secret_key = crt_get_theme_mode( 'instagram_feed_secretkey', '');
$number = crt_get_theme_mode( 'instagram_feed_number', '');
$cc_enabled = crt_get_theme_mode( 'instagram_feed_cc_enable', '');
$cc_position = crt_get_theme_mode( 'instagram_feed_cc_pos', '');
$cc_text = crt_get_theme_mode( 'instagram_feed_cc_text', '');
$cc_link_title = crt_get_theme_mode( 'instagram_feed_cc_link_title', '');
$cc_link_url = crt_get_theme_mode( 'instagram_feed_cc_link_url', '');
$cc_link_nt = crt_get_theme_mode( 'instagram_feed_cc_link_nt', '');

$number = absint($number);
if(!$number) {
	$number = 13;
}
$cc_position = absint($cc_position);
if(!$cc_position) {
	$cc_position = 7;
}

$fetch_feed = 'yes';

$cached_feeds = get_transient('cr_instagram_feed');

$has_feed = (false !== $cached_feeds) && count($cached_feeds) >= $number;
if(!$has_feed) {
	delete_transient('cr_instagram_feed');
}
if(isset($_GET['cr_clear_instafeed'])) {
	$has_feed = false;
	$cached_feeds = false;
	delete_transient('cr_instagram_feed');
}

if($secret_key):
	$cc_enabled = $cc_enabled && ($cc_text ||  $cc_link_title);
	$data_attributes = array();
	$data_attributes[] = 'data-secretkey="'. esc_attr($secret_key) .'"';
	$data_attributes[] = 'data-number="'. esc_attr($number) .'"';
	if($cc_enabled) {
		$data_attributes[] = 'data-ccenabled="yes"';
		$data_attributes[] = 'data-ccpos="' . esc_attr($cc_position) . '"';
	}
?> 
<div class="cr-container">
	<div class="cr-row">
		<div class="cr-instagram-feed-wrap <?php if(!$has_feed) {echo 'cr-fetch-feed';} ?>" <?php if(!$has_feed) {echo join( ' ', $data_attributes );} ?>>
			<div class="cr-instagram-feed-inner">
				<div class="cr-instagram-feed-con">
					<?php
					if($has_feed):
						$count = 0;
						$custom_content_shown = false;
						foreach($cached_feeds as $item):
							$count++;
							if($count > $number){
								break;
							}
							if($cc_enabled && $count == $cc_position){
								$custom_content_shown = true;
								include locate_template('modules/instagram-feed/instagram-feed-custom-item.php');
							}
							include locate_template('modules/instagram-feed/instagram-feed-item.php');
							
						endforeach;
						if(!$custom_content_shown) {
							$custom_content_shown = true;
							include locate_template('modules/instagram-feed/instagram-feed-custom-item.php');
						}
					endif;
					?>
				</div>
			</div>
		</div>
	</div>
</div>
		
<?php endif; ?>