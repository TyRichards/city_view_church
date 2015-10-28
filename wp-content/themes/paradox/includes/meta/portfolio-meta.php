<?php

/**
 * Create the Post meta boxes
 */

add_action('add_meta_boxes', 'zilla_metabox_portfolios');
function zilla_metabox_portfolios() {

	/* Create a featured image metabox ----------------------------------------------------*/
	$meta_box = array(
		'id' => 'zilla-metabox-post-image',
		'title' =>  __('Feature Image Settings', 'zilla'),
		'description' => __('Set up your featured image.', 'zilla'),
		'page' => 'portfolio',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' =>  __('Lower Image Opacity', 'zilla'),
				'desc' => __('Drop the opacity of an image to make text more readable.', 'zilla'),
				'id' => '_zilla_image_opacity',
				'type' => 'checkbox',
				'std' => ''
			)
		)
	);
	zilla_add_meta_box( $meta_box );

}