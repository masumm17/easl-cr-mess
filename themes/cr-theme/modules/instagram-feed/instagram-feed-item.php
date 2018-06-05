<?php
if (!defined('ABSPATH')) die('-1');
?>
<div class="cr-instagram-feed-item">
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
					<a href="<?php echo esc_url($item['url']); ?>" target="_blank"></a>
				</div>
			</div>
		</div>
	</div>
</div>
