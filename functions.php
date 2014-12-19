<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Holistic' );
define( 'CHILD_THEME_URL', 'http://medeskidesign.com/themes/holistic/' );
define( 'CHILD_THEME_VERSION', '0.2.0' );

// Includes
require_once( get_stylesheet_directory() . '/tgm_plugin_activation.php');
require_once( get_stylesheet_directory() . '/widget-social-icons.php');

//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'jm_holistic_scripts_styles' );
function jm_holistic_scripts_styles() {

	wp_enqueue_script( 'mobile-first-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );

	wp_enqueue_style( 'dashicons' );

  // Google Fonts
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Josefin+Slab:400,600,700', array(), CHILD_THEME_VERSION );
  wp_enqueue_style( 'google-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700', array(), CHILD_THEME_VERSION );
}

//* Add Genesis Theme Support
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', ) );
add_theme_support( 'genesis-responsive-viewport' );

// Genesis Styles
add_theme_support( 'genesis-style-selector', array(
  'theme-salmon' => __( 'Salmon', 'holistic' ),
  'theme-aquamarine' => __( 'Aquamarine', 'holistic' ),
  'theme-pariwinkle' => __( 'Periwinkle', 'holistic' ),
  'theme-citrus' => __( 'Citrus', 'holistic' ),
  'theme-mute' => __( 'Mute', 'holistic' ),
  ) );

//* Unregister Genesis Functions
unregister_sidebar( 'sidebar-alt' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'jm_holistic_remove_comment_form_allowed_tags' );
function jm_holistic_remove_comment_form_allowed_tags( $defaults ) {
	$defaults['comment_notes_after'] = '';
	return $defaults;
}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'jm_holistic_author_box_gravatar' );
function jm_holistic_author_box_gravatar( $size ) {

	return 160;

}

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'jm_holistic_comments_gravatar' );
function jm_holistic_comments_gravatar( $args ) {

	$args['avatar_size'] = 100;
	return $args;

}

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_subnav' );

// Add the Page Title section
add_action( 'genesis_before_content_sidebar_wrap', 'jm_holistic_cta' );
function jm_holistic_cta() {

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
  'name'      => __( 'Call-to-Action', 'holistic' ),
  'description' => __( 'This displays below the primary nav and featured image', 'holistic')
  ) );

//* Stop Simple Social Icons' CSS from loading and load our modified copy
add_action( 'wp_enqueue_scripts', 'jm_holistic_disable_simple_social_icons_styles', 11 );
function jm_holistic_disable_simple_social_icons_styles() {

  if ( class_exists( 'jm_holistic_simple_social_icons_widget' ) ) {

    wp_dequeue_style( 'simple-social-icons-font');

    wp_enqueue_style( 'simple-social-icons', get_bloginfo( 'stylesheet_directory' ) . '/css/simple-social-icons.css', array(), CHILD_THEME_VERSION );

  }

}

// Display Logo
// add_action( 'genesis_header', 'jm_holistic_logo_display' );
// function jm_holistic_logo_display() {
//   if ( get_theme_mod( 'holistic_logo_image' ) ) {
//     echo "<img src=\"";
//     echo esc_url( get_theme_mod( 'holistic_logo_image' ) );
//     echo "\" alt=\"";
//     echo esc_attr( get_bloginfo( 'name', 'display' ) );
//     echo "\" class=\"logo-image\">";
//     remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
//     remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
//   }
//   else {}
// };
