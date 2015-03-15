<?php 
  $attachments = new Attachments( 'my_attachments', get_the_id() );
  $feature = wp_get_attachment_image_src( get_post_thumbnail_id(), 'original');
  if ($feature) {
    $feature_src = $feature[0];
  }
?>

<script type="text/javascript">
  window.LWA = { Data:{} };

  LWA.Data.Gallery = {
    feature: '<?php echo $feature_src; ?>',
    inline: [],
    thumbnails: []
  };

  <?php while( $attachments->get() ) : ?>
    LWA.Data.Gallery.inline.push({
      src: '<?php echo $attachments->src( "original" ); ?>',
      width: '<?php echo $attachments->width( "original" ); ?>',
      height: '<?php echo $attachments->height( "original" ); ?>',
      caption: '<?php echo $attachments->field( "caption" ); ?>'
    });
  
    LWA.Data.Gallery.thumbnails.push({
      src: '<?php echo $attachments->src( "thumbnail" ); ?>'
    });
  <?php endwhile; ?>

</script>