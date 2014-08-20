(function(window, undefined) {
  'use strict';

  function onLoad(instance) {
    $(instance.elements[0]).closest('div').removeClass('m-transparent').prev().remove();
  }

  function LazyImage(elements, options) {
    var self = this,
      state = {
        batch: 10,
        position: 0,
        length: 0
      };

    options = options || {};
    for (var key in LazyImage.defaults) {
      if (!options.hasOwnProperty(key)) {
        options[key] = LazyImage.defaults[key];
      }
    }
    state.length = elements.length;

    function next(position) {
      return position === state.position - 1;
    }
    
    self.load = function(idx) {
      if (idx === state.position) {
        var src,
          pos = state.position,
          bound = pos + state.batch;

        if (bound > state.length) {
          bound = state.length;
        }

        for (var i = pos; i < bound; i++) {
          var img = $(elements[i]);
          img.attr('src', img.data('img-src'));
          imagesLoaded(img, options.onLoad);
        }
        state.position += state.batch;
      }
    };

    return self;
  }

  LazyImage.defaults = {
    onLoad: onLoad
  };

  // Public
  window.LazyImage = LazyImage;

})(window);