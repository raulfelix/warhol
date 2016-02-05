
var imagesLoaded = require('imagesLoaded');

function onLoad(instance) {
  instance.elements[0].classList.add('image-loaded');
}


function LazyImage(elements, options) {
  var defaults = {
    onLoad: onLoad
  };
  
  var self = this,
    state = {
      batch: 5,
      position: 0,
      length: 0
    };

  options = options || {};
  for (var key in defaults) {
    if (!options.hasOwnProperty(key)) {
      options[key] = defaults[key];
    }
  }
  
  state.length = elements.length;
  state.options = options;
  this.state = state;
  
  
  function next(position) {
    return position === state.position - 1;
  }
  
  
  function load(idx) {
    if (idx === state.position) {
      var src,
        pos = state.position,
        bound = pos + state.batch;

      if (bound > state.length) {
        bound = state.length;
      }

      for (var i = pos; i < bound; i++) {
        var img = elements[i];
        img.setAttribute('src', img.getAttribute('data-src'));
        imagesLoaded(img, options.onLoad);
      }
      state.position += state.batch;
    }
  }
  
  load(0);
  
  self.load = load;
  
  return self;
}


module.exports = {

  
  init: function(elements, options) {
    return new LazyImage(elements, options);
  }
  
};