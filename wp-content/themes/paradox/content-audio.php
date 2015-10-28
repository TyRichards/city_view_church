<?php
/**
 * The template to display post content for audio post formats
 *
 * @package Hanna
 * @since 1.0
 */

zilla_post_before(); ?>
<!--BEGIN .post -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php zilla_post_start(); ?>

	<?php echo hanna_print_audio_html($post->ID); ?>

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