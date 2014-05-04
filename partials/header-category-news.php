<header class="header feature category">
  <div class="feature-bg"></div>

  <?php get_template_part('partials/header', 'nav'); ?>

  <div class="f-grid f-row">
    <div class="f-1">
      <div class="content">
        <div class="f-1-2">
          <div class="category-h1">News</div>
          <div class="category-h2">
            <?php 
              global $post;
              echo( category($post->post_type)['name'] );
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>