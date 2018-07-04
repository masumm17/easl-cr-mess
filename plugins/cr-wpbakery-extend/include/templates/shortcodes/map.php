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
 * @var $this CR_VcE_Map
 */
$el_class = $css = $css_animation = '';
$title = $subtitle = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( $atts );

$class_to_filter = '';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$wrapper_attributes = array();
if ( ! empty( $atts['el_id'] ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $atts['el_id'] ) . '"';
}
$map_data = $this->get_map_data();
$map_id = 'cr_map_' . $this->get_instance_count();
?>
<script type="text/javascript">
	var crMapData = crMapData || {KEY: "<?php echo $this->get_api_key(); ?>"};
	crMapData['<?php echo $map_id; ?>'] = <?php echo wp_json_encode($map_data); ?>
</script>
<section class="cr-module-wrap cr-map-wrap <?php echo esc_attr( $css_class ); ?>" <?php echo implode( ' ', $wrapper_attributes ); ?>>
	<?php if($title || $subtitle): ?> 
	<div class="cr-title-subtitle-wrapper <?php if($subtitle){ echo 'cr-title-has-subtitle'; } ?>">
		<h2 class="cr-sc-title"><span class="cr-title-inner cr-animate-when-visible"><?php echo esc_html($title); ?></span></h2>
		<?php if ($subtitle): ?>
		<h2 class="cr-sc-subtitle"><span class="cr-subtitle-inner cr-animate-when-visible"><?php echo esc_html($subtitle); ?></span></h2>
		<?php endif; ?>
	</div>
	<?php endif; ?>
	<div class="cr-map-inner cr-animate-when-visible">
		<div class="cr-map-con">
			<?php if(!empty($map_data['filters']) && count($map_data['filters']) > 0):?>
			<div class="cr-map-filters cr-map-hide">
				<ul class="cr-map-filters-list">
					<?php foreach($map_data['filters'] as $filter_icon): ?> 
					<li class="cr-map-filter-icon" data-mapid="<?php echo $map_id; ?>" data-filtername="<?php echo esc_attr($filter_icon['name']); ?>">
						<img alt="<?php echo esc_attr($filter_icon['label']); ?>" src="<?php echo esc_url($filter_icon['icon']); ?>"/>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>
			<div class="cr-map" id="<?php echo $map_id; ?>"></div>
		</div>
	</div>
</section>

