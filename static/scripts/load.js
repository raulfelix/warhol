/* global LWA, imagesLoaded */
window.LWA = window.LWA || { Views: {}, Modules: {} };

/* 
 * Depedencies: 
 * - jquery
 * - imagesLoaded
 */
LWA.Modules.Loader = function(mediaWrap, container, spinner) {

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
        state.loader.hide();
        $container.removeClass('m-transparent');
      });
    }
  };

  function init(mediaWrap, container, spinner) {
    state.loader = LWA.Modules.Spinner(spinner);
    
    var wrap = $(mediaWrap);
    state.type = wrap.data('type');

    Images.init(wrap, container);
  }

  init(mediaWrap, container, spinner);

};

LWA.Modules.Loader('.media-target', '.header-feature .m-wrap', '#header-loader');
LWA.Modules.Loader('.media-target-footer', '.footer-next-feature .m-wrap', '');