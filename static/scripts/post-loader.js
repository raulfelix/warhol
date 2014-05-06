/* global LWA, Handlebars */
window.LWA = window.LWA || { Views: {}, Modules: {} };

LWA.Views.PostThumbs = (function() {

  var $body = $('body');

  var AjaxFeature = {

    state: {
      button: undefined,
      element: $('#tmpl_featured')
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
      AjaxFeature.renderButton();
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
      AjaxFeature.state.element.append(e);
      scrollPage(e);
    },

    renderButton: function() {
      if (this.params.page === false) {
        this.state.button.addClass('button-disabled');
      }
    },

    onClick: function() {
      if (AjaxFeature.params.page !== false) {
        get(AjaxFeature.done, AjaxFeature.params);
      }
    }
  };

  var AjaxNews = {

    state: {
      button: undefined,
      element: $('#tmpl_news')
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
      AjaxNews.renderButton();
    },

    render: function(posts) {
      var e, html = '';

      $.each(posts, function(o) {
        posts[o].column_css = 'f-1-3 bp2-1-2 thumb-inline';
        html += AjaxNews.template(posts[o]);
      });

      e = $(html);
      AjaxNews.state.element.append(e);
      scrollPage(e);
    },

    renderButton: function() {
      if (this.params.page === false) {
        this.state.button.addClass('button-disabled');
      }
    },

    onClick: function() {
      if (AjaxNews.params.page !== false) {
        get(AjaxNews.done, AjaxNews.params);
      }
    }
  };

  function get(callback, params) {
    $.getJSON('http://localhost/wordpress/wp-admin/admin-ajax.php', params)
      .done(function(response) {
        callback(response);
      })
      .fail(function(response) {
        console.log(response);
      });
  }

  function scrollPage(element) {
    $body.animate({
      scrollTop: element.offset().top - 20
    }, 500);
  }

  return {
    init: function() {
      AjaxFeature.state.button = $('#ajax-load-features').click(AjaxFeature.onClick);
      AjaxNews.state.button = $('#ajax-load-news').click(AjaxNews.onClick);
    }
  };

})();

LWA.Views.PostThumbs.init();