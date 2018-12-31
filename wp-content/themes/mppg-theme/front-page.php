<?php
/**
 * The template for displaying the front page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Mid-Peninsula_Puppy_Guides
 */

$title = get_bloginfo( 'title', 'display' );
$description = get_bloginfo( 'description', 'display' );

get_header(); ?>

<div class="content-area">
<!--        <main id="main" class="site-main">-->

<div class="home-top">
    <div class="full-row default-grid-container">
        <div id="home-top-text">
            <h1 class="site-title"><?php echo $title; ?></h1>
            <p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
            <a class="mppg-cta" href="">Learn about our club <i class="fas fa-angle-double-right"></i></a>
        </div>
    </div>
</div>

<div class="default-grid-container narrow row-container">
    <div class="line-under">
        <h2>Welcome to our club!</h2>
        <p class="minor-text larger-text">Mid-Peninsula Puppy Guides is a local puppy raising club affiliated with Guide Dogs for the Blind, Inc. We are located on the San Francisco peninsula in California.</p>
    </div>
</div>

<div class="default-grid-container row-container">

    <div class="thirds">
        <div class="third-box">
            <i class="fas fa-paw"></i>
            <h3>Who we are</h3>
            <p class="minor-text">We are volunteer puppy raisers and puppy sitters of all ages and from all walks of life.</p>
        </div>

        <div class="third-box">
            <i class="fas fa-paw"></i>
            <h3>What we do</h3>
            <p class="minor-text">Our club raises puppies from 8 weeks to 16-18 months of age. We teach the puppies basic obedience.</p>
        </div>

        <div class="third-box">
            <i class="fas fa-paw"></i>
            <h3>How you can help</h3>
            <p class="minor-text">The club is always looking for new members who are interested in becoming puppy sitters or raisers.</p>
        </div>
    </div>

    <div class="button-row">
        <a class="mppg-cta" href="">Find out how to get involved</a>
    </div>

</div>

<div class="banner-row default-grid-container newest-puppy">
    <div class="puppy-text">
        <h2>Meet our newest member.</h2>

	    <?php
	    // Retrieve info for latest puppy
	    $args = array( 'numberposts' => '1', 'post_type' => 'puppy' );
	    $recent_posts = wp_get_recent_posts( $args );
	    foreach( $recent_posts as $recent ){

		    $puppy_data = retrieve_puppy_data( $recent["ID"] );

	        echo '<p class="minor-text larger-text">';
		        echo $recent["post_title"];
		        echo ' is a ';
		        echo strtolower( $puppy_data['gender'] );
		        echo ' ';
		        echo strtolower( $puppy_data['breed'] );
		        if ($puppy_data['raiser']) {
			        echo ' being raised by ';
			        echo $puppy_data['raiser'];
                }
                echo '.';
            echo '</p>';

            echo '<a class="mppg-cta" href="' . get_permalink($recent["ID"]) . '">' . 'Learn more about ' . $recent["post_title"] . '</a>';

	    }
	    wp_reset_query();
	    ?>

    </div>

    <?php
    echo get_the_post_thumbnail( $recent["ID"], 'profile-pic' );
    ?>
<!--    <figure class="puppy-img">-->
<!--        <img src="https://loremflickr.com/320/320/puppy" alt="" />-->
<!--        <figcaption>Image description: A dog.</figcaption>-->
<!--    </figure>-->



</div>

<!--        </main><!-- #main -->
</div>

<?php
get_footer();
