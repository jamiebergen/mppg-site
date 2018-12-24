<?php
namespace JMB\MidPenPuppyGuides;

/**
 * Shortcode to display a CMB2 form for a given post ID.
 *
 * [cmb2_form id="jmb_mppg_puppy_data"]
 *
 * @param  array  $atts Shortcode attributes.
 * @return string       Form HTML markup.
 */
function cmb2_form_shortcode( $atts = array() ) {

	$atts = shortcode_atts(
		array(
			'id' => '',
			//'object_id' => get_object_id_from_query_string(),
			'object_id' => get_query_var( 'puppy_id' ),
			'save_button_text' => __( 'Submit', 'mppg-content' ),
			'post_type' => 'puppy',
		),
		$atts,
		'cmb2_form'
	);

	// If no metabox id is set, yell about it.
	if ( empty( $atts['id'] ) ) {
		return __( "Please add an 'id' attribute to specify the CMB2 form to display.", 'mppg-content' );
	}

	// Instantiate a new metabox object
	$metabox_id = esc_attr( $atts['id'] );
	$object_id = absint( $atts['object_id'] );
	$metabox = cmb2_get_metabox( $metabox_id, $object_id );
	$output = '';

	$output .= cmb2_get_metabox_form( $metabox, $object_id, array( 'save_button' => esc_attr( $atts['save_button_text'] ) ) );

	return $output;
}
add_shortcode( 'cmb2_form', __NAMESPACE__ . '\cmb2_form_shortcode' );