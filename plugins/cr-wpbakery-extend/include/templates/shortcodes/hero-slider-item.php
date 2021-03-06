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
$type = $yt_video_id = $yt_video_ar = $yt_video_start = $image_large = $image_small = $tagline_type = $tagline_title = $tagline_subtitle = $cta_button = $tagline_image = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$tagline_title = trim($tagline_title);
$tagline_subtitle = trim($tagline_subtitle);
if($cta_button) {
	$cta_button = $this->parse_url($cta_button);
}
if($tagline_image) {
	$tagline_image = $this->get_image_src($tagline_image, 'thumbnail');
}
$content = wpb_js_remove_wpautop( trim($content), true );
if($cta_button) {
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
}else{
	$cta_button_attributes = '';
}

CR_VcE_Sc_Hero_Slider::$items_count++;
CR_VcE_Sc_Hero_Slider::$items_data[] = $atts;

$duration = !empty(CR_VcE_Sc_Hero_Slider::$data['duration']) ? CR_VcE_Sc_Hero_Slider::$data['duration'] : 4000;
//$duration = $duration + 1200;
?> 
<li data-transition="fade" 
	data-fstransition="notransition" 
	data-hideafterloop="0" 
	data-hideslideonmobile="off"  
	data-easein="default" 
	data-easeout="default" 
	data-delay="<?php echo esc_attr($duration); ?>"  
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
	data-taglinetype="<?php echo esc_attr($tagline_type); ?>"
	>
	<?php 
	if('video' == $type):
		$img_id = preg_replace( '/[^\d]/', '', $image_large );
		$img_id_mobile = false;
		if(wp_is_mobile()){
			$img_id_mobile = preg_replace( '/[^\d]/', '', $image_small );
		}
		if($img_id_mobile){
			$img_id = $img_id_mobile;
		}
		$img_id = preg_replace( '/[^\d]/', '', $image_large );
		$img_full_src = wp_get_attachment_image_src( $img_id, 'full' );
		if($img_full_src){
			$img_full_src = $img_full_src[0];
		}
		if(!$img_full_src) {
			$img_full_src = 'https://img.youtube.com/vi/' . $yt_video_id . '/maxresdefault.jpg';
		}
		if(!$yt_video_ar) {
			$yt_video_ar = '16:9';
		}
		if(!$yt_video_start) {
			$yt_video_start = '00:00';
		}
	?> 
	<img src="<?php echo esc_url( $img_full_src); ?>" 
         alt="Ocean" 
         class="rev-slidebg" 
         data-bgposition="center center" 
         data-bgfit="cover" 
         data-bgrepeat="no-repeat">
		<div class="rs-background-video-layer cr-background-video-layer" 
				data-forcerewind="on" 
				data-nextslideatend="true" 
				data-videoloop="loop" 
				data-volume="mute" 
				data-ytid="<?php echo esc_attr($yt_video_id); ?>" 
				data-videoattributes="version=3&enablejsapi=1&html5=1&hd=1&vq=hd1080&wmode=opaque&showinfo=0&rel=0&ref=0&origin=<?php echo untrailingslashit( get_home_url() );?>" 
				data-videorate="1" 
				data-videowidth="100%" 
				data-videoheight="100%" 
				data-videostartat="<?php echo esc_attr($yt_video_start); ?>" 
				data-videocontrols="none"  
				data-forcecover="1" 
				data-aspectratio="<?php echo $yt_video_ar; ?>" 
				data-autoplay="true" 
				data-autoplayonlyfirsttime="false" 
		></div>
	<?php 
	else: 
		$img_id = preg_replace( '/[^\d]/', '', $image_large );$img_id_mobile = false;
		if(wp_is_mobile()){
			$img_id_mobile = preg_replace( '/[^\d]/', '', $image_small );
		}
		if($img_id_mobile){
			$img_id = $img_id_mobile;
		}
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
         data-scaleend="120" 
         data-offsetstart="0 0" 
         data-offsetend="0 0"
         data-rotatestart="0" 
         data-rotateend="0" 
		 
		 data-bgparallax="10"  
		 data-no-retina
		 />
	<?php endif; ?> 
	<?php if($tagline_type === 'type1' && $tagline_title && $tagline_image): ?>
	<div class="tp-caption hero-slider-caption hero-slider-caption-1"
		 data-frames='[{"delay":0,"speed":750,"frame":"0","from":"opacity:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":750,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]' 
		 data-x="center" 
		 data-y="center" data-width="100%" >
		<div class="hero-slider-caption-content" >
			<div class="hero-slider-caption-image">
				<img src="<?php echo esc_url($tagline_image); ?>" alt=""/>
			</div>
			<div class="hero-slider-caption-text">
				<div class="hero-slider-caption-title"><?php echo esc_html($tagline_title); ?></div>
				<?php if($tagline_subtitle): ?>
				<div class="hero-slider-caption-subtitle"><?php echo esc_html($tagline_subtitle); ?></div>
				<?php endif; ?>
				<?php if($cta_button_attributes): ?>
				<div class="hero-slider-caption-cta"><a class="cr-button-tertiary-bordered" <?php echo $cta_button_attributes ?>><?php echo esc_html($cta_button['title']); ?></a></div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php elseif($tagline_type === 'type2' && $tagline_title && $tagline_subtitle): ?> 
	<div class="tp-caption hero-slider-caption hero-slider-caption-2"
		 data-frames='[{"delay":0,"speed":750,"frame":"0","from":"opacity:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":750,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]' 
		 data-x="center" 
		 data-y="center" data-width="100%" >
		<div class="hero-slider-caption-content" >
			<div class="hero-slider-caption-text">
				<div class="hero-slider-caption-title-wrap">
					<div class="hero-slider-caption-border-topleft"></div>
					<div class="hero-slider-caption-title"><?php echo cr_truncate($tagline_title, 40, '', true); ?></div>
					<div class="hero-slider-caption-border-topright"></div>
				</div>
				<div class="hero-slider-caption-subtitle"><?php echo cr_truncate($tagline_subtitle, 80, '', true); ?></div>
				<?php if($content): ?> 
				<div class="hero-slider-caption-desc"><?php echo cr_truncate($content, 260, '', true); ?></div>
				<?php endif; ?>
				<?php if($cta_button_attributes): ?>
				<div class="hero-slider-caption-cta"><a class="cr-button" <?php echo $cta_button_attributes ?>><?php echo esc_html($cta_button['title']); ?></a></div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php elseif($tagline_type === 'type3' && $tagline_title && $tagline_subtitle): ?> 
	<div class="tp-caption hero-slider-caption hero-slider-caption-3"
		 data-frames='[{"delay":0,"speed":750,"frame":"0","from":"opacity:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":750,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]' 
		 data-x="center" 
		 data-y="center" data-width="100%" >
		<div class="hero-slider-caption-content" >
			<div class="hero-slider-caption-text">
				<div class="hero-slider-caption-title"><?php echo cr_truncate($tagline_title, 40, '', true); ?></div>
				<div class="hero-slider-caption-subtitle"><?php echo cr_truncate($tagline_subtitle, 80, '', true); ?></div>
			</div>
		</div>
	</div>
	<?php elseif($tagline_type === 'type4' && $tagline_title && $tagline_subtitle): ?> 
	<div class="tp-caption hero-slider-caption hero-slider-caption-4"
		 data-frames='[{"delay":0,"speed":750,"frame":"0","from":"opacity:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":750,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]' 
		 data-x="left" 
		 data-y="center" data-width="100%">
		<div class="hero-slider-caption-content" >
			<div class="hero-slider-caption-text">
				<div class="hero-slider-caption-title"><?php echo cr_truncate($tagline_title, 40, '', true); ?></div>
				<div class="hero-slider-caption-subtitle"><?php echo cr_truncate($tagline_subtitle, 80, '', true); ?></div>
				<?php if($content): ?> 
				<div class="hero-slider-caption-desc"><?php echo cr_truncate($content, 160, '', true); ?></div>
				<?php endif; ?>
				<?php if($cta_button_attributes): ?>
				<div class="hero-slider-caption-cta"><a class="cr-button" <?php echo $cta_button_attributes ?>><?php echo esc_html($cta_button['title']); ?></a></div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
</li>