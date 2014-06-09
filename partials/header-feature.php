<?php 
  
  // check if there is a gallery associated with the post
  $attachments = new Attachments( 'my_attachments', get_the_id() );
  if ( $attachments->exist() ):
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
    <div id="inline-gallery-frame" class="header-feature-bg header-gallery-frame frame" >
      <ul class="slidee">
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
    
    <?php get_template_part('partials/header', 'nav'); ?>
    
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
    $is_feature = has_post_thumbnail( get_the_id() );
    if ($is_feature === true) {
      $img_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'original');
    }  
?>

  <header class="header <?php echo ($is_feature === true) ? 'header-feature': 'header-not-feature' ?>">
    <?php if ($is_feature === true): ?>
      <div class="m-wrap m-transparent">
        <div class="m-bg header-feature-bg" style="background-image: url(<?php echo $img_url[0] ?>);"></div>
        <div class="m-overlay blanket-light"></div>
      </div>
    <?php endif; ?>
    
    <?php get_template_part('partials/header', 'nav'); ?>

    <div class="f-grid f-row">
      <div class="f-1 content-wrap">
        <div class="content-row">
          <div class="header-content">
            <?php $category = category($post->post_type); ?>
            <a class="link h-5" href="<?php echo $category['permalink']; ?>"><?php echo $category['name']; ?></a>
            <div class="h-1"><?php the_title(); ?></div>
            <div class="h-4"><?php the_subtitle(); ?></div>
          </div>
        </div>
      </div>
    </div>
  </header>

<?php
  endif;
?>