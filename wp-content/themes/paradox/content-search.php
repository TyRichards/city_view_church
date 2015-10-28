<?php
/**
 * The template to display post content for standard, quote, link, and image
 * post formats
 *
 * @package Hanna
 * @since Hanna 1.0
 */

zilla_post_before(); ?>
<!--BEGIN .post -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php zilla_post_start(); ?>

	<!--BEGIN .entry-header-->
	<header class="entry-header">

		<div class="entry-title-wrapper">
			<?php hanna_post_title(); ?>
		</div>
	<!--END .entry-header-->
	</header>

	<?php hanna_the_content(); ?>

<?php zilla_post_end(); ?>
<!--END .post-->
</article>
<?php zilla_post_after(); ?>