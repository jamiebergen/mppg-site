<?php

namespace JMB\MidPenPuppyGuides;

/**
 * Registers the `status` taxonomy,
 * for use with 'puppy'.
 *
 * @since  0.1.0
 */
function status_init() {
	register_taxonomy( 'status', array( 'puppy' ), array(
		'hierarchical'      => true,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_ui'           => true,
		'show_admin_column' => false,
		'query_var'         => true,
		'rewrite'           => true,
		'capabilities'      => array(
			'manage_terms'  => 'edit_posts',
			'edit_terms'    => 'edit_posts',
			'delete_terms'  => 'edit_posts',
			'assign_terms'  => 'edit_posts',
		),
		'labels'            => array(
			'name'                       => __( 'Status', 'mppg-content' ),
			'singular_name'              => _x( 'Status', 'taxonomy general name', 'mppg-content' ),
			'search_items'               => __( 'Search Statuses', 'mppg-content' ),
			'popular_items'              => __( 'Popular Statuses', 'mppg-content' ),
			'all_items'                  => __( 'All Statuses', 'mppg-content' ),
			'parent_item'                => __( 'Parent Status', 'mppg-content' ),
			'parent_item_colon'          => __( 'Parent Status:', 'mppg-content' ),
			'edit_item'                  => __( 'Edit Status', 'mppg-content' ),
			'update_item'                => __( 'Update Status', 'mppg-content' ),
			'view_item'                  => __( 'View Status', 'mppg-content' ),
			'add_new_item'               => __( 'Add New Status', 'mppg-content' ),
			'new_item_name'              => __( 'New Status', 'mppg-content' ),
			'separate_items_with_commas' => __( 'Separate statuses with commas', 'mppg-content' ),
			'add_or_remove_items'        => __( 'Add or remove statuses', 'mppg-content' ),
			'choose_from_most_used'      => __( 'Choose from the most used statuses', 'mppg-content' ),
			'not_found'                  => __( 'No statuses found.', 'mppg-content' ),
			'no_terms'                   => __( 'No statuses', 'mppg-content' ),
			'menu_name'                  => __( 'Statuses', 'mppg-content' ),
			'items_list_navigation'      => __( 'Statuses list navigation', 'mppg-content' ),
			'items_list'                 => __( 'Statuses list', 'mppg-content' ),
			'most_used'                  => _x( 'Most Used', 'status', 'mppg-content' ),
			'back_to_items'              => __( '&larr; Back to Statuses', 'mppg-content' ),
		),
		'show_in_rest'      => true,
		'rest_base'         => 'status',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	) );

}
add_action( 'init', __NAMESPACE__ . '\status_init' );

/**
 * Sets the post updated messages for the `status` taxonomy.
 *
 * @since  0.1.0
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `status` taxonomy.
 */
function status_updated_messages( $messages ) {

	$messages['status'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Status added.', 'mppg-content' ),
		2 => __( 'Status deleted.', 'mppg-content' ),
		3 => __( 'Status updated.', 'mppg-content' ),
		4 => __( 'Status not added.', 'mppg-content' ),
		5 => __( 'Status not updated.', 'mppg-content' ),
		6 => __( 'Statuses deleted.', 'mppg-content' ),
	);

	return $messages;
}
add_filter( 'term_updated_messages', __NAMESPACE__ . '\status_updated_messages' );
