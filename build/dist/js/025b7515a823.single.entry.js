/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ({

/***/ 0:
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var Subscribe = __webpack_require__(172);
	
	Subscribe.init();
	
	LWA.Modules.Loader({
	  imageContent: '.header-feature-bg',
	  hiddenContent: '#header-feature .m-wrap',
	  loader: LWA.Modules.Spinner('#header-feature .loader-icon', { show: true })
	});
	
	LWA.Modules.Loader({
	  imageContent: '.media-target-footer',
	  hiddenContent: '.footer-next-feature .m-wrap'
	});

/***/ },

/***/ 172:
/***/ function(module, exports) {

	'use strict';
	
	module.exports = function () {
	
	  var COOKIE = '_lwa_subcribe';
	
	  function subscribe(ev) {
	    ev.preventDefault();
	
	    $.getJSON(this.action + '?callback=?', $(this).serialize(), function (data) {
	      CoverPop.close();
	
	      // error
	      if (data.Status === 400) {
	        updateCookie(COOKIE, 1);
	      } else {
	        updateCookie(COOKIE, 180);
	      }
	    });
	  }
	
	  function updateCookie(name, days) {
	    var date = new Date();
	    date.setTime(+date + days * 86400000);
	    document.cookie = name + '=true; expires=' + date.toUTCString() + '; path=/';
	  }
	
	  function alreadySubscribed() {
	    CoverPop.close();
	    updateCookie(COOKIE, 30);
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
	
	  return {
	    init: init
	  };
	}();

/***/ }

/******/ });
//# sourceMappingURL=single.entry.js.map