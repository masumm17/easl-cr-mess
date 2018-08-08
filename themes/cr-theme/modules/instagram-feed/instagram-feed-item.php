<?php
if (!defined('ABSPATH')) die('-1');
$position_class = '';
if($count == $cc_position - 1) {
	$position_class = 'item-before-cc item-prev-cc';
}elseif($count == $cc_position) {
	$position_class = 'item-after-cc item-next-cc';
}elseif($count < $cc_position){
	$position_class = 'item-before-cc'; 
}elseif($count > $cc_position) {
	$position_class = 'item-after-cc'; 
}

if($count > $number - 3) {
	$position_class .= ' items-on-larger-screen'; 
}
?>
<div class="cr-instagram-feed-item <?php echo $position_class; ?>" onClick="return true">
	<div class="cr-instagram-feed-item-inner">
		<div class="cr-instagram-feed-image" style="background-image: url('<?php echo esc_url($item['url']); ?>');">
			<img style="display: none;" src="<?php echo esc_url($item['url']); ?>"/>
		</div>
		<div class="cr-instagram-feed-overlay">
			<div class="cr-instagram-feed-info">
				<?php if( $item[ 'caption' ] ): ?><h5 class="cr-instagram-feed-caption"><?php echo cr_truncate($item['caption'], 155, '...', true); ?></h5><?php endif; ?>
			</div>
			<div class="cr-instagram-feed-metainfo">
				<div class="cr-instagram-feed-likes">
					<span><?php echo $item['likes']; ?></span>
				</div>
				<div class="cr-instagram-feed-comments">
					<span><?php echo $item['comments']; ?></span>
				</div>
				<div class="cr-instagram-feed-plink">
					<a href="<?php echo esc_url($item['plink']); ?>" target="_blank"></a>
				</div>
			</div>
		</div>
	</div>
</div>
