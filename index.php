<?php
/**
 * Home page template
 */
?>

<?php get_header(); ?>

  <!-- featured articles -->
  <div id="feature-waypoint"></div>
  
  <div class="row-ad">
    <!-- /27068509/LWA_leaderboard_02 -->
    <div id='div-gpt-ad-1454759838428-0'>
      <script type='text/javascript'>
        googletag.cmd.push(function() { googletag.display('div-gpt-ad-1454759838428-0'); });
      </script>
    </div>
  </div>
  
  <!-- news articles -->
  <div id="news-waypoint" class="section-thumb-bg"></div>

<?php 
  wp_enqueue_script( 'index' );
  get_footer(); 
?>