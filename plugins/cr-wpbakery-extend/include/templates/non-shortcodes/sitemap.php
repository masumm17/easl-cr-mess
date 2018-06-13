<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
//$title_override
$module_title = $title_override;
?> 
<div class="cr-sitemap-module cr-animate-when-visible">
	<?php if($module_title):?>
	<h2 class="cr-sitemap-title"><span class="cr-title-inner"><?php echo esc_html($module_title); ?></span></h2>
	<?php endif; ?>

	<div class="cr-sitemap-module-wrap">
		<?php get_template_part('template-parts/sitemap'); ?>
	</div>

</div>
