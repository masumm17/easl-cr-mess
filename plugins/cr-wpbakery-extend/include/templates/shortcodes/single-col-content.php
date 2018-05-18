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
$buttons = array();
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$parsed_buttons = $this->get_buttons_data( $atts );

$class_to_filter = '';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

if($subtitle) {
	$css_class = ' cr-title-has-subtitle';
}

$wrapper_attributes = array();
if ( ! empty( $atts['el_id'] ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $atts['el_id'] ) . '"';
}


?> 

<section class="cr-single-col-content-wrapper <?php echo esc_attr( $css_class ); ?>" <?php echo implode( ' ', $wrapper_attributes ); ?>>
	<?php if($content): ?>
	<div class="cr-scc-text cr-animate-when-visible">
		<?php echo wpb_js_remove_wpautop( $content, true ) ?>
	</div>
	<?php endif; ?><?php if(count($parsed_buttons) > 0): ?>
	<div class="cr-scc-buttons-wrap">
		<ul class="cr-scc-buttons cr-animate-when-visible">
		<?php 
		foreach($parsed_buttons as $button): 
			$link_attributes = array();
			$link_attributes[] = 'href="' . trim( $button['url'] ) . '"';
			$link_attributes[] = 'title="' . esc_attr( trim( $button['url'] ) ) . '"';
			if ( ! empty( $button['target'] ) ) {
				$link_attributes[] = 'target="' . esc_attr( trim( $button['target'] ) ) . '"';
			}
			if ( ! empty( $button['rel'] ) ) {
				$link_attributes[] = 'rel="' . esc_attr( trim( $button['rel'] ) ) . '"';
			}
			$link_attributes = implode( ' ', $link_attributes );
		?>
			<li>
				<a class="cr-button" <?php echo $link_attributes; ?>><span class="cr-button-text"><?php echo esc_html($button['title']) ?></span></a>
			</li>
		<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>
</section>