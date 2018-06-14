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
 * @var $this CR_VcE_Sc_Instagram_Feed
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
$secret_key = get_theme_mod( 'instagram_feed_secretkey', '');
if($secret_key):
	CR_VcE_Sc_Instagram_Feed::$instance_count++;
	$instagram_feed_id = 'cr_instagram_feed_' . $this->get_instance_count();
?>

<section class="cr-module-wrap cr-insta-feed-wrap <?php echo esc_attr( $css_class ); ?>" <?php echo implode( ' ', $wrapper_attributes ); ?>>
	<?php if($title || $subtitle): ?> 
	<div class="cr-title-subtitle-wrapper <?php if($subtitle){ echo 'cr-title-has-subtitle'; } ?>">
		<h2 class="cr-sc-title"><span class="cr-title-inner cr-animate-when-visible"><?php echo esc_html($title); ?></span></h2>
		<?php if ($subtitle): ?>
		<h2 class="cr-sc-subtitle"><span class="cr-subtitle-inner cr-animate-when-visible"><?php echo esc_html($subtitle); ?></span></h2>
		<?php endif; ?>
	</div>
	<?php endif; ?>
	<div class="cr-insta-feedinner">
		<div class="cr-insta-feed-con">
			<?php get_template_part('modules/instagram-feed/instagram-feed'); ?>
		</div>
	</div>
</section>

<?php endif; ?>