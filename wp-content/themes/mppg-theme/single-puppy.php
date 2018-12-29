<?php
/**
 * The template for displaying single puppy posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Mppg_Theme
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
		                    $puppy_status = get_the_terms( get_the_ID(), 'status' )[0]->name;

		                    $puppy_birthdate = get_post_meta( get_the_ID(), 'jmb_mppg_puppy_birthdate', true );

		                    $puppy_breed_key = get_post_meta( get_the_ID(), 'jmb_mppg_puppy_breed', true );
		                    $puppy_breed_options = JMB\MidPenPuppyGuides\breed_select_options();
		                    $puppy_breed_name = isset( $puppy_breed_options[ $puppy_breed_key ] ) ? $puppy_breed_options[ $puppy_breed_key ] : '';

		                    $puppy_gender_key = get_post_meta( get_the_ID(), 'jmb_mppg_puppy_gender', true );
		                    $puppy_gender_options = JMB\MidPenPuppyGuides\gender_select_options();
		                    $puppy_gender_name = isset( $puppy_gender_options[ $puppy_gender_key ] ) ? $puppy_gender_options[ $puppy_gender_key ] : '';

		                    $puppy_dam = get_post_meta( get_the_ID(), 'jmb_mppg_puppy_dam', true );

		                    $puppy_sire = get_post_meta( get_the_ID(), 'jmb_mppg_puppy_sire', true );

		                    //$puppy_raiser = get_post_meta( get_the_ID(), 'jmb_mppg_puppy_dam', true );


		                    if ( $puppy_status ) {
			                    echo '<p><strong>Status: </strong>' . $puppy_status . '</p>';
		                    }
		                    if ( $puppy_birthdate ) {
			                    echo '<p><strong>Birthdate: </strong>' . $puppy_birthdate . '</p>';
		                    }
		                    if ( $puppy_breed_name ) {
			                    echo '<p><strong>Breed: </strong>' . $puppy_breed_name . '</p>';
		                    }
		                    if ( $puppy_gender_name ) {
			                    echo '<p><strong>Gender: </strong>' . $puppy_gender_name . '</p>';
		                    }
		                    if ( $puppy_dam && $puppy_sire ) {
			                    echo '<p><strong>Parents: </strong>' . $puppy_dam . ' (dam) and ' . $puppy_sire . ' (sire)</p>';
		                    }
		                    // $puppy_raiser
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
