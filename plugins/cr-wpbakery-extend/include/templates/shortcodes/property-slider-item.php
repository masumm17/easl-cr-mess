<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * Shortcode class
 * @var $this CR_VcE_Sc_Property_Slider_Item
 */
$el_class = $css = $css_animation = '';
$image = $overlay_title = $cta_button = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$cta_button = $this->parse_url($cta_button);

$image = preg_replace( '/[^\d]/', '', $image );
$img_full_src = wp_get_attachment_image( $image, 'fw2-3_col2-3_x', false, array('class' => 'property-slider-image') );

if($img_full_src) {
	CR_VcE_Sc_Property_Slider::$items_count++;
	CR_VcE_Sc_Property_Slider::$items_data[] = $atts;
	
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
	<div class="property-slider-item">
		<div class="property-slider-stripe"></div>
		<div class="property-slider-stripe right"></div>
		<div class="property-slider-text">
			<h3 class="property-slider-text-title"><?php echo cr_vce_truncate($overlay_title, 23, '', false); ?></h3>
			<p><?php echo cr_vce_truncate($content, 180); ?></p>
			<?php if($cta_button_attributes): ?>
			<a class="property-slider-text-cta cr-button" <?php echo $cta_button_attributes ?>><span><?php echo esc_html($cta_button['title']); ?></span></a>
			<?php endif; ?>
		</div>
		<?php echo $img_full_src; ?>
	</div>
<?php } ?>