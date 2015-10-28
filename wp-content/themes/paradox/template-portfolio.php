<?php
/**
 * Template Name: Portfolio
 * Description: A portfolio page template for displaying portfolio posts
 *
 * @package  Hanna
 * @since Hanna 1.0
 */

get_header(); ?>

	<!--BEGIN #primary .site-main-->
	<div id="primary" class="site-main" role="main">

	<?php while (have_posts()) : the_post(); ?>

		<?php zilla_page_before(); ?>
		<!--BEGIN .page-->
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
		<?php zilla_page_start(); ?>

			<?php
				hanna_page_header();
				hanna_the_content();
			?>

		<?php zilla_page_end(); ?>
		<!--END .page-->
		</article>
		<?php zilla_page_after(); ?>

	<?php endwhile;

	if( ! post_password_required() ) {
		get_template_part( 'content', 'portfolio-loop' );
	} ?>

	<!--END #primary .site-main-->
	</div>

<?php get_footer(); ?>