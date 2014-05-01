<?php
  /*
   * Standard thumbnail layout
   */
  $category = category($post->post_type);
?>

<div class="thumb">
  <a class="h-5 thumb-link" href="<?php echo $category['permalink']; ?>"><?php echo $category['name']; ?></a>
  <div class="thumb-feature">
     <?php get_thumbnail(); ?>  
    <span class="thumb-time"><?php when(); ?></span>
    <span class="thumb-views data-views"><i class="icon-views"></i><?php views(); ?></span>
  </div>
  <a href="<?php echo the_permalink(); ?>" class="h-2 thumb-title"><?php the_title(); ?></a>
  <div class="h-5 thumb-caption"><?php the_subtitle(); ?></div>
</div>