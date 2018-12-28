<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Mppg_Theme
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">

        <div class="site-info">
            <div class="thirds default-grid-container">
                <div class="third-box">
                    <h3>Mid-Peninsula Puppy Guides</h3>
                    <p>Follow us on Facebook</p>
                    <p>Accessibilty statement</p>
                </div>

                <div class="third-box">
                    <h3>Quick links for prospective members</h3>
                    <ul>
                        <li>FAQ</li>
                        <li>How to get involved</li>
                        <li>GDB volunteers page</li>
                    </ul>
                </div>

                <div class="third-box">
                    <h3>Quick links for current members</h3>
                    <ul>
                        <li>Calendar</li>
                        <li>New puppy form</li>
                        <li>New member form</li>
                    </ul>
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
