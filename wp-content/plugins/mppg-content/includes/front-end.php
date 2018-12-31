<?php
namespace JMB\MidPenPuppyGuides;

/**
 * Handle the cmb_frontend_form shortcode
 *
 * [cmb_frontend_form id="jmb_mppg_puppy_data"] (default post_type is puppy)
 * [cmb_frontend_form id="jmb_mppg_member_data" post_type="member"]
 *
 * @param  array  $atts Array of shortcode attributes
 * @return string       Form html
 */
function do_frontend_form_submission_shortcode( $atts = array() ) {

	// Parse attributes
	$atts = shortcode_atts( array(
		'id' => '',
		'object_id' => get_object_id_from_query_string(),
		//'save_button_text' => __( 'Submit', 'mppg-content' ),
		'post_author' => 1,
		'post_status' => 'pending',
		'post_type'   => 'puppy',
	), $atts, 'cmb_frontend_form' );

	// If no metabox id is set, yell about it.
	if ( empty( $atts['id'] ) ) {
		return __( "Please add an 'id' attribute to specify the CMB2 form to display.", 'mppg-content' );
	}

	$metabox_id = esc_attr( $atts['id'] );
	$object_id = absint( $atts['object_id'] );

	// Get CMB2 metabox object
	$cmb = cmb2_get_metabox( $metabox_id, $object_id );

	/*
	* Let's add these attributes as hidden fields to our cmb form
	* so that they will be passed through to our form submission
	*/
	foreach ( $atts as $key => $value ) {
		$cmb->add_hidden_field( array(
			'field_args'  => array(
				'id'    => "atts[$key]",
				'type'  => 'hidden',
				'default' => $value,
			),
		) );
	}

	// Initiate our output variable
	$output = '';

	// Get any submission errors
	if ( ( $error = $cmb->prop( 'submission_error' ) ) && is_wp_error( $error ) ) {
		// If there was an error with the submission, add it to our output.
		$output .= '<h3>' . sprintf( __( 'There was an error in the submission: %s', 'mppg-content' ), '<strong>'. $error->get_error_message() .'</strong>' ) . '</h3>';
	}

	// If the post was submitted successfully, notify the user.
	if ( isset( $_GET['submission'] ) && 'success' === $_GET['submission'] ) {
		return '<h3>' . __( 'Thank you for your submission! Check your email for a confirmation link.', 'mppg-content' ) . '</h3>';
	}

	// Bail here if editing a post and the edit nonce is invalid.
	if ( isset( $_GET['object_id'] ) && ( ! isset( $_GET['key'] ) || ! wp_verify_nonce( $_GET['key'], 'edit_profile' ) ) ) {
		return '<h3>' . __( 'Invalid key.', 'mppg-content' ) . '</h3>';
	}

	// Get our form
	$output .= cmb2_get_metabox_form( $cmb, 'fake-object-id', array( 'save_button' => __( 'Submit', 'mppg-content' ) ) );

	return $output;
}
add_shortcode( 'cmb_frontend_form', __NAMESPACE__ . '\do_frontend_form_submission_shortcode' );


/**
 * Handles form submission on save. Redirects if save is successful, otherwise sets an error message as a cmb property
 *
 * @return void
 */
function handle_frontend_new_post_form_submission() {

	// If no form submission, bail
	if ( empty( $_POST ) || ! isset( $_POST['submit-cmb'], $_POST['object_id'] ) ) {
		return false;
	}

	// Grab the post type from hidden submission data
	$post_type = isset( $_POST['atts']['post_type'] ) ? sanitize_title( $_POST['atts']['post_type'] ) : 'monster';

	$prefix = "jmb_mppg_{$post_type}_";
	$metabox_id = $prefix . 'data';
	$object_id = get_object_id_from_query_string();

	// Get CMB2 metabox object
	$cmb = cmb2_get_metabox( $metabox_id, $object_id );

	$post_data = array();

	// Get our shortcode attributes and set them as our initial post_data args
	if ( isset( $_POST['atts'] ) ) {
		foreach ( (array) $_POST['atts'] as $key => $value ) {
			$post_data[ $key ] = sanitize_text_field( $value );
		}
		unset( $_POST['atts'] );
	}

	// Set the post ID if we are updating an existing post.
	if ( absint( $object_id ) ) {
		$post_data['ID'] = absint( $object_id );
		$post_data['post_status'] = 'draft';
	}

	// Check security nonce
	if ( ! isset( $_POST[ $cmb->nonce() ] ) || ! wp_verify_nonce( $_POST[ $cmb->nonce() ], $cmb->nonce() ) ) {
		return $cmb->prop( 'submission_error', new \WP_Error( 'security_fail', __( 'Security check failed.' ) ) );
	}

	// Check title submitted
	if ( empty( $_POST[ $prefix . 'name' ] ) ) {
		return $cmb->prop( 'submission_error', new \WP_Error( 'post_data_missing', __( 'New post requires a title.' ) ) );
	}

	/**
	 * Fetch sanitized values
	 */
	$sanitized_values = $cmb->get_sanitized_values( $_POST );

	// Set our post data arguments
	$post_data['post_title']   = $sanitized_values[$prefix . 'name'];
	unset( $sanitized_values[$prefix . 'name'] );
	$post_data['post_content'] = $sanitized_values[$prefix . 'bio'];
	unset( $sanitized_values[$prefix . 'bio'] );

	// Protect against empty post content
	if ( ! isset( $post_data['post_content'] ) ) {
		$post_data['post_content'] = '';
	}

	// Create the new post
	$new_submission_id = wp_insert_post( $post_data, true );

	// If we hit a snag, update the user
	if ( is_wp_error( $new_submission_id ) ) {
		return $cmb->prop( 'submission_error', $new_submission_id );
	}

	$cmb->save_fields( $new_submission_id, 'post', $sanitized_values );

	/**
	 * Other than post_type and post_status, we want
	 * our uploaded attachment post to have the same post-data
	 */
	unset( $post_data['post_type'] );
	unset( $post_data['post_status'] );
	unset( $post_data['post_content'] );

	// Try to upload the featured image
	$img_id = frontend_form_photo_upload( $new_submission_id, $post_data, $post_type );

	// If our photo upload was successful, set the featured image
	if ( $img_id && ! is_wp_error( $img_id ) ) {
		set_post_thumbnail( $new_submission_id, $img_id );

		// Assign alt text
		update_post_meta( $img_id, '_wp_attachment_image_alt', $post_data['post_title'] );
	}

	/*
	 * Redirect back to the form page with a query variable with the new post ID.
	 * This will help double-submissions with browser refreshes
	 */
	//wp_redirect( esc_url_raw( add_query_arg( 'post_submitted', $new_submission_id ) ) );

	wp_redirect( esc_url_raw( add_query_arg( array(
		'submission' => 'success',
		'submission_id' => $new_submission_id,
	) ) ) );

	exit;
}
add_action( 'cmb2_after_init', __NAMESPACE__ . '\handle_frontend_new_post_form_submission' );

/**
 * Handles uploading a file to a WordPress post
 *
 * @param  int    $post_id               Post ID to upload the photo to
 * @param  array  $attachment_post_data  Attachment post-data array
 * @param  string $post_type             The post type associated with the upload
 */
function frontend_form_photo_upload( $post_id, $attachment_post_data = array(), $post_type ) {

	$photo_field_id = "jmb_mppg_{$post_type}_photo";

	// Make sure the right files were submitted
	if (
		empty( $_FILES )
		|| ! isset( $_FILES[$photo_field_id] )
		|| isset( $_FILES[$photo_field_id]['error'] ) && 0 !== $_FILES[$photo_field_id]['error']
	) {
		return;
	}

	// Filter out empty array values
	$files = array_filter( $_FILES[$photo_field_id] );

	// Make sure files were submitted at all
	if ( empty( $files ) ) {
		return;
	}

	// Make sure to include the WordPress media uploader API if it's not (front-end)
	if ( ! function_exists( 'media_handle_upload' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/media.php' );
	}

	// Upload the file and send back the attachment post ID
	return media_handle_upload( $photo_field_id, $post_id, $attachment_post_data );
}

/**
 * Disables Gutenberg editor for puppy and member posts
 * (Due to an incompatibility with Gutenberg and CMB2)
 *
 * @param  boolean  $current_status     Whether to use Gutenberg
 * @param  string   $post_type          Post type
 */
function disable_gutenberg( $current_status, $post_type ) {

	if ( $post_type === 'puppy' || $post_type === 'member' ) return false;
	return $current_status;
}
add_filter( 'gutenberg_can_edit_post_type', __NAMESPACE__ . '\disable_gutenberg', 10, 2 );
add_filter( 'use_block_editor_for_post_type', __NAMESPACE__ . '\disable_gutenberg', 10, 2 );