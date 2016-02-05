<?php
/**
 * The Template for displaying all single posts
 */

  get_header();
?>
  <!-- LWA_leaderboard_01 -->
  <div id='div-gpt-ad-1412722263572-0' class="row-ad">
    <script type='text/javascript'>
      googletag.cmd.push(function() { 
        googletag.display('div-gpt-ad-1412722263572-0'); 
      });
    </script>
  </div>

  <div id="fb-root"></div>
  <script>
    window.fbAsyncInit = function() {
      FB.init({
        appId      : 161339120705340,
        xfbml      : true,
        version    : 'v2.0'
      });
    };
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  </script>

  <?php
    
    if (have_posts()): while (have_posts()): the_post();
      get_template_part( 'partials/article', 'content' );
      get_template_part( 'partials/module', 'share' );
      get_template_part( 'partials/module', 'subscribe' );
      get_template_part( 'partials/module', 'editors-pick' );
    endwhile; endif;
  ?>
  
<?php
  wp_enqueue_script( 'single' );
  wp_enqueue_script( 'bundle' );
  get_footer(); 
?>