/* global LWA, Handlebars, LWA_endpoint */
window.Namespace('Views');

LWA.Views.PostThumbs = (function() {

  var $body = $('html,body');

  var AjaxFeature = {

    element: {
      container: $('#tmpl_featured')
    },

    state: {
      loader: undefined
    },

    template: Handlebars.article_thumb,
    
    params: {
      'action': 'do_ajax',
      'fn': 'get_next_featured_posts',
      'page': 2
    },

    done: function(response) {
      AjaxFeature.params.page = response.nextPage;
      AjaxFeature.render(response.posts);
      AjaxFeature.state.loader.stop();

      renderButton('ajax-load-features', AjaxFeature.params.page);
    },

    render: function(posts) {
      var e, html = '', idx = 0;

      $.each(posts, function(o) {
        
        if (idx === 0) {
          html += '<div class="f-row">';
        }
        
        posts[o].column_css = 'f-1-2 bp2-1';
        html += AjaxFeature.template(posts[o]);
        idx++;
        
        if (idx === 2) {
          idx = 0;
          html += '</div>';
        }
      });

      if (idx === 1) {
        html += '</div>';
      }

      e = $(html);
      AjaxFeature.element.container.append(e);
      scrollPage(e);
    },

    init: function() {
      AjaxFeature.state.loader = new ButtonLoader(document.getElementById('ajax-load-features'), {
        onStart: function() {
          get(AjaxFeature.done, AjaxFeature.params);
        }
      });
    }
  };

  var AjaxNews = {

    element: {
      container: $('#tmpl_news')
    },

    state: {
      loader: undefined
    },

    template: Handlebars.article_thumb,

    params: {
      'action': 'do_ajax',
      'fn': 'get_next_news_posts',
      'page': 2
    },

    done: function(response) {
      AjaxNews.params.page = response.nextPage;
      AjaxNews.render(response.posts);
      AjaxNews.state.loader.stop();

      renderButton('ajax-load-news', AjaxNews.params.page);
    },

    render: function(posts) {
      var
        idx = 1,
        html = '',
        touch = '<div class="thumb-touch-inline-fix"></div>',
        desktop = '<div class="thumb-inline-fix"></div>';

      $.each(posts, function(o) {
        posts[o].column_css = 'f-1-3 bp1-1-2';
        html += AjaxNews.template(posts[o]);
        if (idx % 2 === 0) {
          html += touch;
        }
        if (idx % 3 === 0) {
          html += desktop;
        }
        idx++;
      });

      var e = $(html);
      AjaxNews.element.container.append(e);
      scrollPage(e);
    },

    init: function() {
      AjaxNews.state.loader = new ButtonLoader(document.getElementById('ajax-load-news'), {
        onStart: function() {
          get(AjaxNews.done, AjaxNews.params);
        }
      });
    }
  };

  function get(callback, params) {
    $.getJSON(LWA.Modules.Util.getUrl(), params)
      .done(function(response) {
        callback(response);
      })
      .fail(function(response) {
        console.log(response);
      });
  }

  function renderButton(id, page) {
    if (page === false) {
      document.getElementById(id).className = 'button-disabled';
    }
  }

  function scrollPage(element) {
    $body.animate({
      scrollTop: element.offset().top - 20
    }, 500);
  }

  return {
    init: function() {
      AjaxFeature.init();
      AjaxNews.init();
    }
  };

})();

LWA.Views.PostThumbs.init();