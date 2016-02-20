<?php

// ------------------------------ 
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
    "min",
    "min",
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
// get the category helper to return
// custom taxonomy
// -----------------------------------
function category($post_type) {
  $terms = get_the_terms( get_the_id(), get_taxonomy_name($post_type) );
  
  if ($terms) {
    foreach ( $terms as $term ) {
      $p = false;
      if ($term->parent) {
        $p = get_term($term->parent, $post_type === 'lwa_feature' ? 'featured_tax' : 'news_tax');
      }
      
      return array(
        'id' => $term->term_id,
        'name' => enc( $term->name ),
        'permalink' => get_bloginfo('url') . "/" . ($post_type === 'lwa_feature' ? 'featured' : 'news') . "/". $term->slug,
        'slug' => $term->slug,
        'description' => $term->description,
        'parent' => $p ? enc( $p->name ) : null,
        'parentPermalink' => $p ? get_bloginfo('url') . "/" . ($post_type === 'lwa_feature' ? 'featured' : 'news') . "/". $p->slug : null
        );
    }
  }
  return null;
}

function get_taxonomy_name($post_type) {
  return $post_type === 'lwa_feature' ? 'featured_tax' : 'news_tax';
}


// ----------------------------------- 
// post images:
// helper to render post images 
// -----------------------------------
function has_a_feature_image() {
  return ( '' != get_the_post_thumbnail() );
}

function has_gallery_image() {
  $attachments = new Attachments( 'my_attachments', get_the_id() );
  return $attachments->exist();
}

function get_feature_image($as_src, $size) {
  if ( $as_src == false ) {
    echo the_post_thumbnail( $size );
  } else {

    $attrs = wp_get_attachment_image_src( get_post_thumbnail_id(), $size );
    if ( $attrs ) {
      return $attrs[0];
    }
  }
}

function get_content_image($as_src) {
  global $post, $posts;
  $first_img = '';

  $output = preg_match_all('/<img.+class=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  if ($matches[1]) {
    $first_img = $matches[1][0];
  }

  if (!empty($first_img)) {
    $extracted = explode("-", $matches[1][0]);
    $id = $extracted[count($extracted) - 1];
    
    $img_path = wp_get_attachment_image_src( $id, 'news-thumbnail' );
    if ($img_path) {
      if ($as_src === false) {
        echo '<img src="' . $img_path[0] . '" />';
      } else {
        return $img_path[0];
      }  
    } 
  }
  return null;
}

function get_gallery_image($as_src) {
  $attachments = new Attachments( 'my_attachments', get_the_id() );
  if ( $attachments->exist() ) {
    if ( $as_src == false ) {
      echo $attachments->image( 'news-thumbnail', 0 );
    } else {
      return $attachments->src( 'news-thumbnail', 0 ); 
    }
  } 
  else {
    return null;
  }
}

/*
 * A news post always returns a custom thumbnail size
 *
 * For a news post:
 * - if:      there is a feature image 
 * - elseif:  there is a gallery image 
 * - else:    get an image from the content 
 */
function get_thumbnail($src = false, $is_news = false) {
  if ( has_a_feature_image() ) {
    return get_feature_image($src, 'news-thumbnail');
  }
  else if ( has_gallery_image() ) {
    return get_gallery_image($src);
  }
  else {
    return get_content_image($src);
  }
}

/*
 * Used by search
 */
function get_search_thumbnail() {
  if ( has_a_feature_image() ) {
    return get_feature_image(true, 'news-thumbnail');
  }
  else if ( has_gallery_image() ) {
    return get_gallery_image(true);
  }
  else {
    return get_content_image(true);
  }
}


function catch_that_image($src) {
  global $post, $posts;
  $first_img = '';

  $output = preg_match_all('/<img.+class=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches[1][0];

  if (!empty($first_img)) {
    $extracted = explode("-", $matches[1][0]);
    $id = $extracted[count($extracted) - 1];
    
    $img_path = wp_get_attachment_image_src( $id, 'news-thumbnail' );
    if ($img_path) {
      if ($src === false) {
        return '<img src="' . $img_path[0] . '" />';
      } else {
        return $img_path[0];
      }  
    } else {
      return "";
    }
  }
}

// ----------------------------------- 
// get the view count 
// -----------------------------------
function get_views() {
  return do_shortcode('[post_view]');
}
function views() {
  echo get_views();
}

// ----------------------------------- 
// Social media sharing buttons  
// -----------------------------------
function generate_share_link($key) {
  switch ($key) {
    case 'Facebook':
      $args = "https://www.facebook.com/sharer/sharer.php?u=" . urlencode(get_the_permalink()) . 
        "&title=" . urlencode(get_the_title()) . "&og:image=" . urlencode(get_search_thumbnail());
      break;
    case 'Google+':
      $args = "https://plus.google.com/share?url=" . urlencode(get_the_permalink());
      break;

    case 'Twitter':
      $args = "https://twitter.com/share?url=" . urlencode(get_the_permalink());
      break;

    case 'Pinterest':
      $args = "http://www.pinterest.com/pin/create/button/?url=". urlencode(get_the_permalink()) .
        "&media=" . urlencode(get_search_thumbnail()) . "&description=" . urlencode(get_the_title());
      break;
  }
  $key_lower = strtolower($key);
  return "<button class='button button-social' data-name={$key_lower} data-href={$args}>{$key}</button>";
}

function generate_inline_thumb_fix($idx) {
  if ($idx % 2 == 0) {
    echo '<div class="thumb-touch-inline-fix"></div>';
  }
  if ($idx % 3 == 0) {
    echo '<div class="thumb-inline-fix"></div>';
  }
}

function custom_authors_query($author_id, $paged, $order, $post_per_page) {
  global $wpdb, $max_num_pages, $paged;

  $offset = ($paged - 1) * $post_per_page;
  
  $sql = "
      SELECT SQL_CALC_FOUND_ROWS $wpdb->posts.*
      FROM $wpdb->posts
      INNER JOIN lwa_postmeta ON (lwa_posts.ID = lwa_postmeta.post_id) WHERE 1=1
      AND (lwa_posts.post_author = " . $author_id . ")
      AND lwa_posts.post_type IN ('lwa_feature', 'lwa_news')
      AND lwa_posts.post_status = 'publish'
      OR ( (lwa_postmeta.meta_key = 'photos_key' AND lwa_postmeta.meta_value = " . $author_id . ") )
      OR ( (lwa_postmeta.meta_key = 'filmed_key' AND lwa_postmeta.meta_value = " . $author_id . ") )
      GROUP BY lwa_posts.ID
      ORDER BY $wpdb->posts.post_date DESC
      LIMIT " . $offset . ", " . $post_per_page . "; ";   

  if ($order !== 'desc') {
    $sql = "
      SELECT SQL_CALC_FOUND_ROWS $wpdb->posts.* 
      FROM $wpdb->posts 
      INNER JOIN lwa_postmeta ON (lwa_posts.ID = lwa_postmeta.post_id) 
      INNER JOIN lwa_postmeta AS mt1 ON (lwa_posts.ID = mt1.post_id) 
      WHERE 1=1 
      AND (lwa_posts.post_author = " . $author_id . ") 
      AND lwa_posts.post_type IN ('lwa_feature', 'lwa_news') 
      AND (lwa_posts.post_status = 'publish' OR lwa_posts.post_author = " . $author_id . " 
      AND lwa_posts.post_status = 'private') 
      AND (lwa_postmeta.meta_key = '_count-views_all') 
      OR (mt1.meta_key = 'photos_key' AND CAST(mt1.meta_value AS CHAR) = '" . $author_id . "' AND lwa_postmeta.meta_key = '_count-views_all') 
      OR (mt1.meta_key = 'filmed_key' AND CAST(mt1.meta_value AS CHAR) = '" . $author_id . "' AND lwa_postmeta.meta_key = '_count-views_all') 
      GROUP BY lwa_posts.ID 
      ORDER BY lwa_postmeta.meta_value+0 DESC 
      LIMIT " . $offset . ", " . $post_per_page . "; ";
  }

  $sql_result = $wpdb->get_results( $sql, OBJECT);

  /* Determine the total of results found to calculate the max_num_pages
   for next_posts_link navigation */
  $sql_posts_total = $wpdb->get_var( "SELECT FOUND_ROWS();" );
  $max_num_pages = ceil($sql_posts_total / $post_per_page);
  return $sql_result;
}


function custom_home_feature_query($page_num, $post_per_page) {
  global $wpdb, $max_num_pages;

  $offset = ($page_num - 1) * $post_per_page;

  $sql = "SELECT SQL_CALC_FOUND_ROWS $wpdb->posts.* 
    FROM $wpdb->posts 
    INNER JOIN lwa_postmeta ON ( lwa_posts.ID = lwa_postmeta.post_id ) 
    WHERE 1=1 
    AND lwa_posts.post_type = 'lwa_feature' AND (lwa_posts.post_status = 'publish')
    OR lwa_posts.post_type = 'lwa_news' 
    AND lwa_postmeta.meta_key = 'news_featured_key'
    AND (lwa_posts.post_status = 'publish') 
    GROUP BY lwa_posts.ID 
    ORDER BY lwa_posts.post_date DESC 
    LIMIT " . $offset . ", " . $post_per_page . "; ";
  
  $sql_result = $wpdb->get_results( $sql, OBJECT);
  
  $sql_posts_total = $wpdb->get_var( "SELECT FOUND_ROWS();" );
  $max_num_pages = ceil($sql_posts_total / $post_per_page);
  
  return $sql_result;
}


//----------------------
// Get subcategories
// ---------------------
function getSubNav($id, $taxonomy) {
  $args = array(
    'orderby' => 'name',
    'order' => 'ASC',
    'parent' => $id,
    'taxonomy' => $taxonomy
  );
  $categories = get_categories($args);
  
  $pieces = explode("_", $taxonomy);
  
  if (count($categories) > 0) {
    $links = '<div class="nav-links-secondary"><div class="f-grid f-row">';
    foreach ($categories as $category) { 
      $links = $links . '<a class="nav-sublink" href="' . get_home_url() . '/' . $pieces[0] . '/' . $category->slug . '">' . $category->name . '</a>';
    }
    return $links . '</div></div>';
  }
  
  return false;
}

// ----------------------------------- 
// Gets the category of article sub 
// category.  
// -----------------------------------
function render_header_category($category, $post) {
  $sponsor_src = get_term_meta( $category['id'], 'c-sponsor-url', true ); 
  $sponsor_url = get_term_meta( $category['id'], 'c-sponsor-link', true );
  $sponsor_url = fix_url($sponsor_url);
  
  $post_sponsor_src = get_post_meta($post->ID, 'post_sponsor_src', true);
  $post_sponsor_url = get_post_meta($post->ID, 'post_sponsor_url', true);
  $post_sponsor_url = fix_url($post_sponsor_url);
  
  if ($post_sponsor_src) {
    $sponsor_src = $post_sponsor_src;
    $sponsor_url = $post_sponsor_url;
  }

  $cat_parent = '';
  if ($category['parent']) {
    $cat_parent = '<a class="h-5 link" href="' . $category['parentPermalink'] . '">'. $category['parent'] . '</a><span class="colon">:</span>';
  }
  
  if (!$post_sponsor_src && !$sponsor_src) {
    return '<div class="header-feature-category">' . $cat_parent .
      '<a class="link h-5" href="' . $category['permalink'] . '">
        <span class="header-feature-category-item">' . $category['name'] . '</span>
      </a>
    </div>';
  } else {
    return '<div class="header-feature-category">' . $cat_parent .
      '<a class="link h-5" href="' . $category['permalink'] . '">
        <span class="header-feature-category-item">' . $category['name'] . '</span>
      </a>
      <i class="header-feature-category-item icon-close"></i>
      <a class="link h-5" href="' . $sponsor_url . '" target="_blank">
        <img class="category-logo" src="' . $sponsor_src . '">
      </a>
    </div>';
  }
}

function fix_url($url) {
  if ($url) {
    if (strpos($url, 'http://') !== false) {
      // has http included;
      return $url; 
    } else {
      return 'http://' . $url;
    }
  }
}


//----------------------
// Get inline gallery
// ---------------------
 add_filter( 'use_default_gallery_style', '__return_false' );
 
 // Custom filter function to modify default gallery shortcode output
 function my_post_gallery( $output, $attr ) {
  
 	// Initialize
 	global $post, $wp_locale;
  
 	// Gallery instance counter
 	static $instance = 0;
 	$instance++;
  
 	// Validate the author's orderby attribute
 	if ( isset( $attr['orderby'] ) ) {
 		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
 		if ( ! $attr['orderby'] ) unset( $attr['orderby'] );
 	}
  
 	// Get attributes from shortcode
 	extract( shortcode_atts( array(
 		'order'      => 'ASC',
 		'orderby'    => 'menu_order ID',
 		'id'         => $post->ID,
 		'itemtag'    => 'li',
 		'icontag'    => 'li',
 		'captiontag' => 'dd',
 		'columns'    => 3,
 		'size'       => 'thumbnail',
 		'include'    => '',
 		'exclude'    => ''
 	), $attr ) );
  
 	// Initialize
 	$id = intval( $id );
 	$attachments = array();
 	if ( $order == 'RAND' ) $orderby = 'none';
  
 	if ( ! empty( $include ) ) {
  
 		// Include attribute is present
 		$include = preg_replace( '/[^0-9,]+/', '', $include );
 		$_attachments = get_posts( array( 'include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
  
 		// Setup attachments array
 		foreach ( $_attachments as $key => $val ) {
 			$attachments[ $val->ID ] = $_attachments[ $key ];
 		}
  
 	} else if ( ! empty( $exclude ) ) {
  
 		// Exclude attribute is present 
 		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
  
 		// Setup attachments array
 		$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
 	} else {
 		// Setup attachments array
 		$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
 	}
  
 	if ( empty( $attachments ) ) return '';
  

  
 	// Filter tags and attributes
 	$itemtag = tag_escape( $itemtag );
 	$captiontag = tag_escape( $captiontag );
 	$columns = intval( $columns );
 	$itemwidth = $columns > 0 ? floor( 100 / $columns ) : 100;
 	$float = is_rtl() ? 'right' : 'left';
 	$selector = "gallery-{$instance}";
  
 	// Filter gallery CSS
 	$output = apply_filters( 'gallery_style', "
 		<div id='$selector' class='gallery frame-inline galleryid-{$id}'><div class='slidee'>"
 	);
  
 	// Iterate through the attachments in this gallery instance
 	$i = 0;
 	foreach ( $attachments as $id => $attachment ) {
  
 		// Attachment link
 	  // 	$link = isset( $attr['link'] ) && 'file' == $attr['link'] ?  : wp_get_attachment_link( $id, $size, true, false );
   $img = wp_get_attachment_image_src( $id, 'large');
   $width = $img[1];
   $height = $img[2];
   
 		// Start itemtag
 		$output .= "<div class='sly-slide'>";
  
 		$output .= "<img data-src='". $img[0] . "' data-width='". $width . "' data-height='". $height . "'>";
  
 		// End itemtag
 		$output .= "<div class='shades'></div></div>";
  
 		// Line breaks by columns set
 	// 	if($columns > 0 && ++$i % $columns == 0) $output .= '<br style="clear: both">';
  
 	}
  
 	// End gallery output
 	$output .= "</div>
    <div class='sly-controls'>
      <button class='gallery-home button button-white' id='inline-gallery-home'>back to start</button>
      <button class='sly-prev'><i class='icon-arrow-left'></i></button>
      <button class='sly-next'><i class='icon-arrow-right'></i></button>
    </div></div>";
  
 	return $output;
  
 }
  
 // Apply filter to default gallery shortcode
 add_filter( 'post_gallery', 'my_post_gallery', 10, 2 );
?>
