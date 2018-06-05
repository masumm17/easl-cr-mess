<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * Shortcode class
 * @var $this CR_VcE_Sc_Gallery_Item
 */
$el_class = $css = $css_animation = '';
$image = $image_landscape = $overlay_title = '';
$lightbox_title = $lightbox_subtitle = $lightbox_ctas = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$lightbox_ctas = $this->get_buttons_data( $lightbox_ctas );
$lightbox_ctas_html = '';
foreach($lightbox_ctas as $lbcta) {
	$link_attributes = array();
	$link_attributes[] = 'href="' . trim( $lbcta['url'] ) . '"';
	$link_attributes[] = 'title="' . esc_attr( trim( $lbcta['url'] ) ) . '"';
	if ( ! empty( $button['target'] ) ) {
		$link_attributes[] = 'target="' . esc_attr( trim( $lbcta['target'] ) ) . '"';
	}
	if ( ! empty( $button['rel'] ) ) {
		$link_attributes[] = 'rel="' . esc_attr( trim( $lbcta['rel'] ) ) . '"';
	}
	$link_attributes = implode( ' ', $link_attributes );
	if($lbcta['title'] && $link_attributes){
		$lightbox_ctas_html .='<li><a class="cr-button-secondary-bordered" ' . $link_attributes . '><span class="cr-button-text">' .  esc_html($lbcta['title']) . '</span></a></li>';
	}
}

$image = preg_replace( '/[^\d]/', '', $image );
$thumb_image_src = wp_get_attachment_image_src( $image, 'flh_col1-4', false );
$img_full_src = wp_get_attachment_image_src( $image, 'full', false );

$image_landscape = preg_replace( '/[^\d]/', '', $image_landscape );
//$img_full_landscape_src = wp_get_attachment_image_src( $image_landscape, 'full', false );

if($thumb_image_src) {
	CR_VcE_Sc_Gallery::$items_count++;
	CR_VcE_Sc_Gallery::$items_data[] = $atts;
	?> 
	<div class="cr-gallery-item cr-has-overlay cr-animate-when-visible">
		<div class="cr-gallery-item-inner">
			<div class="cr-gallery-item-text">
				<h3 class="cr-gallery-item-title"><?php echo cr_vce_truncate($overlay_title, 60); ?></h3>
				<a 
					class="cr-gallery-item-view-image cr-button-secondary-bordered cr-gallery-slider" 
					data-fancybox="galleryslider<?php echo CR_VcE_Sc_Gallery::$count_instance; ?>" 
					href="<?php echo esc_url($img_full_src[0]); ?>" 
					><span><?php _e('View Image', 'crvc_extension');?></span></a>
			</div>
			<img class="cr-gallery-item-image" alt="" src="<?php echo $thumb_image_src[0]; ?>" />
			<div class="cr-gallery-item-caption" style="display: none;">
				<div class="cr-lightbox-caption">
					<h3 class="cr-lightbox-caption-title"><?php echo esc_html($lightbox_title); ?></h3>
					<?php if($lightbox_subtitle): ?> 
					<h3 class="cr-lightbox-caption-subtitle"><?php echo esc_html($lightbox_subtitle); ?></h3>
					<?php endif; ?>
				</div>
				<?php if($lightbox_ctas_html): ?> 
				<ul class="cr-lightbox-caption-ctas">
					<?php echo $lightbox_ctas_html; ?>
				</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php } ?>