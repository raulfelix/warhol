/* global LWA, imagesLoaded */
window.LWA = window.LWA || { Views: {}, Modules: {} };

/* 
 * Depedencies: 
 * - jquery
 * - imagesLoaded
 */
LWA.Modules.Loader = (function() {

  var Feature = {
    init: function() {

    }
  };

  var BackgroundImages = {

    init: function(selector, container) {
      // if there are background images get them
      // and add to a temporary array 
      var images = $('img'),
        $container = $(selector).each(function() {
          var image =
            $(this)
              .css('background-image')
              .match(/url\((['"])?(.*?)\1\)/);

          if (image) {
            images = images.add($('<img>').attr('src', image.pop()));
          }
        });

      if (container !== undefined) {
        $container = $(container);
      }

      imagesLoaded(images, function(instance) {
        $container.removeClass('m-transparent');
      });
    }
  };

  return {
    init: function(selector, container) {
      BackgroundImages.init(selector, container);
    }
  };

})();

LWA.Modules.Loader.init('.m-bg', '.m-wrap');