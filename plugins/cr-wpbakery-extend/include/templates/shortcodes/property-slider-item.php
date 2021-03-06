<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * Shortcode class
 * @var $this CR_VcE_Sc_Property_Slider_Item
 */
$el_class = $css = $css_animation = '';
$data_source = $offer_id = $room_type_id = $image = $overlay_title = $overlay_subtitle = $cta_button = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$custom_sourse_data = array();
switch($data_source) {
	case 'offers':
		$custom_sourse_data = cr_vce_get_post_overlay_data($offer_id);
		break;
	case 'room_types':
		$custom_sourse_data = cr_vce_get_post_overlay_data($room_type_id);
		break;
}

if($custom_sourse_data) {
	$image = $custom_sourse_data['image'];
	$overlay_title = $custom_sourse_data['title'];
	$overlay_subtitle = $custom_sourse_data['subtitle'];
	$content = $custom_sourse_data['content'];
	$cta_button = $custom_sourse_data['cta_button'];
}else{
	$cta_button = $this->parse_url($cta_button);
}

$image = preg_replace( '/[^\d]/', '', $image );
$img_full_src = wp_get_attachment_image_src( $image, 'fw2-3_col2-3_x' );

$title_length = $this->get_module_global_item_setting('title_length');
$subtitle_length = $this->get_module_global_item_setting('subtitle_length');
$content_length = $this->get_module_global_item_setting('content_length');

if($img_full_src && $overlay_title &&  $cta_button && $content) {
	CR_VcE_Sc_Property_Slider::$items_count++;
	CR_VcE_Sc_Property_Slider::$items_data[] = $atts;
	
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
	if(count($cta_button_attributes) > 0){
		$cta_button_attributes = implode( ' ', $cta_button_attributes );
	}else{
		$cta_button_attributes = '';
	}
	$read_more_truncate = '';
	if($content_length && $cta_button_attributes) {
		$read_more_truncate = ' <a class="property-slider-text-readmore" '. $cta_button_attributes .'>'. __('...read more', 'crvc_extension') .'</a>';
	}
	?> 
	<div class="property-slider-item">
		<div class="property-slider-stripe"></div>
		<div class="property-slider-stripe right"></div>
		<div class="property-slider-text <?php if($overlay_subtitle){echo 'cr-has-subtitle';} ?>">
			<div class="property-slider-text-title-subtitle">
				<h3 class="property-slider-text-title <?php if($title_length > 0) {echo 'cr-lenght-limited-text';}?>"><?php echo cr_vce_truncate($overlay_title, $title_length, '', false); ?></h3>
				<?php if($overlay_subtitle): ?> 
				<h3 class="property-slider-text-subtitle <?php if($subtitle_length > 0) {echo 'cr-lenght-limited-text';}?>"><?php echo cr_vce_truncate($overlay_subtitle, $subtitle_length, '', false); ?></h3>
				<?php endif; ?>
			</div>
			<p><?php echo cr_vce_truncate($content, $content_length, $read_more_truncate); ?></p>
			<?php if($cta_button_attributes): ?>
			<a class="property-slider-text-cta cr-button" <?php echo $cta_button_attributes ?>><span><?php echo esc_html($cta_button['title']); ?></span></a>
			<?php endif; ?>
		</div>
		<div class="property-slider-image" style="background-image: url('<?php echo esc_url($img_full_src[0]); ?>');"><img src="<?php echo $img_full_src[0]; ?>" width="1280" height="720"/></div>
	</div>
<?php } ?>