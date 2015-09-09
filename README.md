Life Without Andy
======
[Life Without Andy](http://www.lifewithoutandy.com) is a place to see photography, music, food, travel, fashion, tv and movie content that will make you smile and appreciate this amazing world that we live in.

Our website is built using the latest HTML5, CSS3 and Javascript features to provide you with an awesome experience across all sorts of devices... so enjoy!

-----------------------

# Installation guide #

## Prerequisites ##
1. Download Wordpress on target server
2. Create a database and edit **wp-config.php** with database settings
3. Install Wordpress
4. Create Wordpress options (wp_options) to store the Instagram API access token. Name it: **instagram_access_token**
5. Turn off google analytics tracking for non-production installs by editing header.php ga code element


## Theme ##
` cd ` into the `wordpress/wp-content/themes` directory and clone the LWA theme
``` 
git clone https://raulfelix@bitbucket.org/newbuild/warhol.git
```
Activate the theme from within Wordpress admin console

## Install Plugins ##
In order for the LWA theme to function the following plugins are required:

* [Video Embedder](http://nextgenthemes.com/plugins/advanced-responsive-video-embedder/)
* [Attachments](https://github.com/jchristopher/attachments)
* BAW Post Views Count
* KIA Subtitle
* Simple Term Meta

##### BAW Post View Count settings #####

* Set the **Count format:**  `%count%`
* Deselect posts and check **featured/news** for count tracking

## Navigation structure ##
1. Create pages to match primary nav elements
2. Create categories to tag by
3. Add the `Add to homepage carousel` category under **carousel**

## Site Settings ##
##### Site Address #####
1. Go to `Settings > General`
2. Set the `Site address` field to a root URL removing the `/wordpress`

##### Site home page #####
1. Go to `Settings > Reading`
2. Set a static front page to the `home` template

##### Site pretty permalinks #####
1. Go to `Settings > Permalinks`
2. Set permalinks to `postname`

##### Site/Server settings #####
At the server root level e.g. public_html folder create a **.htaccess** file with the following:

```
# BEGIN WordPress

<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>

# END WordPress
```

At the server root level e.g. public_html folder create an **index.php** file with the following:


```
#!php

<?php
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */
require( dirname( __FILE__ ) . '/wordpress/wp-blog-header.php' );

```