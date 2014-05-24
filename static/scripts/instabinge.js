/* global LWA, Sly, Handlebars */
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
        since = calc + 'mn';
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
    feedUrl: 'https://api.instagram.com/v1/users/self/feed?access_token=433449303.fcca1bd.c0fea0b12a3f412fbc240be570e5dfc0&callback=?',
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
      sly: undefined
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
        releaseSwing: 1,
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
        LWA.Modules.Modal(undefined, '#modal-instabinge', {
          open: function() {
            Modal.initialize(View.state.sly.getIndex($(ev.currentTarget)));
          },
          close: Modal.destroy
        }).show();
      });

      Ajax.get();
    },

    render: function(response) {
      console.log(response);
      View.element.$frame.find('ul').append(this.template(response));
      View.state.sly.init();
    },

    append: function(response) {
      console.log(response);
      View.state.sly.add(View.template(response));
    },

    reload: function() {
      View.state.sly.reload();
    }
  };

  var Modal = {

    element: {
      $frame: $('#modal-instabinge-frame .slidee')
    },

    state: {
      sly: undefined
    },

    template: Handlebars.instabinge_thumb_large,

    initialize: function(itemIndex) {
      var $wrap = $('#modal-instabinge-controls');
      Modal.state.sly = new Sly('#modal-instabinge-frame', {
        horizontal: 1,
        itemNav: 'forceCentered',
        smart: 1,
        activateMiddle: 1,
        touchDragging: 1,
        releaseSwing: 1,
        startAt: itemIndex,
        speed: 0,
        elasticBounds: 1,
        easing: 'swing',
        dragHandle: 1,
        dynamicHandle: 1,
        clickBar: 1,

        prev: $wrap.find('.sly-prev'),
        next: $wrap.find('.sly-next')
      });

      Modal.state.sly.on('moveEnd', function() {
        if (this.pos.dest === this.pos.end) {
          console.log("reached end load next batch more");
          Ajax.get(Modal.append);
        }
      });

      // get cached data and call render
      Modal.render(Ajax.cache);
    },

    render: function(response) {
      var fragment = $(document.createDocumentFragment());
      for (var i = 0; i < response.length; i++) {
        Modal.formatData(response[i]);
        fragment.append(this.template({data: response[i]}));
      }
      Modal.element.$frame.html(fragment);
      Modal.state.sly.init();
    },

    append: function(response) {
      Modal.formatData(response.data);
      Modal.state.sly.add(Modal.template(response));
      View.state.sly.add(View.template(response));
    },

    formatData: function(data) {
      var
        width = $(window).width(),
        now = Date.now();

      for (var i = 0; i < data.length; i++) {
        data[i].width = width;
        data[i].created_time = Time.convert(now, data[i].created_time);
      }
    },
    
    destroy: function() {
      Modal.state.sly.destroy();
      Modal.element.$frame.html('');
    },

    reload: function() {
      if (Modal.state.sly !== undefined) {
        Modal.element.$frame.css('width', '100%');
        var w = $(window).width();
        Modal.element.$frame.children().css('width', w);
        Modal.state.sly.reload();
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
      console.log("reload...");
      View.reload();
      Modal.reload();
    }, 200);
  }

  return {
    init: function() {
      View.initialize();
      $(window).resize(updateSly);
    }
  };

})();

LWA.Views.Instabinge.init();