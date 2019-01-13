<?php
namespace JMB\MidPenPuppyGuides;

/**
 * Send an email to the site administrator when someone submits a puppy or member post
 *
 * @param  integer $speaker_id Speaker post ID
 * @return string|WP_Error     Success message or WP_Error on failure.
 */
function send_administrator_email( $new_submission_id, $post_data, $sanitized_values, $cmb, $post_type ) {

	$admin_email = get_option( 'admin_email' );
	$edit_link = admin_url( '/edit.php?post_status=pending&post_type=' . $post_type );

	/*
	 * The blogname option is escaped with esc_html on the way into the database
	 * in sanitize_option we want to reverse this for the plain text arena of emails.
	 */
	$site_name = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );

	/* translators: Pending post email subject. %s: Site name */
	$subject = sprintf( __( 'Pending profile for [%s]', 'mppg-content' ), $site_name );

	$message = __( 'There is a new pending post for you to review.', 'mppg-content' ) . "\r\n\r\n";

	$message .= __( 'You can review the post from the admin dashboard:', 'mppg-content' ) . "\r\n\r\n";
	$message .= $edit_link . "\r\n";


	if ( $message && ! wp_mail( $admin_email, wp_specialchars_decode( $subject ), $message ) ) {
		wp_die( __( 'The email could not be sent.', 'mppg-content' ) . "<br />\n" . __( 'Possible reason: your host may have disabled the mail() function.', 'mppg-content' ) );
	}

	return true;
}
add_action( 'after_process_frontend_submission', __NAMESPACE__ . '\send_administrator_email', 10, 5 );
