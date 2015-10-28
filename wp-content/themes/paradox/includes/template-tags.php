<?php
/**
 * Custom template tags for Hanna
 *
 * @package Base
 * @since 1.0
 */

if ( ! function_exists('hanna_post_thumbnail') ) :
/**
 * Display the post thumbnail
 *
 * @return void
 */
function hanna_post_thumbnail($postid) {
	if ( post_password_required() || ! has_post_thumbnail() ) {
		return;
	}
	
	$theme_options = get_theme_mod('zilla_theme_options');
	$format = get_post_format();
	
	if( $format == 'link' ) {
		$link_to = get_post_meta($postid, '_zilla_link_url', true);
	} else {
		$link_to = get_the_permalink($postid);
	}
	?>

	<div class="entry-thumbnail">
	<?php if ( is_singular() || is_layout_standard() ) {
		the_post_thumbnail('full');
	} else { ?>
		<a href="<?php echo esc_url($link_to); ?>">
			<?php the_post_thumbnail(); ?>
		</a>
	<?php } ?>
	</div>

<?php }
endif;

if ( ! function_exists('hanna_link_quote') ) :
function hanna_link_quote($postid) {
	$html = '';
	$format = get_post_format($postid);
	if( $format == 'quote' ) {
		$quote = get_post_meta($postid, '_zilla_quote_quote', true);
		$html .= "\n<div class='the-quote'>\n";
		$html .= "\t<blockquote>" . esc_html($quote) . "</blockquote>\n";
		$html .= "</div>\n";
	} elseif( $format == 'link' ) {
		$url = get_post_meta($postid, '_zilla_link_url', true);
		$html .= "\n<div class='the-link'>\n";
		$html .= "<h2><a href='" . esc_url($url) . "'>" . esc_url($url) . "</a></h2>\n";
		$html .= "</div>";
	}
	echo $html;
}
endif;

if ( ! function_exists( 'hanna_get_image_description' ) ) :
/**
 * A simple function to grab the post_content for an image
 *
 * @param  int $p the attachment id
 * @return mixed
 */
function hanna_get_image_description($p) {
	$image = get_post( $p );
	if( $image->post_content ) {
		return '<p class="portfolio-image-description">' . $image->post_content . '</p>';
	}
	return false;
}
endif;

if ( ! function_exists( 'hanna_portfolio_media_feature' ) ) :
/**
 * Add a cool featured image/video/audio to the top of a portfolio post
 *
 * @param  int $p the post id
 * @param  array $meta the custom meta fields
 * @return string HTML string
 */
function hanna_portfolio_media_feature($p, $meta) {
	$output = '<div class="portfolio-media-feature">';

		if( $meta['display_video'] ) {
			$output .= hanna_print_video_html($p);
		} elseif( $meta['display_audio'] ) {
			$output .= hanna_print_audio_html($p);
		} elseif( has_post_thumbnail($p) ) {
			$output .= get_the_post_thumbnail($p, 'full');
			$output .= hanna_get_image_description( get_post_thumbnail_id( $p ) );
		}

	$output .= '</div>';

	echo $output;
}
endif;

if ( ! function_exists( 'hanna_portfolio_media' ) ) :
/**
 * Return the portfolio media portion of content
 * @param  int $p    the post id
 * @param  array $meta the meta content
 * @return string       HTML for output
 */
function hanna_portfolio_media($p, $meta) {
	$output = '<div class="portfolio-media-main">';

		if( $meta['display_video'] ) {
			// if showing a video, it gets featured spot
			if( $meta['display_gallery'] && $meta['display_audio'] ) {
				// if showing audio and gallery, add audio to gallery code
				add_filter('hanna_filter_gallery_content', 'hanna_add_audio_to_gallery', 10, 2);
				// add gallery to output
				$output .= hanna_post_gallery($p, 'full', 'stacked');
			} elseif( $meta['display_audio'] ) {
				// showing video and audio; video gets preemo spot, add audio here
				$output .= hanna_print_audio_html($p);
			} elseif( $meta['display_gallery'] ) {
				// showing video and gallery; video gets preemo spot, add gallery here
				$output .= hanna_post_gallery($p, 'full', 'stacked');
			}
		} elseif( $meta['display_audio'] ) {
			// if showing audio it gets featured spot
			if( $meta['display_gallery'] ) {
				// showing audio and gallery; audio gets preemo spot, add gallery here
				$output .= hanna_post_gallery($p, 'full', 'stacked');
			}
		} elseif( $meta['display_gallery'] ) {
			// displaying only a gallery; featured image in preemo spot, add gallery here
			$output .= hanna_post_gallery($p, 'full', 'stacked');
		}

	$output .= '</div>';

	echo $output;
}
endif;

function hanna_add_audio_to_gallery($html, $postid) {
	return hanna_print_audio_html($postid) . $html;
}

if ( !function_exists( 'hanna_post_gallery' ) ) :
/**
 * Print the HTML for galleries
 *
 * @since 1.0
 *
 * @param int $id ID of the post
 * @param string $imagesize Optional size of image
 * @param string $layout Optional layout format
 * @param int/string $imagesize the image size
 * @return void
 */
function hanna_post_gallery( $postid, $imagesize = '', $layout = 'slideshow' ) {

	if ( get_post_type($postid) == 'portfolio' ) {
		$image_ids_raw = get_post_meta($postid, '_tzp_gallery_images_ids', true);
	} else {
		$image_ids_raw = get_post_meta($postid, '_zilla_image_ids', true);
	}

	if( $image_ids_raw != '' ) {
		// custom gallery created
		$image_ids = explode(',', $image_ids_raw);
		$orderby = 'post__in';
		$post_parent = null;
	} else {
		// pull all images attached to post
		$image_ids = '';
		$orderby = 'menu_order';
		$post_parent = $postid;
	}

	// get the gallery images
	$args = array(
		'include' => $image_ids,
		'numberposts' => -1,
		'orderby' => $orderby,
		'order' => 'ASC',
		'post_type' => 'attachment',
		'post_parent' => $post_parent,
		'post_mime_type' => 'image',
		'post_status' => 'null'
	);
	$attachments = get_posts($args);

	$output = '';

	if( !empty($attachments) ) {
		$output .= "<div class='zilla-gallery-container'>";
			$output .= "<!--BEGIN #zilla-gallery-$postid -->\n<div id='zilla-gallery-" . esc_attr($postid) . "' class='zilla-gallery " . esc_attr($layout) . "' data-cycle-pager='.zilla-gallery-pager-" . esc_attr($postid) . "' data-cycle-pager-active-class='zilla-active-pager' data-cycle-pager-template='<a href=#> {{slideNum}} </a>' data-cycle-caption='#custom-caption' data-cycle-caption-template='{{cycleTitle}}'>";

				// create a fragment so that we can add a filter to be hooked into
				$fragment = '';
				foreach( $attachments as $attachment ) {
					$src = wp_get_attachment_image_src( $attachment->ID, $imagesize );
					$caption = $attachment->post_excerpt;
					$cycleCaption = ($caption && !is_home() && !is_archive()) ? ' data-cycle-title="' . htmlentities($caption) . '" ' : ' data-cycle-title="" ';
					$alt = ( !empty($attachment->post_content) ) ? $attachment->post_content : $attachment->post_title;
		            $fragment .= "<div $cycleCaption class='slide'><img height='" . esc_attr($src[2]) . "' width='" . esc_attr($src[1]) . "' src='" . esc_url($src[0]) . "' alt='" . esc_attr($alt) . "' />";
		            if( $caption && $layout != 'slideshow' ) { $fragment .= "<div class='wp-caption'>$caption</div>"; }
		            $fragment .= "</div>";
				}
				$fragment = apply_filters('hanna_filter_gallery_content', $fragment, $postid);
				$output .= $fragment;

				if( $layout == 'slideshow' ) { $output .= '<div class="zilla-gallery-pager zilla-gallery-pager-' . esc_attr($postid) . '"></div>'; }
			$output .= '</div>';
			
		$output .= '</div>';
	}

	return $output;
}
endif;

if ( !function_exists('hanna_print_video_html') ) :
/**
 * Prints the WP Vidio Shortcode to output the HTML for video
 * @param  int $postid The post ID
 * @return string         The "html" for printing video elements
 */
function hanna_print_video_html($postid) {
	$output = '';

	$posttype = get_post_type($postid);

	$keys = array(
		'post' => array(
			'embed' => '_zilla_video_embed_code',
			'poster' => '_zilla_video_poster_url',
			'm4v' => '_zilla_video_m4v',
			'ogv' => '_zilla_video_ogv',
			'mp4' => 'a_field'
		),
		'portfolio' => array(
			'embed' => '_tzp_video_embed',
			'poster' => '_tzp_video_poster_url',
			'm4v' => '_tzp_video_file_m4v',
			'ogv' => '_tzp_video_file_ogv',
			'mp4' => '_tzp_video_file_mp4'
		)
	);

	$embed = get_post_meta( $postid, $keys[$posttype]['embed'], true);
	if( $embed ) {
		// Output the embed code if provided
		$output .= '<div class="wp-video">' . html_entity_decode( esc_html( $embed ) ) . '</div>';
	} else {
		// Build the video "shortcode"
		$poster = get_post_meta( $postid, $keys[$posttype]['poster'], true );
		$m4v = get_post_meta( $postid, $keys[$posttype]['m4v'], true );
		$ogv = get_post_meta( $postid, $keys[$posttype]['ogv'], true );
		$mp4 = get_post_meta( $postid, $keys[$posttype]['mp4'], true );

		$attr = array('width' => '2000');
		if( $poster ) $attr['poster'] = $poster;
		if( $m4v ) $attr['m4v'] = $m4v;
		if( $ogv ) $attr['ogv'] = $ogv;
		if( $mp4 ) $attr['mp4'] = $mp4;

		$output .= '<div class="wp-video">' . wp_video_shortcode( $attr ) . '</div>';
	}

	return $output;
}
endif;

if ( !function_exists('hanna_print_audio_html') ) :
/**
 * Prints the WP Audio Shortcode to output the HTML for audio
 * @param  int $postid The post ID
 * @return string         The "hmtl" for printing audio elements
 */
function hanna_print_audio_html($postid) {
	$output = '';

	$posttype = get_post_type($postid);

	$keys = array(
		'post' => array(
			'mp3' => '_zilla_audio_mp3',
			'ogg' => '_zilla_audio_ogg'
		),
		'portfolio' => array(
			'mp3' => '_tzp_audio_file_mp3',
			'ogg' => '_tzp_audio_file_ogg'
		)
	);

	// Print an image if needed
	if( $posttype == 'portfolio' ) {
		$img = get_post_meta( $postid, '_tzp_audio_poster_url', true );
		if( $img ) {
			$output .= '<img src="' . esc_url_raw($img) . '" alt="' . esc_attr( get_the_title($postid) ) . '" />';
		}
	} elseif( has_post_thumbnail($postid) ) {
		$size = 'post-thumbnail';
		if( is_singular() ) {
			$size = 'full';
		}
		$output .= get_the_post_thumbnail($postid, $size);
	}

	// Build the "shortcode"
	$mp3 = get_post_meta( $postid, $keys[$posttype]['mp3'], true );
	$ogg = get_post_meta( $postid, $keys[$posttype]['ogg'], true );
	$attr = array();
	if( $mp3 ) $attr['mp3'] = $mp3;
	if( $ogg) $attr['ogg'] = $ogg;

	$output .= wp_audio_shortcode($attr);

	return $output;
}
endif;

if ( ! function_exists('hanna_post_title') ) :
/**
 * Display the post title
 *
 * @return void
 */
function hanna_post_title() {
	if ( is_single() ) {
		the_title( '<h1 class="entry-title">', '</h1>');
	} else {
		the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>');
	}
}
endif;

if( !function_exists('hanna_post_meta_header') ) :
/**
 * Print HTML meta information for current post
 *
 * @return void
 */
function hanna_post_meta_header() {
	$theme_options = get_theme_mod('zilla_theme_options');
	if ( is_singular() || is_layout_standard() ) {
?>
	<!--BEGIN .entry-meta-->
	<div class="entry-meta">
	<?php
		printf( '<span class="author">%1$s <a href="%2$s" title="%3$s" rel="author">%4$s</a></span>',
			__('by', 'zilla'),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __('View all posts by %s', 'zilla' ), get_the_author() ) ),
			get_the_author()
		);
	?>
	<!--END .entry-meta -->
	</div>
	<hr class="hr-center">
<?php
	}
}
endif;

if ( ! function_exists('hanna_the_content') ) :
/**
 * Display the content
 *
 * @return  voide
 */
function hanna_the_content() {
	if( is_singular() ) {
		if( get_the_content() ) { ?>
		<!--BEGIN .entry-content -->
		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages(array('before' => '<p><strong>'.__('Pages: ', 'zilla').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			<?php if( is_singular('post') ) { ?>
				<hr class="hr-center">
			<?php } ?>
		<!--END .entry-content -->
		</div>
		<?php } ?>
	<?php } else { ?>

		<!--BEGIN .entry-summary -->
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		<!--END .entry-summary -->
		</div>

	<?php } ?>
<?php }
endif;

if ( ! function_exists('hanna_post_footer') ) :
/**
 * Display the post footer
 *
 * @return  void
 */
function hanna_post_footer() { ?>
	<footer class="entry-footer">
		<?php if ( is_singular('post') ) {
			printf( '<span class="author">%1$s <a href="%2$s" title="%3$s" rel="author">%4$s</a></span>',
				__('Written by', 'zilla'),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __('View all posts by %s', 'zilla' ), get_the_author() ) ),
				get_the_author()
			);
			echo '<div class="the-categories">' . __('in', 'zilla') . ' '; the_category(', ');
		?>
			<div class="entry-tags"><?php the_tags('', ' ', ''); ?></div>

		<?php } else {

			comments_popup_link(__('No Comments', 'zilla'), __('1 Comment', 'zilla'), __('% Comments', 'zilla'), '', '');

		} ?>

	</footer>
<?php }
endif;

if ( ! function_exists('hanna_author_bio') ) :
/**
 * Display the author bio
 *
 * @package Hanna
 * @since Hanna 1.0
 *
 * @return void
 */
function hanna_author_bio() {
?>
	<!--BEGIN .author-bio-->
	<div class="author-bio">
		<?php if( is_archive() ) { ?>
			<div class="author-avatar">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), 74 ); ?>
			</div><!-- .author-avatar -->
		<?php } ?>
		<div class="author-title"><?php _e('About the author', 'zilla') ?></div>
		<div class="author-description"><?php the_author_meta("description"); ?></div>
	<!--END .author-bio-->
	</div>
<?php
}
endif;

if ( ! function_exists('hanna_page_header' ) ) :
/**
 * Display page header
 *
 * @return void
 */
function hanna_page_header() { ?>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>
<?php }
endif;

if ( ! function_exists( 'hanna_paging_nav' ) ) :
function hanna_paging_nav() {
	// Don't print empty markup
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) )
		return;
	?>

	<!--BEGIN .navigation .page-navigation-->
	<nav class="navigation page-navigation">
	<?php if ( get_next_posts_link() ) { ?>
		<div class="nav-next"><?php next_posts_link( __('<span>&#8249;</span> Older Entries', 'zilla') ); ?></div>
	<?php } ?>
	<?php if ( get_previous_posts_link() ) { ?>
		<div class="nav-previous"><?php previous_posts_link( __('Newer Entries <span>&#8250;</span>', 'zilla') ); ?></div>
	<?php } ?>
	</nav>
	<?php
}
endif;

if ( ! function_exists( 'hanna_post_nav' ) ) :
/**
 * Display nav to prev/next post as needed
 *
 * @return  void
 */
function hanna_post_nav() {
	// Do not print nav links on attachment page
	if ( is_attachment() )
		return;

	// Do not print markup if no prev/next posts to link to
	if ( ! get_adjacent_post( false, '', true ) )
		return;
	?>

	<nav class="navigation single-post-navigation">
		<hr class="hr-center">

		<span><?php _e('Next Post', 'zilla'); ?></span>
		<article class="post">
			<div class="entry-header">
				<h1 class="entry-title"><?php previous_post_link('%link', '%title'); ?></h1>
				<!--BEGIN .entry-meta-->
				<div class="entry-meta">
				<?php
					$next = get_previous_post();
					setup_postdata( $next );
					printf( '<span class="author">%1$s <a href="%2$s" title="%3$s" rel="author">%4$s</a></span>',
						__('by', 'zilla'),
						esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
						esc_attr( sprintf( __('View all posts by %s', 'zilla' ), get_the_author() ) ),
						get_the_author()
					);
				?>
				<!--END .entry-meta -->
				</div>
			</div>

			<?php if( ! post_password_required($next) ) { ?>
			<!--BEGIN .entry-summary -->
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			<!--END .entry-summary -->
			</div>
			<?php } ?>
		</article>
	</nav>
	<?php
}
endif;

if ( ! function_exists( 'hanna_back_to_portfolio' ) ) :
/**
 * Display back to portfolio link
 *
 * @return mixed
 */
function hanna_back_to_portfolio() {
	$portfolio_page = get_pages( array(
		'meta_key' => '_wp_page_template',
		'meta_value' => 'template-portfolio.php'
	));
	if( count($portfolio_page) < 2 ) {
		echo '<div class="back-to-portfolio">';
		echo '<a href="' . esc_url( $portfolio_page[0]->guid ) . '" class="button">' . __('Back to Portfolio', 'zilla') . '</a>';
		echo '</div>';

	}

	return false;
}
endif;

if ( ! function_exists( 'hanna_portfolio_terms' ) ) :
/**
 * Echo the portfolio terms
 *
 * @param  int $postid the post id
 * @since  1.0
 */
function hanna_portfolio_terms($postid) {
	$portfolio_terms = wp_get_object_terms( $postid,  'portfolio-type' );
	if ( ! empty( $portfolio_terms ) && ! is_wp_error( $portfolio_terms ) ) {
		foreach( $portfolio_terms as $term ) {
			$portfolio_terms_list[] = $term->name;
		}
		echo implode(', ', $portfolio_terms_list);
	}
}
endif;

if ( ! function_exists( 'hanna_portfolio_meta' ) ) :
/**
 * Build and echo the portfolio meta information
 *
 * @param  int $postid The post id
 * @since  1.0
 * @return void
 */
function hanna_portfolio_meta($postid) {
	$output = '';

	$url = get_post_meta( $postid, '_tzp_portfolio_url', true);
	$date = get_post_meta( $postid, '_tzp_portfolio_date', true);
	$client = get_post_meta( $postid, '_tzp_portfolio_client', true);

	if( $url || $date || $client ) {
		$output .= '<div class="portfolio-entry-meta"><hr><ul>';
			if( $date ) {
				$output .= sprintf( '<li><strong>%1$s</strong><span class="portfolio-project-date">%2$s</span></li>', __('Date: ', 'zilla'), esc_html( $date ) );
			}
			if( $client ) {
				$output .= sprintf( '<li><strong>%1$s</strong><span class="portfolio-project-client">%2$s</span></li>', __('Client: ', 'zilla'), esc_html( $client ) );
			}
			if( $url ) {
				$output .= sprintf( '<li><strong>%1$s</strong><a class="portfolio-project-url" href="%2$s">%3$s</a></li>', __('URL: ', 'zilla'), esc_url( $url ), esc_url($url) );
			}

		$output .= '</ul><hr></div>';
	}

	echo $output;
}
endif;

if ( ! function_exists( 'hanna_get_the_term_slugs' ) ) :
/**
 * Return a list of tags with the hash
 * @param  int $postid post id
 * @return mixed
 */
function hanna_get_the_term_slugs($postid, $taxonomy) {
	$terms = get_the_terms( $postid, $taxonomy );
	$term_list = '';
	if( !empty($terms) ) {
		foreach( $terms as $term ) {
			$term_list .= 'term-'. $term->slug .' ';
		}
		$term_list = trim($term_list);
	}

	return $term_list;
}
endif;