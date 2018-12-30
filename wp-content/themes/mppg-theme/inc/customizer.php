<?php
/**
 * Mid-Peninsula Puppy Guides Theme Theme Customizer
 *
 * @package Mid-Peninsula_Puppy_Guides
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mppg_theme_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'mppg_theme_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'mppg_theme_customize_partial_blogdescription',
		) );
	}

	/**
	 * Add 'Home Top' Section.
	 */
	$wp_customize->add_section(
	// $id
		'mppg_theme_section_home_top',
		// $args
		array(
			'title'			=> __( 'Home Top', 'mppg-theme' ),
			// 'description'	=> __( 'Some description for the options in the Home Top section', 'theme-slug' ),
			'active_callback' => 'is_front_page',
		)
	);

	/**
	 * Add 'Home Top Background Image' Setting.
	 */
	$wp_customize->add_setting(
	// $id
		'mppg_theme_home_top_background_image',
		// $args
		array(
			'default'		=> get_stylesheet_directory_uri() . '/images/Black_lab_with_jacket.jpg',
			'sanitize_callback'	=> 'esc_url_raw',
			'transport'		=> 'postMessage'
		)
	);

	/**
	 * Add 'Home Top Background Image' image upload Control.
	 */
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
		// $wp_customize object
			$wp_customize,
			// $id
			'mppg_theme_home_top_background_image',
			// $args
			array(
				'settings'		=> 'mppg_theme_home_top_background_image',
				'section'		=> 'mppg_theme_section_home_top',
				'label'			=> __( 'Home Top Background Image', 'mppg-theme' ),
				'description'	=> __( 'Select the image to be used for Home Top Background.', 'mppg-theme' )
			)
		)
	);
}
add_action( 'customize_register', 'mppg_theme_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function mppg_theme_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function mppg_theme_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Writes the Home Top background image out to the 'head' element of the document
 * by reading the value from the theme mod value in the options table.
 */
function mppg_customizer_css() {
	?>
	<style type="text/css">
		<?php
			if ( get_theme_mod( 'mppg_theme_home_top_background_image' ) ) {
				$home_top_background_image_url = get_theme_mod( 'mppg_theme_home_top_background_image' );
			} else {
				$home_top_background_image_url = get_stylesheet_directory_uri() . '/images/Black_lab_with_jacket.jpg';
			}

			// if ( 0 < count( strlen( ( $home_top_background_image_url = get_theme_mod( 'mppg_theme_home_top_background_image', sprintf( '%s/images/minimography_005_orig.jpg', get_stylesheet_directory_uri() ) ) ) ) ) ) { ?>
		.home-top {
			background-image: linear-gradient(rgba(62, 62, 62, 0.3), rgba(62, 62, 62, 0.3)), url( <?php echo $home_top_background_image_url; ?> );
		}
		<?php // } // end if ?>
	</style>
	<?php
} // end mppg_customizer_css

add_action( 'wp_head', 'mppg_customizer_css');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function mppg_theme_customize_preview_js() {
	wp_enqueue_script( 'mppg-theme-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'mppg_theme_customize_preview_js' );
