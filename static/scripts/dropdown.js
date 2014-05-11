/* global LWA */
window.LWA = window.LWA || { Views: {}, Modules: {} };

LWA.Modules.Dropdown = function(selector, options) {

  var Dropdown = {

    element: {
      $wrap: undefined,
      $label: undefined,
      $items: undefined
    },
    
    onClick: function(ev) {
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
      Dropdown.element.$wrap.on('click', '.dropdown-item', this.onItemClick);
    }
  };

  Dropdown.init(selector, options);

  return {
  };

};

LWA.Modules.Dropdown('#dropdown-sort');