<?php 
  
  // check if there is a gallery associated with the post
  $attachments = new Attachments( 'my_attachments', get_the_id() );
  $post_type = get_post_type( get_the_ID() );
  if ( $attachments->exist() && $post_type != 'lwa_news' ):
    wp_enqueue_script( 'gallery-build' );
  ?>
 
<div id="modal-gallery" class="modal modal-transparent modal-gallery">
  <button class="modal-action modal-close"><i class="icon-close"></i></button>
  <button class="modal-action modal-gallery-thumbs"><i class="icon-thumbs"></i></button>
  <div class="modal-gallery-count"></div>
  
  <div class="modal-wrap">
    <div class="modal-wrap-row">
      <div id="modal-gallery-frame" class="modal-view frame">
        <ul class="slidee">
          <?php 
            while( $attachments->get() ) : ?>
            <li>
              <img src="<?php echo $attachments->src( 'large' ); ?>">
              <div class="modal-gallery-caption"><?php echo $attachments->field( 'caption' ); ?></div>
            </li>
          <?php endwhile; ?>
        </ul>
      </div>
      <div class="sly-controls">
        <button class="sly-prev"><i class="icon-arrow-left"></i></button>
        <button class="sly-next"><i class="icon-arrow-right"></i></button>
      </div>
    </div>
  </div>
</div>

<header class="header header-feature header-gallery">
  <div class="header-gallery-wrap">
    <?php get_template_part('partials/header', 'nav'); ?>

    <div class="m-wrap m-transparent">
      <div id="inline-gallery-frame" class="header-feature-bg header-gallery-frame frame" >
        <ul class="media-target slidee" data-type="inline">
          <?php 
            $is_first = true;
            $attachments->rewind();
            while( $attachments->get() ) : ?>
            <li class="header-gallery-overlay">
              <?php echo $attachments->image( 'original' ); ?>
              
              <?php 
                if ($is_first) {
                  $title = get_the_title();
                } 
                $is_first = false;
              ?>

            </li>
          <?php endwhile; ?>
        </ul>
      </div>
    
      <div class="header-gallery-content">
        <div class="f-grid f-row">
          <div class="f-1">
            <div class="header-content">
              <div id="header-gallery-title" class="h-1"><?php echo $title; ?></div>
            </div>
            <div id="inline-gallery-controls" class="sly-controls">
              <div class="f-1">
                <button class="sly-prev"><i class="icon-arrow-left"></i></button>
                <button class="sly-next"><i class="icon-arrow-right"></i></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    
      <div class="header-gallery-controls">
        <button id="gallery-thumbs" class="button button-gallery"><i class="icon-thumbs"></i></button>
        <button id="modal-gallery-button" class="button button-gallery"><i class="icon-expand"></i></button>
      </div>
    </div>
  </div>
  
  <img id="header-loader" class="loader-icon loader-show" src="<?php bloginfo('template_directory'); ?>/static/images/loader.GIF " />
  
  <div id="header-gallery-thumbs" class="header-gallery-thumbs frame">
    <ul class="slidee">
      <?php 
        $attachments->rewind();
        while( $attachments->get() ) : 
      ?>
        <li><?php echo $attachments->image( 'thumbnail' ); ?></li>
      <?php endwhile; ?>
    </ul>
    <div class="sly-controls">
      <button class="sly-prev"><i class="icon-arrow-left"></i></button>
      <button class="sly-next"><i class="icon-arrow-right"></i></button>
    </div>
  </div>
</header>

<?php
  else:

    if ( has_a_feature_image() ) {
      get_template_part('partials/header', 'featured');
    } else {
      get_template_part('partials/header', 'standard');
    }
  
  endif;
?>