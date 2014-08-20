/* global LWA, Sly, imagesLoaded, Handlebars, ga */

var Views = window.Namespace('Views');

Views.Gallery = (function() {

  var Helper = {
    isRight: function(previous, current) {
      return previous < current;
    }
  };

  
  var StartAgain = function(element, callback) {
    var self = this,
      ACTIVE = 'gallery-home-active';

    self.show = function() {
      element.addClass(ACTIVE);
    };

    self.hide = function() {
      element.removeClass(ACTIVE);
    };

    element.click(function() {
      callback.call(self);
    });
  };

  // @param: wrapping dom element
  var FinalSlide = function(element) {
    var self = this,
      ACTIVE = 'gallery-next-active';

    self.show = function() {
      element.addClass(ACTIVE);
    };

    self.hide = function() {
      element.removeClass(ACTIVE);
    };

    self.isActive = function() {
      return element.hasClass(ACTIVE);
    };
  };

  var Modal = {
    
    state: {
      modal: undefined,
      slider: undefined,
      responsive: {
        height: 120,
        heightTouch: 160
      },
      startTime: 0,
      previousPosition: 0
    },

    elements: {
      $imgs: undefined,
      $total: undefined
    },



    NextUp: {
      
      state: {
        pos: 0
      },

      isFirst: function() {
        return this.state.slider.currSlideId === 0;
      },

      isEnabled: function() {
        return this.elements.slider.hasClass('gallery-next-enable');
      },

      isActivated: function() {
        return this.elements.slider.hasClass('gallery-next-active');
      },
      
      activate: function() {
        this.elements.slider.addClass('gallery-next-active');
      },

      deactivate: function() {
        this.elements.slider.removeClass('gallery-next-active');
      },

      enable: function() {
        this.elements.slider.addClass('gallery-next-enable');
      },

      disable: function() {
        this.elements.slider.removeClass('gallery-next-enable');
      },

      onActivate: function(event) {
        var position = this.state.slider.currSlideId;
        console.log(this.isFirst(), position);

        if (this.isFirst()) {
          this.deactivate();
        } else {
          this.activate();
        }

        // if is swipe at position 0
        if (this.isFirst() && position === this.state.pos) {
          this.disable();
          Modal.prev();
        }
        this.state.pos = position;
      },

      destroy: function() {
        this.state.slider.goTo(0);
        this.disable();
        this.deactivate();
        Modal.state.slider.goTo(0);
        Modal.onActivate(0);
      },

      init: function() {
        this.elements = {
          slider: $('#modal-slider-next')
        };

        var container = this.elements.slider.find('.royalSlider');
        this.state.slider = container.css({
          'width': LWA.Modules.Util.windowWidth(),
          'height': LWA.Modules.Util.windowHeight()
        })
        .royalSlider({
          sliderDrag: false,
          navigateByClick: false,
          transitionSpeed: 260,
          startSlideId: 0,
          controlNavigation: 'none',
          fadeinLoadedSlide: false,
          addActiveClass: true,
          arrowsNav: false
        }).data('royalSlider');

        this.state.slider.ev.on('rsBeforeAnimStart', function(event) {
          Modal.NextUp.onActivate(event);
        });

        container.find('#modal-gallery-home').click(function() { Modal.NextUp.destroy(); });
      }
    },



    init: function() {
      Modal.state.startTime = new Date().getTime();

      if (Modal.state.slider !== undefined) {
        return;
      }

      Modal.elements.$slider = $('#modal-gallery-frame .royalSlider');
      Modal.elements.$imgs = Modal.elements.$slider.find('img');
      Modal.elements.$total = Modal.state.modal.el().find('.modal-gallery-count');

      Modal.state.modal.el().find('.sly-prev').click(Modal.prev);
      Modal.state.modal.el().find('.sly-next').click(Modal.next);
      Modal.state.startAgain = new StartAgain($('#modal-gallery-home'), Modal.startAgain);

      Modal.setModalRowHeight();

      Modal.state.slider = Modal.elements.$slider.royalSlider({
        sliderDrag: false,
        navigateByClick: false,
        transitionSpeed: 260,
        startSlideId: 0,
        controlNavigation: 'none',
        fadeinLoadedSlide: false,
        globalCaption: true,
        addActiveClass: true,
        arrowsNav: false
      }).data('royalSlider');

      Modal.state.slider.ev.on('rsAfterSlideChange', function(event) {
        ga('send', 'event', 'Gallery', 'click', 'Gallery modal navigate', { 'page': location.pathName });
        Modal.onActivate(Modal.state.slider.currSlideId);
      });
      Modal.onActivate(0);

      Modal.elements.$imgs.each(function() {
        imagesLoaded(this, function(instance) {
          $(instance.elements[0]).removeClass('m-transparent').next().remove();
        });
      });

      Modal.NextUp.init();
    },

    startAgain: function() {
      if (Modal.NextUp.isEnabled()) {
        Modal.NextUp.destroy();
      } else {
        Modal.state.slider.goTo(0);
      }
    },

    destroy: function() {
      var endTime = new Date().getTime();
      ga('send', 'timing', 'Gallery', 'Modal view', endTime - Modal.state.startTime, 'Gallery modal', { 'page': location.pathName });
    },

    next: function() {
      if (LWA.hasNextPost && Modal.NextUp.isEnabled()) {
        Modal.NextUp.activate();
        Modal.NextUp.state.slider.goTo(1);
        Modal.state.startAgain.show();
        return;
      }
      Modal.state.slider.next();
    },

    prev: function() {
      if (Modal.NextUp.isActivated()) {
        Modal.NextUp.deactivate();
        Modal.NextUp.state.slider.goTo(0);
        Modal.state.startAgain.hide();
        return;
      }
      Modal.NextUp.disable();
      Modal.state.slider.prev();
    },

    onActivate: function(position) {
      position = position + 1;
      this.elements.$total.html(position + ' / ' + this.state.slider.numSlides);

      if (position === 1 || Helper.isRight(this.state.previousPosition, position)) {
        Modal.state.startAgain.hide();
      } else {
        Modal.state.startAgain.show();
      }

      // if is last slide enable the next up slider
      if (position === Modal.state.slider.numSlides) {
        Modal.NextUp.enable();
      }
      this.state.previousPosition = position;
    },

    setModalRowHeight: function() {
      var extraHeight = LWA.Modules.Util.getResponsive().BP1.match() ? Modal.state.responsive.heightTouch : Modal.state.responsive.height;
      Modal.elements.$slider.css('height', LWA.Modules.Util.windowHeight() - extraHeight);
      Modal.elements.$slider.find('.rsOverflow').css('height', LWA.Modules.Util.windowHeight() - extraHeight);
    },

    clearDimensions: function() {
      Modal.elements.$slider.height('auto').width(LWA.Modules.Util.windowWidth());
      var fragment = $(document.createDocumentFragment());
      for (var i = 0; i < Modal.state.slider.slides.length; i++) {
        Modal.state.slider.slides[i].content.find('img').removeClass('modal-gallery-height modal-gallery-width');
        fragment.append(Modal.state.slider.slides[i].content);
      }
      Modal.elements.$slider.children().remove();
      Modal.elements.$slider.append(fragment);
    },

    reload: function() {
      if (Modal.state.slider === undefined) {
        return;
      }
      
      Modal.state.modal.loader.start();
      
      var currSlideId = Modal.state.slider.currSlideId;
      
      Modal.clearDimensions();
      Modal.state.slider.destroy();
      Modal.state.slider = undefined;

      Modal.setModalRowHeight();

      Modal.state.slider = Modal.elements.$slider.royalSlider({
        sliderDrag: false,
        navigateByClick: false,
        transitionSpeed: 260,
        startSlideId: currSlideId,
        controlNavigation: 'none',
        fadeinLoadedSlide: false,
        globalCaption: true,
        addActiveClass: true,
        arrowsNav: false
      }).data('royalSlider');

      Modal.state.slider.ev.on('rsAfterSlideChange', function(event) {
        Modal.onActivate(Modal.state.slider.currSlideId);
      });

      Modal.onActivate(currSlideId);

      setTimeout(function() {
        Modal.state.modal.loader.stop();
      }, 1000);
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
      title: $('.header-gallery-title'),
      overlay: $('#header-gallery .m-overlay'),
      gallery: $('#header-gallery-wrap')
    },

    state: {
      sly: undefined,
      responsive: undefined,
      isTouch: false,
      loader: false,
      previousPosition: 0
    },

    template: Handlebars.gallery_inline,

    init: function() {
      this.state.responsive = LWA.Modules.Util.getResponsive();
      this.state.isTouch = !this.state.responsive.BP3.match();
      this.state.loader = LWA.Modules.Spinner('#header-gallery .loader-icon', {show: true});

      this.element.title.on('webkitTransitionEnd transitionend msTransitionEnd oTransitionEnd', Inline.onTransitionEnd);

      Handlebars.registerHelper('getWidth', function() {
        return Math.round(this.width * (748 / this.height));
      });

      Handlebars.registerHelper('loader', function(index) {
        if (index > 1) {
          return '<div class="loader-icon"><i class="icon-reload"></i></div>';
        }
      });
        
      var $controls = $('#inline-gallery-controls');
      $controls.find('.sly-prev').click(Inline.prev);
      $controls.find('.sly-next').click(Inline.next);

      this.state.finalSlide = new FinalSlide(Inline.element.gallery);
      this.state.startAgain = new StartAgain($('#inline-gallery-home'), this.reset);

      this.chooseRendering(this.state.loader);
    },

    initialiseSlider: function() {
      Inline.state.sly = new Sly('#inline-gallery-frame', {
        horizontal: 1,
        itemNav: 'centered',
        smart: 1,
        activateOn: 'click',
        touchDragging: 0,
        releaseSwing: 1,
        startAt: 0,
        speed: 300,
        elasticBounds: 1,
        easing: 'swing'
      });

      Inline.state.sly.init();
      Inline.state.sly.on('active', Inline.onActivate);
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
        Inline.renderGallery();

        setTimeout(function() {
          $('#header-gallery-wrap').removeClass('m-transparent');
          Inline.state.loader.destroy();
        }, 2000);
        
        this.state.isTouch = false;
      }
    },

    renderGallery: function() {
      var wrap = $('#tmpl-gallery-images').html(this.template(LWA.Data.Gallery));
      wrap.find('img').each(function() {
        imagesLoaded(this, function(instance) {
          $(instance.elements[0]).closest('div').removeClass('m-transparent').prev().remove();
        });
      });
      Inline.element.overlay.hide();
      Inline.initialiseSlider();
    },

    renderFeature: function() {
      $('#tmpl-gallery-images')
        .css('background-image', 'url(' + LWA.Data.Gallery.feature + ')')
        .addClass('header-feature-bg');
      Inline.element.overlay.show();
      Inline.showTitle();
    },

    destroyFeature: function() {
      $('#tmpl-gallery-images')
        .css('background-image', 'none')
        .removeClass('header-feature-bg');
    },

    destroyGallery: function() {
      $('#tmpl-gallery-images').html('');
      Inline.state.sly.destroy();
    },

    onActivate: function(eventName, position) {
      ga('send', 'event', 'Gallery', 'click', 'Gallery inline navigate', { 'page': location.pathName });
      
      Thumbs.setActive(position);

      if (Inline.state.previousPosition > position) {
        Inline.state.startAgain.show();
      } else {
        Inline.state.startAgain.hide();
      }

      if (position > 0) {
        Inline.hideTitle();
      } else {
        Inline.showTitle();
        Inline.element.gallery.removeClass('gallery-end');
        Inline.state.startAgain.hide();
      }

      // mark end of gallery
      if (Inline.isEnd()) {
        Inline.element.gallery.addClass('gallery-end');
      }

      Inline.state.previousPosition = position;
    },

    next: function() {
      // show next slide
      if (LWA.hasNextPost && Inline.isEnd()) {
        Inline.state.finalSlide.show();
        Inline.state.startAgain.show();
        return;
      }
      Inline.state.sly.next();
    },

    prev: function() {
      if (Inline.state.finalSlide.isActive()) {
        Inline.state.finalSlide.hide();
        Inline.state.startAgain.hide();
        return;
      }
      
      Inline.state.sly.prev();
      Inline.element.gallery.removeClass('gallery-end');
    },

    isEnd: function() {
      return this.state.sly.items.length - 1 === this.state.sly.rel.activeItem;
    },

    showTitle: function() {
      Inline.element.title.css('display', '');
      setTimeout(function() { Inline.element.gallery.removeClass('animate-gallery'); }, 200);
    },

    hideTitle: function() {
      Inline.element.gallery.addClass('animate-gallery');
    },

    onTransitionEnd: function(ev) {
      if (Inline.element.gallery.hasClass('animate-gallery')) {
        Inline.element.title.css('display', 'none');
      }
    },

    setActive: function(position) {
      Inline.state.sly.activate(position);
    },

    reset: function() {
      Inline.state.sly.activate(0);
      Inline.state.finalSlide.hide();
    },

    reload: function() {
      if (this.state.responsive.BP3.match() && this.state.isTouch !== true) {
        this.destroyGallery();
        this.renderFeature();
        this.state.isTouch = true;
      }
      else if (!this.state.responsive.BP3.match() && this.state.isTouch === true) {
        this.destroyFeature();
        this.renderGallery();
        this.state.isTouch = false;
      }
      else if (this.state.isTouch === false) {
        this.state.sly.reload();
      }
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

      Modal.state.modal =
        LWA.Modules.Modal('#modal-gallery-button', '#modal-gallery', {
          closeable: true,
          open: Modal.init,
          close: Modal.destroy
        });

      $(window).resize(updateSly);
    }
  };

})();

LWA.Views.Gallery.init();