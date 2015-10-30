<?php
/**
 * Template Name: Home
 * Description: A custom home page template
 *
 * @package  Hanna
 * @since  Hanna 1.0
 */

$theme_options = get_theme_mod('zilla_theme_options');
get_header(); ?>

	<!--BEGIN #primary .site-main-->
	<div id="primary" class="site-main" role="main">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<?php zilla_page_before(); ?>
		<!--BEGIN .page-->
		<article id="post-<?php the_ID(); ?>" <?php post_class() ?>>
		<?php zilla_page_start(); ?>

			<!-- "Simple Responsive Slider" Slides from plugin -->
			<div class="entry-thumbnail">
				<?php if ( function_exists( 'show_simpleresponsiveslider' ) ) show_simpleresponsiveslider(); ?>
			</div>

			<!-- default feature image setup that comes with theme -->			
			<?php
				/* hanna_post_thumbnail($post->ID); */
				hanna_the_content();
			?>

		<?php zilla_page_end(); ?>
		<!--END .page-->
		</article>
		<?php zilla_page_after(); ?>

	<?php endwhile; endif;

	if( $theme_options['portfolio_show_featured_portfolios_on_home'] ) {
		get_template_part('content', 'portfolio-feature');
	} ?>

<?php get_footer(); ?>