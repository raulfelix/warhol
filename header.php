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
  <title></title>

  <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/static/images/favicon.ico">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">

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
</head>

<body>

  <?php 
    if ( is_page('home') ) {
      get_template_part('partials/header', 'home');
    } 
    else if ( is_page('info') || is_author()) {
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