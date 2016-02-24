<?php

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
        'title'     => enc(get_the_title()),
        'subtitle'  => enc(get_the_subtitle()),
        'permalink' => get_the_permalink(),
        'thumbnail' => get_search_thumbnail(),
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
    'paged' => $page,
    'post_status' => 'publish',
    'meta_key' => 'news_featured_key',
    'meta_compare' => 'NOT EXISTS'
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
        'id'        => get_the_id(),
        'title'     => enc(get_the_title()),
        'subtitle'  => enc(get_the_subtitle()),
        'permalink' => get_the_permalink(),
        'thumbnail' => get_thumbnail(true, $post_type === 'lwa_news' ? true : false, true),
        'views'     => get_views(),
        'when'      => get_when(),
        'category'  => category($post_type)
      );
      $idx++;
    endwhile;
  endif;

  return $data;
}

function get_next_featured_posts($page) {
  global $max_num_pages;

  $feature_query = custom_home_feature_query($page, 4);

  $data = Array (
    'posts' => Array(),
    'nextPage' => false,
    '$max_num_pages' => $max_num_pages
  );

  // check if there is more data to fetch
  if ( $max_num_pages > 1 ) {
    if ( $page < $max_num_pages ) {
      $data['nextPage'] = $page + 1;
    }
  }
  if ($feature_query) {
    global $post;
    
    $idx = 0;
    foreach( $feature_query as $post ) {
      setup_postdata($post);
      
      $data['posts'][$idx] = Array(
        'id'        => get_the_id(),
        'title'     => enc(get_the_title()),
        'subtitle'  => enc(get_the_subtitle()),
        'permalink' => get_the_permalink(),
        'thumbnail' => get_thumbnail(true, false, true),
        'views'     => get_views(),
        'when'      => get_when(),
        'category'  => category($post->post_type)
      );
      $idx++;
    }
  }

  return $data;
}

function get_next_news_posts($page) {
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
    case 'instagram':
      $output = get_instagram_feed($_REQUEST['next_max_id']);
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

// ----------------------------------- 
// decode output via json 
// -----------------------------------
function enc($text) {
  return html_entity_decode($text, ENT_COMPAT, 'UTF-8');
}


// ------------------------ 
// instagram ajax
// ------------------------
function get_instagram_feed($next_max_id) {
  $access_token = get_option( 'instagram_access_token', 'nothing' );
  $url = 'https://api.instagram.com/v1/users/self/feed?access_token=' . $access_token . '&count=60';
  
  if ($next_max_id) {
    $url = $url . '&max_id=' . $next_max_id;
  }

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_URL, $url);
  $jsonData = curl_exec($ch);

  if (false === $jsonData) {
    throw new Exception("Error: _makeOAuthCall() - cURL error: " . curl_error($ch));
  }
  
  curl_close($ch);
  return json_decode($jsonData);
}

?>