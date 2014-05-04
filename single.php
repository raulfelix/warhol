<?php
/**
 * The Template for displaying all single posts
 */

  get_header();
?>

  <?php
    
    if (have_posts()): while (have_posts()): the_post();
      get_template_part( 'partials/article', 'content' );
      get_template_part( 'partials/module', 'share' );
    endwhile; endif;
    
  ?>
  
<?php get_footer(); ?>