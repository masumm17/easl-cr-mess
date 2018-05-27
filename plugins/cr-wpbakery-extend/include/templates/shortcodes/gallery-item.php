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

$image = preg_replace( '/[^\d]/', '', $image );
$thumb_image = wp_get_attachment_image( $image, 'flh_col1-4', false, array('class' => 'cr-gallery-item-image') );
$img_full_src = wp_get_attachment_image_src( $image, 'full', false );

$image_landscape = preg_replace( '/[^\d]/', '', $image_landscape );
$img_full_landscape_src = wp_get_attachment_image_src( $image_landscape, 'full', false );

if($thumb_image) {
	CR_VcE_Sc_Gallery::$count_instance++;
	CR_VcE_Sc_Gallery::$items_count++;
	CR_VcE_Sc_Gallery::$items_data[] = $atts;
	?> 
	<div class="cr-gallery-item cr-has-overlay">
		<div class="cr-gallery-item-inner">
			<div class="cr-gallery-item-text">
				<h3 class="cr-gallery-item-title"><?php echo cr_vce_truncate($overlay_title, 60); ?></h3>
				<a 
					class="cr-gallery-item-view-image cr-button-secondary-bordered cr-gallery-slider" 
					data-fancybox="galleryslider_<?php echo CR_VcE_Sc_Gallery::$count_instance; ?>" 
					href="<?php echo esc_url($img_full_src[0]); ?>" 
					><span><?php _e('View Image', 'crvc_extension');?></span></a>
			</div>
			<?php echo $thumb_image; ?>
		</div>
	</div>
<?php } ?>