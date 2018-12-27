<?php
namespace JMB\MidPenPuppyGuides;


/**
 * Helper function to grab ID from 'object_id' query string.
 *
 * @since  0.1.0
 *
 * @return mixed ID (cast as integer) if exists, otherwise 'fake-id'.
 */
function get_object_id_from_query_string() {
	return isset( $_GET['object_id'] )
		? absint( $_GET['object_id'] )
		: 'fake-object-id';
}

/**
 * Sets the front-end-post-form field values if form has already been submitted.
 *
 * @since  0.1.0
 *
 * @return string
 */
function maybe_set_default_from_posted_values( $args, $field ) {
	if ( ! empty( $_POST[ $field->id() ] ) ) {
		return $_POST[ $field->id() ];
	}

	return '';
}
