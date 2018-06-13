<?php
/**
 * The template for displaying search forms
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$placeholder = apply_filters( 'wpex_search_placeholder_text', __( 'Search', 'total' ), 'main' );
$action      = apply_filters( 'wpex_search_action', esc_url( home_url( '/' ) ), 'main' ); ?>

<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<label>
		<span class="screen-reader-text"><?php echo esc_html( $placeholder ); ?></span>
		<input type="search" class="field" name="s" placeholder="<?php echo esc_attr( __( 'Search', 'crt' ) ); ?>" />
	</label>
	<?php if ( defined( 'ICL_LANGUAGE_CODE' ) ) : ?>
		<input type="hidden" name="lang" value="<?php echo( ICL_LANGUAGE_CODE ); ?>"/>
	<?php endif; ?>
	<?php do_action( 'wpex_searchform_fields' ); ?>
	<button type="submit" class="searchform-submit screen-reader-text"><span class=""><?php esc_html_e( 'Submit', 'total' ); ?></span></button>
</form>