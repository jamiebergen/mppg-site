<?php
/**
 * Plugin Name:     MPPG Front-End Content
 * Plugin URI:      https://jamiebergen.com/
 * Description:     Utility plugin for registering content types, taxonomies, data handling, and front-end submission functionality
 * Author:          Jamie Bergen
 * Author URI:      https://jamiebergen.com/
 * Text Domain:     mppg-content
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Mppg_Content
 */

namespace JMB\MidPenPuppyGuides;

/**
 * Base plugin file includes.
 *
 * @since 0.1.0
 */
function plugin_includes() {
	// Custom post types
	require_once 'post-types/puppy.php';
	require_once 'post-types/member.php';

	// Custom taxonomies
	require_once 'taxonomies/status.php';

	// Custom fields
	require_once 'custom-fields/puppy.php';
	require_once 'custom-fields/member.php';

	// Custom functionality
	require_once 'includes/front-end.php';
	require_once 'includes/helpers.php';
	require_once 'includes/p2p.php';
}

add_action( 'plugins_loaded', __NAMESPACE__ . '\plugin_includes' );