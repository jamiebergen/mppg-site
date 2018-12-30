<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mid-Peninsula_Puppy_Guides
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">

        <div class="site-info">
            <div class="thirds default-grid-container">
                <div class="third-box">
                    <h3>Mid-Peninsula Puppy Guides</h3>
                    <ul>
                        <li><a href="https://www.facebook.com/midpenpuppyguides/">Follow us on Facebook</a></li>
                        <li><a href="#">Accessibilty statement</a></li>
                    </ul>
                </div>

                <div class="third-box">
                    <h3>Quick links for prospective members</h3>
	                <?php
	                wp_nav_menu( array(
		                'theme_location'  => 'menu-2',
		                'menu_id'         => 'footer-middle-menu',
	                ) );
	                ?>
                </div>

                <div class="third-box">
                    <h3>Quick links for current members</h3>
	                <?php
	                wp_nav_menu( array(
		                'theme_location'  => 'menu-3',
		                'menu_id'         => 'footer-right-menu',
	                ) );
	                ?>
                </div>
            </div>
            <div class="footer-credits full-row default-grid-container">
                <p>&copy;<?php echo date('Y'); ?> Mid-Peninsula Puppy Guides. All rights reserved. Site by <a href="<?php echo esc_url( 'https://jamiebergen.com/' ); ?>">Jamie Bergen</a></p>
            </div>

        </div><!-- .site-info -->

	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
