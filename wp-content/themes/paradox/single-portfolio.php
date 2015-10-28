<?php
/**
 * The template for showing the single portfolio view
 *
 * @package Hanna
 * @since Hanna 1.0
 */

$theme_options = get_theme_mod('zilla_theme_options');
get_header(); ?>

	<!--BEGIN #primary .site-main-->
	<div id="primary" class="site-main" role="main">

	<?php
		// The loop
		while (have_posts()) : the_post();

			get_template_part('content', 'portfolio');

		endwhile;

		if( $theme_options['portfolio_show_featured_portfolios_on_single_portfolio'] ) {
			get_template_part('content', 'portfolio-feature');
		}
	?>

	<!--END #primary .site-main-->
	</div>

<?php get_footer(); ?>