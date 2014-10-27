<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Amy Jo Beaver' );
define( 'CHILD_THEME_URL', 'http://medeskidesign.com/themes/amyjobeaver/' );
define( 'CHILD_THEME_VERSION', '1.0.0' );


require_once( get_stylesheet_directory() . '/tgm_plugin_activation.php');

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'mobile_first_scripts_styles' );
function mobile_first_scripts_styles() {

	wp_enqueue_script( 'mobile-first-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );

	wp_enqueue_style( 'dashicons' );

  // Google Fonts
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Josefin+Slab:400,600,700', array(), CHILD_THEME_VERSION );
  wp_enqueue_style( 'google-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700', array(), CHILD_THEME_VERSION );

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Remove the secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Remove site layouts
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );


//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'mobile_first_remove_comment_form_allowed_tags' );
function mobile_first_remove_comment_form_allowed_tags( $defaults ) {

	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'mobile_first_author_box_gravatar' );
function mobile_first_author_box_gravatar( $size ) {

	return 160;

}

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'mobile_first_comments_gravatar' );
function mobile_first_comments_gravatar( $args ) {

	$args['avatar_size'] = 100;
	return $args;

}

//* Add support for 3-column footer widgets
// add_theme_support( 'genesis-footer-widgets', 3 );


//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_subnav' );

// // Add Homepage Widget
// add_action( 'genesis_after_header', 'amyjobeaver_homepage' );
// function amyjobeaver_homepage() {

//     if (is_active_sidebar( 'homepage' )) {
//         genesis_widget_area( 'homepage', array(
//             'before' => '<div class="homepage widget-area"><div class="wrap">',
//             'after' => '</div></div>'
//             ) );
//     }
// }

// // Register widget areas
// genesis_register_sidebar( array(
//     'id'          => 'homepage',
//     'name'        => __( 'Homepage', 'amyjobeaver' ),
//     'description' => __( 'This is the top section on the homepage.', 'amyjobeaver' ),
// ) );


/** Add the featured image section */
add_action( 'genesis_after_header', 'full_featured_image');
function full_featured_image() {
  if ( has_post_thumbnail( ) ) {
    echo '<div id="full-image">';
    echo get_the_post_thumbnail();
    echo '</div>';
  }
  else {}
}


// Add the Page Title section
add_action( 'genesis_after_header', 'jm_amyjobeaver_cta' );
function jm_amyjobeaver_cta() {

    if (is_active_sidebar( 'jm_cta' )) {
        genesis_widget_area( 'jm_cta', array(
            'before' => '<div class="cta-widget widget-area"><div class="wrap">',
            'after' => '</div></div>'
            ) );
    }
}

// Register widget areas
genesis_register_sidebar( array(
    'id'      => 'jm_cta',
    'name'      => __( 'Call-to-Action', 'jm' ),
    'description' => __( 'This displays below the primary nav and featured image', 'jm')
) );

add_theme_support( 'genesis-style-selector', array(
'sample-red' => __( 'Red', 'sample' ),
'sample-green' => __( 'Green', 'sample' )
) );
