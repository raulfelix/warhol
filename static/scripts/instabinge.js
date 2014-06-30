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
        speed: 300,
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
        Modal.initialize(View.state.sly.getIndex($(ev.currentTarget)));
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
      $frame: $('#modal-instabinge-frame')
    },

    template: Handlebars.instabinge_thumb_modal,

    setDefaults: function() {
      return {
        sly: undefined,
        modal: undefined,
        windowWidth: Modal.getWindowWidth(),
        isLoad: true
      };
    },

    initialize: function(index) {
      View.state.modal.loader.start();
      
      Modal.state = Modal.setDefaults();
      Modal.element.$frame.width(Modal.state.windowWidth);

      // get cached data and render
      Modal.render(index);
      Modal.initializeSly(index);
    },

    initializeSly: function(index) {
      var $wrap = $('#modal-instabinge-controls');
      Modal.state.sly = new Sly('#modal-instabinge-frame', {
        horizontal: 1,
        itemNav: 'basic',
        smart: 1,
        activateMiddle: 1,
        releaseSwing: 0,
        touchDragging: 1,
        startAt: index,
        speed: 150,
        elasticBounds: 1,
        easing: 'swing',
        prev: $wrap.find('.sly-prev'),
        next: $wrap.find('.sly-next')
      });

      Modal.state.sly.init();
      Modal.state.sly.on('moveEnd', function() {
        console.log("moveEnd");
        if (Modal.state.isLoad === true && index !== 0) {
          View.state.modal.loader.stop();
          Modal.state.isLoad = false;
        }

        if (this.pos.dest === this.pos.end) {
          Ajax.get(Modal.onLoad);
        }
      });
    },

    handleImageLoad: function(wrapper, images, callback) {
      imagesLoaded(images, function(instance) {
        wrapper.find('.m-wrap').removeClass('m-transparent');
        if (callback) {
          callback();
        }
      });
    },

    isLast: function(index) {
      return (index === Ajax.cache.length - 1);
    },

    getWindowWidth: function() {
      return $(window).width();
    },

    onLoad: function(response) {
      var element = $(Modal.template(response));
      Modal.handleImageLoad(element, element.find('.m-bg'));
      Modal.state.sly.add(element);
      // keep horizontal view in sync
      View.state.sly.add(View.template(response));
      View.state.sly.reload();
    },

    reload: function() {
      Modal.state.windowWidth = Modal.getWindowWidth();
      Modal.element.$frame
        .width(Modal.state.windowWidth)
        .find('.sly-slide').css('width', Modal.state.windowWidth);
      Modal.state.sly.reload();
    },

    destroy: function() {
      Modal.state.sly.destroy();
      Modal.element.$frame
        .find('.slidee').attr('style', null)
        .find('.sly-slide').remove();
    },

    render: function(index) {
      var slidee = Modal.element.$frame.find('.slidee');

      var fragment = $(document.createDocumentFragment());
      for (var i = 0; i < Ajax.cache.length; i++) {
        fragment.append(Modal.template({data: Ajax.cache[i]}));
      }
      slidee.append(fragment);

      Modal.handleImageLoad(slidee, slidee.find('.m-bg'), function() {
        console.log("all images loaded");
        if (index === 0) {
          View.state.modal.loader.stop();
        }
      });
    },

    init: function() {
      View.state.modal = LWA.Modules.Modal(undefined, '#modal-instabinge', {
        close: Modal.destroy,
        closeable: true
      });

      Handlebars.registerHelper('formatTime', function() {
        return Time.convert(Date.now(), this.created_time);
      });

      Handlebars.registerHelper('formatWidth', function() {
        return 'width:' + Modal.state.windowWidth + 'px;';
      });
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
      Modal.reload();
    }, 200);
  }

  return {
    init: function() {
      View.initialize();
      Modal.init();
      $(window).resize(updateSly);
    }
  };

})();

LWA.Views.Instabinge.init();