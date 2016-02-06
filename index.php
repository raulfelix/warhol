<?php
/**
 * Home page template
 */
?>

<?php get_header(); ?>

  <!-- featured articles -->
  <div id="feature-waypoint"></div>
  
  <div class="row-ad">
  
  </div>
  
  <!-- news articles -->
  <div id="news-waypoint" class="section-thumb-bg"></div>

<?php 
  wp_enqueue_script( 'home' );
  wp_enqueue_script( 'bundle' );
  get_footer(); 
?>