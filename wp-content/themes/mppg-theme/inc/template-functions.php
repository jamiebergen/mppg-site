<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Sample_Theme
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function jmb_sample_theme_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'jmb_sample_theme_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function jmb_sample_theme_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'jmb_sample_theme_pingback_header' );

/**
 * Makes the excerpt "read more" a link to the full post
 */
// Case for automatically generated excerpts
function jmb_sample_theme_excerpt_more( $more ) {
	global $post;
	$permalink = get_permalink($post->ID);
	$title = get_the_title();
	$excerpt_more = jmb_sample_theme_get_read_more_link( $permalink, $title );
	return $excerpt_more;
}
add_filter( 'excerpt_more', 'jmb_sample_theme_excerpt_more' );

// Case for hand-crafted excerpts
function jmb_sample_theme_manual_excerpt_more( $excerpt ) {
	$excerpt_more = '';
	if ( has_excerpt() && !is_attachment() && get_post_type() == 'post' ) {
		$permalink = get_permalink();
		$title = get_the_title();
		$excerpt_more = jmb_sample_theme_get_read_more_link( $permalink, $title );
	}
	return $excerpt . $excerpt_more;
}
add_filter( 'get_the_excerpt', 'jmb_sample_theme_manual_excerpt_more' );