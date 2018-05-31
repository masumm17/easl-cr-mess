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
 * @var $this CR_VcE_Sc_Accommodations
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

$accomodations = CR_VcE_Sc_Accommodations::get_accommodations();

?>
<section class="cr-module-wrap accommodations-wrap <?php echo esc_attr( $css_class ); ?>" <?php echo implode( ' ', $wrapper_attributes ); ?>>
	<?php if($title || $subtitle): ?> 
	<div class="cr-title-subtitle-wrapper <?php if($subtitle){ echo 'cr-title-has-subtitle'; } ?>">
		<h2 class="cr-sc-title"><span class="cr-title-inner cr-animate-when-visible"><?php echo esc_html($title); ?></span></h2>
		<?php if ($subtitle): ?>
		<h2 class="cr-sc-subtitle"><span class="cr-subtitle-inner cr-animate-when-visible"><?php echo esc_html($subtitle); ?></span></h2>
		<?php endif; ?>
	</div>
	<?php endif; ?> 
	<div class="accommodations-inner">
		<div class="accommodations-con">
			<div class="accommodations-filters cr-animate-when-visible">
				<div class="accommodations-filters-inner">
					<div class="accommodations-filter accommodations-filter-location" data-type="location">
						<h5 class="accommodations-filter-label"><?php _e('Location', 'crvc_extension'); ?></h5>
						<p class="accommodations-filter-selected">
							<span class="accommodations-filter-selected-name"><?php _e('All', 'crvc_extension'); ?></span>
							<span class="accommodations-filter-arrow">
								<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129">
									<g>
										<path class="cr-path-darrow" d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z"/>
									</g>
								</svg>
							</span>
						</p>
						<ul class="accommodations-filter-options">
							<li data-id="-1" class="selected-option"><?php _e('All', 'crvc_extension'); ?></li>
							<?php echo CR_VcE_Sc_Accommodations::get_accommodations_filter('accommodation_location'); ?>
						</ul>
					</div>
					<div class="accommodations-filter accommodations-filter-roomtype" data-type="roomtype">
						<h5 class="accommodations-filter-label"><?php _e('Room Type', 'crvc_extension'); ?></h5>
						<p class="accommodations-filter-selected">
							<span class="accommodations-filter-selected-name"><?php _e('All', 'crvc_extension'); ?></span>
							<span class="accommodations-filter-arrow">
								<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129">
									<g>
										<path class="cr-path-darrow" d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z"/>
									</g>
								</svg>
							</span>
						</p>
						<ul class="accommodations-filter-options">
							<li data-id="-1" class="selected-option"><?php _e('All', 'crvc_extension'); ?></li>
							<?php echo CR_VcE_Sc_Accommodations::get_accommodations_filter('accommodation_room_type'); ?>
						</ul>
					</div>
					<div class="accommodations-filter accommodations-filter-amenities" data-type="amenity">
						<h5 class="accommodations-filter-label"><?php _e('Amenities', 'crvc_extension'); ?></h5>
						<p class="accommodations-filter-selected">
							<span class="accommodations-filter-selected-name"><?php _e('All', 'crvc_extension'); ?></span>
							<span class="accommodations-filter-arrow">
								<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129">
									<g>
										<path class="cr-path-darrow" d="m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z"/>
									</g>
								</svg>
							</span>
						</p>
						<ul class="accommodations-filter-options">
							<li data-id="-1" class="selected-option"><?php _e('All', 'crvc_extension'); ?></li>
							<?php echo CR_VcE_Sc_Accommodations::get_accommodations_filter('accommodation_amenity'); ?>
						</ul>
					</div>
					<div class="accommodations-filter accommodations-filter-button-wrap">
						<a class="accommodations-filter-button cr-button" href="#"><?php _e('View Resutls', 'crvc_extension'); ?></a>
						<div class="accommodations-filter-loader">
						<svg class="accommodations-bar-loader" version="1.1" id="L4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 52 12" xml:space="preserve">
							<circle stroke="none" cx="6" cy="6" r="6">
							  <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.1"></animate>    
							</circle>
							<circle stroke="none" cx="26" cy="6" r="6">
							  <animate attributeName="opacity" dur="2s" values="0;1;0" repeatCount="indefinite" begin="0.2"></animate>       
							</circle>
							<circle stroke="none" cx="46" cy="6" r="6">
							  <animate attributeName="opacity" dur="2s" values="0;1;0" repeatCount="indefinite" begin="0.3"></animate>     
							</circle>
						</svg>
					</div>
					</div>
				</div>
			</div>
			<ul class="accommodations-list">
				<?php echo $accomodations; ?>
			</ul>
		</div>
	</div>
</section>
