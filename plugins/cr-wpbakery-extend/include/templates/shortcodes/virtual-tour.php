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
$title = $subtitle = $width = $height = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$content = rawurldecode( base64_decode( strip_tags( $content ) ) );
$content = wpb_js_remove_wpautop( apply_filters( 'vc_raw_html_module_content', $content ) );

$class_to_filter = '';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$wrapper_attributes = array();
if ( ! empty( $atts['el_id'] ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $atts['el_id'] ) . '"';
}
if($content):
	$tours_styles = '';
	if($width) {
		$tours_styles .= 'width: ' . $width . ';';
	}
	if($height) {
		$tours_styles .= 'height: ' . $height . ';';
	}
	if($tours_styles) {
		$tours_styles = ' style="' . $tours_styles . '" ';
	}
?>
<section class="cr-module-wrap virtual-tour-wrap <?php echo esc_attr( $css_class ); ?>" <?php echo implode( ' ', $wrapper_attributes ); ?>>
	<?php if($title || $subtitle): ?> 
	<div class="cr-title-subtitle-wrapper <?php if($subtitle){ echo 'cr-title-has-subtitle'; } ?>">
		<h2 class="cr-sc-title"><span class="cr-title-inner cr-animate-when-visible"><?php echo esc_html($title); ?></span></h2>
		<?php if ($subtitle): ?>
		<h2 class="cr-sc-subtitle"><span class="cr-subtitle-inner cr-animate-when-visible"><?php echo esc_html($subtitle); ?></span></h2>
		<?php endif; ?>
	</div>
	<?php endif; ?>
	<div class="virtual-tour-inner">
		<div class="virtual-tour-con"<?php echo $tours_styles; ?>>
			<?php echo $content; ?>
		</div>
	</div>
</section>
<?php endif; ?>