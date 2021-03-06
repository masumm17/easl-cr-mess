<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * Shortcode class
 * @var $this CR_VcE_Sc_Two_Col_Content
 */
$el_class = $css = $css_animation = '';
$enable_button = $button = $col_1_title = $col_1_note = $col_2_title = $col_2_note = $disable_col1 = $disable_col2 = '';
$amenity_ids = array();
$floorplans = array();
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$parsed_floorplans = $this->get_floorplans_data( $atts );
$button = $this->parse_url($button);

$amenitey_args = array(
	'post_type' => CR_Custom_types::get_amenity_data('type'),
	'numberposts' => -1,
	'orderby' => 'menu_order',
	'order' => 'ASC',
);

$amenity_ids = $this->get_inlcluded_amenities($amenity_ids);

if(count($amenity_ids) > 0) {
	$amenitey_args['post__in'] = $amenity_ids;
	$amenitey_args['orderby'] = 'post__in';
}

$amenities = get_posts($amenitey_args);
if(!$amenities || is_wp_error($amenities)){
	$amenities = array();
}

$class_to_filter = '';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$column_1_enabled = 'yes' != $disable_col1 ? true : false;
$column_2_enabled = 'yes' != $disable_col2 ? true : false;
if($column_1_enabled && count($amenities) < 1) {
	$column_1_enabled = false;
}
if($column_2_enabled && count($parsed_floorplans) < 1) {
	$column_2_enabled = false;
}

if('yes' == $enable_button && $button) {
	$css_class .= ' cr-2col-content-has-button';
}
if(!$column_2_enabled) {
	$css_class .= ' cr-2col-content-nofloorpans';
}
if(!$column_1_enabled && $column_2_enabled) {
	$css_class .= ' cr-2col-content-noamenities';
}

$wrapper_attributes = array();
if ( ! empty( $atts['el_id'] ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $atts['el_id'] ) . '"';
}
if($column_1_enabled || $column_2_enabled):
?> 

<section class="cr-module-wrap cr-2col-content-wrapper <?php echo esc_attr( $css_class ); ?>" <?php echo implode( ' ', $wrapper_attributes ); ?>>
	<div class="cr-2col-content-inner cr-animate-when-visible">
		<?php if($column_1_enabled): ?>
		<div class="cr-2col-content-amenities">
			<div class="cr-2col-content-bg"></div>
			<div class="cr-2col-content-col-inner">
				<?php if($col_1_title): ?>
				<h2 class="cr-2col-content-title"><?php echo esc_html($col_1_title); ?></h2>
				<?php endif; ?>
				<ul class="cr-2col-content-amenities-list">
					<?php 
					foreach($amenities as $am_post):
						if( function_exists('get_field')){
							$am_thumb = get_field('amenity_icon', $am_post->ID);
						} else {
							$am_thumb = get_post_meta($am_post->ID, 'amenity_icon', true);
						}

					?>
					<li>
						<?php if($am_thumb): ?>
						<img alt="" src="<?php echo esc_url($am_thumb); ?>"/>
						<?php endif; ?>
						<span><?php echo get_the_title($am_post); ?></span>
					</li>
					<?php endforeach; ?>
				</ul>
				<?php if( $col_1_note ): ?>
				<div class="cr-2col-content-note"><?php echo wpautop($col_1_note); ?></div>
				<?php endif; ?>
			</div>
		</div>
		<?php endif; ?>
		<?php if($column_2_enabled): ?>
		<div class="cr-2col-content-floorplans">
			<div class="cr-2col-content-bg"></div>
			<div class="cr-2col-content-col-inner">
				<?php if($col_2_title): ?>
				<h2 class="cr-2col-content-title"><?php echo esc_html($col_2_title); ?></h2>
				<?php endif; ?>
				<ul class="cr-2col-content-floorplans-thumbs cr-2col-content-floorplans-thumbs-count-<?php echo count($parsed_floorplans); ?>">
				<?php 
				foreach($parsed_floorplans as $floorplan): 
					$link_attributes = array();
					if ( ! empty( $floorplan['url'] ) ) {
						$link_attributes[] = 'href="' . esc_attr( trim( $floorplan['url'] ) ) . '"';
					}
					if ( ! empty( $floorplan['title'] ) ) {
						$link_attributes[] = 'title="' . esc_attr( trim( $floorplan['title'] ) ) . '"';
					}
					if ( ! empty( $floorplan['target'] ) ) {
						$link_attributes[] = 'target="' . esc_attr( trim( $floorplan['target'] ) ) . '"';
					}
					if ( ! empty( $floorplan['rel'] ) ) {
						$link_attributes[] = 'rel="' . esc_attr( trim( $floorplan['rel'] ) ) . '"';
					}
					if(count($link_attributes) > 0){
						$link_attributes = implode( ' ', $link_attributes );
					}else{
						$link_attributes = '';
					}
				?>
					<li>
						<?php if($link_attributes) :?><a <?php echo $link_attributes; ?>><?php endif; ?><img alt="" src="<?php echo esc_url( $floorplan['thumb'] ) ?>"/><?php if($link_attributes) :?></a><?php endif; ?>
					</li>
				<?php endforeach; ?>
				</ul>
				<?php if( $col_2_note ): ?>
				<div class="cr-2col-content-note"><?php echo wpautop($col_2_note); ?></div>
				<?php endif; ?>
			</div>
		</div>
		<?php endif; ?>
	</div>
	<?php 
	if($enable_button && $button && !empty($button['title'])):
		$button_attributes = array();
		if ( ! empty( $button['url'] ) ) {
			$button_attributes[] = 'href="' . esc_attr( trim( $button['url'] ) ) . '"';
		}
		if ( ! empty( $button['target'] ) ) {
			$button_attributes[] = 'target="' . esc_attr( trim( $button['target'] ) ) . '"';
		}
		if ( ! empty( $button['rel'] ) ) {
			$button_attributes[] = 'rel="' . esc_attr( trim( $button['rel'] ) ) . '"';
		}
		if(count($button_attributes) > 0){
			$button_attributes = implode( ' ', $button_attributes );
		}else{
			$button_attributes = '';
		}
	?>
		<div class="cr-2col-content-button-wrap cr-animate-when-visible">
			<a class="cr-2col-content-button cr-button" <?php echo $button_attributes ?>><?php echo esc_html($button['title']); ?></a>
		</div>
	<?php endif; ?>
</section>
<?php endif; ?>