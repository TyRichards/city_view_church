<?php
/**
 * The template for looping through featured portfolios and displaying their content.
 *
 * @package  Hanna
 * @since  Hanna 1.0
 */

$exclude = get_the_ID();

// featured portfolios
$args = array(
	'post_type' => 'portfolio',
	'orderby' => 'menu_order',
	'order' => 'ASC',
	'posts_per_page' => -1,
	'update_post_meta_cache' => false,
	'post__not_in' => array($exclude),
	'meta_query' => array(
		array(
			'key' => '_zilla_base_featured_portfolio',
			'value' => 1,
			'compare' => '='
		)
	)
);
$query = new WP_Query($args);

if( $query->have_posts() ) :

	echo '<div id="portfolio-feature" class="portfolio-feature clearfix">';
		echo '<div class="portfolio-feature-wrapper">';
		echo '<h2>' . __('Featured Videos', 'zilla') . '</h2>';

	$rows = array_chunk($query->get_posts(), 3);
	foreach( $rows as $row ) {
		echo '<div class="portfolio-feature-row clearfix">';
		foreach( $row as $post ) {
			get_template_part('content', 'portfolio-simple');
		}
		echo '</div>';
	}

	echo '</div></div>';

endif;

wp_reset_query();