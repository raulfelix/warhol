<?php
  $next_post = get_previous_post(true, '', get_taxonomy_name($post->post_type));
  $post_thumbnail_id = null;
  
  if ( !empty($next_post) ):
    $post_thumbnail_id = get_post_thumbnail_id( $next_post->ID );
?>
  <script type="text/javascript">
    LWA.hasNextPost = true;
  </script>

  <div class="gallery-next" data-closeable="0">
    <div class="h-3">Next up...</div>
    <div class="thumb" data-closeable="0">
      <a href="<?php echo get_permalink( $next_post->ID ); ?>" class="thumb-feature">
        <?php 
          if ( strlen( $post_thumbnail_id) > 0  ) { 
            $img_url = wp_get_attachment_image_src( $post_thumbnail_id, 'large' );
            echo '<img src="'. $img_url[0] . '">';
          }
        ?>
        <div class="blanket-light"></div>
      </a>
    </div>
    <a href="<?php echo get_permalink( $next_post->ID ); ?>" class="h-1"><?php echo $next_post->post_title; ?></a>
    <div class="h-4"><?php echo get_the_subtitle( $next_post->ID ); ?></div>
  </div>
<?php else: ?>
  <script type="text/javascript">
    LWA.hasNextPost = false;
  </script>
<?php
  endif;
?>