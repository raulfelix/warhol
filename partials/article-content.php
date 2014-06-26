<div class="article-row f-grid f-row">
  <div class="f-1">
    <div class="details-row">
      <?php $category = category($post->post_type); ?>
      <a href="<?php echo $category['permalink']; ?>"><?php echo $category['name']; ?></a>
      <div class="details-row-right">
        <span class="fb-like" data-href="<?php echo the_permalink(); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></span>
      </div>
      <a class="button button-share" href="javascript:void(0)"><i class="icon-share"></i>share this</a>
    </div>
    
    <div class="article-row-content">
      <?php the_content(); ?>
    </div>
   
    <div class="details-row details-row-secondary">
      <?php 
        $words_by = get_post_meta( get_the_id(), 'credits_author_key', true );
        $photos_by = get_post_meta( get_the_id(), 'credits_photos_key', true );
      ?>

      <?php if ($words_by): ?>
        Words by <?php echo $words_by; ?>
        <span class="bullet"></span>
      <?php endif; ?>
      
      <?php if ($photos_by): ?>
        Photos by <?php echo $photos_by; ?>
        <span class="bullet"></span>
      <?php endif; ?>
      
      <?php echo get_the_time( get_option('date_format')) ?>
    </div>
  </div>
</div>