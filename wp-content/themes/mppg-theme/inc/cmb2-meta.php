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

	$puppy_social = get_post_meta( $post_id, 'jmb_mppg_puppy_social', true );

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
	if ( $puppy_social ) {
		$puppy_fields['social'] = esc_url( $puppy_social );
	}

	// Get connected members
	$connected_members = new WP_Query( array(
		'connected_type' => 'members_to_puppies',
		'connected_items' => get_post( $post_id ),
		'nopaging' => true,
		'orderby' => 'title',
		'order' => 'ASC',
	) );

	if ( $connected_members->have_posts() ) {

		$puppy_fields['members'] = array();

		while ( $connected_members->have_posts() ) {
			$connected_members->the_post();

			array_push( $puppy_fields['members'], get_the_ID() );
		}
	}
	wp_reset_postdata();

	if ( $puppy_fields['members'] || $puppy_fields['raisers'] ) {

		$raiser_array = array();

		if ( $puppy_fields['members'] ) {

			foreach ( $puppy_fields['members'] as $member_id ) {

				$member_link = '<a href="' . get_permalink( $member_id ) . '">' . get_the_title( $member_id ) . '</a>';
				array_push( $raiser_array, $member_link );
			}
		}

		if ( $puppy_fields['raisers'] ) {
			array_push( $raiser_array, $puppy_fields['raisers'] );
		}

		$puppy_fields['raiser_array'] = $raiser_array;
	}

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

	$member_leader = get_post_meta( $post_id, 'jmb_mppg_member_leader', true );

	if ( $member_since ) {
		$member_fields['since'] = $member_since;
	}

	if ( $member_leader ) {
		$member_fields['leader'] = $member_leader;
	}

	// Get connected puppies
	$connected_puppies = new WP_Query( array(
		'connected_type' => 'members_to_puppies',
		'connected_items' => get_queried_object(),
		'nopaging' => true,
		'meta_key' => 'jmb_mppg_puppy_birthdate',
		'orderby' => 'meta_value',
		'order' => 'DESC',
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