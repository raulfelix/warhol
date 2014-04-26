<header class="header feature category">
  <div class="feature-bg"></div>

  <?php get_template_part('partials/header', 'nav'); ?>

  <div class="f-grid f-row">
    <div class="f-1">
      <div class="content">
        <div class="f-1-2">
          <h1 class="category-h1"><?php the_title(); ?></h1>
          <h2 class="category-h2"><?php the_subtitle(); ?></h2>
        </div>
        <div class="f-1-2 category-branding">
          <!-- <h2 class="category-h2">in partnership with</h2>
          <img src="../images/red_bull.png"> -->
        </div>
      </div>
    </div>
  </div>
</header>