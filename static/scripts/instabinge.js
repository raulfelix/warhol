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
          Ajax.cache = Ajax.cache.concat(response.data);
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
      $frame: $('#modal-instabinge-frame'),
      $prev: undefined,
      $next: undefined
    },

    state: {
      modal: undefined,
      itemIndex: undefined,
      singleLoader: undefined
    },

    template: Handlebars.instabinge_thumb_modal,

    initialize: function(index) {
      View.state.modal.loader.start();
      Modal.state.singleLoader = LWA.Modules.Spinner('#modal-instabinge .loader-icon');

      // get cached data and render
      Modal.setPos(index);
      Modal.render(Ajax.cache[Modal.getPos()]);

      // var e = document.getElementById('modal-instabinge-frame');
      // // todo only do this on mobile
      // new Hammer(e).on('swipeleft', function(event) {
      //   Modal.getNext();
      // });
      // new Hammer(e).on('swiperight', function(event) {
      //   Modal.getPrev();
      // });

      // Modal.element.$frame.touchwipe({
      //   wipeLeft: Modal.getNext,
      //   wipeRight: Modal.getPrev
      // });
    },

    getPrev: function(ev) {
      ev.preventDefault();
      
      Modal.element.$next.removeClass('disabled');
      
      var index = Modal.getPos() - 1;
      if (index < 0) {
        return;
      }

      if (index === 0) {
        Modal.element.$prev.addClass('disabled');
      }
      
      Modal.render(Ajax.cache[index]);
      Modal.setPos(index);
    },

    getNext: function(ev) {
      ev.preventDefault();

      Modal.element.$prev.removeClass('disabled');
      var index = Modal.getPos() + 1;
      if (index > Ajax.cache.length - 1) {
        return;
      }

      if (Modal.isLast(index)) {
        Modal.element.$next.addClass('disabled');

        // load more
        Ajax.get(Modal.onLoad);
      }

      Modal.render(Ajax.cache[index]);
      Modal.setPos(index);
    },

    isLast: function(index) {
      return (index === Ajax.cache.length - 1);
    },

    getPos: function() {
      return Modal.state.itemIndex;
    },

    setPos: function(index) {
      Modal.state.itemIndex = index;
    },

    setHeight: function() {
      if (window.matchMedia && window.matchMedia("(min-width: 600px)").matches) {
        Modal.element.$frame.height(Modal.element.$frame.find('img').height());
      }
    },

    onLoad: function(response) {
      // keep horizontal view in sync
      View.state.sly.add(View.template(response));
      View.state.sly.reload();

      View.state.modal.loader.stop();
      Modal.element.$next.removeClass('disabled');
    },

    onResize: function() {
      var img = Modal.element.$frame.find('img');
      if (img.length > 0) {
        Modal.setHeight();
      }
    },

    render: function(response) {
      Modal.state.singleLoader.show();
      Modal.formatData(response);
      Modal.element.$frame.html(this.template(response));
      
      imagesLoaded(Modal.element.$frame.find('img'), function(instance) {
        View.state.modal.loader.stop();
        Modal.state.singleLoader.hide();
        Modal.setHeight();
        Modal.element.$frame.find('.m-wrap').removeClass('m-transparent');
      });
    },

    formatData: function(data) {
      data.created_time = Time.convert(Date.now(), data.created_time);
    },

    init: function() {
      var $wrap = $('#modal-instabinge-controls');
      Modal.element.$prev = $wrap.find('.sly-prev').click(Modal.getPrev).addClass('disabled');
      Modal.element.$next = $wrap.find('.sly-next').click(Modal.getNext);
      View.state.modal = LWA.Modules.Modal(undefined, '#modal-instabinge');

      $(window).resize(Modal.onResize);
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

  return {
    init: function() {
      View.initialize();
      Modal.init();

      $(window).resize(updateSly);
    }
  };

})();

LWA.Views.Instabinge.init();