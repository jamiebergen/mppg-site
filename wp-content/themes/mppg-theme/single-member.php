<?php
/**
 * The template for displaying single member posts
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

                    <div class="member-main-bio">
                        <div class="member-left">
	                        <?php

	                        $member_data = retrieve_member_data( get_the_ID() );

                            the_post_thumbnail( 'member-single' );
	                        if ( $member_data['since'] ) {
		                        echo '<p><strong>Member since: </strong>' . $member_data['since'] . '</p>';
	                        }
	                        ?>
                        </div>

                        <?php

	                    if ( $member_data['puppies'] ) {

	                        echo '<div class="member-puppies-container">';
                                echo '<h2>Puppies Raised</h2>';

                                echo '<ul class="member-puppies">';

                                foreach ( $member_data['puppies'] as $puppy_id ) { ?>

                                    <li>
                                        <a href="<?php echo esc_url( get_permalink( $puppy_id ) ); ?>" rel="bookmark">

		                                    <?php
		                                    echo get_the_post_thumbnail( $puppy_id, 'small-profile-pic' );
		                                    echo '<p>' . esc_html( get_the_title( $puppy_id ) ) . '</p>';
		                                    ?>
                                        </a>
                                    </li>

                                    <?php
                                }

                                echo '</ul>';
		                    echo '</div>';
	                    } ?>


                    </div><!-- .member-main-bio -->

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
