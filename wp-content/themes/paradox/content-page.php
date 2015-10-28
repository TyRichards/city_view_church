<?php
/**
 * The template to display page content
 *
 * @package  Hanna
 * @since  Hanna 1.0
 */

zilla_page_before(); ?>
<!--BEGIN .page-->
<article id="post-<?php the_ID(); ?>" <?php post_class() ?>>
<?php zilla_page_start(); ?>

	<?php
		hanna_post_thumbnail($post->ID);
		hanna_page_header();
		hanna_the_content();
	?>

<?php zilla_page_end(); ?>
<!--END .page-->
</article>
<?php zilla_page_after(); ?>