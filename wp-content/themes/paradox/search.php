<?php
/**
 * The template for displaying search results
 *
 * @package Hanna
 * @since Hanna 1.0
 */
get_header(); ?>

	<!--BEGIN #primary .site-main-->
	<div id="primary" class="site-main" role="main">
	<?php if (have_posts()) : ?>

		<header class="page-header">
			<h1 class="page-title"><?php _e('Search Results for', 'zilla') ?> &#8220;<?php the_search_query(); ?>&#8221;</h1>
		</header>

		<ol>
		<?php while (have_posts()) : the_post(); ?>

			<li><?php get_template_part('content', 'search'); ?></li>

		<?php endwhile; ?>
		</ol>

		<?php hanna_paging_nav(); ?>

	<?php else : ?>

		<?php get_template_part('content', 'none'); ?>

	<?php endif; ?>
	<!--END #primary .site-main-->
	</div>

<?php get_footer(); ?>