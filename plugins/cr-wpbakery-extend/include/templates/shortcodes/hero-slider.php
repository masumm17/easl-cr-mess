<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * @var $el_class
 * @var $el_id
 * @var $this CR_VcE_Sc_Hero_Slider
 */
$el_class = $css = $css_animation = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$this->reset_items_data();
CR_VcE_Sc_Hero_Slider::$data = $atts;
extract( $atts );

// It is required to be before to get slide items data
$prepareContent = wpb_js_remove_wpautop( $content, false );

$class_to_filter = '';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$wrapper_attributes = array();
if ( ! empty( $atts['el_id'] ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $atts['el_id'] ) . '"';
}
if(CR_VcE_Sc_Hero_Slider::$items_count > 0):
?>
<section class="cr-rev-slider-wrapper  rev_slider_wrapper <?php echo esc_attr( $css_class ); ?>" <?php echo implode( ' ', $wrapper_attributes ); ?>>
	<div class="cr-rev-slider rev_slider" data-version="5.4.5" style="display:none" data-crdelay="<?php echo esc_attr($duration); ?>">
		<ul>
			<?php echo $prepareContent; ?>
		</ul>
	</div>
</section>
<?php endif; ?>