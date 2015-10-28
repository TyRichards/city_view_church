<?php
/**
 * The template for showing the single post view
 *
 * @package Hanna
 * @since Hanna 1.0
 */
get_header(); ?>

	<!--BEGIN #primary .site-main-->
	<div id="primary" class="site-main" role="main">

		<?php
			// The loop
			while (have_posts()) : the_post();

				get_template_part('content', get_post_format() );

				if ( comments_open() || get_comments_number() ) {
				    comments_template('', true);
				}

				hanna_post_nav();
			endwhile;
		?>

	<!--END #primary .site-main-->
	</div>

<?php get_footer(); ?>