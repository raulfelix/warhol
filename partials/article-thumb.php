<?php
  /*
   * Standard thumbnail layout
   */
  $category = category($post->post_type);
?>

<div class="thumb">
  <?php 
    if ($category['parent']):
  ?>
  <a class="h-5 thumb-link" href="<?php echo $category['parentPermalink']; ?>"><?php echo $category['parent']; ?></a><span class="colon">:</span>
  <?php 
    endif;
  ?>
  <a class="h-5 thumb-link" href="<?php echo $category['permalink']; ?>"><?php echo $category['name']; ?></a>
  <a href="<?php echo the_permalink(); ?>" class="thumb-feature">
     <?php get_thumbnail(false, $post->post_type === 'lwa_news' ? true : false); ?>  
     <div class="m-overlay blanket-light"></div>
    <span class="thumb-time"><?php when(); ?></span>
  </a>
  <a href="<?php echo the_permalink(); ?>" class="h-2 thumb-title"><?php the_title(); ?></a>
  <div class="thumb-caption"><?php the_subtitle(); ?></div>
</div>