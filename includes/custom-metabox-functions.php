<?php

/*
 * Adding custom meta boxes to admin.
 */

function add_custom_meta_box() {
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
add_action( 'add_meta_boxes', 'add_custom_meta_box' );

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

?>