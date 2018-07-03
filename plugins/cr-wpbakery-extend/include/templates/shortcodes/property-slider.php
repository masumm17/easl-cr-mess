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
 * @var $this CR_VcE_Sc_Property_Slider
 */
$el_class = $css = $css_animation = '';
$title = $subtitle = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$this->reset_items_data();
CR_VcE_Sc_Property_Slider::$data = $atts;
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

//if(CR_VcE_Sc_Property_Slider::$items_count >= 3 && CR_VcE_Sc_Property_Slider::$items_count <= 20):
?>
<section class="cr-module-wrap property-slider-wrap <?php echo esc_attr( $css_class ); ?>" <?php echo implode( ' ', $wrapper_attributes ); ?>>
	<?php if($title || $subtitle): ?> 
	<div class="cr-title-subtitle-wrapper <?php if($subtitle){ echo 'cr-title-has-subtitle'; } ?>">
		<h2 class="cr-sc-title"><span class="cr-title-inner cr-animate-when-visible"><?php echo esc_html($title); ?></span></h2>
		<?php if ($subtitle): ?>
		<h2 class="cr-sc-subtitle"><span class="cr-subtitle-inner cr-animate-when-visible"><?php echo esc_html($subtitle); ?></span></h2>
		<?php endif; ?>
	</div>
	<?php endif; ?>
	<div class="property-slider-inner">
		<div class="property-slider-con">
			<?php echo $prepareContent; ?>
		</div>
		<a class="property-slider-arrow-left">
			<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
					width="71px" height="70.5px" viewBox="0 0 71 70.5" enable-background="new 0 0 71 70.5" xml:space="preserve">
				<g>
					<path class="cr-ar-circle" d="M41.173,23.061c0.13,0,0.259,0.05,0.356,0.15c0.193,0.197,0.188,0.514-0.008,0.707L30.259,34.946l11.263,11.029
					   c0.197,0.193,0.201,0.51,0.008,0.707c-0.192,0.196-0.51,0.201-0.705,0.008L28.83,34.946l11.994-11.743
					   C40.92,23.109,41.047,23.061,41.173,23.061z"/>
				</g>
				<g>
					<circle class="cr-ar-circle" cx="35.5" cy="35.25" r="34"/>
					<circle class="cr-ar-circle cr-ar-circle-hover" cx="35.5" cy="35.25" r="34"/>
				</g>
			</svg>
		</a>
		<a class="property-slider-arrow-right">
			<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
					width="71px" height="70.5px" viewBox="0 0 71 70.5" enable-background="new 0 0 71 70.5" xml:space="preserve">
				<g>
					<path class="cr-ar-arrow" d="M29.329,46.832c-0.13,0-0.259-0.05-0.356-0.15c-0.193-0.197-0.188-0.514,0.008-0.707l11.263-11.028L28.98,23.918
						c-0.197-0.193-0.201-0.51-0.008-0.707c0.192-0.196,0.51-0.201,0.705-0.008l11.994,11.744L29.678,46.689
						C29.582,46.784,29.455,46.832,29.329,46.832z"/>
				</g>
				<g>
					<circle class="cr-ar-circle" cx="35.5" cy="35.25" r="34"/>
					<circle class="cr-ar-circle cr-ar-circle-hover" cx="35.5" cy="35.25" r="34"/>
				</g>
			</svg>
		</a>
	</div>
</section>
<?php //endif; ?>