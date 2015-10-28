<?php
/**
 * Hanna functions
 *
 * Sets up the theme and provides some helper functions.
 *
 * When using a child theme, you can override certain functions by
 * defining the function within the child theme's functions.php file.
 * It is better to override theme functions via a child theme than to
 * edit directly in this functions.php file. When things go wrong in this
 * file, they go really wrong
 *
 * @package Hanna
 * @since Hanna 1.0
 */


/**
 * Set Max Content Width
 *
 * @since Hanna 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 560;

if( !function_exists( 'zilla_content_width' ) ) :
/**
 * Adjust the content_width for the pages and single image attachment templates.
 *
 * @since 1.0
 *
 * @return void
 */
function zilla_content_width() {
	if ( is_page() || is_attachment() ) {
		global $content_width;
		$content_width = 1160;
	}
}
endif;
add_action( 'template_redirect', 'zilla_content_width' );


if ( !function_exists( 'zilla_theme_setup' ) ) :
/**
 * Sets up theme defaults and registers various features supported
 * by Hanna
 *
 * @uses load_theme_textdoman() For translation support
 * @uses register_nav_menu() To add support for navigation menu
 * @uses add_theme_support() To add support for post-thumbnails and post-formats
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size
 * @uses add_image_size() To add additional image sizes
 *
 * @since Hanna 1.0
 *
 * @return void
 */
function zilla_theme_setup() {

	// Load translation domain
	load_theme_textdomain( 'zilla', get_template_directory() . '/languages' );

	// Register WP 3.0+ Menus
	register_nav_menu( 'primary-menu', __('Primary Menu', 'zilla') );

	// Configure WP 2.9+ Thumbnails
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 360, 9999 ); // Normal post thumbnails
	add_image_size( 'portfolio-featured-image', 360, 240, array('center', 'center') );

	// Add support for post formats
	add_theme_support( 'post-formats', array( 'aside', 'audio', 'gallery', 'image', 'link', 'quote', 'video' ) );

	// Adds RSS feed links to <head> for posts and comments
	add_theme_support( 'automatic-feed-links' );

 	// Enable forms to use HTML5 markup
	add_theme_support( 'html5', array(
	    'search-form', 'comment-form'
	) );

	// Add support for Jetpack infinite scroll
	add_theme_support( 'infinite-scroll', array(
		'container'		 	 => 'primary',
		'wrapper'				 => false,
		'footer' 		 		 => 'footer',
		'footer_widgets' => 'footer-column',
		'type'           => 'scroll'
	) );
}
endif;
add_action( 'after_setup_theme', 'zilla_theme_setup' );


if ( !function_exists( 'zilla_sidebars_init' ) ) :
/**
 * Register the sidebars for the theme
 *
 * @since Hanna 1.0
 *
 * @uses register_sidebar() To add sidebar areas
 * @return void
 */
function zilla_sidebars_init() {
	register_sidebars(2, array(
		'name' => __('Footer Column %d', 'zilla'),
		'id' => 'footer-column',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
}
endif;
add_action( 'widgets_init', 'zilla_sidebars_init' );


if ( !function_exists( 'zilla_enqueue_scripts' ) ) :
/**
 * Enqueues scripts and styles for front end
 *
 * @since Hanna 1.0
 *
 * @return void
 */
function zilla_enqueue_scripts() {
	/* Register our scripts --- */
	wp_register_script('modernizr', get_template_directory_uri() . '/js/modernizr.custom-2.8.3.js', '', '2.8.3', false);
	wp_register_script('validation', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js', 'jquery', '1.9', true);
	wp_register_script('superfish', get_template_directory_uri() . '/js/superfish.js', 'jquery', '1.7.4', true);
	wp_register_script('zillaMobileMenu', get_template_directory_uri() . '/js/jquery.zillamobilemenu.min.js', 'jquery', '0.1', true);
	wp_register_script('fitVids', get_template_directory_uri() . '/js/jquery.fitvids.js', 'jquery', '1.0', true);
	wp_register_script('imagesLoaded', get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js', 'jquery', '3.1.8', true);
	wp_register_script('isotope', get_template_directory_uri() . '/js/isotope.pkgd.min.js', array('jquery', 'imagesLoaded'), '2.0.1', true);
	wp_register_script('cycle2', get_template_directory_uri() . '/js/jquery.cycle2.min.js', array('jquery'), '2.1.5', true);
	wp_register_script('zilla-custom', get_template_directory_uri() . '/js/jquery.custom.js', array('jquery', 'superfish', 'zillaMobileMenu', 'fitVids', 'isotope', 'cycle2'), '', true);

	/* Enqueue our scripts --- */
	wp_enqueue_script('modernizr');
	wp_enqueue_script('jquery');
	wp_enqueue_script('zilla-custom');

	/* loads the javascript required for threaded comments --- */
	if( is_singular() && comments_open() && get_option( 'thread_comments') )
		wp_enqueue_script( 'comment-reply' );

	if( is_page_template('template-contact.php') )
		wp_enqueue_script('validation');

	/* Load our stylesheet --- */
	$zilla_options = get_option('zilla_framework_options');
	wp_enqueue_style( $zilla_options['theme_name'], get_stylesheet_uri() );
	wp_enqueue_style('google-fonts-hanna-theme', '//fonts.googleapis.com/css?family=Quicksand:400,700|Lora:700,400italic');
}
endif;
add_action('wp_enqueue_scripts', 'zilla_enqueue_scripts');


if ( !function_exists( 'zilla_enqueue_admin_scripts' ) ) :
/**
 * Enqueues scripts for back end
 *
 * @since Hanna 1.0
 *
 * @return void
 */
function zilla_enqueue_admin_scripts() {
	wp_register_script( 'zilla-admin', get_template_directory_uri() . '/includes/js/jquery.custom.admin.js', 'jquery' );
	wp_enqueue_script( 'zilla-admin' );
}
endif;
add_action( 'admin_enqueue_scripts', 'zilla_enqueue_admin_scripts' );


if ( !function_exists( 'zilla_wp_title' ) ) :
/**
 * Creates formatted and more specific title element for output based
 * on current view
 *
 * @since Hanna 1.0
 *
 * @param string $title Default title text
 * @param string $sep Optional separator
 * @return string Formatted title
 */
function zilla_wp_title( $title, $sep ) {
	if( !zilla_is_third_party_seo() ){
		global $paged, $page;

		if( is_feed() )
			return $title;

		$title .= get_bloginfo( 'name' );

		$site_description = get_bloginfo( 'description', 'display' );
		if( $site_description && ( is_home() || is_front_page() ) )
			$title = "$title $sep $site_description";

		if( $paged >= 2 || $page >= 2 )
			$title = "$title $sep " . sprintf( __('Page %s', 'zilla'), max( $paged, $page ) );
	}
	return $title;
}
endif;
add_filter('wp_title', 'zilla_wp_title', 10, 2);


/*----------------------------------------------------------------------------*/
/* Blog
/*----------------------------------------------------------------------------*/

if ( !function_exists( 'zilla_excerpt_length' ) ) :
/**
 * Sets a custom excerpt length for portfolios
 *
 * @since Hanna 1.0
 *
 * @param int $length Excerpt length
 * @return int New excerpt length
 */
function zilla_excerpt_length($length) {
	return 55;
}
endif;
add_filter('excerpt_length', 'zilla_excerpt_length');


if ( !function_exists( 'zilla_excerpt_more' ) ) :
/**
 * Replaces [...] in excerpt string
 *
 * @since Hanna 1.0
 *
 * @param string $excerpt Existing excerpt
 * @return string
 */
function zilla_excerpt_more($excerpt) {
	return '&#8230;';
}
endif;
add_filter('exceprt_more', 'zilla_excerpt_more');


if ( ! function_exists('zilla_add_html_to_thumbnail_html') ) :
/**
 * Add html markup to the entry-thumbnail for specific post types
 * @param  string $html   the existing html
 * @param  int $postid 	  the post id of the current post
 * @return string         the modified html
 */
function zilla_add_html_to_thumbnail_html($html, $postid) {
	$format = get_post_format($postid);
	if( $format == 'quote' ) {
		$quote = get_post_meta($postid, '_zilla_quote_quote', true);
		$html .= "\n<div class='overlay'>\n";
		$html .= "\t<blockquote>" . esc_html($quote) . "\n\t\t<cite>" . esc_html(get_the_title($postid)) . "</cite>\n\t</blockquote>\n";
		$html .= "</div>\n";
	} elseif( $format == 'link' ) {
		$url = get_post_meta($postid, '_zilla_link_url', true);
		$html .= "\n<div class='overlay'>\n";
		$html .= "<h2>" . esc_url($url) . "</h2>\n";
		$html .= "</div>";
	}
	return $html;
}
endif;
add_filter('post_thumbnail_html', 'zilla_add_html_to_thumbnail_html', 10, 2);


if( ! function_exists( 'zilla_hash_the_tags' ) ) :
/**
 * Add a hash to the start of the tag term
 *
 * @param  array $els the tags
 * @return array      modded tags
 */
function zilla_hash_the_tags($els) {
	$modded_els = array();
	foreach( $els as $el ) {
		$modded_els[] = preg_replace('/>/', '><span>#</span>', $el, 1);
	}
	return $modded_els;
}
endif;
add_filter('term_links-post_tag', 'zilla_hash_the_tags');
add_filter('term_links-portfolio-type', 'zilla_hash_the_tags');


/*----------------------------------------------------------------------------*/
/* Comments
/*----------------------------------------------------------------------------*/

if ( !function_exists( 'zilla_comment' ) ) :
/**
 * Custom comment HTML output
 *
 * @since Hanna 1.0
 *
 * @param $comment
 * @param $args
 * @param $depth
 * @return void
 */
function zilla_comment($comment, $args, $depth) {

	$isByAuthor = false;

	if($comment->comment_author_email == get_the_author_meta('email')) {
		$isByAuthor = true;
	}

	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

		<div id="comment-<?php comment_ID(); ?>" class="clearfix">

			<?php echo get_avatar($comment,$size='60'); ?>

			<header class="comment-header">
				<div class="comment-author vcard">
				<?php printf(__('<cite class="fn">%s</cite> ', 'zilla'), get_comment_author_link()) ?> <?php if($isByAuthor) { ?><span class="author-tag"><?php _e('(Author)', 'zilla') ?></span><?php } ?>
				</div>
				<div class="comment-meta commentmetadata"><a href="<?php echo esc_url(htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ) ?>"><?php printf(__('%2$s %1$s', 'zilla'), get_comment_date('M j Y'),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)', 'zilla'),'  ','') ?> </div>
			</header>

			<div class="comment-content">
				<?php comment_text() ?>
				<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</div>

			<?php if ($comment->comment_approved == '0') : ?>
				<em class="moderation"><?php _e('Your comment is awaiting moderation.', 'zilla') ?></em><br />
			<?php endif; ?>

		</div>
<?php
}
endif;


if ( !function_exists( 'zilla_list_pings' ) ) :
/**
 * Separate pings from comments
 *
 * @since Hanna 1.0
 *
 * @param $comment
 * @param $args
 * @param $depth
 * @return void
 */
function zilla_list_pings($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
	<?php
}
endif;

/*----------------------------------------------------------------------------*/
/* Portfolio
/*----------------------------------------------------------------------------*/

// Prevent archives for the portfolio plugin; will use a custom page template
if( !defined('TZP_DISABLE_ARCHIVE') ) define('TZP_DISABLE_ARCHIVE', TRUE);
// Prevent Zilla Portfolio CSS from loading
if( !defined('TZP_DISABLE_CSS') ) define('TZP_DISABLE_CSS', TRUE);

// Remove filters on the content that adds portfolio content to the_content output
remove_filter('the_content', 'tzp_add_portfolio_post_meta');
remove_filter('the_content', 'tzp_add_portfolio_post_media');


/**
 * Add meta field to general portfolio settings fields
 *
 * @param  int $post_id the post id
 * @return void
 */
function zilla_render_portfolio_settings_fields( $post_id ) { ?>
	<div class="tzp-field">
		<div class="tzp-left">
			<p><?php _e('Featured Portfolio:', 'zilla'); ?></p>
		</div>
		<div class="tzp-right">
			<ul class="tzp-inline-checkboxes">
				<li>
					<input type="checkbox" name="_zilla_base_featured_portfolio" id="_zilla_base_featured_portfolio"<?php checked( 1, get_post_meta( $post_id, '_zilla_base_featured_portfolio', true) ); ?> />
					<label for='_zilla_base_featured_portfolio'><?php _e('Feature Portfolio', 'zilla'); ?></label>
				</li>
			</ul>
			<p class='tzp-desc howto'><?php _e('Should this portfolio be featured?', 'zilla'); ?></p>
		</div>
	</div>
<?php }
add_action( 'tzp_portfolio_settings_meta_box_fields', 'zilla_render_portfolio_settings_fields', 9 );


/**
 * Add the new meta fields to the array of values to be saved
 *
 * @param  array $array Array of the fields to be sanitized and saved
 * @return array        The updated array
 */
function zilla_save_added_portfolio_post_meta( $array ) {
	$array['_zilla_base_featured_portfolio'] = 'checkbox';
	return $array;
}
add_filter( 'tzp_metabox_fields_save', 'zilla_save_added_portfolio_post_meta' );


if ( !function_exists( 'zilla_add_portfolio_to_rss' ) ) :
/**
 * Adds portfolios to RSS feed
 *
 * @since Hanna 1.0
 *
 * @param obj $request
 * @return obj Updated request
 */
function zilla_add_portfolio_to_rss( $request ) {
	if (isset($request['feed']) && !isset($request['post_type']))
		$request['post_type'] = array('post', 'portfolio');

	return $request;
}
endif;
add_filter('request', 'zilla_add_portfolio_to_rss');

/*----------------------------------------------------------------------------*/
/*	Include the framework
/*----------------------------------------------------------------------------*/

if ( ! function_exists( 'zilla_style_select' ) ) :
/**
 * Add style select to TinyMCE
 */
function zilla_style_select( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
endif;
add_filter( 'mce_buttons_2', 'zilla_style_select' );

if ( ! function_exists( 'zilla_styles_dropdown' ) ) :
/**
 * Add p.lead to styles drop down
 * @param  array $settings
 * @return array
 */
function zilla_styles_dropdown( $settings ) {

	$new_styles = array(
		array(
			'title'	=> __( 'Custom Styles', 'zilla' ),
			'items'	=> array(
				array(
					'title'		=> __('p.lead','zilla'),
					'selector'	=> 'p',
					'classes'	=> 'p-lead'
				)
			)
		)
	);

	// Merge old & new styles
	$settings['style_formats_merge'] = true;

	// Add new styles
	$settings['style_formats'] = json_encode( $new_styles );

	// Return New Settings
	return $settings;
}
endif;
add_filter( 'tiny_mce_before_init', 'zilla_styles_dropdown' );


function is_blog () {
	global  $post;
	$posttype = get_post_type($post );
	return ( ((is_archive()) || (is_author()) || (is_category()) || (is_home()) || (is_tag())) && ( $posttype == 'post')  ) ? true : false ;
}


function is_layout_standard() {
	$theme_options = get_theme_mod('zilla_theme_options');
	$layout_standard = (isset($theme_options['general_blog_layout']) && $theme_options['general_blog_layout'] === 'layout-standard') ? true : false;
	return $layout_standard;
}


function hanna_body_classes($classes) {
	$theme_options = get_theme_mod('zilla_theme_options');
	
	if ( is_blog() && is_layout_standard() ) {
		$classes[] = 'layout-standard';
	}
	
	return $classes;
}
 // Apply filter
add_filter('body_class', 'hanna_body_classes');


//move wpautop filter to AFTER shortcode is processed
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 99);
add_filter( 'the_content', 'shortcode_unautop',100 );


$tempdir = get_template_directory();
require_once $tempdir .'/framework/init.php';
require_once $tempdir .'/includes/init.php';