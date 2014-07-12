/* global LWA, Sly, imagesLoaded, Handlebars */

var Views = window.Namespace('Views');

Views.Gallery = (function() {

  var Modal = {
    
    state: {
      modal: undefined,
      sly: undefined,
      count: undefined,
      responsive: {
        width: 200,
        height: 120,
        widthTouch: 40,
        heightTouch: 160
      }
    },

    elements: {
      $imgs: undefined,
      $total: undefined,
      $caption: undefined
    },

    onActivate: function(eventName, position) {
      var e = $(this.items[position].el);
      Modal.elements.$total.html((position + 1) + ' / ' + Modal.state.count);
      Modal.elements.$caption.html(e.data('title'));
    },

    init: function() {
      // init modal
      Modal.state.modal =
        LWA.Modules.Modal('#modal-gallery-button', '#modal-gallery', { closeable: true });

      // cache elements
      this.elements.$imgs = Modal.state.modal.el().find('#modal-gallery-frame img');
      this.elements.$total = Modal.state.modal.el().find('.modal-gallery-count');
      this.elements.$caption = Modal.state.modal.el().find('.modal-gallery-caption');
      Modal.state.count = this.elements.$imgs.length;

      this.setModalRowHeight();
      this.setImageDimensions();

      setTimeout(function() {
        Modal.state.sly = new Sly('#modal-gallery-frame', {
          horizontal: 1,
          itemNav: 'forceCentered',
          smart: 1,
          activateMiddle: 1,
          mouseDragging: 0,
          touchDragging: 1,
          releaseSwing: 0,
          startAt: 0,
          speed: 240,
          elasticBounds: 1,
          easing: 'swing',
          prev: Modal.state.modal.el().find('.sly-prev'),
          next: Modal.state.modal.el().find('.sly-next')
        });
        Modal.state.sly.on('active', Modal.onActivate);
        Modal.state.sly.init();
      }, 2000);
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
      var w, originalViewport = $(window).width(), viewport, viewportHeight, className = 'modal-gallery-height';

      if (window.matchMedia && window.matchMedia('(max-width: 599px)').matches) {
        viewport = originalViewport - Modal.state.responsive.widthTouch;
      } else {
        viewport = originalViewport - Modal.state.responsive.width;
      }
      viewportHeight = Modal.state.modal.el().find('#modal-gallery-frame').height();

      Modal.elements.$imgs.each(function() {
        w = this.width;
        if (viewport < w) {
          this.className = 'modal-gallery-width';
          
          var img = this;
          setTimeout(function() {
            if (viewportHeight < img.height) {
              $(img).addClass('modal-gallery-height');
            }
          }, 100);
          
        } else {
          $(this).addClass('modal-gallery-height');
        }

        $(this).closest('li').css('width', originalViewport);
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
      var $wrap = $('#header-gallery-thumbs');

      // imagesLoaded($wrap, function() {
      Thumbs.initialiseSly($('#header-gallery-thumbs'));
      // });
     
      $('#gallery-thumbs').click(Thumbs.toggle);
    },

    initialiseSly: function($wrap) {
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
      title: $('#header-gallery-title'),
      details: $('#header-gallery-details')
    },

    state: {
      sly: undefined,
      responsive: undefined,
      isTouch: false,
      loader: false
    },

    template: Handlebars.gallery_inline,

    init: function() {
      this.state.responsive = LWA.Modules.Util.getResponsive();
      this.state.isTouch = !this.state.responsive.BP3.match();
      this.state.loader = LWA.Modules.Spinner('#header-gallery .loader-icon', {show: true});

      Handlebars.registerHelper('getWidth', function() {
        return Math.round(this.width * (748 / this.height));
      });

      this.chooseRendering(this.state.loader);
    },

    chooseRendering: function(loader) {
      if (this.state.responsive.BP3.match() && this.state.isTouch !== true) {
        this.renderFeature();

        LWA.Modules.Loader({
          imageContent: '#tmpl-gallery-images',
          hiddenContent: '#header-gallery .m-wrap',
          loader: loader
        });
        
        this.state.isTouch = true;
      }
      else if (!this.state.responsive.BP3.match() && this.state.isTouch === true) {
        var wrap = $('#tmpl-gallery-images').html(this.template(LWA.Data.Gallery));
        wrap.find('img').each(function() {
          imagesLoaded(this, function(instance) {
            $(instance.elements[0]).closest('div').removeClass('m-transparent').next().remove();
          });
        });

        Inline.initialiseSlider();

        setTimeout(function() {
          $('#header-gallery-wrap').removeClass('m-transparent');
          Inline.state.loader.destroy();
        }, 2000);
        
        this.state.isTouch = false;
      }
    },

    initialiseSlider: function() {
      var $controls = $('#inline-gallery-controls');
      Inline.state.sly = new Sly('#inline-gallery-frame', {
        horizontal: 1,
        itemNav: 'centered',
        smart: 1,
        activateOn: 'click',
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

    renderGallery: function() {
      $('#tmpl-gallery-images').html(this.template(LWA.GalleryData));
    },

    renderFeature: function() {
      $('#tmpl-gallery-images')
        .css('background-image', 'url(' + LWA.GalleryData.feature + ')')
        .addClass('header-feature-bg');
    },

    onActivate: function(eventName, position) {
      Thumbs.setActive(position);
      if (!Inline.element.title.hasClass('fade') && position >= 1) {
        Inline.element.title.addClass('fade');
        Inline.element.details.addClass('slip-off');
      }
      else if (Inline.element.title.hasClass('fade') && position === 0) {
        Inline.element.title.removeClass('fade');
        Inline.element.details.removeClass('slip-off');
      }
    },

    setActive: function(position) {
      Inline.state.sly.activate(position);
    },

    reload: function() {
      Inline.chooseRendering();
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
      Thumbs.init();
      Inline.init();

      var modalLoad = new imagesLoaded('#modal-gallery-frame');
      modalLoad.on('done', function(instance) {
        Modal.init();
      });

      $(window).resize(updateSly);
    }
  };

})();

LWA.Views.Gallery.init();