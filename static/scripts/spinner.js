/*global LWA */
window.LWA = window.LWA || { Views: {}, Modules: {} };

LWA.Modules.Spinner = function(parent, opts) {

  var $el,
    options,
    defaults = {
      message: false,
      messageText: 'Loading',
      affix: false
    };

  function show() {
    //if (App.Supports.transitions) {
    $el.addClass('loader-active');
    // } else {
    //   $el.css('z-index', '100000').fadeTo(150, 0.8);
    // }

    return this;
  }

  function hide() {
    // if (App.Supports.transitions) {
    $el.removeClass('loader-active');
    // } else {
    //   $el.fadeTo(150, 0, function() {
    //     $el.css('z-index', '-1');
    //   });
    // }
    
    return this;
  }

  function init() {
    // options = _.extend(defaults, opts);
    // var css = options.affix ? 'loader loader-affix' : 'loader';
    // if (options.message) {
      // $el = $('<div class="' + css + '"><span>' + options.messageText + '</span></div>');
    // } else {
    $el = $('<div class="loader"></div>');
    // }
    parent.append($el);
  }

  init();

  return {
    show: show,
    hide: hide
  };
};