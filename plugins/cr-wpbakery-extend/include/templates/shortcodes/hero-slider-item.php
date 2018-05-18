<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * Shortcode class
 * @var $this CR_VcE_Sc_Hero_Slider_Item
 */
$el_class = $css = $css_animation = '';
$type = $yt_video_id = $image_large = $image_small = $tagline_type = $tagline_title = $tagline_subtitle = $cta_button = $tagline_image = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );



CR_VcE_Sc_Hero_Slider::$items_count++;
CR_VcE_Sc_Hero_Slider::$items_data[] = $atts;

$duration = !empty(CR_VcE_Sc_Hero_Slider::$data['duration']) ? CR_VcE_Sc_Hero_Slider::$data['duration'] : 4000;
//$duration = $duration + 1200;
?> 
<li data-transition="fade" 
	data-hideafterloop="0" 
	data-hideslideonmobile="off"  
	data-easein="default" 
	data-easeout="default" 
	data-masterspeed="<?php echo esc_attr($duration); ?>"  
	data-rotate="0"  
	data-saveperformance="off"  
	data-title="Slide" 
	data-param1="" 
	data-param2="" 
	data-param3="" 
	data-param4="" 
	data-param5="" 
	data-param6="" 
	data-param7="" 
	data-param8="" 
	data-param9="" 
	data-param10="" 
	data-description=""
	>
	<?php 
	if('video' == $type): 
		$img_id = preg_replace( '/[^\d]/', '', $image_large );
		$img_full_src = wp_get_attachment_image_src( $img_id, 'full' );
		if($img_full_src){
			$img_full_src = $img_full_src[0];
		}
		if(!$img_full_src) {
			$img_full_src = cr_get_asset_url('images/hero-video-bg.png');
		}
	?> 
	<img src="<?php echo esc_url( $img_full_src); ?>" 
         alt="Ocean" 
         class="rev-slidebg" 
         data-bgposition="center center" 
         data-bgfit="cover" 
         data-bgrepeat="no-repeat">
		<div class="rs-background-video-layer" 
				data-forcerewind="on" 
				data-nextslideatend="true" 
				data-volume="mute" 
				data-ytid="<?php echo esc_attr($yt_video_id); ?>" 
				data-videoattributes="version=3&amp;enablejsapi=1&amp;html5=1&amp;hd=1&amp;wmode=opaque&amp;showinfo=0&amp;rel=0;" 
				data-videorate="1" 
				data-videowidth="100%" 
				data-videoheight="100%" 
				data-videocontrols="none" 
				data-videoloop="loop" 
				data-forceCover="1" 
				data-aspectratio="4:3" 
				data-autoplay="true" 
				data-autoplayonlyfirsttime="false" 
		></div>
	<?php 
	else: 
		$img_id = preg_replace( '/[^\d]/', '', $image_large );
		$img_full_src = wp_get_attachment_image_src( $img_id, 'full' );
		if($img_full_src){
			$img_full_src = $img_full_src[0];
		}
	?> 
	<img src="<?php echo esc_url( $img_full_src); ?>" 
         alt="" 
         class="rev-slidebg" 
         data-bgposition="center center" 
         data-bgfit="cover" 
         data-bgrepeat="no-repeat"
		 data-kenburns="on" 
         data-duration="<?php echo esc_attr($duration * 4); ?>" 
         data-ease="Linear.easeNone" 
         data-scalestart="100" 
         data-scaleend="150" 
         data-offsetstart="0 0" 
         data-offsetend="0 0"
         data-rotatestart="0" 
         data-rotateend="0" 
		 
		 data-bgparallax="10"  
		 data-no-retina
		 />
	<?php endif; ?>
</li>