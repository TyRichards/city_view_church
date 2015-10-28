<?php
/**
 * The template to display portfolio content
 *
 * @package Hanna
 * @since Hanna 1.0
 */

$class = ( 'on' == get_post_meta( $post->ID, '_zilla_image_opacity', true ) ) ? 'lower-opacity' : '';
$class = $class . ' ' . $term_list = hanna_get_the_term_slugs($post->ID, 'portfolio-type');

zilla_post_before(); ?>
<!--BEGIN .post -->
<article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
<?php zilla_post_start(); ?>

	<?php
	$portfolio_custom_fields = array();
	$portfolio_custom_fields['display_gallery'] = get_post_meta( $post->ID, '_tzp_display_gallery', true );
	$portfolio_custom_fields['display_audio'] = get_post_meta( $post->ID, '_tzp_display_audio', true );
	$portfolio_custom_fields['display_video'] = get_post_meta( $post->ID, '_tzp_display_video', true );
	?>

	<!--BEGIN .entry-header-->
	<header class="entry-header">
		<?php
		hanna_portfolio_media_feature($post->ID, $portfolio_custom_fields);
		echo '<div class="portfolio-title">';
		hanna_post_title();
		hanna_portfolio_terms($post->ID);
		echo '</div>';
		?>
	<!--END .entry-header-->
	</header>

	<?php
		hanna_the_content();
		hanna_portfolio_meta($post->ID);
		hanna_portfolio_media($post->ID, $portfolio_custom_fields);
		hanna_back_to_portfolio();
	?>

<?php zilla_post_end(); ?>
<!--END .post-->
</article>
<?php zilla_post_after(); ?>