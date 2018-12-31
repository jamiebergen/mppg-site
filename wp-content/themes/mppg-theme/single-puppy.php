<?php
/**
 * The template for displaying single puppy posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Mid-Peninsula_Puppy_Guides
 */

get_header();
?>

	<header class="entry-header">
		<div class="default-grid-container">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</div>
	</header><!-- .entry-header -->

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php
			while ( have_posts() ) :
				the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <div class="puppy-main-bio">

	                    <?php the_post_thumbnail( 'profile-pic' ); ?>

                        <div class="puppy-stats">

		                    <?php

                            $puppy_data = retrieve_puppy_data( get_the_ID() );

		                    if ( $puppy_data['status'] ) {
			                    echo '<p><strong>Status: </strong>' . $puppy_data['status'] . '</p>';
		                    }
		                    if ( $puppy_data['birthdate'] ) {
			                    echo '<p><strong>Birthdate: </strong>' . $puppy_data['birthdate'] . '</p>';
		                    }
		                    if ( $puppy_data['breed'] ) {
			                    echo '<p><strong>Breed: </strong>' . $puppy_data['breed'] . '</p>';
		                    }
		                    if ( $puppy_data['gender'] ) {
			                    echo '<p><strong>Gender: </strong>' . $puppy_data['gender'] . '</p>';
		                    }
		                    if ( $puppy_data['dam'] && $puppy_data['sire'] ) {
			                    echo '<p><strong>Parents: </strong>' . $puppy_data['dam'] . ' (dam) and ' . $puppy_data['sire'] . ' (sire)</p>';
		                    }
		                    if ( $puppy_data['raiser'] ) {
			                    echo '<p><strong>Raiser: </strong>' . $puppy_data['raiser'] . '</p>';
		                    }
                            ?>
                        </div>
                    </div>

                    <div class="entry-content">

                        <?php the_content(); ?>

                    <?php
                    wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mppg-theme' ),
                        'after'  => '</div>',
                    ) );
                    ?>

                    </div><!-- .entry-content -->


					<footer class="entry-footer">
						<?php mppg_theme_entry_footer(); ?>
					</footer><!-- .entry-footer -->
				</article><!-- #post-<?php the_ID(); ?> -->

				<?php
			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
