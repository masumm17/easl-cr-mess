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
$grid_size = $display_option = $data_source = $offer_id = $room_type_id = $image = $title = $subtitle = $cta_button = $overlay_trans_disable = $text_align = $enable_video = $video_id = '';

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
	$title = $custom_sourse_data['title'];
	$subtitle = $custom_sourse_data['subtitle'];
	$content = $custom_sourse_data['content'];
	$cta_button = $custom_sourse_data['cta_button'];
}else{
	$cta_button = $this->parse_url($cta_button);
}

$class_to_filter = '';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );
// Set Grid Class
$image_size_w = '';
switch($grid_size) {
	case '3_3':
		$image_size = 'fw1-2_x';
		$image_size_w = 1920;
		$css_class .= ' cr-grid-col-full';
		break;
	case '2_3':
		$image_size = 'fw1-2_col2-3_x';
		$image_size_w = 1280;
		$css_class .= ' cr-grid-col-2-of-3';
		break;
	default:
		$image_size = 'fw1-2_col1-3_x';
		$image_size_w = 640;
		$css_class .= ' cr-grid-col-1-of-3';
		break;
}

switch($display_option) {
	case 'no_text': 
		$cta_class = 'cr-button';
		break;
	case 'no_image': 
		$cta_class = 'cr-button';
		break;
	case 'title_only': 
		$cta_class = 'cr-button';
		break;
	case 'text_hover': 
		$cta_class = 'cr-button';
		break;
	case 'text_always': 
		$cta_class = 'cr-button';
		break;
}

$image = preg_replace( '/[^\d]/', '', $image );
$img_full_src = wp_get_attachment_image_src( $image, $image_size );

$img_full_src_mobile = wp_get_attachment_image_src( $image, 'fw1-2_col1-4_x' );
$image_srcset = $image_sizes = array();
if($img_full_src_mobile){
	$image_srcset[] = "{$img_full_src_mobile[0]} 480w";
	$image_sizes[] = "(max-width: 600px) 160px";
}

if($img_full_src){
	$image_srcset[] = "{$img_full_src[0]} {$image_size_w}w";
	$image_sizes[] = "{$image_size_w}px";
}
if( count($image_srcset)) {
	$image_srcset = join(',', $image_srcset);
	$image_sizes = join(',', $image_sizes);
}
//$image_srcset = $image_sizes = array();
$img_full = wp_get_attachment_image( $image, $image_size, false, array('class' => 'fw-grid-item-image '. $image_size, 'srcset' => $image_srcset, 'sizes' => $image_sizes) );

// Build item elements html
$html_image = $html_title = $html_subtitle = $html_description = $html_cta = $html_video = '';

if($img_full_src) {
	$html_image = $img_full;
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
$read_more_truncate = '';
if($cta_button_attributes) {
	$html_cta = '<a class="fw-grid-item-cta '. $cta_class .'" '. $cta_button_attributes . '><span>' . esc_html($cta_button['title']) . '</span></a>';
	$read_more_truncate = ' <a class="fw-grid-item-readmore" '. $cta_button_attributes .'>'. __('...read more', 'crvc_extension') .'</a>';
}
if('no_image' != $display_option && $html_image){
	$html_image = '<div class="fw-grid-item-sizer"></div>' . $html_image;
}
if($title) {
	$html_title = '<h3 class="fw-grid-item-title">'. cr_vce_truncate($title, 52) .'</h3>';
}
if($subtitle) {
	$html_subtitle = '<h4 class="fw-grid-item-subtitle">'. cr_vce_truncate($subtitle, 52) .'</h4>';
}
if($content){
	$html_description = '<p>' . cr_vce_truncate($content, 186, $read_more_truncate) . '</p>';
}
$css_inner_class = '';
if($enable_video == 'yes' && $video_id) {
	$css_inner_class = "cr-iframe-video-parent";
	$html_video = '<div class="cr-iframe-video" data-videoid="'. esc_attr($video_id) .'"></div>';
}

$video_image = $html_image . $html_video;

if( 'text_hover' == $display_option &&  $html_title && !$html_subtitle && !$html_description && !$html_cta) {
	$display_option = 'title_only';
}
if( 'title_only' == $display_option && $html_cta) {
	$display_option = 'title_only_cta';
}

// Set display option class and build html markup
$html = '';
switch($display_option) {
	case 'no_text': 
		$css_class .= ' fw-grid-item-notext';
		$html = '';
		if($html_cta){
			$html  = '<div class="fw-grid-item-text">';
				$html .= "{$html_cta}";
			$html .= '</div>';
		}
		$html .= $video_image;
		break;
	case 'no_image': 
		$css_class .= ' fw-grid-item-noimage';
		$html  = '<div class="fw-grid-item-text">';
			$html .= "{$html_title}{$html_subtitle}{$html_description}{$html_cta}";
		$html .= '</div>';
		$html .= '<div class="fw-grid-item-sizer"></div>';
		break;
	case 'title_only': 
		$css_class .= ' fw-grid-item-titleonly';
		$html  = '<div class="fw-grid-item-text">';
			$html .= "{$html_title}";
		$html .= '</div>';
		$html .= $video_image;
		break;
	case 'title_only_cta': 
		$css_class .= ' fw-grid-item-text-hover';
		$html  = '<div class="fw-grid-item-text"><div class="fw-grid-item-text-inner">';
			$html .= '<div class="fw-grid-item-text-top">' . $html_title . '</div>';
			$html .= '<div class="fw-grid-item-text-bottom">' . $html_cta . '</div>';
		$html .= '</div></div>';
		$html .= $video_image;
		break;
	case 'text_hover': 
		$css_class .= ' fw-grid-item-text-hover';
		$html  = '<div class="fw-grid-item-text"><div class="fw-grid-item-text-inner">';
			$html .= '<div class="fw-grid-item-text-top">' . $html_title . '</div>';
			$html .= '<div class="fw-grid-item-text-bottom">' . $html_subtitle . $html_description . $html_cta . '</div>';
		$html .= '</div></div>';
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
if(( $html_title || $html_subtitle || $html_description || $html_cta) && $display_option != 'no_image'){
	$css_class .= ' cr-has-overlay-text';
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
if($html):
CR_VcE_Sc_Full_Width_Grid::$items_count++;
CR_VcE_Sc_Full_Width_Grid::$items_data[] = $atts;


?> 
<div class="fw-grid-item cr-grid-col cr-animate-when-visible <?php echo $css_class; ?>">
	<div class="fw-grid-item-inner cr-grid-col-inner <?php echo $css_inner_class; ?>" <?php if('no_image' != $display_option){ ?>style="background-image: url('<?php echo esc_url($img_full_src[0]); ?>');" <?php } ?>>
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
<?php endif; ?>
