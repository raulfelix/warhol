Life Without Andy
======
[Life Without Andy](http://www.lifewithoutandy.com) is a place to see photography, music, food, travel, fashion, tv and movie content that will make you smile and appreciate this amazing world that we live in.

Our website is built using the latest HTML5, CSS3 and Javascript features to provide you with an awesome experience across all sorts of devices... so enjoy!

# Site Deployment #

## Prerequisites ##
1. Download Wordpress on target server
2. Create a database and edit **wp-config.php** with database settings
3. Install Wordpress

## Theme ##
Cd into the **wordpress/wp-content/themes** directory and clone the LWA theme
``` 
git clone https://raulfelix@bitbucket.org/newbuild/warhol.git
```
Active the LWA theme within Wordpress

## Install Plugins ##
In order for the LWA theme to function the following plugins are required

* [Video Embedder](http://nextgenthemes.com/plugins/advanced-responsive-video-embedder/)
* [Attachments](https://github.com/jchristopher/attachment)
* BAW Post Views Count
* KIA Subtitle
* Simple Term Meta

##### Plugin settings #####
Apply settings for BAW Post View Counts as follows

* **Count format:**  %count%
* Deselect posts and check featured/news for count tracking

## Create Navigation ##
1. Create pages to match primary nav elements
2. Create categories to tag by
3. Add the **Add to homepage carousel** category under **carousel**

## Site Settings ##
##### Site Address #####
1. Go to **Settings > General**
2. Set the "Site address" field to a root URL removing the "/wordpress"

##### Site home page #####
1. Go to **Settings > Reading**
2. Set a static front page to the **home** template

##### Site pretty permalinks #####
1. Go to **Settings > Permalinks**
2. Set permalinks to "postname"

##### Site/Server settings #####
At the sites root level