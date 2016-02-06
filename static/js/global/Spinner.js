module.exports = function(loaderSelector, opts) {

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
    if (opts && opts.show) {
      show();
    }
  }

  function destroy() {
    $el.remove();
    $el = undefined;
  }

  init();

  return {
    show: show,
    hide: hide,
    destroy: destroy
  };
};