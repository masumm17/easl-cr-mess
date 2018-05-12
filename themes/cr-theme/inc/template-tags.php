<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Cheval_Residences_theme
 */

if ( ! function_exists( 'cr_theme_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function cr_theme_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'cr-theme' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'cr_theme_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function cr_theme_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'cr-theme' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'cr_theme_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function cr_theme_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'cr-theme' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'cr-theme' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'cr-theme' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'cr-theme' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'cr-theme' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'cr-theme' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'cr_theme_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function cr_theme_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;

/**
 * Returns header logo image
 *
 * @since 4.0
 */
function crt_header_logo_img() {
	
	// Get logo from theme mod
	$logo = crt_get_theme_mode( 'site_main_logo', '');

	// Convert to URL if it's an ID
	if ( $logo && is_numeric( $logo ) ) {
		$logo = wp_get_attachment_image_src( $logo, 'full' );
		$logo = isset( $logo[0] ) ? $logo[0] : '';
	}
	
	if(!$logo) {
		$logo = get_template_directory_uri() . 'assets/image/slogo.png';
	}

	// Set correct scheme and return
	return $logo ? set_url_scheme( $logo ) : '';

}
/**
 * Returns header logo image
 *
 * @since 4.0
 */
function crt_scroll_header_logo_img() {
	
	// Get logo from theme mod
	$logo = crt_get_theme_mode( 'fixed_header_logo', '');

	// Convert to URL if it's an ID
	if ( $logo && is_numeric( $logo ) ) {
		$logo = wp_get_attachment_image_src( $logo, 'full' );
		$logo = isset( $logo[0] ) ? $logo[0] : '';
	}
	
	if(!$logo) {
		$logo = get_template_directory_uri() . 'assets/images/scroll-header-logo.png';
	}

	// Set correct scheme and return
	return $logo ? set_url_scheme( $logo ) : '';
}
/**
 * Returns header logo image
 *
 * @since 4.0
 */
function crt_header_highlighted_butotn() {
	
	// Get highlight button from theme mod
	$link = crt_get_theme_mode( 'search_availabilty_link', '');
	$title = crt_get_theme_mode( 'search_availabilty_title', '');
	$newtab = crt_get_theme_mode( 'search_availabilty_nt', '');
	
	$button_markup = '';
	
	if(!$link || !$title){
		return '';
	}
	
	if($newtab){
		$newtab = ' target="_blank"';
	}else{
		$newtab = '';
	}
	$button_markup = '<a class="header-highlight-button" href="'. esc_url($link) .'"'. $newtab .'><span>' . esc_html($title) . '</span></a>';

	return $button_markup;
}