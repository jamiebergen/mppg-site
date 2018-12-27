<?php
namespace JMB\MidPenPuppyGuides;

function puppy_member_connection_setup() {
	p2p_register_connection_type( array(
		'name' => 'members_to_puppies',
		'from' => 'member',
		'to' => 'puppy'
	) );
}
add_action( 'p2p_init',  __NAMESPACE__ . '\puppy_member_connection_setup' );