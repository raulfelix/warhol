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

  <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/static/images/favicon.ico">

  <script type="text/javascript" src="http://fast.fonts.net/jsapi/2193ac1a-a011-45fb-ba43-962a973eeea9.js"></script>
  <script type="text/javascript">
    WebFontConfig = { fontdeck: { id: '45215' } };

    (function() {
      var wf = document.createElement('script');
      wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
      '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
      wf.type = 'text/javascript';
      wf.async = 'true';
      var s = document.getElementsByTagName('script')[0];
      s.parentNode.insertBefore(wf, s);
    })();
  </script>
  
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

      googletag.enableServices();
    });
  </script>
</head>

<body>

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