<?php
/*
 * The Header
 */
?>

<!DOCTYPE html>

<html <?php language_attributes(); ?>>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
  <title><?php wp_title(''); ?></title>

  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/static/images/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_template_directory_uri(); ?>/static/images/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/static/images/favicon-16x16.png">
  
  <?php if ( is_single() ): ?>
    <meta property="og:title" content="<?php echo the_title() ?>" />
    <meta property="og:site_name" content="Life Without Andy"/>
    <meta property="og:url" content="<?php echo get_the_permalink() ?>" />
    <meta property="fb:app_id" content="161339120705340" />
    <meta property="og:image" content="<?php echo get_search_thumbnail() ?>" />
  <?php endif; ?>

  <?php wp_head(); ?>

  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-41298642-1', 'auto');
    ga('send', 'pageview');

  </script>

  <script async src="//www.googletagservices.com/tag/js/gpt.js"> </script>
 
  <script type='text/javascript'>
    var googletag = googletag || {};
    googletag.cmd = googletag.cmd || [];
    
    googletag.cmd.push(function() {
      var mapping = googletag.sizeMapping().
      addSize([1009, 0], [970, 90]).
      addSize([759, 0], [728, 90]).  
      addSize([487, 0], [468, 60]).  
      addSize([1, 0], [300, 250]).
      build();

      googletag
        .defineSlot('/27068509/LWA_leaderboard_01', [970, 90], 'div-gpt-ad-1412722263572-0')
        .defineSizeMapping(mapping)
        .addService(googletag.pubads());
      
      var bottomLeaderBoardmapping = googletag.sizeMapping().
        addSize([1024, 0], [970, 250]).
        addSize([980, 0], [728, 90]).
        addSize([487, 0], [468, 60]).
        addSize([1, 0], [300, 250]). 
        build();
        
      googletag
        .defineSlot('/27068509/LWA_leaderboard_bottom_article', [[300, 250], [728, 90], [970, 250], [468, 60]], 'div-gpt-ad-1454153553644-0')
        .defineSizeMapping(bottomLeaderBoardmapping)
        .addService(googletag.pubads());
      // googletag.pubads().enableSingleRequest();
      // googletag.enableServices();
        
      googletag.defineSlot('/27068509/LWA_sidebar_01', [300, 250], 'div-gpt-ad-1453979832228-0').addService(googletag.pubads());
      googletag.defineSlot('/27068509/LWA_sidebar_02', [300, 600], 'div-gpt-ad-1453981103890-0').addService(googletag.pubads());
      googletag.defineSlot('/27068509/LWA_leaderboard_bottom', [970, 250], 'div-gpt-ad-1454150799057-0')
        .defineSizeMapping(bottomLeaderBoardmapping)
        .addService(googletag.pubads());
      googletag.pubads().enableSingleRequest();
      googletag.enableServices();
    });
  </script>
  
  <script>
    (function() {
      var _fbq = window._fbq || (window._fbq = []);
      if (!_fbq.loaded) {
      var fbds = document.createElement('script');
      fbds.async = true;
      fbds.src = '//connect.facebook.net/en_US/fbds.js';
      var s = document.getElementsByTagName('script')[0];
      s.parentNode.insertBefore(fbds, s);
      _fbq.loaded = true;
      }
      _fbq.push(['addPixelId', '916483698389722']);
    })();
    
    window._fbq = window._fbq || [];
    window._fbq.push(['track', 'PixelInitialized', {}]);
  </script>
  <noscript>
    <img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=916483698389722&amp;ev=PixelInitialized" />
  </noscript>
  
</head>

<body>
  <?php get_template_part('partials/header', 'social'); ?>
  <?php get_template_part('partials/header', 'nav'); ?>
  
  <?php 
    if ( is_page('home') ) {
      get_template_part('partials/header', 'home');
    } 
    else if ( is_page(array('info', 'subscribe', 'subscribed', 'contributors')) || is_author()) {
      get_template_part('partials/header', 'info');
    }
    else if ( is_tax('news_tax') || is_tax('featured_tax') ) {
      get_template_part('partials/header', 'category');
    }
    else if ( is_tax('featured_tax') ) {
      get_template_part('partials/header', 'category-featured');
    }
    else {
      get_template_part('partials/header', 'feature');
    }
  ?>
  