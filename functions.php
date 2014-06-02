<?php

// ------------------------------ 
// theme support
// ------------------------------ 
add_theme_support( 'post-thumbnails' ); 


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
// admin: 
// hide default posts menu option
// ------------------------------ 
function post_remove () {
  remove_menu_page('edit.php');
}
add_action('admin_menu', 'post_remove'); 


// --------------------------------- 
// register custom taxonomies
//
// feature: featured_tax
// news: news_tax
// postpending to avoid name clashes
// --------------------------------- 
function register_custom_taxonomies() {
  $labels = array(
    'name'              => _x( 'Feature categories', 'taxonomy general name' ),
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
    'supports' => array('author', 'title', 'editor', 'thumbnail', 'revisions' ),
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
    'supports' => array('author', 'title', 'editor', 'thumbnail', 'revisions' ),
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
  add_rewrite_rule( 'featured/([^/]+)/([^/]+)', 'index.php?lwa_feature=$matches[2]', 'top' );

  // this will match any featured page
  add_rewrite_rule( 'featured/([^/]+)', 'index.php?pagename=$matches[1]', 'top' );
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


// ---------------------------------- 
// customisation: BAW post view count
//
// only keep the total view count
// ----------------------------------
function remove_timing_for_bawpvc( $timings ) {
    return array( 'all' => '' );
}
add_filter( 'baw_count_views_timings', 'remove_timing_for_bawpvc' );


// ------------------------------ 
// util: 
// distance of time in words
// ------------------------------ 
function get_when() {
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
  return preg_replace($time_patterns, $time_replacements, $time);
}

function when() {
  echo get_when();
}


// ----------------------------------- 
// util:
// get the category helper to return
// custom taxonomy
// -----------------------------------
function category($post_type) {
  $terms = get_the_terms( get_the_id(), get_taxonomy_name($post_type) );

  foreach ( $terms as $term ) {
    return array(
      'name' => $term->name,
      'permalink' => get_bloginfo('wpurl') . "/" . ($post_type === 'lwa_feature' ? 'featured' : 'news') . "/". $term->slug,
      'slug' => $term->slug
      );
  }
}

function get_taxonomy_name($post_type) {
  return $post_type === 'lwa_feature' ? 'featured_tax' : 'news_tax';
}


// ----------------------------------- 
// util:
// get the view count 
// -----------------------------------
function get_views() {
  return do_shortcode('[post_view]');
}
function views() {
  echo get_views();
}


function get_thumbnail($src = false) {
 if ('' != get_the_post_thumbnail()) {
    if ($src == false) {
      echo the_post_thumbnail( 'large' );
    } else {
      $attrs = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
      if ( $attrs ) {
        return $attrs[0];
      }
    }
  } else {
    if ($src == false) {
      echo catch_that_image($src);
    } else {
      return catch_that_image($src);
    }
  }
}

function catch_that_image($src) {
  global $post, $posts;
  $first_img = '';
  // ob_start();
  // ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches[1][0];

  if (empty($first_img)) {
    $first_img = "/path/to/default.png";
  }

  if ($src === false) {
    return '<img src="' . $first_img . '" />';
  } else {
    return $first_img;
  }
}


// ------------------------------ 
// add app JS in footer of page
// ------------------------------ 
function add_scripts() {
  wp_register_script( 'global-build', get_template_directory_uri() . '/static/dist/global-build.js', null, '', true );
  wp_register_script( 'home-build', get_template_directory_uri() . '/static/dist/home-build.js', null, '', true );
  wp_register_script( 'category-build', get_template_directory_uri() . '/static/dist/category-build.js', null, '', true );
  wp_register_script( 'gallery-build', get_template_directory_uri() . '/static/dist/gallery-build.js', null, '', true );
  wp_register_script( 'single-build', get_template_directory_uri() . '/static/dist/single-build.js', null, '', true );
  
  wp_enqueue_script( 'global-build' );
}
add_action( 'wp_enqueue_scripts', 'add_scripts', 999 );



// ------------------------ 
// ajax requests functions
// ------------------------
function search_posts($term, $page, $posts_per_page) {
  $args = Array(
    'post_type' => Array('lwa_feature', 'lwa_news'),
    's' => $term,
    'posts_per_page' => $posts_per_page,
    'paged' => $page
  );

  $wp_query = new WP_Query( $args );

  $data = Array (
    'term' => $term,
    'posts' => Array(),
    'nextPage' => false,
    'postsPerPage' => $posts_per_page
  );

  // check if there is more data to fetch
  if ( $wp_query->max_num_pages > 1 ) {
    if ( $page < $wp_query->max_num_pages ) {
      $data['nextPage'] = $page + 1;
    }
  }

  if ( $wp_query->have_posts() ):
    $idx = 0;
    
    while ( $wp_query->have_posts() ): 
      $wp_query->the_post();
      
      $data['posts'][$idx] = Array(
        'title'     => html_entity_decode(get_the_title()),
        'subtitle'  => html_entity_decode(get_the_subtitle()),
        'permalink' => get_the_permalink(),
        'thumbnail' => get_thumbnail(true),
        'views'     => get_views(),
        'when'      => get_when(),
        'category'  => category( get_post_type() )
      );

      $idx++;
    endwhile;
  endif;

  return $data;
}


function fetch_posts($page, $post_per_page, $post_type) {
  $args = Array(
    'post_type' => $post_type,
    'posts_per_page' => $post_per_page,
    'paged' => $page
  );

  $wp_query = new WP_Query( $args );

  $data = Array (
    'posts' => Array(),
    'nextPage' => false
  );

  // check if there is more data to fetch
  if ( $wp_query->max_num_pages > 1 ) {
    if ( $page < $wp_query->max_num_pages ) {
      $data['nextPage'] = $page + 1;
    }
  }

  if ( $wp_query->have_posts() ):
    $idx = 0;
    while ( $wp_query->have_posts() ): 
      $wp_query->the_post();
      
      $data['posts'][$idx] = Array(
        'title'     => html_entity_decode(get_the_title()),
        'subtitle'  => html_entity_decode(get_the_subtitle()),
        'permalink' => get_the_permalink(),
        'thumbnail' => get_thumbnail(true),
        'views'     => get_views(),
        'when'      => get_when(),
        'category'  => category($post_type)
      );
      $idx++;
    endwhile;
  endif;

  return $data;
}

function get_next_featured_posts($page = 2) {
  return fetch_posts($page, 4, 'lwa_feature');
}

function get_next_news_posts($page = 2) {
  return fetch_posts($page, 6, 'lwa_news');
}

add_action('wp_ajax_nopriv_do_ajax', 'ajax_handler');
add_action('wp_ajax_do_ajax', 'ajax_handler');

function ajax_handler() {
 
  switch($_REQUEST['fn']){
    case 'get_next_featured_posts':
      $output = get_next_featured_posts($_REQUEST['page']);
      break;
    case 'get_next_news_posts':
      $output = get_next_news_posts($_REQUEST['page']);
      break;
    case 'search_posts':
      $output = search_posts($_REQUEST['s'], $_REQUEST['page'], $_REQUEST['posts_per_page']);
      break;
  }
 
  wp_reset_query();

  $output = json_encode($output);

  if (is_array($output)){
    print_r($output);  
  }
  else{
    echo $output;
  }
  die;
}


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