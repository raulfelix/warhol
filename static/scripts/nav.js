/* global LWA */
window.Namespace('Views');

LWA.Views.Navigation = (function() {

  var $nav;

  function onClick(ev) {
    ev.preventDefault();
    $nav.toggleClass('nav-active');
  }
  
  function onSearchClick(ev) {
    ev.preventDefault();
    $nav.toggleClass('search-active');
  }

  return {
    init: function() {
      $nav = $('.nav');
      $nav.find('#nav').click(onClick);
      $nav.find('.nav-search').click(onSearchClick);
    }
  };

})();

LWA.Views.Navigation.init();