<?php
/**
 * Mid-Peninsula Puppy Guides Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Mid-Peninsula_Puppy_Guides
 */

if ( ! function_exists( 'mppg_theme_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function mppg_theme_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Mid-Peninsula Puppy Guides Theme, use a find and replace
		 * to change 'mppg-theme' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'mppg-theme', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Enable support for three nav menus.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'mppg-theme' ),
			'menu-2' => esc_html__( 'Footer Middle', 'mppg-theme' ),
			'menu-3' => esc_html__( 'Footer Right', 'mppg-theme' ),
			'menu-4' => esc_html__( 'Footer Left', 'mppg-theme' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'mppg_theme_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		/**
		 * Add support for wide images with Gutenberg
		 *
		 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/
		 */
		add_theme_support( 'align-wide' );

		/**
		 * Add custom image size
		 *
		 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/
		 */
		add_image_size( 'profile-pic', 300, 300, true );
		add_image_size( 'small-profile-pic', 150, 150, true );
		add_image_size( 'member-single', 500, 500 );
	}
endif;
add_action( 'after_setup_theme', 'mppg_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function mppg_theme_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'mppg_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'mppg_theme_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function mppg_theme_scripts() {
	wp_enqueue_style( 'mppg-theme-style', get_stylesheet_uri() );

	wp_enqueue_script( 'mppg-theme-responsive-nav', get_template_directory_uri() . '/js/responsive-nav.js', array(), '20151215', true );
	wp_enqueue_script( 'mppg-theme-nav-init', get_template_directory_uri() . '/js/navigation.js', array( 'mppg-theme-responsive-nav' ), '20151215', true );

	wp_enqueue_script( 'mppg-theme-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Add Google Fonts: Lora and Lato  
  	wp_enqueue_style( 'mppg-theme-google-fonts', 'https://fonts.googleapis.com/css?family=Lato|Lora:400' );

  	// Make dashicons available on front end
  	wp_enqueue_style( 'dashicons' );
}
add_action( 'wp_enqueue_scripts', 'mppg_theme_scripts' );

/**
 * Use puppy archive template for status taxonomy pages.
 */
function mppg_theme_template_redirect( $template ) {
	if ( is_tax( 'status' ) ) {
		$template = get_query_template( 'archive-puppy' );
	}
	return $template;
}
add_filter( 'template_include', 'mppg_theme_template_redirect' );

/**
 * Display puppies in order of birthdate.
 */
function mppg_theme_pre_get_posts_status( $query ) {
	if ( ( $query->is_post_type_archive( 'puppy' ) || $query->is_tax( 'status' ) ) && ! is_admin() && $query->is_main_query() )  {
		$query->set( 'meta_key', 'jmb_mppg_puppy_birthdate' );
		$query->set( 'orderby', 'meta_value' );
		$query->set( 'order', 'DESC' );
	}
}
add_action( 'pre_get_posts', 'mppg_theme_pre_get_posts_status' );

/**
 * Display members in order of name.
 */
function mppg_theme_pre_get_posts_members( $query ) {
	if ( $query->is_post_type_archive( 'member' )  && ! is_admin() && $query->is_main_query() )  {
		$query->set( 'orderby', 'title' );
		$query->set( 'order', 'ASC' );
	}
}
add_action( 'pre_get_posts', 'mppg_theme_pre_get_posts_members' );

/**
 * Display only puppies in search results.
 */
function mppg_theme_only_puppies_in_search( $query ) {
	if ( $query->is_main_query() && ! is_admin() && is_search() ) {
		$query->set( 'post_type', 'puppy' );
	}
	return $query;
}
add_filter( 'pre_get_posts','mppg_theme_only_puppies_in_search' );

/**
 * Remove prefix from archive titles.
 */
function mppg_theme_filter_archive_title( $title ) {

	if ( is_post_type_archive( array('puppy', 'member') ) ) {
		$title = post_type_archive_title( '', false );
	}
	if ( is_tax( 'status' ) ) {
		$title = single_term_title( '', false );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'mppg_theme_filter_archive_title' );

/**
 * Add active menu class for terms, archives, and single cpt posts.
 */
function mppg_theme_menu_item_classes( $classes, $item, $args ) {

	if( ( is_singular( 'puppy' ) || is_post_type_archive( 'puppy' ) || is_tax( 'status' ) ) && 'Puppies' == $item->title ) {
		$classes[] = 'current-menu-item';
	}
	if( ( is_singular( 'member' ) || is_post_type_archive( 'member' ) ) && 'Members' == $item->title ) {
		$classes[] = 'current-menu-item';
	}
	return array_unique( $classes );
}
add_filter( 'nav_menu_css_class', 'mppg_theme_menu_item_classes', 10, 3 );

/**
 * Retrieve CMB2 meta fields.
 */
require get_template_directory() . '/inc/cmb2-meta.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

