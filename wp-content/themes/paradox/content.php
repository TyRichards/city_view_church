<?php
/**
 * The template to display post content for standard, quote, link, and image
 * post formats
 *
 * @package Hanna
 * @since Hanna 1.0
 */

$class = ( ! get_post_format() && 'on' == get_post_meta( $post->ID, '_zilla_image_opacity', true ) ) ? 'lower-opacity' : '';

zilla_post_before(); ?>
<!--BEGIN .post -->
<article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
<?php zilla_post_start(); ?>

	<?php
	$format = get_post_format();
	if( in_array($format, array('link', 'quote') ) ) {
		hanna_link_quote($post->ID);
	} elseif( $format == 'image' ) {
		hanna_post_thumbnail($post->ID);
	}
	?>

	<!--BEGIN .entry-header-->
	<header class="entry-header">
		<?php if( $format == '' ) {
			hanna_post_thumbnail($post->ID);
		} ?>
		<div class="entry-title-wrapper">
			<?php
				hanna_post_title();
				hanna_post_meta_header();
			?>
		</div>
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