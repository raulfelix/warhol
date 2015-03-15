this["Handlebars"] = this["Handlebars"] || {};

this["Handlebars"]["gallery_inline"] = Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  var buffer = "", stack1, self=this, functionType="function", blockHelperMissing=helpers.blockHelperMissing, helperMissing=helpers.helperMissing, escapeExpression=this.escapeExpression;

function program1(depth0,data) {
  
  var buffer = "", stack1, helper, options;
  buffer += "\n      <li class=\"sly-slide header-gallery-overlay\" style=\"width: ";
  options={hash:{},inverse:self.noop,fn:self.program(2, program2, data),data:data}
  if (helper = helpers.getWidth) { stack1 = helper.call(depth0, options); }
  else { helper = (depth0 && depth0.getWidth); stack1 = typeof helper === functionType ? helper.call(depth0, options) : helper; }
  if (!helpers.getWidth) { stack1 = blockHelperMissing.call(depth0, stack1, {hash:{},inverse:self.noop,fn:self.program(2, program2, data),data:data}); }
  if(stack1 || stack1 === 0) { buffer += stack1; }
  buffer += "px;\">\n        ";
  stack1 = (helper = helpers.loader || (depth0 && depth0.loader),options={hash:{},inverse:self.noop,fn:self.program(2, program2, data),data:data},helper ? helper.call(depth0, (data == null || data === false ? data : data.index), options) : helperMissing.call(depth0, "loader", (data == null || data === false ? data : data.index), options));
  if(stack1 || stack1 === 0) { buffer += stack1; }
  buffer += "\n        <div class=\"m-wrap m-transparent\"><img class=\"m-bg\" data-img-src=\"";
  if (helper = helpers.src) { stack1 = helper.call(depth0, {hash:{},data:data}); }
  else { helper = (depth0 && depth0.src); stack1 = typeof helper === functionType ? helper.call(depth0, {hash:{},data:data}) : helper; }
  buffer += escapeExpression(stack1)
    + "\"></div>\n        <div class=\"blanket\"></div>\n      </li>\n    ";
  return buffer;
  }
function program2(depth0,data) {
  
  var buffer = "";
  return buffer;
  }

  buffer += "<div id=\"inline-gallery-frame\" class=\"header-feature-bg header-gallery-frame frame\" >\n  <ul class=\"slidee\">\n    ";
  stack1 = helpers.each.call(depth0, (depth0 && depth0.inline), {hash:{},inverse:self.noop,fn:self.program(1, program1, data),data:data});
  if(stack1 || stack1 === 0) { buffer += stack1; }
  buffer += "\n  </ul>\n</div>";
  return buffer;
  });

this["Handlebars"]["gallery_modal"] = Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  var stack1, functionType="function", escapeExpression=this.escapeExpression, self=this;

function program1(depth0,data) {
  
  var buffer = "", stack1, helper;
  buffer += "\n<div class=\"sly-slide\" data-closeable=\"0\">\n  <img class=\"m-wrap m-transparent\" data-img-src=\"";
  if (helper = helpers.src) { stack1 = helper.call(depth0, {hash:{},data:data}); }
  else { helper = (depth0 && depth0.src); stack1 = typeof helper === functionType ? helper.call(depth0, {hash:{},data:data}) : helper; }
  buffer += escapeExpression(stack1)
    + "\">\n  <span class=\"rsCaption\">";
  if (helper = helpers.caption) { stack1 = helper.call(depth0, {hash:{},data:data}); }
  else { helper = (depth0 && depth0.caption); stack1 = typeof helper === functionType ? helper.call(depth0, {hash:{},data:data}) : helper; }
  buffer += escapeExpression(stack1)
    + "</span>\n  <div class=\"loader-icon\"><i class=\"icon-reload\"></i></div>\n</div>\n";
  return buffer;
  }

  stack1 = helpers.each.call(depth0, (depth0 && depth0.inline), {hash:{},inverse:self.noop,fn:self.program(1, program1, data),data:data});
  if(stack1 || stack1 === 0) { return stack1; }
  else { return ''; }
  });

this["Handlebars"]["gallery_thumb"] = Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  var stack1, functionType="function", escapeExpression=this.escapeExpression, self=this;

function program1(depth0,data) {
  
  var buffer = "", stack1, helper;
  buffer += "\n<li><img src=\"";
  if (helper = helpers.src) { stack1 = helper.call(depth0, {hash:{},data:data}); }
  else { helper = (depth0 && depth0.src); stack1 = typeof helper === functionType ? helper.call(depth0, {hash:{},data:data}) : helper; }
  buffer += escapeExpression(stack1)
    + "\" width=\"150\" height=\"150\"></li>\n";
  return buffer;
  }

  stack1 = helpers.each.call(depth0, (depth0 && depth0.thumbnails), {hash:{},inverse:self.noop,fn:self.program(1, program1, data),data:data});
  if(stack1 || stack1 === 0) { return stack1; }
  else { return ''; }
  });