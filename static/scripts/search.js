/* global LWA, Handlebars, LWA_endpoint, ga */
window.Namespace('Modules');

LWA.Modules.Search = (function() {

  // Fixing infinite scroll checking
  function infsrc_local_hiddenHeight(element) {
    var height = 0;
    $(element).children().each(function() {
      height = height + $(this).outerHeight(false);
    });
    return height;
  }

  $.extend($.infinitescroll.prototype, {
    _nearbottom_local: function infscr_nearbottom_local() {
      var
        opts = this.options,
        instance = this,
        pixelsFromWindowBottomToBottom = infsrc_local_hiddenHeight(opts.binder) - $(opts.binder).scrollTop() - $(opts.binder).height();
      if (opts.local_pixelsFromNavToBottom === undefined) {
        opts.local_pixelsFromNavToBottom = infsrc_local_hiddenHeight(opts.binder) + $(opts.binder).offset().top - $(opts.navSelector).offset().top;
      }
      return ($(opts.binder).prop("scrollHeight") - $(opts.binder).height() - $(opts.binder).scrollTop() < opts.bufferPx);
    }
  });

  var View = {

    element: {
      input: $('.input-search input'),
      overflow: $('.search-row-results'),
      container: $('.search-row-results').find('.container')
    },

    loader: undefined,
    
    template: Handlebars.search_thumb,
    templateLink: Handlebars.search_next_link,

    render: function(data) {
      if (data.posts.length === 0) {
        this.element.container.html('<div class="h-4">There are no results to display</div>');
      }
      else {
        this.element.container.html(this.template(data));
        this.initInfiniteScroll(data.term);
      }
    },

    append: function(data) {
      View.element.container.append(View.template(data));

      if (data.nextPage === false) {
        View.element.overflow.infinitescroll('pause');
      }
    },

    onClick: function() {
      var term = View.element.input.val();
      if (term.length !== 0) {
        View.loader.start();
        ga('send', 'pageview', '/search.php?q=' + term);
        
        Ajax.setNextPage(1);
        Ajax.setTerm(term);
        Ajax.get(Ajax.params);
        View.element.container.html('');
        
        if (View.reset !== undefined) {
          View.element.overflow.infinitescroll('destroy');
          View.element.overflow.data('infinitescroll', null);
        }
      }
    },

    onClose: function() {
      View.element.overflow.infinitescroll('destroy');
      View.element.overflow.data('infinitescroll', null);
      View.element.container.html('');
      View.element.input.val('');
    },

    onKeyUp: function(ev) {
      if (ev.keyCode === 13) {
        View.onClick();
      }
    },

    initInfiniteScroll: function(term) {
      View.reset = View.element.overflow.infinitescroll({
        loading: {
          selector: '.loader-container',
          msg: $('<div class="loader-icon loader-icon-pink"><i class="icon-reload"></i></div>'),
          finishedMessage: undefined,
        },
        behavior: 'local',
        binder: View.element.overflow,
        bufferPx: 100,
        dataType: 'json',
        navSelector: '.pagination',
        nextSelector: '.data-next',
        pathParse: function(path, page) {
          return [
            Ajax.getUrl() + '?action=do_ajax&fn=search_posts&page=',
            '&posts_per_page=' + Ajax.params.posts_per_page + '&s=' + term
          ];
        },
        appendCallback: false
      }, View.append);
    }
  };

  var Ajax = {
    
    params: {
      'action': 'do_ajax',
      'fn': 'search_posts',
      'page': 1,
      'posts_per_page': 7,
      's': undefined
    },

    get: function(params, callback) {
      $.getJSON(Ajax.getUrl(), params)
        .done(function(response) {
          if (callback) {
            callback(response);
          } else {
            Ajax.done(response);
          }
        })
        .fail(function(response) {
          console.log(response);
        });
    },

    done: function(response) {
      View.loader.stop();
      View.render(response);
    },

    setNextPage: function(number) {
      Ajax.params.page = number;
    },

    setTerm: function(term) {
      Ajax.params.s = term;
    },

    getUrl: function() {
      return LWA.Modules.Util.getUrl();
    }
  };

  return {
    init: function() {
      View.loader = LWA.Modules.ButtonLoader('#js-search');

      // init events
      View.loader.el.click(View.onClick);
      View.element.input.keyup(View.onKeyUp);

      Handlebars.registerPartial('search_next_link', Handlebars.search_next_link);
    },
    close: View.onClose
  };

})();

LWA.Modules.Search.init();