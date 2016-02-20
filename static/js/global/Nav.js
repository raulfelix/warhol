module.exports = (function() {

  var $nav;

  function onClick(ev) {
    ev.preventDefault();
    $nav.toggleClass('nav-active');
    $('html').toggleClass('no-scroll');
    
    if (!$nav.hasClass('nav-active')) {
      $('.nav-touch-toggle').text('+');
      $('.nav-links-primary li').attr('style', null);
    }
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
      
      $('.nav-touch-toggle').click(function() {
        if (this.dataset.state == 0) {
          this.dataset.state = 1;
          $(this).text('+').closest('li').attr('style', null);
        } else {
          this.dataset.state = 0;
          var height = $(this).next().height();
          $(this).text('-').closest('li').css('height', 62 + height + 'px');
        }
      });
    }
  };

})();