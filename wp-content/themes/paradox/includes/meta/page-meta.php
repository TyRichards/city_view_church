<?php

/**
 * Create the Page meta boxes
 */

add_action('add_meta_boxes', 'zilla_metabox_pages');
function zilla_metabox_pages() {

    // /* Create a featured image metabox ----------------------------------------------------*/
    // $meta_box = array(
    //     'id' => 'zilla-metabox-post-image',
    //     'title' =>  __('Feature Image Settings', 'zilla'),
    //     'description' => __('Set up your featured image.', 'zilla'),
    //     'page' => 'page',
    //     'context' => 'normal',
    //     'priority' => 'high',
    //     'fields' => array(
    //         array(
    //             'name' =>  __('Lower Image Opacity', 'zilla'),
    //             'desc' => __('Drop the opacity of an image to make text more readable.', 'zilla'),
    //             'id' => '_zilla_image_opacity',
    //             'type' => 'checkbox',
    //             'std' => ''
    //         )
    //     )
    // );
    // zilla_add_meta_box( $meta_box );

	/* About page -------------------------------------------------------*/
	$meta_box = array(
		'id' => 'zilla-metabox-page-template-template-about',
		'title' =>  __('About Page Settings', 'zilla'),
		'description' => '',
		'page' => 'page',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array()
	);
    $meta_box['fields'] = array_merge( $meta_box['fields'], zilla_about_page_template_profile( 1, 'first' ) );
    $meta_box['fields'] = array_merge( $meta_box['fields'], zilla_about_page_template_profile( 2, 'second' ) );
    $meta_box['fields'] = array_merge( $meta_box['fields'], zilla_about_page_template_profile( 3, 'third' ) );
	$meta_box['fields'] = array_merge( $meta_box['fields'], zilla_about_page_template_profile( 4, 'fourth' ) );
	$meta_box['fields'] = array_merge( $meta_box['fields'], zilla_about_page_template_profile( 5, 'fith' ) );
	$meta_box['fields'] = array_merge( $meta_box['fields'], zilla_about_page_template_profile( 6, 'sixth' ) );
	$meta_box['fields'] = array_merge( $meta_box['fields'], zilla_about_page_template_profile( 7, 'seventh' ) );
	$meta_box['fields'] = array_merge( $meta_box['fields'], zilla_about_page_template_profile( 8, 'eighth' ) );
	$meta_box['fields'] = array_merge( $meta_box['fields'], zilla_about_page_template_profile( 9, 'ninth' ) );
	$meta_box['fields'] = array_merge( $meta_box['fields'], zilla_about_page_template_profile( 10, 'tenth' ) );
	$meta_box['fields'] = array_merge( $meta_box['fields'], zilla_about_page_template_profile( 11, 'eleventh' ) );
	$meta_box['fields'] = array_merge( $meta_box['fields'], zilla_about_page_template_profile( 12, 'twelfth' ) );
    zilla_add_meta_box( $meta_box );

    /* Contact page -----------------------------------------------------*/
    $meta_box = array(
        'id' => 'zilla-metabox-page-template-template-contact',
        'title' =>  __('Contact Page Settings', 'zilla'),
        'description' => __('This info will appear in the "Additional Contact Details" section of the contact page', 'zilla'),
        'page' => 'page',
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
            array(
                'name' => __( 'Google Maps Embed Code', 'zilla' ),
                'desc' => __( 'Generate your map <a href="https://developers.google.com/maps/documentation/embed/start" target="_blank">here</a>, then paste the embed code above. The map width should be 460px', 'zilla' ),
                'id' => '_zilla_contact_map_embed',
                'type' => 'textarea',
                'std' => ''
            ),
            // array(
            //     'name' => __( 'Address', 'zilla' ),
            //     'desc' => '',
            //     'id' => '_zilla_contact_address',
            //     'type' => 'textarea',
            //     'std' => ''
            // ),
            // array(
            //     'name' => __( 'Phone Number', 'zilla' ),
            //     'desc' => '',
            //     'id' => '_zilla_contact_phone',
            //     'type' => 'text',
            //     'std' => ''
            // ),
            // array(
            //     'name' => __( 'Email Address', 'zilla' ),
            //     'desc' => '',
            //     'id' => '_zilla_contact_email',
            //     'type' => 'text',
            //     'std' => ''
            // ),
        )
    );
    zilla_add_meta_box( $meta_box );

    /* Location page -----------------------------------------------------*/
    $meta_box = array(
        'id' => 'zilla-metabox-page-template-template-location',
        'title' =>  __('Location Page Settings', 'zilla'),
        'description' => __('This info will appear in the "Additional Location Details" section of the contact page', 'zilla'),
        'page' => 'page',
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
            array(
                'name' => __( 'Google Maps Embed Code', 'zilla' ),
                'desc' => __( 'Generate your map <a href="https://developers.google.com/maps/documentation/embed/start" target="_blank">here</a>, then paste the embed code above. The map width should be 460px', 'zilla' ),
                'id' => '_zilla_location_map_embed',
                'type' => 'textarea',
                'std' => ''
            ),
            // array(
            //     'name' => __( 'Address', 'zilla' ),
            //     'desc' => '',
            //     'id' => '_zilla_contact_address',
            //     'type' => 'textarea',
            //     'std' => ''
            // ),
            // array(
            //     'name' => __( 'Phone Number', 'zilla' ),
            //     'desc' => '',
            //     'id' => '_zilla_contact_phone',
            //     'type' => 'text',
            //     'std' => ''
            // ),
            // array(
            //     'name' => __( 'Email Address', 'zilla' ),
            //     'desc' => '',
            //     'id' => '_zilla_contact_email',
            //     'type' => 'text',
            //     'std' => ''
            // ),
        )
    );
    zilla_add_meta_box( $meta_box );    

}

function zilla_about_page_template_profile( $index, $word ){
    return array(
        array(
            'name' => sprintf( __( 'Profile %d Image', 'zilla' ), $index ),
            'desc' => sprintf( __( 'Image for profile %d. Image should be 220px x 220px', 'zilla' ), $index ),
            'id' => '_zilla_about_image_'. $index,
            'type' => 'file',
            'std' => ''
        ),
        array(
            'name' => sprintf( __( 'Profile %d Name', 'zilla' ), $index ),
            'desc' => sprintf( __( 'Name of profile 1', 'zilla' ), $index ),
            'id' => '_zilla_about_name_'. $index,
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => sprintf( __( 'Profile %d Title', 'zilla' ), $index ),
            'desc' => sprintf( __( 'Job title for profile %d', 'zilla' ), $index ),
            'id' => '_zilla_about_title_'. $index,
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => sprintf( __( 'Profile %d Bio', 'zilla' ), $index ),
            'desc' => sprintf( __( 'Bio of for profile %d', 'zilla' ), $index ),
            'id' => '_zilla_about_bio_'. $index,
            'type' => 'textarea',
            'std' => ''
        ),
  //       array(
  //           'name' => __( 'Profile '. $index .' Twitter', 'zilla' ),
  //           'desc' => __( 'Twitter URL for the '. $word .' profile', 'zilla' ),
  //           'id' => '_zilla_about_twitter_'. $index,
  //           'type' => 'text',
  //           'std' => ''
  //       ),
  //       array(
  //           'name' => __( 'Profile '. $index .' Dribbble', 'zilla' ),
  //           'desc' => __( 'Dribbble URL for the '. $word .' profile', 'zilla' ),
  //           'id' => '_zilla_about_dribbble_'. $index,
  //           'type' => 'text',
  //           'std' => ''
  //       ),
		// array(
		// 	'name' => __( 'Profile '. $index .' LinkedIn', 'zilla' ),
		// 	'desc' => __( 'LinkedIn URL for the '. $word .' profile', 'zilla' ),
		// 	'id' => '_zilla_about_linkedin_'. $index,
		// 	'type' => 'text',
		// 	'std' => ''
		// ),
		// array(
		// 	'name' => __( 'Profile '. $index .' Behance', 'zilla' ),
		// 	'desc' => __( 'Behance URL for the '. $word .' profile', 'zilla' ),
		// 	'id' => '_zilla_about_behance_'. $index,
		// 	'type' => 'text',
		// 	'std' => ''
		// ),
		// array(
		// 	'name' => __( 'Profile '. $index .' Medium', 'zilla' ),
		// 	'desc' => __( 'Medium URL for the '. $word .' profile', 'zilla' ),
		// 	'id' => '_zilla_about_medium_'. $index,
		// 	'type' => 'text',
		// 	'std' => ''
		// ),
    );
}
