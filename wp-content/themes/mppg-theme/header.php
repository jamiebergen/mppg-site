<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mppg_Theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

    <script defer src="https://use.fontawesome.com/releases/v5.6.3/js/solid.js" integrity="sha384-F4BRNf3onawQt7LDHDJm/hwm3wBtbLIfGk1VSB/3nn3E+7Rox1YpYcKJMsmHBJIl" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.6.3/js/fontawesome.js" integrity="sha384-treYPdjUrP4rW5q82SnECO7TPVAz4bpas16yuE9F5o7CeBn2YYw1yr5oC8s8Mf8t" crossorigin="anonymous"></script>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'mppg-theme' ); ?></a>

	<header id="masthead" class="site-header">

		<div class="default-grid-container inner-container">
			
			<div class="site-branding">
				<?php
				the_custom_logo();
				if ( is_front_page() && is_home() ) :
					?>
					<h1 class="site-title screen-reader-text"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
				else :
					?>
					<p class="site-title screen-reader-text"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
				endif; ?>
			</div><!-- .site-branding -->

			<div id="site-navigation" class="main-navigation">
				<button id="nav-toggle" class="nav-toggle"><?php esc_html_e( 'OPEN MENU', 'mppg-theme' ); ?></button>
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
