<?php
namespace JMB\MidPenPuppyGuides;

/**
 * Register custom fields for the Member post type.
 *
 * @since 0.1.0
 */
function register_member_fields() {

	$prefix = 'jmb_mppg_member_';

	$member_data = new_cmb2_box( array(
		'id'           => $prefix . 'data',
		'title'        => __( 'Member Data', 'mppg-content' ),
		'object_types' => array( 'member' ),
		'context'      => 'normal',
	) );

	// Member Name (saved as post_title)
	$member_data->add_field( array(
		'type'       => 'text',
		'id'         => $prefix . 'name',
		'name'       => __( 'Member Name *', 'mppg-content' ),
		'show_on_cb' => function() { return ! is_admin(); },
		'default' => ! empty( $_POST['jmb_mppg_member_name'] )
			? $_POST['jmb_mppg_member_name']
			: __( '', 'mppg-content' ),
		'attributes' => array(
			'required' => 'required',
		),
	) );

	// Member Main Photo (saved as post featured image)
	$member_data->add_field( array(
		'default_cb' => __NAMESPACE__ . '\maybe_set_default_from_posted_values',
		'name'       => __( 'Photo', 'mppg-content' ),
		'id'         => $prefix . 'photo',
		'type'       => 'text',
		'attributes' => array(
			'type'     => 'file', // Let's use a standard file upload field
		),
		'show_on_cb' => function() { return ! is_admin(); },
	) );

	// Member since (text_small)
	$member_data->add_field( array(
		'default_cb' => __NAMESPACE__ . '\maybe_set_default_from_posted_values',
		'type' => 'text_small',
		'id'   => $prefix . 'since',
		'name' => __( 'Member since', 'mppg-content' ),
	) );

	// Leader (checkbox)
	$member_data->add_field( array(
		'default_cb' => __NAMESPACE__ . '\maybe_set_default_from_posted_values',
		'type' => 'checkbox',
		'id'   => $prefix . 'leader',
		'name' => __( 'Leader', 'mppg-content' ),
	) );

	// Email address (email field; used for future edits)
//	$member_data->add_field( array(
//		'default_cb' => __NAMESPACE__ . '\maybe_set_default_from_posted_values',
//		'type' => 'text_email',
//		'id'   => $prefix . 'email',
//		'name' => __( 'Member\'s email address', 'mppg-content' ),
//		'desc' => __( 'Used for authentication.', 'mppg-content' ),
//	) );

	// Member Bio (saved as post_content)
	$member_data->add_field( array(
		'default_cb' => __NAMESPACE__ . '\maybe_set_default_from_posted_values',
		'type' => 'wysiwyg',
		'id'   => $prefix . 'bio',
		'name' => __( 'Bio', 'mppg-content' ),
		'options' => array(
			'media_buttons' => false,
			'teeny'         => true,
		),
		'show_on_cb' => function() { return ! is_admin(); },
	) );

}
add_action( 'cmb2_init', __NAMESPACE__ . '\register_member_fields' );

/**
 * Override the loaded value for the Member Name meta field.
 *
 * @since  0.1.0
 *
 * @param  string $data         Value of the stored meta data.
 * @param  int    $object_id    Member post ID.
 * @param  array  $data_args    Various data args provided by CMB2.
 * @param  object $field_object CMB2_Field object.
 * @return string               Overridden meta value.
 */
function override_member_name_value( $data, $object_id, $data_args, $field_object ) {
	if ( 'member' === get_post_type( $object_id ) ) {
		$post = get_post( $object_id );
		$data = $post->post_title;
	}

	return $data;
}
add_filter( 'cmb2_override_jmb_mppg_member_name_meta_value', __NAMESPACE__ . '\override_member_name_value', 10, 4 );


/**
 * Override the loaded value for the Member Bio meta field.
 *
 * @since  0.1.0
 *
 * @param  string $data         Value of the stored meta data.
 * @param  int    $object_id    Member post ID.
 * @param  array  $data_args    Various data args provided by CMB2.
 * @param  object $field_object CMB2_Field object.
 * @return string               Overridden meta value.
 */
function override_member_bio_value( $data, $object_id, $data_args, $field_object ) {
	if ( 'member' !== get_post_type( $object_id ) ) {
		return;
	} else {
		$post = get_post( $object_id );
		$data = $post->post_content;
	}

	return wpautop( $data );
}
add_filter( 'cmb2_override_jmb_mppg_member_bio_meta_value', __NAMESPACE__ . '\override_member_bio_value', 10, 4 );
