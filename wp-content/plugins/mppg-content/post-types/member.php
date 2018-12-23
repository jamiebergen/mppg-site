<?php

namespace JMB\MidPenPuppyGuides;

/**
 * Registers the `member` post type.
 *
 * @since  0.1.0
 */
function member_init() {
	register_post_type( 'member', array(
		'labels'                => array(
			'name'                  => __( 'Members', 'mppg-content' ),
			'singular_name'         => __( 'Member', 'mppg-content' ),
			'all_items'             => __( 'All Members', 'mppg-content' ),
			'archives'              => __( 'Member Archives', 'mppg-content' ),
			'attributes'            => __( 'Member Attributes', 'mppg-content' ),
			'insert_into_item'      => __( 'Insert into member', 'mppg-content' ),
			'uploaded_to_this_item' => __( 'Uploaded to this member', 'mppg-content' ),
			'featured_image'        => _x( 'Featured Image', 'member', 'mppg-content' ),
			'set_featured_image'    => _x( 'Set featured image', 'member', 'mppg-content' ),
			'remove_featured_image' => _x( 'Remove featured image', 'member', 'mppg-content' ),
			'use_featured_image'    => _x( 'Use as featured image', 'member', 'mppg-content' ),
			'filter_items_list'     => __( 'Filter members list', 'mppg-content' ),
			'items_list_navigation' => __( 'Members list navigation', 'mppg-content' ),
			'items_list'            => __( 'Members list', 'mppg-content' ),
			'new_item'              => __( 'New Member', 'mppg-content' ),
			'add_new'               => __( 'Add New', 'mppg-content' ),
			'add_new_item'          => __( 'Add New Member', 'mppg-content' ),
			'edit_item'             => __( 'Edit Member', 'mppg-content' ),
			'view_item'             => __( 'View Member', 'mppg-content' ),
			'view_items'            => __( 'View Members', 'mppg-content' ),
			'search_items'          => __( 'Search members', 'mppg-content' ),
			'not_found'             => __( 'No members found', 'mppg-content' ),
			'not_found_in_trash'    => __( 'No members found in trash', 'mppg-content' ),
			'parent_item_colon'     => __( 'Parent Member:', 'mppg-content' ),
			'menu_name'             => __( 'Members', 'mppg-content' ),
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
		'rest_base'             => 'member',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'init', __NAMESPACE__ . '\member_init' );

/**
 * Sets the post updated messages for the `member` post type.
 *
 * @since  0.1.0
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `member` post type.
 */
function member_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['member'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Member updated. <a target="_blank" href="%s">View member</a>', 'mppg-content' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'mppg-content' ),
		3  => __( 'Custom field deleted.', 'mppg-content' ),
		4  => __( 'Member updated.', 'mppg-content' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Member restored to revision from %s', 'mppg-content' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Member published. <a href="%s">View member</a>', 'mppg-content' ), esc_url( $permalink ) ),
		7  => __( 'Member saved.', 'mppg-content' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Member submitted. <a target="_blank" href="%s">Preview member</a>', 'mppg-content' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Member scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview member</a>', 'mppg-content' ),
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Member draft updated. <a target="_blank" href="%s">Preview member</a>', 'mppg-content' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', __NAMESPACE__ . '\member_updated_messages' );
