<?php
/**
 * The template to display post content for audio post formats
 *
 * @package Hanna
 * @since Hanna 1.0
 */
zilla_post_before(); ?>
<!--BEGIN .post -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php zilla_post_start(); ?>

	<?php 
	if (is_layout_standard()) {
		echo '<div class="media-bg">';
		hanna_post_thumbnail($post->ID);
	}	
	?>
	
	<?php echo hanna_print_video_html($post->ID); ?>
	
	<?php echo is_layout_standard() ? '</div>' : ''; ?>

	<!--BEGIN .entry-header-->
	<header class="entry-header">
		<?php
			hanna_post_title();
			hanna_post_meta_header();
		?>
	<!--END .entry-header-->
	</header>

	<?php
		hanna_the_content();
		hanna_post_footer();
	?>

<?php zilla_post_end(); ?>
<!--END .post-->
</article>
<?php zilla_post_after(); ?>