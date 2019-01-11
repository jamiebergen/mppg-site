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

                        <ul class="puppy-stats">

		                    <?php

                            $puppy_data = retrieve_puppy_data( get_the_ID() );

		                    if ( $puppy_data['status'] ) {
			                    echo '<li><strong>Status: </strong>' . $puppy_data['status'] . '</li>';
		                    }
		                    if ( $puppy_data['birthdate'] ) {
			                    echo '<li><strong>Birthdate: </strong>' . $puppy_data['birthdate'] . '</li>';
		                    }
		                    if ( $puppy_data['breed'] ) {
			                    echo '<li><strong>Breed: </strong>' . $puppy_data['breed'] . '</li>';
		                    }
		                    if ( $puppy_data['gender'] ) {
			                    echo '<li><strong>Gender: </strong>' . $puppy_data['gender'] . '</li>';
		                    }
		                    if ( $puppy_data['dam'] && $puppy_data['sire'] ) {
			                    echo '<li><strong>Parents: </strong>' . $puppy_data['dam'] . ' (dam) and ' . $puppy_data['sire'] . ' (sire)</li>';
		                    }

                            // Display raiser(s) and/or connected member(s)
                            if ( $puppy_data['raiser_array'] ) {
	                            $raiser_array = $puppy_data['raiser_array'];

	                            echo '<li><strong>Raiser(s): </strong>';

	                            echo implode( ', ', $raiser_array );

	                            echo '</li>';
                            }

		                    if ( $puppy_data['nickname'] ) {
			                    echo '<li><strong>Nickname: </strong>' . $puppy_data['nickname'] . '</li>';
		                    }

		                    if ( $puppy_data['social'] ) {
			                    echo '<li><strong>Social: </strong><a href="' . $puppy_data['social'] . '">' . $puppy_data['social'] . '</a></li>';
		                    }

                            ?>
                        </ul>
                    </div>

                    <?php

                    if ( get_the_content() ) { ?>

	                    <div class="entry-content">

                            <h2>More about <?php echo get_the_title(); ?></h2>
                            <?php the_content(); ?>

                        </div><!-- .entry-content -->

                    <?php
                    }

                    ?>
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
