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
 * @var $this CR_VcE_Sc_Allora_Integration
 */
$el_class = $css = $css_animation = '';
$title = $subtitle = $client_type = $client_id = $limit = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( $atts );

$class_to_filter = '';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$wrapper_attributes = array();
if ( ! empty( $atts['el_id'] ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $atts['el_id'] ) . '"';
}


$allora_settings = $this->get_allora_settings();

if(!$client_type) {
	$client_type = $allora_settings['client_type'];
}
if(!$client_id) {
	$client_id = $allora_settings['client_id'];
}
if(!$limit) {
	$limit = $allora_settings['limit'];
}

$allora_url = $allora_settings['url'];
$allora_params = array(
	'template' => $allora_settings['template'],
	'limit' => absint($limit),
);

if('portal' == $client_type) {
	$allora_params['portalID'] = $client_id;
}elseif('site' == $client_type) {
	$allora_params['siteID'] = $client_id;
}

if($allora_url && $client_id) {
	$allora_url = add_query_arg($allora_params, $allora_url);
}else{
	$allora_url = false;
}

if( $allora_url ): 
?>
<section class="cr-module-wrap fxw-grid-wrap cr-allora-wrap <?php echo esc_attr( $css_class ); ?>" <?php echo implode( ' ', $wrapper_attributes ); ?> data-alloraurl="<?php echo $allora_url; ?>">
	<div class="cr-title-subtitle-wrapper cr-title-has-subtitle">
		<h2 class="cr-sc-title"><span class="cr-title-inner cr-animate-when-visible"><?php echo esc_html($title); ?></span></h2>
		<h2 class="cr-sc-subtitle"><span class="cr-subtitle-inner cr-animate-when-visible"><?php echo esc_html($subtitle); ?></span></h2>
	</div>
	<div class="fxw-grid-inner cr-animate-when-visible">
		<div class="fxw-grid-con cr-allora-con">
			<div class="fxw-grid-item cr-has-overlay cr-allora-item-template" onClick="return true">
				<div class="fxw-grid-item-inner">
					<div class="fxw-grid-item-text">
						<div class="fxw-grid-item-text-inner">
							<div class="fxw-grid-item-text-top">
								<h3 class="fxw-grid-item-title"></h3>
								<h4 class="fxw-grid-item-subtitle"></h4>
							</div>
							<div class="fxw-grid-item-text-bottom">
								<p class="allora-item-text"></p>
								<a class="fxw-grid-item-cta cr-button-tertiary-bordered" target="_blank"></a>
							</div>
						</div>
					</div>
					<div class="fxw-grid-item-imagebg"></div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif;?>

