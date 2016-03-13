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
/******/ ([
/* 0 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var Dropdown = __webpack_require__(1);
	
	Dropdown('#dropdown-sort');
	
	LWA.Modules.Loader({
	  imageContent: '.header-feature-bg',
	  hiddenContent: '.header-feature .m-wrap'
	});

/***/ },
/* 1 */
/***/ function(module, exports) {

	'use strict';
	
	module.exports = function (selector, options) {
	
	  var Dropdown = {
	
	    element: {
	      $wrap: undefined,
	      $label: undefined,
	      $items: undefined
	    },
	
	    close: function close() {
	      Dropdown.element.$wrap.removeClass('dropdown-active');
	    },
	
	    onClick: function onClick(ev) {
	      ev.preventDefault();
	      ev.stopPropagation();
	      Dropdown.element.$wrap.toggleClass('dropdown-active');
	    },
	
	    onItemClick: function onItemClick(ev) {
	      Dropdown.element.$wrap.removeClass('dropdown-active');
	
	      var item = $(ev.currentTarget),
	          label = item.addClass('dropdown-item-active').html();
	      item.siblings().removeClass('dropdown-item-active');
	      Dropdown.setLabel(label);
	    },
	
	    setLabel: function setLabel(label) {
	      Dropdown.element.$label.html(label);
	    },
	
	    init: function init(selector, options) {
	      Dropdown.element.$wrap = $(selector);
	      Dropdown.element.$label = Dropdown.element.$wrap.find('.dropdown-label span');
	
	      // events
	      Dropdown.element.$wrap.find('.dropdown-label').click(Dropdown.onClick);
	    }
	  };
	
	  var Events = {
	    init: function init() {
	      $('html').click(Dropdown.close);
	    }
	  };
	
	  Dropdown.init(selector, options);
	  Events.init();
	};

/***/ }
/******/ ]);
//# sourceMappingURL=category.entry.js.map