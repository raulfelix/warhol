/*global LWA */
window.LWA = window.LWA || { Views: {}, Modules: {} };

LWA.Modules.Spinner = function(loaderSelector, opts) {

  var $el;

  function show() {
    $el.addClass('loader-show');
    return this;
  }

  function hide() {
    $el.removeClass('loader-show');
    return this;
  }

  function init() {
    $el = $(loaderSelector);
  }

  init();

  return {
    show: show,
    hide: hide
  };
};