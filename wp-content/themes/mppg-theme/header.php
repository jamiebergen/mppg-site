<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Sample_Theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'jmb-sample-theme' ); ?></a>

	<header id="masthead" class="site-header">

		<div class="default-grid-container inner-container">
			
			<div class="site-branding">
				<?php
				the_custom_logo();
				if ( is_front_page() && is_home() ) :
					?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
				else :
					?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
				endif;
				$jmb_sample_theme_description = get_bloginfo( 'description', 'display' );
				if ( $jmb_sample_theme_description || is_customize_preview() ) :
					?>
					<p class="site-description"><?php echo $jmb_sample_theme_description; /* WPCS: xss ok. */ ?></p>
				<?php endif; ?>
			</div><!-- .site-branding -->

			<div id="site-navigation" class="main-navigation">
				<button id="nav-toggle" class="nav-toggle"><?php esc_html_e( 'OPEN MENU', 'jmb-sample-theme' ); ?></button>
				<?php
				wp_nav_menu( array(
				        'container'       => 'nav',
					    'container_class' => 'nav-collapse',
					    'theme_location'  => 'menu-1',
					    'menu_id'         => 'primary-menu',
				) );
				?>
			</div><!-- #site-navigation -->

		</div> <!-- .default-grid-container -->

	</header><!-- #masthead -->

	<div id="content" class="site-content">
