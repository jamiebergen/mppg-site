<?php
/**
 * Retrieve CMB2 meta fields
 *
 * @package Mid-Peninsula_Puppy_Guides
 */

/**
 * Retrieves puppy field data
 *
 * @param int $post_id Post id to retrieve data from.
 * @return array
 */
function retrieve_puppy_data( $post_id ) {

	$puppy_fields = array();

	$puppy_status = get_the_terms( $post_id, 'status' )[0]->name;

	$puppy_birthdate = date("M j, Y", get_post_meta( $post_id, 'jmb_mppg_puppy_birthdate', true ) );

	$puppy_breed_key = get_post_meta( $post_id, 'jmb_mppg_puppy_breed', true );
	$puppy_breed_options = JMB\MidPenPuppyGuides\breed_select_options();
	$puppy_breed_name = isset( $puppy_breed_options[ $puppy_breed_key ] ) ? $puppy_breed_options[ $puppy_breed_key ] : '';

	$puppy_gender_key = get_post_meta( $post_id, 'jmb_mppg_puppy_gender', true );
	$puppy_gender_options = JMB\MidPenPuppyGuides\gender_select_options();
	$puppy_gender_name = isset( $puppy_gender_options[ $puppy_gender_key ] ) ? $puppy_gender_options[ $puppy_gender_key ] : '';

	$puppy_dam = get_post_meta( $post_id, 'jmb_mppg_puppy_dam', true );

	$puppy_sire = get_post_meta( $post_id, 'jmb_mppg_puppy_sire', true );

	//$puppy_raiser = get_post_meta( get_the_ID(), 'jmb_mppg_puppy_dam', true );

	if ( $puppy_status ) {
		$puppy_fields['status'] = $puppy_status;
	}
	if ( $puppy_birthdate ) {
		$puppy_fields['birthdate'] = $puppy_birthdate;
	}
	if ( $puppy_breed_name ) {
		$puppy_fields['breed'] = $puppy_breed_name;
	}
	if ( $puppy_gender_name ) {
		$puppy_fields['gender'] = $puppy_gender_name;
	}
	if ( $puppy_dam ) {
		$puppy_fields['dam'] = $puppy_dam;
	}
	if ( $puppy_sire ) {
		$puppy_fields['sire'] = $puppy_sire;
	}

	return $puppy_fields;
}