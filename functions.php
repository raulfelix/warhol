<?php

require_once('includes/custom-category-functions.php');
require_once('includes/custom-profile-functions.php');
require_once('includes/ui-util-functions.php');
require_once('includes/ajax-functions.php');


// ------------------------------ 
// theme support
// ------------------------------ 
add_theme_support( 'post-thumbnails' ); 


// ------------------------------ 
// theme support
// add a custom image size
// w: 600, h: 388
// ------------------------------ 
add_image_size( 'news-thumbnail', 600, 388, true );

add_filter( 'image_size_names_choose', 'my_custom_sizes' );

function my_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'news-thumbnail' => __('News thumbnail'),
    ) );
}

// ------------------------------ 
// admin:
// add admin stylesheet
// ------------------------------ 
function change_adminbar_css() {
    wp_register_style( 'add-admin-stylesheet', get_template_directory_uri() . '/admin-styles.css' );
    wp_enqueue_style( 'add-admin-stylesheet' );
}
add_action( 'admin_enqueue_scripts', 'change_adminbar_css' ); 


// ------------------------------ 
// admin:
// add editor css for better content
// management 
// ------------------------------
function add_editor_styles() {
  add_editor_style( 'editor-styles.css' );
}
add_action( 'init', 'add_editor_styles' );


// ------------------------------ 
// admin JS files
// ------------------------------ 
add_action('admin_enqueue_scripts', 'enqueue_custom_admin_scripts');
 
function enqueue_custom_admin_scripts() {
  wp_enqueue_media();
  wp_register_script('edit-category', get_template_directory_uri() . '/admin/edit-category.js', array('jquery'));
  wp_enqueue_script('edit-category');
}


// ------------------------------ 
// add app JS in footer of page
// ------------------------------ 
function add_scripts() {
  wp_register_script( 'global-build', get_template_directory_uri() . '/static/dist/global-build.js', null, '', true );
  wp_register_script( 'home-build', get_template_directory_uri() . '/static/dist/home-build.js', null, '', true );
  wp_register_script( 'category-build', get_template_directory_uri() . '/static/dist/category-build.js', null, '', true );
  wp_register_script( 'gallery-build', get_template_directory_uri() . '/static/dist/gallery-build.js', array('single-build'), '', true );
  wp_register_script( 'single-build', get_template_directory_uri() . '/static/dist/single-build.js', null, '', true );
  
  wp_enqueue_script( 'global-build' );
}
add_action( 'wp_enqueue_scripts', 'add_scripts', 999 );


// ------------------------------ 
// admin:
// modify editor headings dropdown
// ------------------------------
function mce_mod( $init ) {
  $init['block_formats'] = 'Intro=h1;Header=h2;Subhead=h4;Paragraph=p;Quote=blockquote';

  // this is to add style formats to the options
  // $style_formats = array (
  //   array( 'title' => 'Bold text', 'inline' => 'b' ),
  //   array( 'title' => 'Red text', 'inline' => 'span', 'styles' => array( 'color' => '#ff0000' ) ),
  //   array( 'title' => 'Red header', 'block' => 'h1', 'styles' => array( 'color' => '#ff0000' ) ),
  //   array( 'title' => 'Example 1', 'inline' => 'span', 'classes' => 'example1' ),
  //   array( 'title' => 'Example 2', 'inline' => 'span', 'classes' => 'example2' )
  // );

  // $init['style_formats'] = json_encode( $style_formats );
  // $init['style_formats_merge'] = false;
  return $init;
}
add_filter('tiny_mce_before_init', 'mce_mod');


// ------------------------------ 
// admin: 
// hide default posts menu option
// ------------------------------ 
function post_remove () {
  remove_menu_page('edit.php');
}
add_action('admin_menu', 'post_remove'); 


// ------------------------------ 
// admin: 
// remove wrapping of img elements
// ------------------------------ 
function filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', 'filter_ptags_on_images');


// --------------------------------- 
// register custom taxonomies
//
// feature: featured_tax
// news: news_tax
// postpending to avoid name clashes
// --------------------------------- 
function register_custom_taxonomies() {
  $labels = array(
    'name'              => _x( 'Custom categories', 'taxonomy general name' ),
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
    'rewrite' => array (
      'hierarchical' => true
    )
  );

  register_taxonomy( 'featured_tax', 'lwa_feature', $args );
  register_taxonomy( 'news_tax', 'lwa_news', $args );

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
//
// featured: lwa_feature
// news: lwa_news
// ------------------------------ 
function create_post_type() {
  
  $lwa_feature_post_type = array(
    'labels' => array(
      'name' => __( 'Featured posts' ),
      'singular_name' => __( 'Featured' ),
    ),
    'description' => __( 'Featured articles are defined within this type' ),
    'hierarchical' => true, 
    'show_ui' => true,
    'public' => true,
    'has_archive' => true,
    'rewrite' => array('slug' => 'featured/%featured_tax%', 'with_front' => false),
    'menu_position' => 5,
    'supports' => array('title', 'editor', 'thumbnail', 'revisions' ),
    'taxonomies' => array( 'featured_tax', 'subtitle', 'carousel' )
  );

  $lwa_news_post_type = array(
    'labels' => array(
      'name' => __( 'News posts' ),
      'singular_name' => __( 'News' ),
    ),
    'description' => __( 'News articles are defined within this type' ),
    'hierarchical' => true,
    'show_ui' => true,
    'public' => true,
    'has_archive' => true,
    'rewrite' => array('slug' => 'news/%news_tax%', 'with_front' => false),
    'menu_position' => 5,
    'supports' => array('title', 'editor', 'thumbnail', 'revisions' ),
    'taxonomies' => array( 'news_tax', 'subtitle', 'carousel' )
  );

  register_post_type( 'lwa_feature', $lwa_feature_post_type );
  register_post_type( 'lwa_news', $lwa_news_post_type );
}

add_action( 'init', 'create_post_type' );


// --------------------------------------------  
// customisation: disable canonical url
//
// done for featured pages (pagination/sorting)
// expected: ids should match featured pages
// --------------------------------------------   
function disable_redirect_canonical( $redirect_url ) {
  if ( is_page( array( 'parties-bullshit', 'tuesdays-without', 'twentyfour', 'news' ) ))
    $redirect_url = false;
    return $redirect_url;
}
add_filter('redirect_canonical','disable_redirect_canonical');


// --------------------------------------------  
// customisation: url rewrite 
//
// featured page url re-write for consistency 
// with news categories which are not content
// managed pages
// --------------------------------------------  
function featured_rewrite_rules() {
  // this will match single template pages
  // add_rewrite_rule( 'featured/([^/]+)/([^/]+)', 'index.php?lwa_feature=$matches[2]', 'top' );

  // this will match any featured page
  // add_rewrite_rule( 'featured/([^/]+)', 'index.php?pagename=$matches[1]', 'top' );
}
add_action( 'init', 'featured_rewrite_rules' );


// --------------------------------------------  
// customisation: custom post type permalink 
//
// make sure post permalinks follow structure: 
// post_type/%custom_taxonomy%/%postname%
// -------------------------------------------- 
function custom_post_type_permastruct($link, $post) {
  if ($post->post_type === 'lwa_feature') {
    if ($cats = get_the_terms($post->ID, 'featured_tax'))
      $link = str_replace('%featured_tax%', array_pop($cats)->slug, $link);
      return $link;
  } 
  else if ($post->post_type === 'lwa_news') {
    if ($cats = get_the_terms($post->ID, 'news_tax'))
      $link = str_replace('%news_tax%', array_pop($cats)->slug, $link);
      return $link;
  } else {
    return $link;
  }
}
add_filter('post_type_link', 'custom_post_type_permastruct', 10, 2);


// --------------------------------------------  
// customisation: custom meta data 
//
// hexidecimal field value for category page 
// overlay colour
// -------------------------------------------- 
function add_heximus_meta_box() {
  add_meta_box(
    'heximus_id',
    'Define image overlay colour',
    'heximus_meta_box_callback',
    'page'
  );

  $screens = array( 'lwa_feature', 'lwa_news' );
  foreach ( $screens as $screen ) {
    add_meta_box(
      'credits_id',
      'Author and photography',
      'credits_meta_box_callback',
      $screen
    );
  }
}
add_action( 'add_meta_boxes', 'add_heximus_meta_box' );

function heximus_meta_box_callback( $post ) {

  // Add an nonce field so we can check for it later.
  wp_nonce_field( 'heximus_meta_box', 'heximus_meta_box_nonce' );

  $value = get_post_meta( $post->ID, 'heximus_key', true );
  $alpha = get_post_meta( $post->ID, 'heximus_alpha_key', true );

  echo '<label class="label-heximus" for="heximus_new_field">';
  _e( 'Hex value. Default: #000', 'heximus_textdomain' );
  echo '</label> ';
  echo '<input class="input-heximus" type="text" id="heximus_new_field" name="heximus_new_field" value="' . esc_attr( $value ) . '" size="7" />';
  echo '<label class="label-heximus" for="heximus_alpha_new_field">';
  _e( 'Alpha value. Default: 0.8', 'heximus_textdomain' );
  echo '</label> ';
  echo '<input type="text" id="heximus_alpha_new_field" name="heximus_alpha_new_field" value="' . esc_attr( $alpha ) . '" size="7" />';
}

function heximus_save_meta_box_data( $post_id ) {

  // Check if our nonce is set.
  if ( ! isset( $_POST['heximus_meta_box_nonce'] ) ) {
    return;
  }

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $_POST['heximus_meta_box_nonce'], 'heximus_meta_box' ) ) {
    return;
  }

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;
  }

  // Check the user's permissions
  if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
    if ( ! current_user_can( 'edit_page', $post_id ) ) {
      return;
    }
  } else {
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
      return;
    }
  }

  // Make sure that data is set
  if ( !isset( $_POST['heximus_new_field'] ) && !isset( $_POST['heximus_alpha_new_field'] ) ) {
    return;
  }

  // Sanitize input
  $heximus = sanitize_text_field( $_POST['heximus_new_field'] );
  $alpha = sanitize_text_field( $_POST['heximus_alpha_new_field'] );

  // Update the meta field in the database.
  update_post_meta( $post_id, 'heximus_key', $heximus );
  update_post_meta( $post_id, 'heximus_alpha_key', $alpha );
}
add_action( 'save_post', 'heximus_save_meta_box_data' );


function credits_meta_box_callback( $post ) {

  // Add an nonce field so we can check for it later.
  wp_nonce_field( 'credits_meta_box', 'credits_meta_box_nonce' );

  $value = get_post_meta( $post->ID, 'credits_author_key', true );
  $alpha = get_post_meta( $post->ID, 'credits_photos_key', true );

  echo '<div><label class="label-credits" for="credits_author_new_field">';
  _e( 'Words by', 'textdomain' );
  echo '</label> ';
  echo '<input class="c-credits widefat" type="text" id="credits_author_new_field" name="credits_author_new_field" value="' . esc_attr( $value ) . '"/></div>';
  echo '<div class="c-field-wrap"><label class="label-credits-photos" for="credits_photos_new_field">';
  _e( 'Photos by', 'textdomain' );
  echo '</label> ';
  echo '<input class="c-credits widefat" type="text" id="credits_photos_new_field" name="credits_photos_new_field" value="' . esc_attr( $alpha ) . '"/></div>';
}

function credits_save_meta_box_data( $post_id ) {

  // Check if our nonce is set.
  if ( ! isset( $_POST['credits_meta_box_nonce'] ) ) {
    return;
  }

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $_POST['credits_meta_box_nonce'], 'credits_meta_box' ) ) {
    return;
  }

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;
  }

  // Check the user's permissions
  if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
    if ( ! current_user_can( 'edit_page', $post_id ) ) {
      return;
    }
  } else {
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
      return;
    }
  }

  // Make sure that data is set
  if ( !isset( $_POST['credits_author_new_field'] ) && !isset( $_POST['credits_photos_new_field'] ) ) {
    return;
  }

  // Sanitize input
  $author = sanitize_text_field( $_POST['credits_author_new_field'] );
  $photos = sanitize_text_field( $_POST['credits_photos_new_field'] );

  // Update the meta field in the database.
  update_post_meta( $post_id, 'credits_author_key', $author );
  update_post_meta( $post_id, 'credits_photos_key', $photos );
}
add_action( 'save_post', 'credits_save_meta_box_data' );


// ----------------------------------
// BAW post view count config
// only keep the total view count
// ----------------------------------
function remove_timing_for_bawpvc( $timings ) {
    return array( 'all' => '' );
}
add_filter( 'baw_count_views_timings', 'remove_timing_for_bawpvc' );


// -------------------------- 
// attachment plugin config
// --------------------------
add_filter( 'attachments_default_instance', '__return_false' ); // disable the default instance
function my_attachments( $attachments )
{
  $fields = array( 
    array(
      'name'      => 'caption',                       // unique field name
      'type'      => 'text',                          // registered field type
      'label'     => __( 'Caption', 'attachments' ),  // label to display
      'default'   => 'caption',                       // default value upon selection
    )
  );

  $args = array(

    // title of the meta box (string)
    'label'         => 'Gallery',

    // all post types to utilize (string|array)
    'post_type'     => array( 'page' ,'lwa_feature', 'lwa_news'),

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

    'post_parent'   => true,

    // fields array
    'fields'        => $fields,

  );

  $attachments->register( 'my_attachments', $args ); // unique instance name
}
add_action( 'attachments_register', 'my_attachments' );


?>