/* global LWA, Sly, Handlebars */
window.LWA = window.LWA || { Views: {}, Modules: {} };

LWA.Views.Instabinge = (function() {

  var Ajax = {
    feedUrl: 'https://api.instagram.com/v1/users/self/feed?access_token=433449303.fcca1bd.c0fea0b12a3f412fbc240be570e5dfc0&callback=?',
    get: function(callback) {
      $.getJSON(Ajax.feedUrl)
        .done(function(response) {
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
        activateOn: 'click',
        mouseDragging: 1,
        touchDragging: 1,
        releaseSwing: 1,
        startAt: 0,
        activatePageOn: 'click',
        speed: 300,
        elasticBounds: 1,
        easing: 'swing',
        dragHandle: 1,
        dynamicHandle: 1,
        clickBar: 1,

        prevPage: instabingeButtons.find('.instabinge-prev'),
        nextPage: instabingeButtons.find('.instabinge-next')
      });

      View.state.sly.on('moveEnd', function(eventName) {
        if (this.pos.dest === this.pos.end) {
          Ajax.get(View.append);
        }
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
    }
  };

  return {
    init: View.initialize
  };

})();

LWA.Views.Instabinge.init();