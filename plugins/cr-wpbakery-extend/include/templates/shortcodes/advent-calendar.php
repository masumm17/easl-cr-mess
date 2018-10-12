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
 * @var $this CR_VcE_Sc_Virtual_Tour
 */
$el_class = $css = $css_animation = '';
$size = $width = $height = $scroll_down_arrow = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if(!in_array( $size, array('full_width', 'full_con_width', 'full_screen', 'custom') )){
	$size = 'full_screen';
}

if($scroll_down_arrow == 'yes'){
	$scroll_down_arrow = true;
}else{
	$scroll_down_arrow = false;
}

$content = rawurldecode( base64_decode( strip_tags( $content ) ) );
$content = wpb_js_remove_wpautop( apply_filters( 'vc_raw_html_module_content', $content ) );

$class_to_filter = '';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

if('full_screen' == $size) {
	$css_class .= ' cr-force-full-screen cr-force-full-width ';
}
if('full_width' == $size) {
	$css_class .= ' cr-force-full-width ';
}

$wrapper_attributes = array();
if ( ! empty( $atts['el_id'] ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $atts['el_id'] ) . '"';
}
if($content):
	$calendars_styles = '';
	if(('custom' == $size) && $width) {
		$calendars_styles .= 'width: ' . $width . ';';
	}
	if( ('full_screen' != $size) && $height) {
		$calendars_styles .= 'height: ' . $height . ';';
	}
	if($calendars_styles) {
		$calendars_styles = ' style="' . $calendars_styles . '" ';
	}
?>
<section class="cr-module-wrap advent-calendar-wrap <?php echo esc_attr( $css_class ); ?>" <?php echo implode( ' ', $wrapper_attributes ); ?>>
	<div class="advent-calendar-inner">
		<div class="advent-calendar-con"<?php echo $calendars_styles; ?>>
			<?php echo $content; ?>
		</div>
	</div>
	<?php if($scroll_down_arrow): ?>
	<span class="cr-scroll-down"><span></span><span></span><span></span></span>
	<?php endif; ?>
</section>
<?php endif; ?>