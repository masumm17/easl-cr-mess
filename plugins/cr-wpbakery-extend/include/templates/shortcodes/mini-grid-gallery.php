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
 * @var $this CR_VcE_Sc_Mini_Gallery
 */
$el_class = $css = $css_animation = '';
$title = $subtitle = '';
$column1_images = $column2_image = $col2_blur = $col2_title = $col2_subtitle = $col2_cta = $column3_images = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( $atts );

$column1_images = $this->get_iamges_data($column1_images);
$column3_images = $this->get_iamges_data($column3_images);

$column2_image = preg_replace( '/[^\d]/', '', $column2_image );


$col2_blur = !empty($col2_blur) ? $col2_blur . 'px': false; 
$column2_image_attributes = array(
	'class' => 'mini-gallery-col2-image',
);
if($col2_blur) {
	$column2_image_attributes['style'] = "-webkit-filter: blur({$col2_blur});filter: blur({$col2_blur});";
}
$column2_image = wp_get_attachment_image( $column2_image, 'fw1-2_col1-3_x', false, $column2_image_attributes );

$cta_button = $this->parse_url($col2_cta);

$slider_speed = $this->get_module_setting('speed');
$slider_transition = $this->get_module_setting('transition');
$slider_pagination = $this->get_module_setting('pagination');

$slider_speed = !empty($slider_speed) ? absint($slider_speed) : 4000;
$slider_transition = !empty($slider_transition) ? trim($slider_transition) : 'fade';
$slider_pagination = !empty($slider_pagination) ? 'yes' : 'no';

switch($slider_transition) {
	case 'random':
		$slider_transition = 'random';
		break;
	case 'fold_left':
		$slider_transition = '7';
		break;
	case 'box_right':
		$slider_transition = '14';
		break;
	case 'box_fade':
		$slider_transition = '17';
		break;
	case 'fade':
		$slider_transition = '13';
	default:
		$slider_transition = '13';
		break;
}

$class_to_filter = '';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$wrapper_attributes = array();
if ( ! empty( $atts['el_id'] ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $atts['el_id'] ) . '"';
}

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
if(count($cta_button_attributes) > 0 && !empty($cta_button['title'])){
	$cta_button_attributes = implode( ' ', $cta_button_attributes );
}else{
	$cta_button_attributes = '';
}


CR_VcE_Sc_Mini_Grid_Gallery::$count_instance++;
?>
<section class="cr-module-wrap mini-gallery-wrap <?php echo esc_attr( $css_class ); ?>" <?php echo implode( ' ', $wrapper_attributes ); ?>>
	<?php if($title || $subtitle): ?> 
	<div class="cr-title-subtitle-wrapper <?php if($subtitle){ echo 'cr-title-has-subtitle'; } ?>">
		<h2 class="cr-sc-title"><span class="cr-title-inner cr-animate-when-visible"><?php echo esc_html($title); ?></span></h2>
		<?php if ($subtitle): ?>
		<h2 class="cr-sc-subtitle"><span class="cr-subtitle-inner cr-animate-when-visible"><?php echo esc_html($subtitle); ?></span></h2>
		<?php endif; ?>
	</div>
	<?php endif; ?>
	<div class="mini-gallery-inner cr_start_animation">
		<div class="mini-gallery-con">
			<div class="mini-gallery-col mini-gallery-col1">
				<div class="mini-gallery-col-inner mini-gallery-slider-wrapper">
					<div id="mini-gallery-slider-<?php echo CR_VcE_Sc_Mini_Grid_Gallery::$count_instance; ?>-1" class="mini-gallery-slider" 
						 data-speed="<?php echo $slider_speed; ?>" 
						 data-effect="<?php echo esc_attr($slider_transition); ?>" 
						 data-pagination="<?php echo esc_attr($slider_pagination); ?>">
						<?php foreach($column1_images as $img_data): ?>
						<a href="<?php echo esc_url($img_data['full']); ?>" class="cr-fancybox-minimum" data-fancybox="miniGridGallery<?php echo CR_VcE_Sc_Mini_Grid_Gallery::$count_instance; ?>_1">
							<img alt="" src="<?php echo esc_url($img_data['src']); ?>"/>
						</a>
						<?php endforeach; ?>
					</div>
					<?php if($slider_pagination == 'yes'): ?>
					<div class="mini-gallery-slider-pagination cr-hide"><span class="mg-current"></span> <?php _e('of', 'crt') ?> <span class="mg-all"><?php echo count($column1_images); ?></span></div>
					<?php endif;?>
				</div>
			</div>
			<div class="mini-gallery-col mini-gallery-col2">
				<div class="mini-gallery-col-inner">
					<div class="mini-gallery-col2-text">
						<h3 class="mini-gallery-col2-title"><?php echo cr_vce_truncate($col2_title, 36); ?></h3>
						<h4 class="mini-gallery-col2-subtitle"><?php echo cr_vce_truncate($col2_subtitle, 36); ?></h4>
						<?php if($cta_button_attributes): ?>
						<a class="mini-gallery-col2-cta cr-button" <?php echo $cta_button_attributes ?>><span><?php echo esc_html($cta_button['title']); ?></span></a>
						<?php endif; ?>
					</div>
					<?php echo $column2_image; ?>
				</div>
			</div>
			<div class="mini-gallery-col mini-gallery-col3">
				<div class="mini-gallery-col-inner mini-gallery-slider-wrapper">
					<div id="mini-gallery-slider-<?php echo CR_VcE_Sc_Mini_Grid_Gallery::$count_instance; ?>-2" class="mini-gallery-slider" data-speed="<?php echo $slider_speed; ?>" data-effect="<?php echo esc_attr($slider_transition); ?>" data-pagination="<?php echo esc_attr($slider_pagination); ?>">
						<?php foreach($column3_images as $img_data): ?>
						<a href="<?php echo esc_url($img_data['full']); ?>" class="cr-fancybox-minimum" data-fancybox="miniGridGallery<?php echo CR_VcE_Sc_Mini_Grid_Gallery::$count_instance; ?>_2">
							<img alt="" src="<?php echo esc_url($img_data['src']); ?>"/>
						</a>
						<?php endforeach; ?>
					</div>
					<div class="mini-gallery-slider-pagination cr-hide"><span class="mg-current"></span> <?php _e('of', 'crt') ?> <span class="mg-all"><?php echo count($column3_images); ?></span></div>
				</div>
			</div>
		</div>
	</div>
</section>
