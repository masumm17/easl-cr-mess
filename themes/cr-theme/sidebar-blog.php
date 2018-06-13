<?php
/**
 * The sidebar containing the blog widget area
 */

if ( ! is_active_sidebar( 'sidebar-blog' ) ) {
	return;
}
?>

<aside id="secondary" class="cr-blog-widget-area">
	<div class="sidebar-inner">
	<?php dynamic_sidebar( 'sidebar-blog' ); ?>
	</div>
</aside>