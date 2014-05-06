this["Handlebars"] = this["Handlebars"] || {};

this["Handlebars"]["article_thumb"] = Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  var buffer = "", stack1, helper, functionType="function", escapeExpression=this.escapeExpression;


  buffer += "<div class=\"";
  if (helper = helpers.column_css) { stack1 = helper.call(depth0, {hash:{},data:data}); }
  else { helper = (depth0 && depth0.column_css); stack1 = typeof helper === functionType ? helper.call(depth0, {hash:{},data:data}) : helper; }
  buffer += escapeExpression(stack1)
    + "\">\n  <div class=\"thumb\">\n    <a class=\"h-5 thumb-link\" href=\""
    + escapeExpression(((stack1 = ((stack1 = (depth0 && depth0.category)),stack1 == null || stack1 === false ? stack1 : stack1.permalink)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "\">"
    + escapeExpression(((stack1 = ((stack1 = (depth0 && depth0.category)),stack1 == null || stack1 === false ? stack1 : stack1.name)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</a>\n    <a href=\"";
  if (helper = helpers.permalink) { stack1 = helper.call(depth0, {hash:{},data:data}); }
  else { helper = (depth0 && depth0.permalink); stack1 = typeof helper === functionType ? helper.call(depth0, {hash:{},data:data}) : helper; }
  buffer += escapeExpression(stack1)
    + "\" class=\"thumb-feature\">\n      <img src=\"";
  if (helper = helpers.thumbnail) { stack1 = helper.call(depth0, {hash:{},data:data}); }
  else { helper = (depth0 && depth0.thumbnail); stack1 = typeof helper === functionType ? helper.call(depth0, {hash:{},data:data}) : helper; }
  buffer += escapeExpression(stack1)
    + "\">\n      <span class=\"thumb-time\">";
  if (helper = helpers.when) { stack1 = helper.call(depth0, {hash:{},data:data}); }
  else { helper = (depth0 && depth0.when); stack1 = typeof helper === functionType ? helper.call(depth0, {hash:{},data:data}) : helper; }
  buffer += escapeExpression(stack1)
    + "</span>\n      <span class=\"thumb-views data-views\"><i class=\"icon-views\"></i>";
  if (helper = helpers.views) { stack1 = helper.call(depth0, {hash:{},data:data}); }
  else { helper = (depth0 && depth0.views); stack1 = typeof helper === functionType ? helper.call(depth0, {hash:{},data:data}) : helper; }
  buffer += escapeExpression(stack1)
    + "</span>\n    </a>\n    <a href=\"";
  if (helper = helpers.permalink) { stack1 = helper.call(depth0, {hash:{},data:data}); }
  else { helper = (depth0 && depth0.permalink); stack1 = typeof helper === functionType ? helper.call(depth0, {hash:{},data:data}) : helper; }
  buffer += escapeExpression(stack1)
    + "\" class=\"h-2 thumb-title\">";
  if (helper = helpers.title) { stack1 = helper.call(depth0, {hash:{},data:data}); }
  else { helper = (depth0 && depth0.title); stack1 = typeof helper === functionType ? helper.call(depth0, {hash:{},data:data}) : helper; }
  buffer += escapeExpression(stack1)
    + "</a>\n    <div class=\"h-5 thumb-caption\">";
  if (helper = helpers.subtitle) { stack1 = helper.call(depth0, {hash:{},data:data}); }
  else { helper = (depth0 && depth0.subtitle); stack1 = typeof helper === functionType ? helper.call(depth0, {hash:{},data:data}) : helper; }
  buffer += escapeExpression(stack1)
    + "</div>\n  </div>\n</div>";
  return buffer;
  });
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
/* global LWA */
window.LWA = window.LWA || { Views: {}, Modules: {} };

LWA.Views.Home = (function() {

  return {
    init: function() {
      $('.feature-carousel').flexslider();
    }
  };

})();

LWA.Views.Home.init();
