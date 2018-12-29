<?php
/**
 * The template for displaying the archive pages for the puppy CPT
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Mppg_Theme
 */

get_header();
?>

	<header class="page-header">
		<div class="default-grid-container">
			<?php
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="archive-description">', '</div>' );
			?>
		</div>
	</header><!-- .entry-header -->

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php if ( have_posts() ) : ?>

				<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

				    ?>
                    <a class="puppy-archive-block" href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
                        <?php

                        the_post_thumbnail( 'profile-pic' );

                        the_title( '<h2 class="entry-title">', '</h2>' );

                        $puppy_status = get_the_terms( get_the_ID(), 'status' )[0]->name;
                        if ( $puppy_status ) {
                            echo '<p>' . $puppy_status . '</p>';
                        }

                        ?>
                    </a>
                    <?php

				endwhile;

				the_posts_navigation();

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
