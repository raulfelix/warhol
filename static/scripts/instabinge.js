/* global LWA, Sly, Handlebars, imagesLoaded, Hammer */
window.LWA = window.LWA || { Views: {}, Modules: {} };

LWA.Views.Instabinge = (function() {

  var Time = {
    MINUTE_IN_SECONDS : 60,
    HOUR_IN_SECONDS   : 60 * 60,
    DAY_IN_SECONDS    : 24 * 60 * 60,
    WEEK_IN_SECONDS   : 7 * 24 * 60 * 60,
    YEAR_IN_SECONDS   : 365 * 24 * 60 * 60,

    convert: function(now, unixSeconds) {
      var
        since,
        calc,
        diff = (now/1000) - unixSeconds;
      
      if ( diff < Time.HOUR_IN_SECONDS ) {
        calc = Math.round( diff / Time.MINUTE_IN_SECONDS );
        if ( calc <= 1 ) {
          calc = 1;
        }
        since = calc + 'min';
      } else if ( diff < Time.DAY_IN_SECONDS && diff >= Time.HOUR_IN_SECONDS ) {
        calc = Math.round( diff / Time.HOUR_IN_SECONDS );
        if ( calc <= 1 ) {
          calc = 1;
        }
        since = calc + 'h';
      } else if ( diff < Time.WEEK_IN_SECONDS && diff >= Time.DAY_IN_SECONDS ) {
        calc = Math.round( diff / Time.DAY_IN_SECONDS );
        if ( calc <= 1 ) {
          calc = 1;
        }
        since = calc + 'd';
      } else if ( diff < 30 * Time.DAY_IN_SECONDS && diff >= Time.WEEK_IN_SECONDS ) {
        calc = Math.round( diff / Time.WEEK_IN_SECONDS );
        if ( calc <= 1 ) {
          calc = 1;
        }
        since = calc + 'w';
      } else if ( diff < Time.YEAR_IN_SECONDS && diff >= 30 * Time.DAY_IN_SECONDS ) {
        calc = Math.round( diff / ( 30 * Time.DAY_IN_SECONDS ) );
        if ( calc <= 1 ) {
          calc = 1;
        }
        since = calc + 'm';
      } else if ( diff >= Time.YEAR_IN_SECONDS ) {
        calc = Math.round( diff / Time.YEAR_IN_SECONDS );
        if ( calc <= 1 ){
          calc = 1;
        }
        since = calc + 'y';
      }

      return since;
    }
  };

  var Ajax = {
    cache: [],
    feedUrl: 'https://api.instagram.com/v1/users/self/feed?access_token=9513217.1f648b0.783f3c9408a64877b9783ccc25bb983f&callback=?',
    get: function(callback) {
      $.getJSON(Ajax.feedUrl)
        .done(function(response) {
          Ajax.cache.push(response.data);
          Ajax.feedUrl = response.pagination.next_url + '&callback=?';
          if (callback) {
            callback(response);
          } else {
            View.render(response);
          }
        })
        .fail(function(response) {
          console.log(response);
        });
    }
  };

  var View = {
    
    element: {
      $frame: $('#instabinge')
    },

    state: {
      sly: undefined,
      modal: undefined
    },

    template: Handlebars.instabinge_thumb,

    initialize: function() {
      var instabingeButtons = $('#instabinge-buttons');
      
      View.state.sly = new Sly('#instabinge', {
        horizontal: 1,
        itemNav: 'basic',
        smart: 1,
        activateOn: null,
        mouseDragging: 1,
        touchDragging: 1,
        releaseSwing: 0,
        startAt: 0,
        activatePageOn: null,
        speed: 260,
        elasticBounds: 1,
        easing: 'swing',
        dragHandle: 1,
        dynamicHandle: 1,
        clickBar: 1,

        prevPage: instabingeButtons.find('.sly-prev'),
        nextPage: instabingeButtons.find('.sly-next')
      });

      View.state.sly.on('moveEnd', function(eventName) {
        if (this.pos.dest === this.pos.end) {
          Ajax.get(View.append);
        }
      });

      View.element.$frame.on('click', 'li', function(ev) {
        View.state.modal.show();
        Modal.initializeSlider(View.state.sly.getIndex($(ev.currentTarget)));
      });

      Ajax.get();
    },

    render: function(response) {
      View.element.$frame.find('ul').append(this.template(response));
      View.state.sly.init();
    },

    append: function(response) {
      View.state.sly.add(View.template(response));
    },

    reload: function() {
      View.state.sly.reload();
    }
  };

  var Modal = {

    element: {
      $frame: $('#modal-instabinge-slider')
    },

    state: {
      slider: undefined,
      modal: undefined
    },

    template: Handlebars.instabinge_thumb_modal,
    templateSingle: Handlebars.instabinge_single_thumb_modal,

    init: function() {
      View.state.modal = LWA.Modules.Modal(undefined, '#modal-instabinge', {
        close: Modal.destroy,
        closeable: true
      });

      Handlebars.registerHelper('formatTime', function() {
        return Time.convert(Date.now(), this.created_time);
      });

      $('#modal-instabinge-controls .sly-prev').click(Modal.prev);
      $('#modal-instabinge-controls .sly-next').click(Modal.next);
    },

    initializeSlider: function(index) {
      View.state.modal.loader.start();

      Modal.render(index);
      Modal.element.$frame.royalSlider({
        keyboardNavEnabled: true,
        sliderDrag: false,
        navigateByClick: false,
        transitionSpeed: 260,
        startSlideId: index,
        controlNavigation: 'none'
      });
      Modal.state.slider = Modal.element.$frame.data('royalSlider');

      Modal.handleImageLoad(Modal.element.$frame, Modal.element.$frame.find('.m-bg'), function() {
        View.state.modal.loader.stop();
      });
     
      Modal.state.slider.ev.on('rsAfterSlideChange', function(event) {
        if (Modal.state.slider.numSlides - 1 === Modal.state.slider.currSlideId) {
          Ajax.get(Modal.onLoad);
        }
        Modal.handleImageLoad(
          Modal.state.slider.currSlide.content,
          Modal.state.slider.currSlide.content.find('img')
        );
      });
    },

    render: function(index) {
      var fragment = $(document.createDocumentFragment());
      for (var i = 0, length = Ajax.cache.length; i < length; i++) {
        fragment.append(Modal.template({ data: Ajax.cache[i] }));
      }
      Modal.element.$frame.append(fragment);
    },

    next: function() {
      Modal.state.slider.next();
    },

    prev: function() {
      Modal.state.slider.prev();
    },

    handleImageLoad: function(wrapper, images, callback) {
      imagesLoaded(images, function(instance) {
        wrapper.find('.m-wrap').removeClass('m-transparent');
        wrapper.find('.loader-icon').remove();
        if (callback) {
          callback();
        }
      });
    },

    onLoad: function(response) {
      var dataArray = response.data;
      for (var i = 0, length = dataArray.length; i < length; i++) {
        Modal.state.slider.appendSlide( $(Modal.templateSingle(dataArray[i])) );
      }
    
      // keep horizontal view in sync
      View.state.sly.add(View.template(response));
      View.state.sly.reload();
    },

    destroy: function() {
      Modal.state.slider.destroy();
      Modal.state.slider = undefined;
      Modal.element.$frame.html('');
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
      console.log("reload...");
      View.reload();
    }, 200);
  }

  function init() {
    View.initialize();
    Modal.init();
    $(window).resize(updateSly);
  }

  return {
    init: init
  };

})();

LWA.Views.Instabinge.init();