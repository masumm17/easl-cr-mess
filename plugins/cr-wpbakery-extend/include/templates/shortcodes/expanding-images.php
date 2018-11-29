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
 * @var $this CR_VcE_Sc_Expanding_Images
 */
$el_class = $css = $css_animation = '';
$title = $subtitle = $element_tag = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$this->reset_items_data();
CR_VcE_Sc_Expanding_Images::$data = $atts;
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

if(CR_VcE_Sc_Expanding_Images::$items_count > 0):
?>
<section class="cr-module-wrap expanding-images-wrap <?php echo esc_attr( $css_class ); ?>" <?php echo implode( ' ', $wrapper_attributes ); ?>>
	<?php
	if($title || $subtitle): 
		$title_element_tag = CR_VcE_Sc_Title_Subtitle::get_element_tag($element_tag);
	?> 
	<div class="cr-title-subtitle-wrapper <?php if($subtitle){ echo 'cr-title-has-subtitle'; } ?>">
		<<?php echo $title_element_tag; ?> class="cr-sc-title"><span class="cr-title-inner cr-animate-when-visible"><?php echo esc_html($title); ?></span<?php echo $title_element_tag; ?>>
		<?php if ($subtitle): ?>
		<h2 class="cr-sc-subtitle"><span class="cr-subtitle-inner cr-animate-when-visible"><?php echo esc_html($subtitle); ?></span></h2>
		<?php endif; ?>
	</div>
	<?php endif; ?>
	<div class="expanding-images-inner">
		<div class="expanding-images-con expanding-images-col-<?php echo CR_VcE_Sc_Expanding_Images::$items_count; ?>">
			<?php echo $prepareContent; ?>
		</div>
	</div>
</section>
<?php endif; ?>