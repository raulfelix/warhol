<?php

/**
 * Template Name: info
 */

  get_header();
?>

<div class="f-grid f-row">
  <div class="f-5-6 f-center bp1-1">
    <div class="section">
      <div class="section-article">
        <?php 
          if (have_posts()): while (have_posts()): the_post();
            the_content(); 
          endwhile; endif;
        ?>
      </div>
      <a name="disclaimer" href="#disclaimer"></a>
    </div>
  </div>
</div>

<?php 
  get_footer(); 
?>