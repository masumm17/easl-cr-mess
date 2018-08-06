<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * Shortcode class
 * @var $this CR_VcE_Sc_Single_Col_Content
 */
$el_class = $css = $css_animation = '';
$id = $ajax = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$class_to_filter = '';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$wrapper_attributes = array();
if ( ! empty( $atts['el_id'] ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $atts['el_id'] ) . '"';
}

?> 

<section class="cr-module-wrap cr-gravity-form-wrapper cr-single-col-content-wrapper <?php echo esc_attr( $css_class ); ?>" <?php echo implode( ' ', $wrapper_attributes ); ?>>
	<?php if($id): ?>
	<div class="cr-scc-text cr-gravity-form cr-animate-when-visible">
		<?php 
		gravity_form_enqueue_scripts( $id, $ajax );
		gravity_form($id, false, false, false, '', $ajax);
		?>
	</div>
	<?php endif; ?>
</section>