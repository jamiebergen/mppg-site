<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Sample_Theme
 */

if ( ! function_exists( 'jmb_sample_theme_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function jmb_sample_theme_posted_on() {
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
			wp_kses(
			/* translators: %s: post date. */
				__( '<span class="screen-reader-text">Posted on </span>%s', 'jmb-sample-theme' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'jmb_sample_theme_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function jmb_sample_theme_posted_by() {
		$byline = sprintf(
			wp_kses(
			/* translators: %s: post author. */
				__( '<span class="screen-reader-text">by </span>%s', 'jmb-sample-theme' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"><span class="sep">|</span>' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'jmb_sample_theme_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function jmb_sample_theme_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'jmb-sample-theme' ) );
			if ( $categories_list ) {
				echo '<span class="cat-links">';
                printf(
					wp_kses(
					/* translators: 1: list of categories. */
						__( '<span class="screen-reader-text">Posted in </span>%1$s', 'jmb-sample-theme' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					), $categories_list
                );
                echo '</span>';
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'jmb-sample-theme' ) );
			if ( $tags_list ) {
				echo '<span class="tags-links">';
				printf(
					wp_kses(
					/* translators: 1: list of tags. */
						__( '<span class="screen-reader-text">Tagged </span>%1$s', 'jmb-sample-theme' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					), $tags_list
				);
				echo '</span>';

			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
					/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'jmb-sample-theme' ),
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
					__( 'Edit <span class="screen-reader-text">%s</span>', 'jmb-sample-theme' ),
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

if ( ! function_exists( 'jmb_sample_theme_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function jmb_sample_theme_post_thumbnail() {
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

if ( ! function_exists( 'jmb_sample_theme_get_read_more_link' ) ) :
	/**
	 * Helper function to generate read more link for excerpts
	 *
	 * Makes the excerpt "read more" a link and includes screen reader text
	 * 'Continue reading: ' is a translatable string
	 */
	//
	function jmb_sample_theme_get_read_more_link( $permalink, $title ) {
		$excerpt_more = '';
		$excerpt_more .= '&nbsp;<a class="excerpt-more" href="' . $permalink . '">[&hellip;]';
		$excerpt_more .= sprintf(
			wp_kses(
			/* translators: %s: Name of current post. Only visible to screen readers */
				__( '<span class="screen-reader-text">Continue reading: "%s"</span>', 'jmb-sample-theme' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			$title
		);
		$excerpt_more .= '</a>';

		return $excerpt_more;
	}
endif;