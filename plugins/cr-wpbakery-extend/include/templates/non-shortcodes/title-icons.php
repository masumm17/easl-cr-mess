<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
//$title_override
if(!empty($title_override)){
	$module_title = $title_override;
}else{
	$module_title = get_option('site_social_icons_title');
}
$social_icons = array(
	'facebook' => array(
		'label' => __( 'Facebook', 'crvc_extension' ),
	),
	'twitter' => array(
		'label' => __( 'Twitter', 'crvc_extension' ),
	),
	'youtube' => array(
		'label' => __( 'youtube', 'crvc_extension' ),
	),
	'instagram' => array(
		'label' => __( 'Instagram', 'crvc_extension' ),
	),
	'pinterest' => array(
		'label' => __( 'Pinterest', 'crvc_extension' ),
	),
	'linkedin' => array(
		'label' => __( 'Linkedin', 'crvc_extension' ),
	),
);
$active_icons = array();
foreach($social_icons as $icon_key => $icon_settings){
	$icons_url = get_option('site_social_icons_'. $icon_key .'_link');
	$icons_image = get_option('site_social_icons_'. $icon_key .'_icon');
	if(!$icons_url || !$icons_image) {
		continue;
	}
	$active_icons[$icon_key] = array(
		'url' => $icons_url,
		'image' => $icons_image,
	);
}?> 
<div class="cr-title-icons-module cr-animate-when-visible">
<?php if($module_title):?>
<h2 class="cr-title-icons-title"><span class="cr-title-inner"><?php echo esc_html($module_title); ?></span></h2>
<?php endif; ?>

<?php if(count($active_icons) > 0): ?>
<div class="cr-title-icons-list-wrap">
	<ul class="cr-title-icons-list">
		<?php foreach($active_icons as $icon_key => $icon): ?>
		<li>
			<a href="<?php echo esc_url($icon['url']); ?>" target="_blank"><img alt="<?php echo $icon_key; ?>" src="<?php echo esc_url($icon['image']); ?>"/></a>
		</li>
		<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>
</div>
