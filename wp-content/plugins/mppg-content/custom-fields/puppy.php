<?php
namespace JMB\MidPenPuppyGuides;

/**
 * Register custom fields for the Puppy post type.
 *
 * @since 0.1.0
 */
function register_puppy_fields() {

	$prefix = 'jmb_mppg_puppy_';

	$puppy_data = new_cmb2_box( array(
		'id'           => $prefix . 'data',
		'title'        => __( 'Puppy Data', 'mppg-content' ),
		'object_types' => array( 'puppy' ),
		'context'      => 'normal',
		'priorty'      => 'high',
		'show_names'   => true,
	) );

	// Puppy Name (saved as post_title)
	$puppy_data->add_field( array(
		'type'       => 'text',
		'id'         => $prefix . 'name',
		'name'       => __( 'Puppy Name', 'mppg-content' ),
		'show_on_cb' => function() { return ! is_admin(); },
	) );

	// Email address (email field; used for future edits)
	$puppy_data->add_field( array(
		'type' => 'text_email',
		'id'   => $prefix . 'email',
		'name' => __( 'Raiser\'s email address', 'mppg-content' ),
		'desc' => __( 'Used for authentication.', 'mppg-content' ),
	) );

	// Birthdate (date picker field)
	$puppy_data->add_field( array(
		'type' => 'text_date_timestamp',
		'id'   => $prefix . 'birthdate',
		'name' => __( 'Birthdate', 'mppg-content'),
	) );

	// Status (single-select taxonomy terms - radio)
	$puppy_data->add_field( array(
		'type'           => 'taxonomy_radio',
		'id'             => $prefix . 'status',
		'name'           => __( 'Status', 'mppg-content' ),
		'taxonomy'       => 'status',
		'remove_default' => true, // Removes the default metabox provided by WP core. // !!! Broken in Gutenberg
		'save_field'     => false,
	) );

	// Breed/color (radio)
	$puppy_data->add_field( array(
		'type'             => 'radio',
		'id'               => $prefix . 'breed',
		'name'             => __( 'Breed/color', 'mppg-content' ),
		'options'          => array(
			'black-lab'     => __( 'Black Labrador Retriever', 'mppg-content' ),
			'yellow-lab'    => __( 'Yellow Labrador Retriever', 'mppg-content' ),
			'golden-pure'   => __( 'Golden Retriever', 'mppg-content' ),
			'golden-mix'    => __( 'Golden Retriever/Lab Mix', 'mppg-content' ),
		),
	) );

	// Gender (radio)
	$puppy_data->add_field( array(
		'type'             => 'radio',
		'id'               => $prefix . 'gender',
		'name'             => __( 'Gender', 'mppg-content' ),
		'options'          => array(
			'male'    => __( 'Male', 'mppg-content' ),
			'female'  => __( 'Female', 'mppg-content' ),
		),
	) );

	// Dam (text field)
	$puppy_data->add_field( array(
		'type'    => 'text',
		'id'      => $prefix . 'dam',
		'name'    => __( 'Dam', 'mppg-content' ),
		'desc'    => __( 'Puppy\'s mother', 'mppg-content' ),
	) );

	// Sire (text field)
	$puppy_data->add_field( array(
		'type'    => 'text',
		'id'      => $prefix . 'sire',
		'name'    => __( 'Sire', 'mppg-content' ),
		'desc'    => __( 'Puppy\'s father', 'mppg-content' ),
	) );

	// Main photo (post featured image)
	$puppy_data->add_field( array(
		'type'    => 'file',
		'id'      => $prefix . 'photo',
		'name'    => __( 'Image', 'mppg-content' ),
		'desc'    => 'Upload the puppy\'s featured image.',

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

	// Puppy Bio (saved as post_content)
	$puppy_data->add_field( array(
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
add_action( 'cmb2_init', __NAMESPACE__ . '\register_puppy_fields' );

/**
 * Override the loaded value for the Puppy Name meta field.
 *
 * @since  0.1.0
 *
 * @param  string $data         Value of the stored meta data.
 * @param  int    $object_id    Puppy post ID.
 * @param  array  $data_args    Various data args provided by CMB2.
 * @param  object $field_object CMB2_Field object.
 * @return string               Overridden meta value.
 */
function override_puppy_name_value( $data, $object_id, $data_args, $field_object ) {
	if ( 'puppy' === get_post_type( $object_id ) ) {
		$post = get_post( $object_id );
		$data = $post->post_title;
	}

	return $data;
}
add_filter( 'cmb2_override_jmb_mppg_puppy_name_meta_value', __NAMESPACE__ . '\override_puppy_name_value', 10, 4 );

/**
 * Override the loaded value for the Puppy Bio meta field.
 *
 * @since  0.1.0
 *
 * @param  string $data         Value of the stored meta data.
 * @param  int    $object_id    Puppy post ID.
 * @param  array  $data_args    Various data args provided by CMB2.
 * @param  object $field_object CMB2_Field object.
 * @return string               Overridden meta value.
 */
function override_puppy_bio_value( $data, $object_id, $data_args, $field_object ) {
	if ( 'puppy' === get_post_type( $object_id ) ) {
		$post = get_post( $object_id );
		$data = $post->post_content;
	}

	return $data;
}
add_filter( 'cmb2_override_jmb_mppg_puppy_bio_meta_value', __NAMESPACE__ . '\override_puppy_bio_value', 10, 4 );

/**
 * Override the loaded value for the Puppy Photo meta field.
 *
 * @since  0.1.0
 *
 * @param  string $data         Value of the stored meta data.
 * @param  int    $object_id    Puppy post ID.
 * @param  array  $data_args    Various data args provided by CMB2.
 * @param  object $field_object CMB2_Field object.
 * @return string               Overridden meta value.
 */
function override_puppy_photo_value( $data, $object_id, $data_args, $field_object ) {
	if ( 'puppy' === get_post_type( $object_id ) ) {
		$data = get_the_post_thumbnail_url( $object_id );
	}

	return $data;
}
add_filter( 'cmb2_override_jmb_mppg_puppy_photo_meta_value', __NAMESPACE__ . '\override_puppy_photo_value', 10, 4 );

/**
 * Save Puppy Name value to post_title.
 *
 * @since  0.1.0
 *
 * @param  mixed $return        Original return value.
 * @param  array $args          Field data arguments.
 * @param  array $field_args    Field arguments.
 * @param  object $field_object CMB2_Field object.
 * @return mixed                Original return value or nothing.
 */
function save_puppy_name_value( $return, $args, $field_args, $field_object ) {

	if ( 'jmb_mppg_puppy_name' !== $field_args['id'] ) {
		return $return;
	}

	wp_update_post( array(
		'ID' => $args['id'],
		'post_title' => esc_html( $args['value'] ),
	) );
}
add_filter( 'cmb2_override_meta_save', __NAMESPACE__ . '\save_puppy_name_value', 10, 4 );

/**
 * Save Puppy Bio value to post_content.
 *
 * @since  0.1.0
 *
 * @param  mixed $return        Original return value.
 * @param  array $args          Field data arguments.
 * @param  array $field_args    Field arguments.
 * @param  object $field_object CMB2_Field object.
 * @return mixed                Original return value or nothing.
 */
function save_puppy_bio_value( $return, $args, $field_args, $field_object ) {

	if ( 'jmb_mppg_puppy_bio' !== $field_args['id'] ) {
		return $return;
	}

	wp_update_post( array(
		'ID' => $args['id'],
		'post_content' => wp_kses_post( $args['value'] ),
	) );
}
add_filter( 'cmb2_override_meta_save', __NAMESPACE__ . '\save_puppy_bio_value', 10, 4 );

/**
 * Save Puppy Photo value to featured_image.
 *
 * @since  0.1.0
 *
 * @param  mixed $return        Original return value.
 * @param  array $args          Field data arguments.
 * @param  array $field_args    Field arguments.
 * @param  object $field_object CMB2_Field object.
 * @return mixed                Original return value or nothing.
 */
function save_puppy_photo_value( $return, $args, $field_args, $field_object ) {

	if ( 'jmb_mppg_puppy_photo' !== $field_args['id'] ) {
		return $return;
	}

	$thumbnail_id = get_post_meta( $args['id'], 'jmb_mppg_puppy_photo_id', 1 );
	set_post_thumbnail( $args['id'], $thumbnail_id );
}
add_filter( 'cmb2_override_meta_save', __NAMESPACE__ . '\save_puppy_photo_value', 10, 4 );