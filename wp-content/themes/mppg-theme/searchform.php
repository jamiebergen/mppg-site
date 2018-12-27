<?php
/**
 * Custom Search Form
 *
 * Search form with Submit text replaced with icon and submit input replaced with button.
 * Same markup otherwise
 *
 * @link https://developer.wordpress.org/reference/functions/get_search_form/
 *
 * @package Sample_Theme
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ) ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_attr_x( 'Search for:', 'label', 'jmb-sample-theme' )?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'jmb-sample-theme' ) ?>" value="<?php echo get_search_query() ?>" name="s" />
	</label>
	<button type="submit" class="search-submit">
        <i class="dashicons dashicons-search" aria-hidden="true"></i>
        <span class="screen-reader-text"><?php echo esc_attr_x( 'Submit', 'submit button', 'jmb-sample-theme' ); ?></span>
    </button>
</form>

