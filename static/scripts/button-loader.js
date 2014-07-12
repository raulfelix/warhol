/* global LWA */
window.Namespace('Modules');

/* 
 * Depedencies: 
 * - jquery
 */
LWA.Modules.ButtonLoader = function(selector, opts) {

  var element = {
    button: undefined
  };

  function start() {
    element.button.addClass('button-loader-active');
    if (opts && opts.start) {
      opts.start();
    }
  }

  function stop() {
    element.button.removeClass('button-loader-active');
    if (opts && opts.stop) {
      opts.stop();
    }
  }

  function getElement() {
    return element.button;
  }

  function init() {
    element.button = $(selector);
  }

  init();

  return {
    el: element.button,
    start: start,
    stop: stop
  };

};