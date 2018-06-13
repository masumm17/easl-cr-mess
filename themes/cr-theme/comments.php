<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Cheval_Residences_theme
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	if ( have_comments() ) :
		?>
		<h2 class="comments-title">
			<?php
			$cr_theme_comment_count = get_comments_number();
			if ( '1' === $cr_theme_comment_count ) {
				printf(
					esc_html__( 'One comment on &ldquo;%1$s&rdquo;', 'crt' ),
					'<span>' . get_the_title() . '</span>'
				);
			} else {
				printf( 
					esc_html( _nx( '%1$s comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', $cr_theme_comment_count, 'comments title', 'crt' ) ),
					number_format_i18n( $cr_theme_comment_count ),
					'<span>' . get_the_title() . '</span>'
				);
			}
			?>
		</h2>

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
			) );
			?>
		</ol>

		<?php
		the_comments_navigation();
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'crt' ); ?></p>
			<?php
		endif;

	endif;

	comment_form(array(
		'title_reply' => __('Leave a Comment', 'crt'),
		'label_submit' => __('Submit Comment', 'crt'),
		'format' => 'html5',
		'comment_notes_before' => '',
		'comment_notes_after' => '',
		'fields' => array(
			'author'  => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'crt' ) . ( $req ? ' <span class="required">' . __('(required)', 'crt') . '</span>' : '' ) . '</label> ' .
						 '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245"' . $html_req . ' /></p>',
			'email'   => '<p class="comment-form-email"><label for="email">' . __( 'Email (will not be published)' ) . ( $req ? ' <span class="required">' . __('(required)', 'crt') . '</span>' : '' ) . '</label> ' .
						 '<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" maxlength="100" aria-describedby="email-notes"' . $html_req . ' /></p>',
			
		),
		'class_submit' => 'cr-button'
	));
	?>

</div>
