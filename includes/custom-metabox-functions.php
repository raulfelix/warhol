<?php

/*
 * Adding custom meta boxes to admin.
 */

function add_custom_meta_box() {
  $screens = array( 'lwa_feature', 'lwa_news' );
  foreach ( $screens as $screen ) {
    add_meta_box('photos_id', 'Credits', 'photos_meta_box_callback', $screen);
    add_meta_box('post_sponsor', 'Sponsor details', 'post_sponsor_meta_box_callback', $screen);
  }

  add_meta_box('shop_url', 'Shop URL', 'shop_meta_box_callback', 'lwa_shop');
  add_meta_box('news_featured_url', 'Show post in featured section', 'news_featured_meta_box_callback', 'lwa_news');
}
add_action( 'add_meta_boxes', 'add_custom_meta_box' );

function photos_meta_box_callback( $post ) {

  // Add an nonce field so we can check for it later.
  wp_nonce_field( 'photos_meta_box', 'photos_meta_box_nonce' );

  $photos_by_id = get_post_meta( $post->ID, 'photos_key', true );
  $filmed_by_id = get_post_meta( $post->ID, 'filmed_key', true );

  // get all the users in the system and present in a drop down
  $users = get_users(array(
    'fields'  => 'all_with_meta',
    'orderby' => 'display_name'
  ));

  echo '<label class="selectit label-heximus">Photos by</label>';
  echo '<select name="photos_author" id="photos_author" style="margin-bottom: 20px;">';
  echo '<option value=""></option>';

  foreach ($users as $user): ?>
    <option value="<?php echo $user->ID ?>" <?php echo $photos_by_id == $user->ID ? 'selected="selected"' : ''?> ><?php echo $user->display_name ?></option>
  <?php
  endforeach;

  echo '</select>';
  
  echo '<label class="selectit label-heximus">Filmed by</label>';
  echo '<select name="filmed_author" id="filmed_author">';
  echo '<option value=""></option>';

  foreach ($users as $user): ?>
    <option value="<?php echo $user->ID ?>" <?php echo $filmed_by_id == $user->ID ? 'selected="selected"' : ''?> ><?php echo $user->display_name ?></option>
  <?php
  endforeach;

  echo '</select>';
}

function photos_save_meta_box_data( $post_id ) {

  // Bail if we're doing an auto save
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
  
  // Check if our nonce is set.
  if ( ! isset( $_POST['photos_meta_box_nonce'] ) ) return;

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $_POST['photos_meta_box_nonce'], 'photos_meta_box' ) ) return;

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
  if ( !isset( $_POST['photos_author'] ) ) return;

  // Sanitize input
  $photos = sanitize_text_field( $_POST['photos_author'] );
  $filmed = sanitize_text_field( $_POST['filmed_author'] );

  // if the value is empty remove it from DB
  if ( strlen($photos) == 0 ) {
    delete_post_meta($post_id, 'photos_key');
  } else {
    update_post_meta( $post_id, 'photos_key', $photos );
  }
  
  if ( strlen($filmed) == 0 ) {
    delete_post_meta($post_id, 'filmed_key');
  } else {
    update_post_meta( $post_id, 'filmed_key', $filmed );
  }
}
add_action( 'save_post', 'photos_save_meta_box_data' );


/*
 * Shop URL meta box
 */
function shop_meta_box_callback( $post ) {

  // Add an nonce field so we can check for it later.
  wp_nonce_field( 'shop_meta_box', 'shop_meta_box_nonce' );

  $value = get_post_meta( $post->ID, 'shop_url_key', true );

  echo '<div class="c-inline-field"><label for="shop_url_field">http://</label>';
  echo '<input class="c-shop widefat" type="text" id="shop_url_field" name="shop_url_field" value="' . esc_attr( $value ) . '"/></div>';
  echo '<p>Defaults to: lifewithoutandy.myshopify.com</p>';
}

function shop_save_meta_box_data( $post_id ) {

  // Check if our nonce is set.
  if ( ! isset( $_POST['shop_meta_box_nonce'] ) ) {
    return;
  }

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $_POST['shop_meta_box_nonce'], 'shop_meta_box' ) ) {
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
  if ( !isset( $_POST['shop_url_field'] ) ) {
    return;
  }

  // Sanitize input
  $shop_url = sanitize_text_field( $_POST['shop_url_field'] );

  // Update the meta field in the database.
  update_post_meta( $post_id, 'shop_url_key', $shop_url );
}
add_action( 'save_post', 'shop_save_meta_box_data' );


/*
 * Add a news post to featured setion on homepage
 */
function news_featured_meta_box_callback( $post ) {

  // Add an nonce field so we can check for it later.
  wp_nonce_field( 'news_featured_meta_box', 'news_featured_meta_box_nonce' );

  $value = get_post_meta( $post->ID, 'news_featured_key', true );
  if ($value == "" || $value == 0) {
    $checked = "";  
  } else {
    $checked = "checked";  
  }
  echo '<div>
    <label class="selectit" for=news_featured_field">
      <input type="checkbox" id="news_featured_field" name="news_featured_field" value="' . esc_attr( $value ) . '" ' . $checked .'/> Display as featured post</label>
      </div>';
}

function news_featured_save_meta_box_data( $post_id ) {

  if ( ! isset( $_POST['news_featured_meta_box_nonce'] ) ) {
    return;
  }

  if ( ! wp_verify_nonce( $_POST['news_featured_meta_box_nonce'], 'news_featured_meta_box' ) ) {
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

  
  if ( !isset( $_POST['news_featured_field'] ) ) {
    // todo delete row from table if not set otherwise flag with a 1
    delete_post_meta($post_id, 'news_featured_key');
  } else {
    update_post_meta( $post_id, 'news_featured_key', 1 );
  }
}
add_action( 'save_post', 'news_featured_save_meta_box_data' );


//
// Post sponsor
// 
function post_sponsor_meta_box_callback( $post ) {

  // Add an nonce field so we can check for it later.
  wp_nonce_field( 'post_sponsor_meta_box', 'post_sponsor_meta_box_nonce' );

  $sponsor_src = get_post_meta( $post->ID, 'post_sponsor_src', true );
  $sponsor_url = get_post_meta( $post->ID, 'post_sponsor_url', true );
  
  ?>
    <label for="post_sponsor_url" style="font-weight:bold;margin-bottom: 5px; display:block;">Logo</label>
  
    <a class="c-post-dark-wrapper" data-input="#c-sponsor-url" data-uploader-title="Set sponsor image" href="<?php echo get_home_url(); ?>/wp-admin/media-upload.php?type=image" id="set-sponsor-thumbnail">
      <?php if ($sponsor_src): ?>
        <img src="<?php echo $sponsor_src; ?>">
      <?php else: ?>
        Set image
      <?php endif; ?>
    </a>
  
    <a data-input="#c-sponsor-url" href="#" id="c-sponsor-url-remove" style="display: <?php echo ($sponsor_src) ? 'block':'none'?>;" class="c-remove">Remove image</a>
    <input type="hidden" value="<?php echo $sponsor_src; ?>" id="c-sponsor-url" name="post_sponsor_src"/>
    
    <div class="c-field-wrap">
      <label for="post_sponsor_url" style="font-weight:bold;margin: 5px 0; display:block;">Website</label>
      <input type="text" value="<?php echo $sponsor_url; ?>" name="post_sponsor_url"/>
      <p class="description">Enter a url e.g. www.name.com</p>
    </div>
  <?php
}

//
// Post sponsor
// 
function post_sponsor_save_meta_box_data( $post_id ) {

  // Bail if we're doing an auto save
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
  
  // Check if our nonce is set.
  if ( ! isset( $_POST['post_sponsor_meta_box_nonce'] ) ) return;

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $_POST['post_sponsor_meta_box_nonce'], 'post_sponsor_meta_box' ) ) return;

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
  if ( !isset( $_POST['post_sponsor_src'] ) || !isset( $_POST['post_sponsor_url'] ) ) return;

  // Sanitize input
  $value = sanitize_text_field( $_POST['post_sponsor_src'] );
  $value1 = sanitize_text_field( $_POST['post_sponsor_url'] );

  // if the value is empty remove it from DB
  if ( strlen($value) == 0 ) {
    delete_post_meta($post_id, 'post_sponsor_src');
  } else {
    update_post_meta( $post_id, 'post_sponsor_src', $value );
  }
  
  // if the value is empty remove it from DB
  if ( strlen($value1) == 0 ) {
    delete_post_meta($post_id, 'post_sponsor_url');
  } else {
    update_post_meta( $post_id, 'post_sponsor_url', $value1 );
  }
  
}
add_action( 'save_post', 'post_sponsor_save_meta_box_data' );
?>