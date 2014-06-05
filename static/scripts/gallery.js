/* global LWA, Sly, imagesLoaded */
window.LWA = window.LWA || { Views: {}, Modules: {} };

LWA.Views.Gallery = (function() {

  var Modal = {
    
    state: {
      modal: undefined,
      sly: undefined,
      count: undefined,
      responsive: {
        width: 200,
        height: 120,
        widthTouch: 40,
        heightTouch: 100
      }
    },

    elements: {
      $imgs: undefined,
      $total: undefined
    },

    onActivate: function(eventName, position) {
      Modal.elements.$total.html((position + 1) + ' / ' + Modal.state.count);
    },

    init: function() {
      // init modal
      Modal.state.modal =
        LWA.Modules.Modal('#modal-gallery-button', '#modal-gallery');

      // cache elements
      this.elements.$imgs = Modal.state.modal.el().find('#modal-gallery-frame img');
      this.elements.$total = Modal.state.modal.el().find('.modal-gallery-count');
      Modal.state.count = this.elements.$imgs.length;

      this.setModalRowHeight();
      this.setImageDimensions();

      Modal.state.sly = new Sly('#modal-gallery-frame', {
        horizontal: 1,
        itemNav: 'forceCentered',
        smart: 1,
        activateMiddle: 1,
        mouseDragging: 1,
        touchDragging: 1,
        releaseSwing: 1,
        startAt: 0,
        speed: 0,
        elasticBounds: 1,
        easing: 'swing',
        prev: Modal.state.modal.el().find('.sly-prev'),
        next: Modal.state.modal.el().find('.sly-next')
      });
      Modal.state.sly.on('active', Modal.onActivate);
      Modal.state.sly.init();
    },

    setModalRowHeight: function() {
      var h;
      if (window.matchMedia && window.matchMedia("(max-width: 599px)").matches) {
        h = $(window).height() - Modal.state.responsive.heightTouch;
      } else {
        h = $(window).height() - Modal.state.responsive.height;
      }
      Modal.state.modal.el().find('#modal-gallery-frame').css('height', h);
    },

    /* 
      if viewport is more narrow than natural width
        - use viewport width
        - set image to have 100% width, height: auto
      else
        - use image width
        - set image to have auto width, height: 100% 
    */
    setImageDimensions: function() {
      var w, viewport, className = 'modal-gallery-height';

      if (window.matchMedia && window.matchMedia("(max-width: 599px)").matches) {
        viewport = $(window).width() - Modal.state.responsive.widthTouch;
      } else {
        viewport = $(window).width() - Modal.state.responsive.width;
      }

      Modal.elements.$imgs.each(function() {
        w = this.width;
        if (viewport < w) {
          w = viewport;
          className = 'modal-gallery-width';
        }
        $(this).addClass(className).closest('li').css('width', w);
      });
    },

    clearDimensions: function() {
      Modal.elements.$imgs.each(function() {
        $(this)
          .removeClass('modal-gallery-height modal-gallery-width')
          .closest('li')
          .attr('style', null);
      });
    },

    reload: function() {
      $('#modal-gallery-frame ul').css('width', '100%');
      Modal.clearDimensions();
      Modal.setModalRowHeight();
      Modal.setImageDimensions();
      Modal.state.sly.reload();
    }
  };

  var Thumbs = {

    state: {
      sly: undefined
    },

    elements: {
      $header: $('.header')
    },

    toggle: function() {
      Thumbs.elements.$header.toggleClass('header-gallery-thumbs-active');
    },

    init: function() {
      $('#gallery-thumbs').click(Thumbs.toggle);

      var $wrap = $('#header-gallery-thumbs');
      Thumbs.state.sly = new Sly('#header-gallery-thumbs', {
        horizontal: 1,
        itemNav: 'basic',
        smart: 1,
        activateOn: 'click',
        mouseDragging: 1,
        touchDragging: 1,
        releaseSwing: 1,
        startAt: 0,
        speed: 300,
        elasticBounds: 1,
        easing: 'swing',
        prevPage: $wrap.find('.sly-prev'),
        nextPage: $wrap.find('.sly-next')
      });

      Thumbs.state.sly.init();
      Thumbs.state.sly.on('active', Thumbs.onActivate);
    },

    onActivate: function(eventName, position) {
      Inline.setActive(position);
    },

    setActive: function(position) {
      Thumbs.state.sly.activate(position);
    },

    reload: function() {
      Thumbs.state.sly.reload();
    }
  };

  var Inline = {

    element: {
      title: $('#header-gallery-title')
    },

    state: {
      sly: undefined
    },

    init: function() {
      var $controls = $('#inline-gallery-controls');

      Inline.state.sly = new Sly('#inline-gallery-frame', {
        horizontal: 1,
        itemNav: 'centered',
        smart: 1,
        activateOn: 'click',
        mouseDragging: 1,
        touchDragging: 1,
        releaseSwing: 1,
        startAt: 0,
        speed: 300,
        elasticBounds: 1,
        easing: 'swing',
        prev: $controls.find('.sly-prev'),
        next: $controls.find('.sly-next')
      });

      Inline.state.sly.init();
      Inline.state.sly.on('active', Inline.onActivate);
    },

    onActivate: function(eventName, position) {
      Thumbs.setActive(position);
      if (!Inline.element.title.hasClass('fade')) {
        Inline.element.title.addClass('fade');
        setTimeout(function() {
          Inline.element.title.css('display', 'none');
        }, 400);
      }
    },

    setActive: function(position) {
      Inline.state.sly.activate(position);
    },

    reload: function() {
      Inline.state.sly.reload();
    }
  };

  // hold off on resize event
  var delay = (function() {
    var timer = 0;
    return function(callback, ms){
      clearTimeout(timer);
      timer = setTimeout(callback, ms);
    };
  })();

  function updateSly() {
    delay(function() {
      console.log('Resize...');
      Inline.reload();
      Thumbs.reload();
      Modal.reload();
    }, 200);
  }

  return {
    init: function() {

      var imgLoad = new imagesLoaded('#inline-gallery-frame');
      imgLoad.on('done', function(instance) {
        Thumbs.init();
        Inline.init();
      });

      var modalImageLoad = new imagesLoaded('#modal-gallery-frame');
      modalImageLoad.on('done', function(instance) {
        Modal.init();
      });

      $(window).resize(updateSly);
    }
  };

})();

LWA.Views.Gallery.init();