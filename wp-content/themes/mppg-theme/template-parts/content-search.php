<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Mid-Peninsula_Puppy_Guides
 */

?>

<a class="puppy-archive-block" href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
	<?php

	the_post_thumbnail( 'profile-pic' );

	the_title( '<h2 class="entry-title">', '</h2>' );

	$puppy_data = retrieve_puppy_data( get_the_ID() );

	if ( $puppy_data['status'] ) {
		echo '<p>' . $puppy_data['status'] . '</p>';
	}

	?>
</a>
