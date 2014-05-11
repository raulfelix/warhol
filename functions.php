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
    'supports' => array('author', 'title', 'editor', 'thumbnail', 'revisions', 'excerpt' ),
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
    'supports' => array('author', 'title', 'editor', 'thumbnail', 'revisions', 'excerpt' ),
    'taxonomies' => array( 'news_tax', 'subtitle', 'carousel' )
  );

  register_post_type( 'lwa_feature', $lwa_feature_post_type );
  register_post_type( 'lwa_news', $lwa_news_post_type );
}

add_action( 'init', 'create_post_type' );




function product_permastruct($link, $post) {

  // Only mess with product permalinks
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
 
  /* -----------------------------------------------------------------------------------
    This is where we could really have fun. This just grabs the last
    applied category and uses it. Depending on how you want permalinks
    handled, you could change this behavior to include hierarchical
    permalinks or anything else.  
     ------------------------------------------------------------------------------------ */ 
}
add_filter('post_type_link', 'product_permastruct', 10, 2);


// ------------------------------ 
// util: custom time
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

// ------------------------------ 
// Call to views plugin
// ------------------------------
function get_views() {
  return do_shortcode('[post_view]');
}
function views() {
  echo get_views();
}


function get_thumbnail() {
  if (has_post_thumbnail( get_the_id() )) {
    echo the_post_thumbnail( 'large' );
  } else {
    bdw_get_images( get_the_id() );
  }
}

function get_the_thumbnail() {
  if (has_post_thumbnail( get_the_id() )) {
    return wp_get_attachment_image_src( get_post_thumbnail_id(), 'large')[0];
  } else {
    return the_attached_images( get_the_id() );
  }
}

function the_attached_images($post_id, $tag = false) {
 
    // Get images for this post
    $arrImages = get_children('post_type=attachment&post_mime_type=image&post_parent=' . $post_id );
 
    // If images exist for this page
    if ($arrImages) {
 
        // Get array keys representing attached image numbers
        $arrKeys = array_keys($arrImages);
 
        // Get the first image attachment
        $iNum = $arrKeys[0];
 
        $url = wp_get_attachment_url($iNum);
        if ($tag === true) {
          $sImgString = '<img src="' . $url . '" />';
          return $sImgString;
        } else {
          return $url;
        }
    }
}

function bdw_get_images($post_id) {
  echo the_attached_images($post_id, true);
}


// ------------------------------ 
// add app JS in footer of page
// ------------------------------ 
function add_scripts() {
  wp_register_script( 'global-build', get_template_directory_uri() . '/static/dist/global-build.js', null, '', true );
  wp_register_script( 'home-build', get_template_directory_uri() . '/static/dist/home-build.js', null, '', true );
  wp_register_script( 'category-build', get_template_directory_uri() . '/static/dist/category-build.js', null, '', true );
  
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
        'title'     => get_the_title(),
        'subtitle'  => get_the_subtitle(),
        'permalink' => get_the_permalink(),
        'thumbnail' => get_the_thumbnail(),
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
        'title'     => get_the_title(),
        'subtitle'  => get_the_subtitle(),
        'permalink' => get_the_permalink(),
        'thumbnail' => get_the_thumbnail(),
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

    // fields array
    'fields'        => $fields,

  );

  $attachments->register( 'my_attachments', $args ); // unique instance name
}
add_action( 'attachments_register', 'my_attachments' );


?>