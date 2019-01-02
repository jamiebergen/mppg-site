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

	$puppy_raiser = get_post_meta( $post_id, 'jmb_mppg_puppy_raisers', true );

	$puppy_nickname = get_post_meta( $post_id, 'jmb_mppg_puppy_nickname', true );

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
	if ( $puppy_raiser ) {
		$puppy_fields['raisers'] = $puppy_raiser;
	}
	if ( $puppy_nickname ) {
		$puppy_fields['nickname'] = $puppy_nickname;
	}

	// Get connected members
	$connected_members = new WP_Query( array(
		'connected_type' => 'members_to_puppies',
		'connected_items' => get_queried_object(),
		'nopaging' => true,
	) );

	if ( $connected_members->have_posts() ) {

		$puppy_fields['members'] = array();

		while ( $connected_members->have_posts() ) {
			$connected_members->the_post();

			array_push( $puppy_fields['members'], get_the_ID() );
		}
	}
	wp_reset_postdata();

	return $puppy_fields;
}

/**
 * Retrieves member field data
 *
 * @param int $post_id Post id to retrieve data from.
 * @return array
 */
function retrieve_member_data( $post_id ) {

	$member_fields = array();

	$member_since = get_post_meta( $post_id, 'jmb_mppg_member_since', true );

	if ( $member_since ) {
		$member_fields['since'] = $member_since;
	}

	// Get connected puppies
	$connected_puppies = new WP_Query( array(
		'connected_type' => 'members_to_puppies',
		'connected_items' => get_queried_object(),
		'nopaging' => true,
	) );

	if ( $connected_puppies->have_posts() ) {

		$member_fields['puppies'] = array();

		while ( $connected_puppies->have_posts() ) {
			$connected_puppies->the_post();

			array_push( $member_fields['puppies'], get_the_ID() );
		}
	}
	wp_reset_postdata();

	return $member_fields;
}