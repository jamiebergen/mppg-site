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
		'priorty'      => 'high',
		'show_names'   => true,
	) );

	// Member Name (saved as post_title)
	$member_data->add_field( array(
		'type'       => 'text',
		'id'         => $prefix . 'name',
		'name'       => __( 'Member Name', 'mppg-content' ),
		'show_on_cb' => function() { return ! is_admin(); },
	) );

	// Email address (email field; used for future edits)
	$member_data->add_field( array(
		'type' => 'text_email',
		'id'   => $prefix . 'email',
		'name' => __( 'Member\'s email address', 'mppg-content' ),
		'desc' => __( 'Used for authentication.', 'mppg-content' ),
	) );

	// Leader (checkbox)
	$member_data->add_field( array(
		'type' => 'checkbox',
		'id'   => $prefix . 'leader',
		'name' => __( 'Leader', 'mppg-content' ),
	) );

	// Photo (post featured image)
	$member_data->add_field( array(
		'type'    => 'file',
		'id'      => $prefix . 'photo',
		'name'    => __( 'Photo', 'mppg-content' ),
		'desc'    => 'Upload the member\'s featured image.',

		// Optional:
		'options' => array(
			'url' => false, // Hide the text input for the url
		),
		'text'    => array(
			'add_upload_file_text' => 'Add Image' // Change upload button text. Default: "Add or Upload File"
		),
		// query_args are passed to wp.media's library query.
		'query_args' => array(
			// Only allow gif, jpg, or png images
			'type' => array(
				'image/gif',
				'image/jpeg',
				'image/png',
			),
		),
		'preview_size' => 'large', // Image size to use when previewing in the admin.
		'show_on_cb' => function() { return ! is_admin(); },
	) );

	// Member Bio (saved as post_content)
	$member_data->add_field( array(
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
	if ( 'member' === get_post_type( $object_id ) ) {
		$post = get_post( $object_id );
		$data = $post->post_content;
	}

	return $data;
}
add_filter( 'cmb2_override_jmb_mppg_member_bio_meta_value', __NAMESPACE__ . '\override_member_bio_value', 10, 4 );

/**
 * Override the loaded value for the Member Photo meta field.
 *
 * @since  0.1.0
 *
 * @param  string $data         Value of the stored meta data.
 * @param  int    $object_id    Member post ID.
 * @param  array  $data_args    Various data args provided by CMB2.
 * @param  object $field_object CMB2_Field object.
 * @return string               Overridden meta value.
 */
function override_member_photo_value( $data, $object_id, $data_args, $field_object ) {
	if ( 'member' === get_post_type( $object_id ) ) {
		$data = get_the_post_thumbnail_url( $object_id );
	}

	return $data;
}
add_filter( 'cmb2_override_jmb_mppg_member_photo_meta_value', __NAMESPACE__ . '\override_member_photo_value', 10, 4 );

/**
 * Save Member Name value to post_title.
 *
 * @since  0.1.0
 *
 * @param  mixed $return        Original return value.
 * @param  array $args          Field data arguments.
 * @param  array $field_args    Field arguments.
 * @param  object $field_object CMB2_Field object.
 * @return mixed                Original return value or nothing.
 */
function save_member_name_value( $return, $args, $field_args, $field_object ) {

	if ( 'jmb_mppg_member_name' !== $field_args['id'] ) {
		return $return;
	}

	wp_update_post( array(
		'ID' => $args['id'],
		'post_title' => esc_html( $args['value'] ),
	) );
}
add_filter( 'cmb2_override_meta_save', __NAMESPACE__ . '\save_member_name_value', 10, 4 );

/**
 * Save Member Bio value to post_content.
 *
 * @since  0.1.0
 *
 * @param  mixed $return        Original return value.
 * @param  array $args          Field data arguments.
 * @param  array $field_args    Field arguments.
 * @param  object $field_object CMB2_Field object.
 * @return mixed                Original return value or nothing.
 */
function save_member_bio_value( $return, $args, $field_args, $field_object ) {

	if ( 'jmb_mppg_member_bio' !== $field_args['id'] ) {
		return $return;
	}

	wp_update_post( array(
		'ID' => $args['id'],
		'post_content' => wp_kses_post( $args['value'] ),
	) );
}
add_filter( 'cmb2_override_meta_save', __NAMESPACE__ . '\save_member_bio_value', 10, 4 );

/**
 * Save Member Photo value to featured_image.
 *
 * @since  0.1.0
 *
 * @param  mixed $return        Original return value.
 * @param  array $args          Field data arguments.
 * @param  array $field_args    Field arguments.
 * @param  object $field_object CMB2_Field object.
 * @return mixed                Original return value or nothing.
 */
function save_member_photo_value( $return, $args, $field_args, $field_object ) {

	if ( 'jmb_mppg_member_photo' !== $field_args['id'] ) {
		return $return;
	}

	$thumbnail_id = get_post_meta( $args['id'], 'jmb_mppg_member_photo_id', 1 );
	set_post_thumbnail( $args['id'], $thumbnail_id );
}
add_filter( 'cmb2_override_meta_save', __NAMESPACE__ . '\save_member_photo_value', 10, 4 );