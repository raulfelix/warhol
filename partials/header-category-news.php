<header class="header header-feature header-category">
  <div class="header-feature-bg"></div>

  <?php get_template_part('partials/header', 'nav'); ?>

  <div class="f-grid f-row">
    <div class="f-1">
      <div class="header-category-content">
        <div class="header-category-h1">News</div>
        <div class="header-category-h2">
          <?php 
            global $post;
            $a = category(get_post_type($post));
            echo $a["name"];
          ?>
        </div>
      </div>
    </div>
  </div>
</header>