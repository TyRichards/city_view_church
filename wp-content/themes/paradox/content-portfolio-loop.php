<?php
/**
 * The template for looping through portfolios and displaying their content.
 *
 * @package  Hanna
 * @since  Hanna 1.0
 */

$terms = get_terms( 'portfolio-type', array('hierarchical' => false, 'order' => 'DESC') );
if( count($terms) ){
	echo '<div class="portfolio-nav-container">';
	echo '<ul class="portfolio-type-nav">';
		foreach( $terms as $term ) {
			echo '<li><a href="'. get_term_link($term) .'" data-filter=".term-'. $term->slug .'"># '. $term->name .'</a></li>';
		}
		echo '<li><a href="#" data-filter="*" class="active"># '. __( 'All', 'zilla' ) .'</a></li>';
	echo '</ul></div>';
}

// main portfolio
$args = array(
	'post_type' => 'portfolio',
	'orderby' => 'menu_order',
	'order' => 'ASC',
	'posts_per_page' => -1,
	'update_post_meta_cache' => false
);
$query = new WP_Query($args);

if( $query->have_posts() ) :

	echo '<div class="portfolio-hr-container"><hr class="portfolio-hr"></div>';

	echo '<div id="portfolio-feed" class="portfolio-feed clearfix">';

	while( $query->have_posts() ) : $query->the_post();

		get_template_part('content', 'portfolio-simple');

	endwhile;

	echo '</div>';

endif;

wp_reset_query();