<?php

// ------------------------------ 
// theme support
// ------------------------------ 
add_theme_support( 'post-thumbnails' ); 

register_nav_menu( 'primary', 'Primary Menu' );

// ------------------------------ 
// add app JS in footer of page
// ------------------------------ 
function add_scripts() {
  // wp_register_script( 'jq', get_template_directory_uri() . '/scripts/jquery-2.0.3.min.js', null, '', true );
  wp_register_script( 'build', get_template_directory_uri() . '/scripts/build.js', null, '', true );
  // wp_register_script( 'slider', get_template_directory_uri() . '/scripts/jquery.flexslider-min.js', array( 'jq' ), '', true );
  
  // wp_enqueue_script( 'jq' );
  // wp_enqueue_script( 'dist' );
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
// function my_attachments( $attachments )
// {
//   $fields         = array( );

//   $args = array(

//     // title of the meta box (string)
//     'label'         => 'Gallery Images',

//     // all post types to utilize (string|array)
//     'post_type'     => array( 'post'),

//     // meta box position (string) (normal, side or advanced)
//     'position'      => 'side',

//     // meta box priority (string) (high, default, low, core)
//     'priority'      => 'high',

//     // allowed file type(s) (array) (image|video|text|audio|application)
//     'filetype'      => array('image'),

//     // include a note within the meta box (string)
//     'note'          => 'Please add your gallery images here.',

//     // by default new Attachments will be appended to the list
//     // but you can have then prepend if you set this to false
//     'append'        => true,

//     // text for 'Attach' button in meta box (string)
//     'button_text'   => __( 'Add to an image to gallery', 'attachments' ),

//     // text for modal 'Attach' button (string)
//     'modal_text'    => __( 'Add', 'attachments' ),

//     // which tab should be the default in the modal (string) (browse|upload)
//     'router'        => 'browse',

//     // fields array
//     'fields'        => $fields,

//   );

//   $attachments->register( 'my_attachments', $args ); // unique instance name
// }
// add_action( 'attachments_register', 'my_attachments' );
 
// ?>