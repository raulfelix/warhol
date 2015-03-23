/* global LWA, CoverPop */
window.Namespace('Views');


LWA.Modules.Loader({
  imageContent: '.header-feature-bg',
  hiddenContent: '#header-feature .m-wrap',
  loader: LWA.Modules.Spinner('#header-feature .loader-icon', {show: true})
});

LWA.Modules.Loader({
  imageContent: '.media-target-footer',
  hiddenContent: '.footer-next-feature .m-wrap'
});


LWA.Views.Subscribe = (function() {

  var COOKIE = '_lwa_subcribe';
  
  function subscribe(ev) {
    ev.preventDefault();
    
    $.getJSON(this.action + '?callback=?', $(this).serialize(), function(data) {
      updateCookie(COOKIE, 180);
      CoverPop.close();
     
      // error
      if (data.Status === 400) {
        updateCookie(COOKIE, 1);
      }
    });
  }
  
  function updateCookie(name, days) {
    var date = new Date();
    date.setTime(+ date + (days * 86400000));
    document.cookie = name + '=true; expires=' + date.toGMTString() + '; path=/';
  }
  
  function alreadySubscribed() {
    updateCookie(COOKIE, 30);
    CoverPop.close();
  }

  function init() {
    CoverPop.start({
      coverId: 'modal-suggest-subscribe',
      expires: 1,
      cookieName: COOKIE,
      closeOnEscape: true,
      delay: 5000
    });

    // events
    $('#js-subscribed').click(alreadySubscribed);
    $('#js-subscribe-form').submit(subscribe);
  }

//  init();

})();