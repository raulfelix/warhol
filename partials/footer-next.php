<?php
  /*
   * Next up footer. 
   * If there is a feature image it will display it else 
   * renders an imageless view.
   */
  $next_post = get_previous_post(true, '', get_taxonomy_name($post->post_type));
  $post_thumbnail_id = null;
?>

<?php
  if ( !empty($next_post) ): 
    $next_css = 'footer-next';
    $post_thumbnail_id = get_post_thumbnail_id( $next_post->ID );
    if (strlen( $post_thumbnail_id) > 0 ):
      $next_css = 'footer-next footer-next-feature';
      $img_url = wp_get_attachment_image_src( $post_thumbnail_id, 'original' );
    endif;
  endif; 
?>

<?php get_template_part('partials/footer', 'up'); ?>

<footer class="footer <?php echo $next_css; ?>">

  <?php  if ( strlen( $post_thumbnail_id) > 0 ): ?>
    <div class="m-wrap m-transparent">
      <div class="media-target-footer footer-next-bg" style="background-image: url(<?php echo $img_url[0] ?>);" data-type="background"></div>
      <div class="m-overlay blanket"></div>
    </div>
  <?php endif; ?>

  <?php if ( !empty($next_post) ): ?>
    <a class="footer-navigate" href="<?php echo get_permalink( $next_post->ID ); ?>">
      <div class="f-grid f-row">
        <div class="f-1 content-wrap">
          <div class="content-row">
            <div class="footer-next-content">
              <h3 class="h-3">Next up...</h3>
              <h1 class="h-1"><?php echo $next_post->post_title; ?></h1>
              <h4 class="h-4"><?php echo get_the_subtitle( $next_post->ID ); ?></h4>
            </div>
          </div>
        </div>
      </div>
    </a>
  <?php endif; ?>

  <?php get_template_part('partials/footer', 'legals'); ?>
</footer>