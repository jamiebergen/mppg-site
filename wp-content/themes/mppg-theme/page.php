<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Mid-Peninsula_Puppy_Guides
 */

get_header();

$bg_img_url = get_the_post_thumbnail_url( $post->ID, 'full' );
?>

    <header class="entry-header" <?php echo ( $bg_img_url ? 'style="background-image: linear-gradient(rgba(62, 62, 62, 0.6), rgba(62, 62, 62, 0.6)), url(' . $bg_img_url . ')";' : '' ); ?> >
        <div class="default-grid-container">
            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
        </div>
    </header><!-- .entry-header -->

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
