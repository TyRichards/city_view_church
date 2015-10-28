<?php
/**
 * Template Name: Location
 *
 * Custom page template for displaying a contact form in page
 *
 * @package Hanna
 * @since Hanna 1.0
 */

$opts = get_option('zilla_theme_options');

get_header(); ?>

	<!--BEGIN #primary .site-main-->
	<div id="primary" class="site-main" role="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<?php zilla_page_before(); ?>
		<!--BEGIN .page-->
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
		<?php zilla_page_start(); ?>

			<?php
				hanna_post_thumbnail($post->ID);
				hanna_page_header();
			?>

			<!--BEGIN .entry-content -->
			<div class="entry-content">

				<?php // the_content(); ?>

			</div><!-- .entry-content -->

			<div class="contact-extras clearfix">
				<div class="contactform-container">
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				</div>

				<?php $map = get_post_meta( $post->ID, '_zilla_contact_map_embed', true ); ?>

				<?php if( $map ){ ?><div class="contact-map"><?php echo html_entity_decode( $map ); ?></div><?php } ?>
			</div>

		<?php zilla_page_end(); ?>
		<!--END .page-->
		</article>
		<?php zilla_page_after(); ?>

		<?php endwhile; endif; ?>

	<!--END #primary .site-main-->
	</div>

<?php get_footer(); ?>