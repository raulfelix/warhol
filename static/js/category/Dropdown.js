module.exports = function(selector, options) {

  var Dropdown = {

    element: {
      $wrap: undefined,
      $label: undefined,
      $items: undefined
    },
    
    close: function() {
      Dropdown.element.$wrap.removeClass('dropdown-active');
    },

    onClick: function(ev) {
      ev.preventDefault();
      ev.stopPropagation();
      Dropdown.element.$wrap.toggleClass('dropdown-active');
    },

    onItemClick: function(ev) {
      Dropdown.element.$wrap.removeClass('dropdown-active');

      var
        item = $(ev.currentTarget),
        label = item.addClass('dropdown-item-active').html();
      item.siblings().removeClass('dropdown-item-active');
      Dropdown.setLabel(label);
    },

    setLabel: function(label) {
      Dropdown.element.$label.html(label);
    },

    init: function(selector, options) {
      Dropdown.element.$wrap = $(selector);
      Dropdown.element.$label = Dropdown.element.$wrap.find('.dropdown-label span');
      
      // events
      Dropdown.element.$wrap.find('.dropdown-label').click(Dropdown.onClick);
    }
  };

  var Events = {
    init: function() {
      $('html').click(Dropdown.close);
    }
  };

  Dropdown.init(selector, options);
  Events.init();
  
};