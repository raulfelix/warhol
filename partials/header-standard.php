<header class="header">
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