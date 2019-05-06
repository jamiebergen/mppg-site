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
	                <?php
	                wp_nav_menu( array(
		                'theme_location'  => 'menu-4',
		                'menu_id'         => 'footer-left-menu',
	                ) );
	                ?>
                </div>

                <div class="third-box">
                    <h3>For prospective members</h3>
	                <?php
	                wp_nav_menu( array(
		                'theme_location'  => 'menu-2',
		                'menu_id'         => 'footer-middle-menu',
	                ) );
	                ?>
                </div>

                <div class="third-box">
                    <h3>For current members</h3>
	                <?php
	                wp_nav_menu( array(
		                'theme_location'  => 'menu-3',
		                'menu_id'         => 'footer-right-menu',
	                ) );
	                ?>
                </div>
            </div>
        </div><!-- .site-info -->
        <div class="footer-credits">
            <div class="default-grid-container">
                <p>&copy;<?php echo date('Y'); ?> Guide Dogs for the Blind - Palo Alto, CA Puppy Raisers. All rights reserved.</p>
            </div>
        </div>

	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
