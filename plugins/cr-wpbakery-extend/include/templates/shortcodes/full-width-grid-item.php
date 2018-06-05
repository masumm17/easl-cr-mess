<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * Shortcode class
 * @var $this CR_VcE_Sc_Fixed_Width_Grid_Item
 */
$el_class = $css = $css_animation = '';
$grid_size = $display_option = $image = $title = $subtitle = $cta_button = $overlay_trans_disable = $text_align = $enable_video = $video_id = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$cta_button = $this->parse_url($cta_button);



$class_to_filter = '';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );
// Set Grid Class
switch($grid_size) {
	case '3_3':
		$image_size = 'fw1-2_x';
		$css_class .= ' cr-grid-col-full';
		break;
	case '2_3':
		$image_size = 'fw1-2_col2-3_x';
		$css_class .= ' cr-grid-col-2-of-3';
		break;
	default:
		$image_size = 'fw1-2_col1-3_x';
		$css_class .= ' cr-grid-col-1-of-3';
		break;
}

switch($display_option) {
	case 'no_text': 
		$cta_class = 'cr-button-secondary';
		break;
	case 'no_image': 
		$cta_class = 'cr-button-bordered';
		break;
	case 'title_only': 
		$cta_class = 'cr-button-secondary';
		break;
	case 'text_hover': 
		$cta_class = 'cr-button-secondary';
		break;
	case 'text_always': 
		$cta_class = 'cr-button-secondary';
		break;
}

$image = preg_replace( '/[^\d]/', '', $image );
$img_full = wp_get_attachment_image( $image, $image_size, false, array('class' => 'fxw-grid-item-image '. $image_size) );


// Build item elements html
$html_image = $html_title = $html_subtitle = $html_description = $html_cta = $html_video = '';

if($img_full) {
	$html_image = $img_full;
}
if($title) {
	$html_title = '<h3 class="fw-grid-item-title">'. cr_vce_truncate($title, 52) .'</h3>';
}
if($subtitle) {
	$html_subtitle = '<h4 class="fw-grid-item-subtitle">'. cr_vce_truncate($subtitle, 52) .'</h4>';
}
if($content){
	$html_description = '<p>' . cr_vce_truncate($content, 186) . '</p>';
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
if(count($cta_button_attributes) > 0){
	$cta_button_attributes = implode( ' ', $cta_button_attributes );
}else{
	$cta_button_attributes = '';
}
if($cta_button_attributes) {
	$html_cta = '<a class="fw-grid-item-cta '. $cta_class .'" '. $cta_button_attributes . '><span>' . esc_html($cta_button['title']) . '</span></a>';
}
$css_inner_class = '';
if($enable_video == 'yes' && $video_id) {
	$css_inner_class = "cr-iframe-video-parent";
	$html_video = '<div class="cr-iframe-video" data-videoid="'. esc_attr($video_id) .'"></div>';
}

$video_image = $html_image . $html_video;

// Set display option class and build html markup
$html = '';
switch($display_option) {
	case 'no_text': 
		$css_class .= ' fw-grid-item-notext';
		$html = $video_image;
		break;
	case 'no_image': 
		$css_class .= ' fw-grid-item-noimage';
		$html  = '<div class="fw-grid-item-text">';
			$html .= "{$html_title}{$html_subtitle}{$html_description}{$html_cta}";
		$html .= '</div>';
		break;
	case 'title_only': 
		$css_class .= ' fw-grid-item-titleonly';
		$html  = '<div class="fw-grid-item-text">';
			$html .= "{$html_title}";
		$html .= '</div>';
		$html .= $video_image;
		break;
	case 'text_hover': 
		$css_class .= ' fw-grid-item-text-hover';
		$html  = '<div class="fw-grid-item-text">';
			$html .= "{$html_title}{$html_subtitle}{$html_description}{$html_cta}";
		$html .= '</div>';
		$html .= $video_image;
		break;
	case 'text_always': 
		$css_class .= ' fw-grid-item-text-always';
		$html  = '<div class="fw-grid-item-text">';
			$html .= "{$html_title}{$html_subtitle}{$html_description}{$html_cta}";
		$html .= '</div>';
		$html .= $video_image;
		break;
}
// Set overlay class
if($overlay_trans_disable != 'yes' && $display_option != 'no_image'){
	$css_class .= ' cr-has-overlay';
}

// set text alignment
switch($text_align) {
	case 'left':
		$css_class .= ' cr-left-text';
		break;
	case 'right':
		$css_class .= ' cr-right-text';
		break;
	default:
		$css_class .= ' cr-center-text';
		break;
}

CR_VcE_Sc_Full_Width_Grid::$items_count++;
CR_VcE_Sc_Full_Width_Grid::$items_data[] = $atts;


?> 
<div class="fw-grid-item cr-grid-col cr-animate-when-visible <?php echo $css_class; ?>">
	<div class="fw-grid-item-inner cr-grid-col-inner <?php echo $css_inner_class; ?>">
		<?php if($display_option == 'no_image'):?> 
		<div class="fw-grid-item-borders">
			<div class="fw-grid-item-borders-top"></div>
			<div class="fw-grid-item-borders-bottom"></div>
			<div class="fw-grid-item-borders-left"></div>
			<div class="fw-grid-item-borders-right"></div>
		</div>
		<?php endif; ?>
		<?php echo $html; ?>
	</div>
</div>
