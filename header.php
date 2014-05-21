<?php
/*
 * The Header
 */
?>

<!DOCTYPE html>

<html <?php language_attributes(); ?>>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width">
  <title></title>

  <!--link rel="icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico"-->
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
  <?php wp_head(); ?>
</head>

<body>
  <?php 
    if ( is_page('home') ) {
      get_template_part('partials/header', 'home');
    } 
    else if ( is_tax('news_tax') ) {
      get_template_part('partials/header', 'category-news');
    }
    else if ( is_page() ) {
      get_template_part('partials/header', 'category');
    }
    else {
      get_template_part('partials/header', 'feature');
    }
  ?>