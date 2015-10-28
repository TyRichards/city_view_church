<?php
/**
 * Displays a simplized form of portfolios posts
 *
 * @package  Hanna
 * @since  Hanna 1.0
 */

$term_list = hanna_get_the_term_slugs($post->ID, 'portfolio-type');

zilla_post_before(); ?>
<!--BEGIN .post -->
<article id="post-<?php the_ID(); ?>" <?php post_class($term_list); ?>>
<?php zilla_post_start(); ?>

	<div class="entry-thumbnail">
		<a href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail('portfolio-featured-image'); ?>
		</a>
	</div>

	<?php the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>'); ?>

  <div class="entry-meta">
    <?php hanna_portfolio_terms($post->ID); ?>
  </div>

<?php zilla_post_end(); ?>
<!--END .post-->
</article>
<?php zilla_post_after(); ?>
