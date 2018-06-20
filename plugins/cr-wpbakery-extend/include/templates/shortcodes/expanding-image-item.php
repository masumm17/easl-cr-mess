<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * Shortcode class
 * @var $this CR_VcE_Sc_Expanding_Image_Item
 */
$el_class = $css = $css_animation = '';
$image = $cta_title = $cta_button = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$cta_button = $this->parse_url($cta_button);

$image = preg_replace( '/[^\d]/', '', $image );
$img_full_src = wp_get_attachment_image_src( $image, 'fw_col2-3_x', false );

if($img_full_src) {
	CR_VcE_Sc_Expanding_Images::$items_count++;
	CR_VcE_Sc_Expanding_Images::$items_data[] = $atts;
	
	$cta_button_attributes = array();
	if ( ! empty( $cta_button['url'] ) ) {
		$cta_button_attributes[] = 'href="' . esc_attr( trim( $cta_button['url'] ) ) . '"';
	}
	if ( ! empty( $cta_button['target'] ) ) {
		$cta_button_attributes[] = 'target="' . esc_attr( trim( $cta_button['target'] ) ) . '"';
	}
	if ( ! empty( $cta_button['rel'] ) ) {
		$cta_button_attributes[] = 'rel="' . esc_attr( trim( $cta_button['rel'] ) ) . '"';
	}
	if(count($cta_button_attributes) > 0){
		$cta_button_attributes = implode( ' ', $cta_button_attributes );
	}else{
		$cta_button_attributes = '';
	}
	?> 
	<div class="expanding-image-item" style="background-image: url('<?php echo esc_url($img_full_src[0]); ?>')">
		<?php if($cta_title): ?>
		<div class="expanding-image-item-cta-wrap">
			<a class="expanding-image-item-cta cr-button" <?php echo $cta_button_attributes ?>><span><?php echo esc_html($cta_title); ?></span></a>
		</div>
		<?php endif; ?>
	</div>
<?php } ?>