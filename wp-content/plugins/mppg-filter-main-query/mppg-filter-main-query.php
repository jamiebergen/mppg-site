<?php
/**
 * Plugin Name: MPPG Filter Main Query
 * Plugin URI:  https://WPSessions.com
 * Description: Filter the results of the main query on post_type archives.
 * Author:      Brian Richards
 * Author URI:  https://WPSessions.com
 * Text Domain: fmq
 * Domain Path: /languages
 * Version:     2.0.0
 *
 * @package     Filter_Main_Query
 */

namespace WPS\FilterMainQuery;

/**
 * Register various front-end assets.
 *
 * @since 2.0.0
 */
function register_assets() {
	$min = defined( 'DEBUG_SCRIPTS' ) ? '' : '.min';
	wp_register_script( 'fmq', plugin_dir_url( __FILE__ ) . "assets/js/fmq-front-end.js", [ 'select2' ], '2.0.0', true );
	wp_register_script( 'select2', plugin_dir_url( __FILE__ ) . "assets/js/select2{$min}.js", [ 'jquery' ], '4.0.6-rc1', true );
	wp_register_style( 'select2', plugin_dir_url( __FILE__ ) . "assets/css/select2{$min}.css", null, '4.0.6-rc1' );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\register_assets' );

/**
 * Output taxonomy filters as a shortcode.
 *
 * @since  2.0.0
 *
 * @param  string $content Archive description.
 * @return string          Modified archive description.
 */

function output_filter_controls( $atts = array() ) {

	$atts = shortcode_atts(
		array(
			'post_type' => 'puppy',
		),
		$atts,
		'output_filter_controls'
	);

	if ( ! is_post_type_archive( $atts['post_type'] ) ) {
		return;
	}

	$taxonomies = get_object_taxonomies( get_post_type() );

	$filter_controls = get_filter_controls( $taxonomies );
	return $filter_controls;
}
add_shortcode( 'output_filter_controls', __NAMESPACE__ . '\output_filter_controls' );


/**
 * Get HTML markup for all desired taxonomy filters.
 *
 * @since  1.0.0
 *
 * @param  array  $taxonomies Taxonomy slugs.
 * @return string             HTML markup.
 */
function get_filter_controls( $taxonomies = [ 'category', 'post_tag' ] ) {

	$controls = array_map( __NAMESPACE__ . '\get_filter_control', (array) $taxonomies );

	if ( empty( $controls ) ) {
		return;
	}

	wp_enqueue_script( 'fmq' );
	wp_enqueue_style( 'select2' );

	$output = sprintf(
		'
		<form method="GET" class="fmq-filters-wrap">
		<p>%1$s</p>
		%2$s
		<button type="submit" class="button">%3$s</button>
		</form>
		',
		__( 'Narrow the results by selecting the appropriate filters.', 'fmq' ),
		implode( "\n", $controls ),
		__( 'Submit', 'fmq' )
	);

	return apply_filters( 'fmq_get_filter_controls', $output, $taxonomies );
}

/**
 * Get HTML markup for a single taxonomy filter input.
 *
 * @since  1.0.0
 *
 * @param  string $taxonomy Taxonomy slug.
 * @return string           HTML markup.
 */
function get_filter_control( $taxonomy = 'category' ) {

	// Bail early if we don't have a real taxonomy
	$taxonomy = get_taxonomy( $taxonomy );
	if ( ! is_object( $taxonomy ) ) {
		return;
	}

	$terms = get_terms( [
		'taxonomy'   => $taxonomy->name,
		'orderby'    => 'count',
		'order'      => 'DESC',
		'hide_empty' => true,
		'number'     => 200,
	] );

	// Bail early if we don't have any terms
	if ( ! is_array( $terms ) && empty( $terms ) ) {
		return;
	}

	$options = '';
	foreach ( $terms as $term ) {
		$options .= sprintf(
			'<option %1$s value="%2$s">%3$s (%4$s)</option>',
			selected( is_selected_term( $taxonomy->name, $term->slug ), true, false ),
			$term->slug,
			$term->name,
			$term->count
		);
	}

	$output = '';
	$output .= sprintf(
		'
		<div class="fmq-filter-wrap fmq-%1$s-wrap">
		<label for="filter-%1$s">%2$s</label>
		<select name="filter-%1$s[]" class="fmq-filter fmq-filter-%1$s" placeholder="%3%s" multiple="multiple">
		%4$s
		</select>
		</div><!-- .fmq-filter-wrap .fmq-%1$s-wrap -->
		',
		$taxonomy->name,
		sprintf( __( 'Limit to these %s:', 'fmq' ), $taxonomy->labels->name ),
		sprintf( __( 'Select %s&hellip;', 'fmq' ),  $taxonomy->labels->name ),
		$options
	);

	return apply_filters( 'fmq_get_filter_control', $output, $taxonomy, $terms );
}

/**
 * Check if a given taxonomy term is a selected filter.
 *
 * @since  2.0.0
 *
 * @param  string  $taxonomy Taxonomy slug.
 * @param  string  $term     Term slug.
 * @return boolean           True if term is selected, otherwise false.
 */
function is_selected_term( $taxonomy = 'category', $term = '' ) {
	$filters = get_applied_filters();

	if ( ! isset( $filters[ $taxonomy ] ) ) {
		return false;
	}

	if ( ! is_array( $filters[ $taxonomy ] ) ) {
		return false;
	}

	return in_array( $term, $filters[ $taxonomy ] );
}

/**
 * Get all querystrings prefixed with "filter-"
 *
 * @since  2.0.0
 *
 * @return array Multi-dimensional array of term slugs keyed by taxonomy slug.
 */
function get_applied_filters() {
	wp_parse_str( $_SERVER['QUERY_STRING'], $query_args );
	$applied_filters = [];

	foreach ( $query_args as $key => $value ) {
		if ( false === strpos( $key, 'filter-' ) ) {
			continue;
		}

		$key = str_replace( 'filter-', '', $key );

		$applied_filters[ $key ] = $value;
	}

	return $applied_filters;
}

/**
 * Filter the main query (via pre_get_posts) if query filters are present.
 *
 * @since 1.0.0
 *
 * @param object $query WP_Query object.
 */
function maybe_filter_query( $query ) {
	if ( $query->is_main_query() && should_filter_query() ) {
		$filters = get_applied_filters();
		$query = filter_query( $query, $filters );
	}
}
add_action( 'pre_get_posts', __NAMESPACE__ . '\maybe_filter_query' );

/**
 * Check if query should be filtered.
 *
 * @since  2.0.0
 *
 * @return bool True if filters are present, otherwise false.
 */
function should_filter_query() {
	$applied_filters = get_applied_filters();
	return is_array( $applied_filters ) && ! empty( $applied_filters );
}

/**
 * Set taxonomy filters on a WP_Query object.
 *
 * @since  1.0.0
 *
 * @param  object $query   WP_Query object.
 * @param  array  $filters Multi-dimensional array of term slugs keyed by taxonomy slug.
 * @return object          Modifed WP_Query object.
 */
function filter_query( $query, $filters = [] ) {

	$tax_query = [];

	// for each remaining taxonomy filter, add to the tax query
	if ( is_array( $filters ) && ! empty( $filters ) ) {
		foreach ( $filters as $taxonomy => $terms ) {
			$tax_query[] = [
				'taxonomy' => $taxonomy,
				'field'    => 'slug',
				'terms'    => $terms,
			];
		}
	}

	// if our tax_query is not empty, join each with AND
	if ( ! empty( $tax_query ) ) {
		$tax_query['relation'] = 'AND';
		$query->set( 'tax_query', $tax_query );
	}

	return $query;
}