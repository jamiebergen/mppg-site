<?php
/**
 * The template for displaying the archive pages for the member CPT
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Mid-Peninsula_Puppy_Guides
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

                        if ( get_the_post_thumbnail() ) {
	                        the_post_thumbnail( 'profile-pic' );
                        } else {
                            echo '<i class="fas fa-paw"></i>';
                        }


						the_title( '<h2 class="entry-title">', '</h2>' );

						$member_data = retrieve_member_data( get_the_ID() );

						if ( $member_data['leader'] ) {
							echo '<p>Leader</p>';
						}

						?>
					</a>
					<?php

				endwhile;

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>

		</main><!-- #main -->
		<?php
        wp_pagenavi();
        ?>

	</div><!-- #primary -->

<?php
get_footer();
