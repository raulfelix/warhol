/* global LWA, imagesLoaded */
window.Namespace('Modules');

/* 
 * Depedencies: 
 * - jquery
 * - imagesLoaded
 */
LWA.Modules.Loader = function(options) {

  var state = {
    loader: undefined,
    type: 'background'
  };

  var Images = {

    collectBackground: function(wrap) {
      var images = $('img');

      wrap.each(function() {
        var image = $(this)
          .css('background-image')
          .match(/url\((['"])?(.*?)\1\)/);

        if (image) {
          images = images.add($('<img>').attr('src', image.pop()));
        }
      });
      return images;
    },

    collectInline: function(wrap) {
      return wrap.find('img');
    },

    init: function(wrap, container) {

      var images, $container;

      if (state.type === 'background') {
        images = this.collectBackground(wrap);
      } else {
        images = this.collectInline(wrap);
      }

      $container = $(container);

      imagesLoaded(images, function(instance) {
        if (options.callback) {
          options.callback();
        }
        if (state.loader) {
          setTimeout(function() { state.loader.hide(); }, options.delayLoader ? options.delayLoader : 0);
        }
        setTimeout(function() {
          $container.removeClass('m-transparent');
        }, options.delayReveal ? options.delayReveal : 0);
      });
    }
  };

  function init() {
    var wrap = $(options.imageContent);
    state.type = wrap.data('type');
    state.loader = options.loader;
    Images.init(wrap, options.hiddenContent);
  }

  init();
};