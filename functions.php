<?php

// ------------------------------ 
// theme support
// ------------------------------ 
add_theme_support( 'post-thumbnails' ); 
register_nav_menu( 'primary', 'Primary Menu' );

// ------------------------------ 
// add editor/admin css files
// ------------------------------ 
function change_adminbar_css() {
    wp_register_style( 'add-admin-stylesheet', get_template_directory_uri() . '/admin-styles.css' );
    wp_enqueue_style( 'add-admin-stylesheet' );
}
add_action( 'admin_enqueue_scripts', 'change_adminbar_css' ); 

// function add_editor_styles() {
//   add_editor_style( 'editor-styles.css' );
// }
// add_action( 'init', 'add_editor_styles' );





// ------------------------------ 
// hide default posts menu option
// ------------------------------ 
function post_remove () {
  remove_menu_page('edit.php');
}
add_action('admin_menu', 'post_remove'); 

// --------------------------------- 
// register custom taxonomies
// --------------------------------- 
function register_custom_taxonomies() {
  $labels = array(
    'name'              => _x( 'Categories', 'taxonomy general name' ),
    'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Categories' ),
    'all_items'         => __( 'All Categories' ),
    'parent_item'       => __( 'Parent Category' ),
    'parent_item_colon' => __( 'Parent Category:' ),
    'edit_item'         => __( 'Edit Category' ), 
    'update_item'       => __( 'Update Category' ),
    'add_new_item'      => __( 'Add New Category' ),
    'new_item_name'     => __( 'New Category' ),
    'menu_name'         => __( 'Categories' ),
  );

  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
    'rewrite' => array(
      'with_front' => true
    )
  );

  register_taxonomy( 'featured', 'lwa_feature', $args );
  register_taxonomy( 'news', 'lwa_news', $args );

  $carousel_labels = array(
    'name'              => _x( 'Carousel', 'taxonomy general name' ),
    'singular_name'     => _x( 'Carousel', 'taxonomy singular name' ),
    'menu_name'         => __( 'Carousel' ),
  );

  $carousel_args = array(
    'labels' => $carousel_labels,
    'hierarchical' => true
  );
  register_taxonomy( 'carousel', 'lwa_carousel', $carousel_args );
}

add_action( 'init', 'register_custom_taxonomies' );

// ------------------------------ 
// register custom post types
// ------------------------------ 
function create_post_type() {
  register_post_type( 'lwa_feature',
    array(
      'labels' => array(
        'name' => __( 'Featured posts' ),
        'singular_name' => __( 'Featured' ),
      ),
      'description' => __( 'Featured articles are defined within this type' ),
      'hierarchical' => true, 
      'show_ui' => true,
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'featured', 'with_front' => false),
      'menu_position' => 5,
      'supports' => array('author', 'title', 'editor', 'thumbnail', 'revisions', 'excerpt' ),
      'taxonomies' => array( 'featured', 'subtitle', 'carousel' )
    )
  );

  register_post_type( 'lwa_news',
    array(
      'labels' => array(
        'name' => __( 'News posts' ),
        'singular_name' => __( 'News' ),
      ),
      'description' => __( 'News articles are defined within this type' ),
      'hierarchical' => true, 
      'show_ui' => true,
      'public' => true,
      'has_archive' => true,
      'rewrite' => array('slug' => 'news', 'with_front' => false),
      'menu_position' => 5,
      'supports' => array('author', 'title', 'editor', 'thumbnail', 'revisions', 'excerpt' ),
      'taxonomies' => array( 'news', 'subtitle', 'carousel' )
    )
  );
}
add_action( 'init', 'create_post_type' );





// ------------------------------ 
// util: custom time
// ------------------------------ 
function when() {
  $time_patterns = array(
    "/ mins/",
    "/ min/",
    "/ hours/",
    "/ hour/",
    "/ days/",
    "/ day/",
    "/ weeks/",
    "/ week/",
    "/ months/",
    "/ month/",
    "/ years/",
    "/ year/"
  );
  $time_replacements = array(
    "mn",
    "mn",
    "h",
    "h",
    "d",
    "d",
    "w",
    "w",
    "m",
    "m",
    "y",
    "y"
  );
  $time = human_time_diff( get_the_time('U'), current_time('timestamp') );
  echo preg_replace($time_patterns, $time_replacements, $time);
}

// ------------------------------ 
// util: next/prev pagination links
// ------------------------------
function get_pagination_link($type) {
  $button_class = "button-$type";
  
  if ($type === 'prev') {
    $link = get_previous_posts_link( $type );
  } else {
    $link = get_next_posts_link( $type );
  }

  if ($link === null) {
    echo '<a class="button button-disabled '. $button_class .'" href="javascript:void(0)"><i class="icon-arrow-'. $type .'"></i>'. $type .'</a>';
  } else {
    preg_match('/(http:\/\/.+?)([ \\n\\r])/', $link, $matches );
    echo '<a class="button '. $button_class .'" href="'. $matches[0] .'><i class="icon-arrow-'. $type .'"></i>'. $type .'</a>';
  }
}

// ------------------------------ 
// get the category helper
// ------------------------------
function category($post_type) {
  $terms = get_the_terms( get_the_id(), $post_type === 'lwa_feature' ? 'featured' : 'news' );

  foreach ( $terms as $term ) {
    return array(
      'name' => $term->name,
      'permalink' => get_bloginfo('wpurl') . "/" . ($post_type === 'lwa_feature' ? 'featured' : 'news') . "/". $term->slug
      );
  }
}


// ------------------------------ 
// Call to views plugin
// ------------------------------
function views() {
  echo do_shortcode('[post_view]');
}

function get_thumbnail() {
  if (has_post_thumbnail( get_the_id() )) {
    echo the_post_thumbnail( 'large' );
  } else {
    $gallery = new Attachments( 'my_attachments', get_the_id() );
    if( $gallery->exist() ) {
      echo $gallery->image( 'large', 0 );
    }
  }
}

// ------------------------------ 
// add app JS in footer of page
// ------------------------------ 
function add_scripts() {
  wp_register_script( 'build', get_template_directory_uri() . '/scripts/build.js', null, '', true );
  wp_enqueue_script( 'build' );
}
add_action( 'wp_enqueue_scripts', 'add_scripts', 999 );


// -------------------- 
// change the excerpt
// -------------------- 
// function custom_excerpt_length( $length ) {
//   return 30;
// }
// add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

// function new_excerpt_more( $more ) {
//   return '...';
// }
// add_filter('excerpt_more', 'new_excerpt_more');


// ------------------------ 
// feature image captions
// ------------------------ 
// function the_post_thumbnail_caption() {
//   global $post;

//   $thumbnail_id    = get_post_thumbnail_id($post->ID);
//   $thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

//   if ($thumbnail_image && isset($thumbnail_image[0])) {
//     echo $thumbnail_image[0]->post_excerpt;
//   }
// }


// ---------------------- 
// add styles to editor
// ---------------------- 
// function add_editor_styles() {
//   add_editor_style( 'editor-styles.css' );
// }
// add_action( 'init', 'add_editor_styles' );



// -------------------------- 
// attachment plugin config
// --------------------------
add_filter( 'attachments_default_instance', '__return_false' ); // disable the default instance
function my_attachments( $attachments )
{
  $fields = array( 
    // array(
    //   'name'      => 'caption',                       // unique field name
    //   'type'      => 'text',                          // registered field type
    //   'label'     => __( 'Caption', 'attachments' ),  // label to display
    //   'default'   => 'caption',                       // default value upon selection
    // )
  );

  $args = array(

    // title of the meta box (string)
    'label'         => 'Gallery',

    // all post types to utilize (string|array)
    'post_type'     => array( 'lwa_feature', 'lwa_news'),

    // meta box position (string) (normal, side or advanced)
    'position'      => 'side',

    // meta box priority (string) (high, default, low, core)
    'priority'      => 'high',

    // allowed file type(s) (array) (image|video|text|audio|application)
    'filetype'      => array('image'),

    // include a note within the meta box (string)
    'note'          => '',

    // by default new Attachments will be appended to the list
    // but you can have then prepend if you set this to false
    'append'        => true,

    // text for 'Attach' button in meta box (string)
    'button_text'   => __( 'Add to gallery', 'attachments' ),

    // text for modal 'Attach' button (string)
    'modal_text'    => __( 'Add', 'attachments' ),

    // which tab should be the default in the modal (string) (browse|upload)
    'router'        => 'browse',

    // fields array
    'fields'        => $fields,

  );

  $attachments->register( 'my_attachments', $args ); // unique instance name
}
add_action( 'attachments_register', 'my_attachments' );
 
 ?>