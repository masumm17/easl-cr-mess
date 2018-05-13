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
$image = $overlay_title = $overlay_subtitle = $cta_button = $overlay_trans_disable = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$cta_button = $this->parse_url($cta_button);

$image = preg_replace( '/[^\d]/', '', $image );
$img_full = wp_get_attachment_image( $image, 'full', false, array('class' => 'fxw-grid-item-image') );

if($img_full) {
	CR_VcE_Sc_Fixed_Width_Grid::$items_count++;
	CR_VcE_Sc_Fixed_Width_Grid::$items_data[] = $atts;
	
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
	?> 
	<div class="fxw-grid-item <?php if($overlay_trans_disable != 'yes'){echo 'cr-has-overlay';} ?>">
		<div class="fxw-grid-item-inner">
			<div class="fxw-grid-item-text">
				<div class="fxw-grid-item-text-top">
					<h3 class="fxw-grid-item-title"><?php echo cr_vce_truncate($overlay_title, 36); ?></h3>
					<?php if($overlay_subtitle): ?>
					<h4 class="fxw-grid-item-subtitle"><?php echo cr_vce_truncate($overlay_subtitle, 36); ?></h4>
					<?php endif; ?>
				</div>
				<div class="fxw-grid-item-text-bottom">
					<p><?php echo cr_vce_truncate($content, 186); ?></p>
					<?php if($cta_button_attributes): ?>
					<a class="fxw-grid-item-cta cr-button" <?php echo $cta_button_attributes ?>><span><?php echo esc_html($cta_button['title']); ?></span></a>
					<?php endif; ?>
				</div>
			</div>
			<?php echo $img_full; ?>
		</div>
	</div>
<?php } ?>