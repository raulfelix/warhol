<?php 
  $attachments = new Attachments( 'my_attachments', get_the_id() );
  $feature = wp_get_attachment_image_src( get_post_thumbnail_id(), 'original');
  if ($feature) {
    $feature_src = $feature[0];
  }
?>

<script type="text/javascript">
  window.LWA = window.LWA || { Views: {}, Modules: {}};

  LWA.GalleryData = {
    gallery: [
    <?php while( $attachments->get() ) : ?>
      { src: "<?php echo $attachments->src( 'original' ); ?>" },
    <?php endwhile; ?>
    ],
    feature: "<?php echo $feature_src; ?>"
  };
</script>