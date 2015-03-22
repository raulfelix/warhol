/*!
 * CoverPop 2.5.0
 * http://coverpopjs.com
 *
 * Copyright (c) 2014 Tyler Pearson
 * Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
 */

(function(e,t){"use strict";var n={coverId:"CoverPop-cover",expires:30,closeClassNoDefault:"CoverPop-close",closeClassDefault:"CoverPop-close-go",cookieName:"_CoverPop",onPopUpOpen:null,onPopUpClose:null,forceHash:"splash",delayHash:"go",closeOnEscape:true,delay:0,hideAfter:null},r={html:document.getElementsByTagName("html")[0],cover:document.getElementById(n.coverId),closeClassDefaultEls:document.querySelectorAll("."+n.closeClassDefault),closeClassNoDefaultEls:document.querySelectorAll("."+n.closeClassNoDefault)},i={hasClass:function(e,t){return(new RegExp("(\\s|^)"+t+"(\\s|$)")).test(e.className)},addClass:function(e,t){if(!i.hasClass(e,t)){e.className+=(e.className?" ":"")+t}},removeClass:function(e,t){if(i.hasClass(e,t)){e.className=e.className.replace(new RegExp("(\\s|^)"+t+"(\\s|$)")," ").replace(/^\s+|\s+$/g,"")}},addListener:function(e,t,n){if(e.addEventListener){e.addEventListener(t,n,false)}else if(e.attachEvent){e.attachEvent("on"+t,n)}},removeListener:function(e,t,n){if(e.removeEventListener){e.removeEventListener(t,n,false)}else if(e.detachEvent){e.detachEvent("on"+t,n)}},isFunction:function(e){var t={};return e&&t.toString.call(e)==="[object Function]"},setCookie:function(e,t){var n=new Date;n.setTime(+n+t*864e5);document.cookie=e+"=true; expires="+n.toGMTString()+"; path=/"},hasCookie:function(e){if(document.cookie.indexOf(e)!==-1){return true}return false},hashExists:function(e){if(window.location.hash.indexOf(e)!==-1){return true}return false},preventDefault:function(e){if(e.preventDefault){e.preventDefault()}else{e.returnValue=false}},mergeObj:function(e,t){for(var n in t){e[n]=t[n]}}},s=function(t){if(n.closeOnEscape){if(t.keyCode===27){e.close()}}},o=function(){if(n.onPopUpOpen!==null){if(i.isFunction(n.onPopUpOpen)){n.onPopUpOpen.call()}else{throw new TypeError("CoverPop open callback must be a function.")}}},u=function(){if(n.onPopUpClose!==null){if(i.isFunction(n.onPopUpClose)){n.onPopUpClose.call()}else{throw new TypeError("CoverPop close callback must be a function.")}}};e.open=function(){var t,u;if(i.hashExists(n.delayHash)){i.setCookie(n.cookieName,1);return}i.addClass(r.html,"CoverPop-open");if(r.closeClassNoDefaultEls.length>0){for(t=0,u=r.closeClassNoDefaultEls.length;t<u;t++){i.addListener(r.closeClassNoDefaultEls[t],"click",function(t){if(t.target===this){i.preventDefault(t);e.close()}})}}if(r.closeClassDefaultEls.length>0){for(t=0,u=r.closeClassDefaultEls.length;t<u;t++){i.addListener(r.closeClassDefaultEls[t],"click",function(t){if(t.target===this){e.close()}})}}i.addListener(document,"keyup",s);o()};e.close=function(e){i.removeClass(r.html,"CoverPop-open");i.setCookie(n.cookieName,n.expires);i.removeListener(document,"keyup",s);u()};e.init=function(t){if(navigator.cookieEnabled){i.mergeObj(n,t);if(!i.hasCookie(n.cookieName)||i.hashExists(n.forceHash)){if(n.delay===0){e.open()}else{setTimeout(e.open,n.delay)}if(n.hideAfter){setTimeout(e.close,n.hideAfter+n.delay)}}}};e.start=function(t){e.init(t)}})(window.CoverPop=window.CoverPop||{})
/* global LWA, ga */
window.Namespace('Modules');

LWA.Modules.Share = (function() {

  var modal, buttonUrl;

  function share(ev) {
    ga('send', 'event', 'Share', 'click', $(ev.currentTarget).data('name'), {'page': location.pathname });
    window.open(
      $(this).data('href'),
      '',
      'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'
    );
  }

  function highlight() {
    buttonUrl.select();
    return false;
  }

  function positionContent() {
    ga('send', 'event', 'Share', 'click', 'Share modal open');

    var contentHeight = modal.$el.find('.modal-view').height();
    if (LWA.Modules.Util.windowHeight() > contentHeight) {
      modal.$el.find('.modal-view').css('margin-top', (LWA.Modules.Util.windowHeight() - contentHeight) / 2 );
    } else {
      modal.$el.find('.modal-view').css('margin-top', '20px');
    }
  }

  return {
    init: function() {
      buttonUrl = $('#modal-share .button-url').click(highlight);

      modal = LWA.Modules.Modal('.button-share', '#modal-share', { open: positionContent });
      modal.$el.find('.button-social').click(share);
    }
  };

})();

LWA.Modules.Share.init();
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

  init();

})();