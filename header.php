<?php
/*
 * The Header
 */
?>

<!DOCTYPE html>

<html <?php language_attributes(); ?>>
<head>
  <meta name="viewport" content="width=device-width">
  <title></title>

  <!--link rel="icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico"-->
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">
  <?php wp_head(); ?>
</head>

<body>
  <?php 
    if ( is_page('home') ) {
    } 
    else if ( is_page() ) {
      get_template_part('partials/header', 'category');
    }
    else {
      get_template_part('partials/header', 'feature');
    }
  ?>