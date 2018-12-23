<?php

namespace JMB\MidPenPuppyGuides;

/**
 * Registers the `puppy` post type.
 *
 * @since 0.1.0
 */
function puppy_init() {
	register_post_type( 'puppy', array(
		'labels'                => array(
			'name'                  => __( 'Puppies', 'mppg-content' ),
			'singular_name'         => __( 'Puppy', 'mppg-content' ),
			'all_items'             => __( 'All Puppies', 'mppg-content' ),
			'archives'              => __( 'Puppy Archives', 'mppg-content' ),
			'attributes'            => __( 'Puppy Attributes', 'mppg-content' ),
			'insert_into_item'      => __( 'Insert into puppy', 'mppg-content' ),
			'uploaded_to_this_item' => __( 'Uploaded to this puppy', 'mppg-content' ),
			'featured_image'        => _x( 'Featured Image', 'puppy', 'mppg-content' ),
			'set_featured_image'    => _x( 'Set featured image', 'puppy', 'mppg-content' ),
			'remove_featured_image' => _x( 'Remove featured image', 'puppy', 'mppg-content' ),
			'use_featured_image'    => _x( 'Use as featured image', 'puppy', 'mppg-content' ),
			'filter_items_list'     => __( 'Filter puppies list', 'mppg-content' ),
			'items_list_navigation' => __( 'Puppies list navigation', 'mppg-content' ),
			'items_list'            => __( 'Puppies list', 'mppg-content' ),
			'new_item'              => __( 'New Puppy', 'mppg-content' ),
			'add_new'               => __( 'Add New', 'mppg-content' ),
			'add_new_item'          => __( 'Add New Puppy', 'mppg-content' ),
			'edit_item'             => __( 'Edit Puppy', 'mppg-content' ),
			'view_item'             => __( 'View Puppy', 'mppg-content' ),
			'view_items'            => __( 'View Puppies', 'mppg-content' ),
			'search_items'          => __( 'Search puppies', 'mppg-content' ),
			'not_found'             => __( 'No puppies found', 'mppg-content' ),
			'not_found_in_trash'    => __( 'No puppies found in trash', 'mppg-content' ),
			'parent_item_colon'     => __( 'Parent Puppy:', 'mppg-content' ),
			'menu_name'             => __( 'Puppies', 'mppg-content' ),
		),
		'public'                => true,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_nav_menus'     => true,
		'supports'              => array( 'title', 'editor' ),
		'has_archive'           => true,
		'rewrite'               => true,
		'query_var'             => true,
		'menu_icon'             => 'dashicons-admin-post',
		'show_in_rest'          => true,
		'rest_base'             => 'puppy',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'init', __NAMESPACE__ . '\puppy_init' );

/**
 * Sets the post updated messages for the `puppy` post type.
 *
 * @since  0.1.0
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `puppy` post type.
 */
function puppy_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['puppy'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Puppy updated. <a target="_blank" href="%s">View puppy</a>', 'mppg-content' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'mppg-content' ),
		3  => __( 'Custom field deleted.', 'mppg-content' ),
		4  => __( 'Puppy updated.', 'mppg-content' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Puppy restored to revision from %s', 'mppg-content' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Puppy published. <a href="%s">View puppy</a>', 'mppg-content' ), esc_url( $permalink ) ),
		7  => __( 'Puppy saved.', 'mppg-content' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Puppy submitted. <a target="_blank" href="%s">Preview puppy</a>', 'mppg-content' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Puppy scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview puppy</a>', 'mppg-content' ),
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Puppy draft updated. <a target="_blank" href="%s">Preview puppy</a>', 'mppg-content' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', __NAMESPACE__ . '\puppy_updated_messages' );
