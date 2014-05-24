/* global LWA, Handlebars */
window.LWA = window.LWA || { Views: {}, Modules: {} };

LWA.Views.PostThumbs = (function() {

  var $body = $('body');

  var AjaxFeature = {

    element: {
      container: $('#tmpl_featured'),
      button: undefined,
      label: undefined
    },

    state: {
      spinner: undefined,
      loading: false
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
      AjaxFeature.hide();
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

    renderButton: function() {
      if (this.params.page === false) {
        this.element.button.addClass('button-disabled');
      }
    },

    isLoadable: function() {
      return this.params.page !== false && this.state.loading === false;
    },

    onClick: function() {
      if (AjaxFeature.isLoadable()) {
        AjaxFeature.show();
        get(AjaxFeature.done, AjaxFeature.params);
      }
    },

    show: function() {
      AjaxFeature.state.loading = true;
      AjaxFeature.element.button.addClass('button-loading');
    },

    hide: function() {
      AjaxFeature.state.loading = false;
      AjaxFeature.element.button.removeClass('button-loading');
    },

    init: function() {
      AjaxFeature.element.button = $('#ajax-load-features').click(AjaxFeature.onClick);
      AjaxFeature.element.label = AjaxFeature.element.button.find('span');
      AjaxFeature.state.spinner = LWA.Modules.Spinner(AjaxFeature.element.button);
    }
  };

  var AjaxNews = {

    element: {
      container: $('#tmpl_news'),
      button: undefined,
      label: undefined
    },

    state: {
      loading: false
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
      AjaxNews.hide();
    },

    render: function(posts) {
      var e, html = '';

      $.each(posts, function(o) {
        posts[o].column_css = 'f-1-3 bp2-1-2 thumb-inline';
        html += AjaxNews.template(posts[o]);
      });

      e = $(html);
      AjaxNews.element.container.append(e);
      scrollPage(e);
    },

    renderButton: function() {
      if (this.params.page === false) {
        this.element.button.addClass('button-disabled');
      }
    },

    isLoadable: function() {
      return this.params.page !== false && this.state.loading === false;
    },

    onClick: function() {
      if (AjaxNews.isLoadable()) {
        AjaxNews.show();
        get(AjaxNews.done, AjaxNews.params);
      }
    },

    show: function() {
      this.state.loading = true;
      this.element.button.addClass('button-loading');
    },

    hide: function() {
      this.state.loading = false;
      this.element.button.removeClass('button-loading');
    },

    init: function() {
      this.element.button = $('#ajax-load-news').click(this.onClick);
      this.element.label = this.element.button.find('span');
      LWA.Modules.Spinner(this.element.button);
    }
  };

  function get(callback, params) {
    $.getJSON('wp-admin/admin-ajax.php', params)
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
      AjaxFeature.init();
      AjaxNews.init();
    }
  };

})();

LWA.Views.PostThumbs.init();