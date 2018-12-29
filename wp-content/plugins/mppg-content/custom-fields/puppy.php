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
	) );

	// Puppy Name (saved as post_title)
	$puppy_data->add_field( array(
		'type'       => 'text',
		'id'         => $prefix . 'name',
		'name'       => __( 'Puppy Name', 'mppg-content' ),
		'show_on_cb' => function() { return ! is_admin(); },
		'default' => ! empty( $_POST['jmb_mppg_puppy_name'] )
			? $_POST['jmb_mppg_puppy_name']
			: __( '', 'mppg-content' ),
//		'attributes' => array(
//			'required' => 'required',
//		),
	) );

	// Puppy Bio (saved as post_content)
	$puppy_data->add_field( array(
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

	// Puppy Main Photo (saved as post featured image)
	$puppy_data->add_field( array(
		'default_cb' => __NAMESPACE__ . '\maybe_set_default_from_posted_values',
		'name'       => __( 'Featured Image for New Post', 'mppg-content' ),
		'id'         => $prefix . 'photo',
		'type'       => 'text',
		'attributes' => array(
			'type'     => 'file', // Let's use a standard file upload field
			//'required' => 'required',
		),
		'show_on_cb' => function() { return ! is_admin(); },
	) );

	// Status (single-select taxonomy terms - radio)
	$puppy_data->add_field( array(
		'default_cb'     => __NAMESPACE__ . '\maybe_set_default_from_posted_values',
		'type'           => 'taxonomy_radio',
		'id'             => $prefix . 'status',
		'name'           => __( 'Status', 'mppg-content' ),
		'taxonomy'       => 'status',
		'remove_default' => true, // Removes the default metabox provided by WP core. // !!! Broken in Gutenberg
	) );

	// Email address (email field; used for future edits)
	$puppy_data->add_field( array(
		'default_cb' => __NAMESPACE__ . '\maybe_set_default_from_posted_values',
		'type' => 'text_email',
		'id'   => $prefix . 'email',
		'name' => __( 'Raiser\'s email address', 'mppg-content' ),
		'desc' => __( 'Used for authentication.', 'mppg-content' ),
	) );

	// Birthdate (date picker field)
	$puppy_data->add_field( array(
		'default_cb' => __NAMESPACE__ . '\maybe_set_default_from_posted_values',
		'type' => 'text_date',
		'id'   => $prefix . 'birthdate',
		'name' => __( 'Birthdate', 'mppg-content' ),
//		'attributes' => array(
//			'required' => 'required',
//		),
	) );

	// Breed/color (radio)
	$puppy_data->add_field( array(
		'default_cb' => __NAMESPACE__ . '\maybe_set_default_from_posted_values',
		'type'             => 'radio',
		'id'               => $prefix . 'breed',
		'name'             => __( 'Breed/color', 'mppg-content' ),
		'options_cb'       => __NAMESPACE__ . '\breed_select_options',
//		'attributes' => array(
//			'required' => 'required',
//		),
	) );

	// Gender (radio)
	$puppy_data->add_field( array(
		'default_cb' => __NAMESPACE__ . '\maybe_set_default_from_posted_values',
		'type'             => 'radio',
		'id'               => $prefix . 'gender',
		'name'             => __( 'Gender', 'mppg-content' ),
		'options_cb'       => __NAMESPACE__ . '\gender_select_options',
//		'attributes' => array(
//			'required' => 'required',
//		),
	) );

	// Dam (text field)
	$puppy_data->add_field( array(
		'default_cb' => __NAMESPACE__ . '\maybe_set_default_from_posted_values',
		'type'    => 'text',
		'id'      => $prefix . 'dam',
		'name'    => __( 'Dam', 'mppg-content' ),
		'desc'    => __( 'Puppy\'s mother', 'mppg-content' ),
	) );

	// Sire (text field)
	$puppy_data->add_field( array(
		'default_cb' => __NAMESPACE__ . '\maybe_set_default_from_posted_values',
		'type'    => 'text',
		'id'      => $prefix . 'sire',
		'name'    => __( 'Sire', 'mppg-content' ),
		'desc'    => __( 'Puppy\'s father', 'mppg-content' ),
	) );
}
add_action( 'cmb2_init', __NAMESPACE__ . '\register_puppy_fields' );


/**
 * Options for Breed/color
 *
 * @since  0.1.0
 *
 * @return array
 */
function breed_select_options() {

	return array(
		'black-lab'     => __( 'Black Labrador Retriever', 'mppg-content' ),
		'yellow-lab'    => __( 'Yellow Labrador Retriever', 'mppg-content' ),
		'golden-pure'   => __( 'Golden Retriever', 'mppg-content' ),
		'golden-mix'    => __( 'Golden Retriever/Lab Mix', 'mppg-content' ),
	);
}

/**
 * Options for Gender
 *
 * @since  0.1.0
 *
 * @return array
 */
function gender_select_options() {

	return array(
		'male'    => __( 'Male', 'mppg-content' ),
		'female'  => __( 'Female', 'mppg-content' ),
	);
}


/**
 * Override the loaded value for the Puppy Name meta field.
 *
 * @since  0.1.0
 *
 * @param  string $data         Value of the stored meta data.
 * @param  int    $object_id    Member post ID.
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
 * @param  int    $object_id    Member post ID.
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
