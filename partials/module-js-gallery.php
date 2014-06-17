<?php 
  $attachments = new Attachments( 'my_attachments', get_the_id() );
?>

<script type="text/javascript">
  window.LWA = window.LWA || { Views: {}, Modules: {}};

  LWA.GalleryData = {
    gallery: [
    <?php while( $attachments->get() ) : ?>
      { src: "<?php echo $attachments->src( 'original' ); ?>" },
    <?php endwhile; ?>
    ],
    feature: "<?php echo wp_get_attachment_image_src( get_post_thumbnail_id(), 'original')[0]; ?>"
  };
</script>