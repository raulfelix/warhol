this["Handlebars"] = this["Handlebars"] || {};

this["Handlebars"]["instabinge_thumb"] = Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  var stack1, functionType="function", escapeExpression=this.escapeExpression, self=this;

function program1(depth0,data) {
  
  var buffer = "", stack1;
  buffer += "\n<li class=\"sly-slide\">\n  <div data-id=\""
    + escapeExpression(((stack1 = ((stack1 = (depth0 && depth0.user)),stack1 == null || stack1 === false ? stack1 : stack1.id)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "\">\n    <img src=\""
    + escapeExpression(((stack1 = ((stack1 = ((stack1 = (depth0 && depth0.images)),stack1 == null || stack1 === false ? stack1 : stack1.low_resolution)),stack1 == null || stack1 === false ? stack1 : stack1.url)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "\">\n    <span class=\"instabinge-link\">@"
    + escapeExpression(((stack1 = ((stack1 = (depth0 && depth0.user)),stack1 == null || stack1 === false ? stack1 : stack1.username)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</span>\n  </div>\n</li>\n";
  return buffer;
  }

  stack1 = helpers.each.call(depth0, (depth0 && depth0.data), {hash:{},inverse:self.noop,fn:self.program(1, program1, data),data:data});
  if(stack1 || stack1 === 0) { return stack1; }
  else { return ''; }
  });

this["Handlebars"]["instabinge_thumb_modal"] = Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  var stack1, functionType="function", escapeExpression=this.escapeExpression, self=this, blockHelperMissing=helpers.blockHelperMissing;

function program1(depth0,data) {
  
  var buffer = "", stack1, helper, options;
  buffer += "\n<div class=\"modal-slide\">\n  <div class=\"instabinge-pod-wrap\">\n    <div class=\"modal-view-image\">\n      <div class=\"loader-icon\"><i class=\"icon-reload\"></i></div>\n      <div class=\"m-wrap m-transparent\"><img class=\"m-bg\" src=\""
    + escapeExpression(((stack1 = ((stack1 = ((stack1 = (depth0 && depth0.images)),stack1 == null || stack1 === false ? stack1 : stack1.standard_resolution)),stack1 == null || stack1 === false ? stack1 : stack1.url)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "\"></div>\n    </div>\n    <div class=\"modal-view-details\">\n      <div class=\"instabinge-profile\">\n        <div class=\"instabinge-profile-img\">\n          <img src=\""
    + escapeExpression(((stack1 = ((stack1 = (depth0 && depth0.user)),stack1 == null || stack1 === false ? stack1 : stack1.profile_picture)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "\">\n        </div>\n        <div class=\"instabinge-profile-details\">\n          <div class=\"instabinge-profile-details-primary\">\n            <div class=\"instabinge-user\">@"
    + escapeExpression(((stack1 = ((stack1 = (depth0 && depth0.user)),stack1 == null || stack1 === false ? stack1 : stack1.username)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</div>\n            <div class=\"instabinge-name\">"
    + escapeExpression(((stack1 = ((stack1 = (depth0 && depth0.user)),stack1 == null || stack1 === false ? stack1 : stack1.full_name)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</div>\n          </div>\n          <div class=\"instabinge-profile-details-secondary\">\n            <div class=\"instabinge-when\">";
  options={hash:{},inverse:self.noop,fn:self.program(2, program2, data),data:data}
  if (helper = helpers.formatTime) { stack1 = helper.call(depth0, options); }
  else { helper = (depth0 && depth0.formatTime); stack1 = typeof helper === functionType ? helper.call(depth0, options) : helper; }
  if (!helpers.formatTime) { stack1 = blockHelperMissing.call(depth0, stack1, {hash:{},inverse:self.noop,fn:self.program(2, program2, data),data:data}); }
  if(stack1 || stack1 === 0) { buffer += stack1; }
  buffer += "</div>\n            <div class=\"instabinge-likes\"><i class=\"icon-likes\"></i> "
    + escapeExpression(((stack1 = ((stack1 = (depth0 && depth0.likes)),stack1 == null || stack1 === false ? stack1 : stack1.count)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</div>\n          </div>\n        </div>\n      </div>\n      <div class=\"instabinge-wrap instabinge-captions\">\n        <span class=\"instabinge-caption\">"
    + escapeExpression(((stack1 = ((stack1 = (depth0 && depth0.caption)),stack1 == null || stack1 === false ? stack1 : stack1.text)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</span>\n        <span class=\"instabinge-tags\">";
  stack1 = helpers.each.call(depth0, (depth0 && depth0.tags), {hash:{},inverse:self.noop,fn:self.program(4, program4, data),data:data});
  if(stack1 || stack1 === 0) { buffer += stack1; }
  buffer += "</span>\n      </div>\n      <div class=\"instabinge-wrap instabinge-comments\">\n        <div class=\"instabinge-secondary\">Comments</div>\n        <ul>\n          ";
  stack1 = helpers.each.call(depth0, ((stack1 = (depth0 && depth0.comments)),stack1 == null || stack1 === false ? stack1 : stack1.data), {hash:{},inverse:self.noop,fn:self.program(6, program6, data),data:data});
  if(stack1 || stack1 === 0) { buffer += stack1; }
  buffer += "\n        </ul>\n      </div>\n    </div>\n  </div>\n</div>\n";
  return buffer;
  }
function program2(depth0,data) {
  
  var buffer = "";
  return buffer;
  }

function program4(depth0,data) {
  
  
  return " ";
  }

function program6(depth0,data) {
  
  var buffer = "", stack1, helper;
  buffer += "\n          <li class=\"instabinge-comment\">\n            <a href=\"http://www.instagram.com/"
    + escapeExpression(((stack1 = ((stack1 = (depth0 && depth0.from)),stack1 == null || stack1 === false ? stack1 : stack1.username)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "\" class=\"instabinge-username\" target=\"_blank\">"
    + escapeExpression(((stack1 = ((stack1 = (depth0 && depth0.from)),stack1 == null || stack1 === false ? stack1 : stack1.username)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</a>\n            <div>";
  if (helper = helpers.text) { stack1 = helper.call(depth0, {hash:{},data:data}); }
  else { helper = (depth0 && depth0.text); stack1 = typeof helper === functionType ? helper.call(depth0, {hash:{},data:data}) : helper; }
  buffer += escapeExpression(stack1)
    + "</div>\n          </li>\n          ";
  return buffer;
  }

  stack1 = helpers.each.call(depth0, (depth0 && depth0.data), {hash:{},inverse:self.noop,fn:self.program(1, program1, data),data:data});
  if(stack1 || stack1 === 0) { return stack1; }
  else { return ''; }
  });

this["Handlebars"]["instabinge_single_thumb_modal"] = Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  var buffer = "", stack1, helper, options, functionType="function", escapeExpression=this.escapeExpression, self=this, blockHelperMissing=helpers.blockHelperMissing;

function program1(depth0,data) {
  
  var buffer = "";
  return buffer;
  }

function program3(depth0,data) {
  
  
  return " ";
  }

function program5(depth0,data) {
  
  var buffer = "", stack1, helper;
  buffer += "\n          <li class=\"instabinge-comment\">\n            <a href=\"http://www.instagram.com/"
    + escapeExpression(((stack1 = ((stack1 = (depth0 && depth0.from)),stack1 == null || stack1 === false ? stack1 : stack1.username)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "\" class=\"instabinge-username\" target=\"_blank\">"
    + escapeExpression(((stack1 = ((stack1 = (depth0 && depth0.from)),stack1 == null || stack1 === false ? stack1 : stack1.username)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</a>\n            <div>";
  if (helper = helpers.text) { stack1 = helper.call(depth0, {hash:{},data:data}); }
  else { helper = (depth0 && depth0.text); stack1 = typeof helper === functionType ? helper.call(depth0, {hash:{},data:data}) : helper; }
  buffer += escapeExpression(stack1)
    + "</div>\n          </li>\n          ";
  return buffer;
  }

  buffer += "<div class=\"modal-slide\">\n  <div class=\"instabinge-pod-wrap\">\n    <div class=\"modal-view-image\">\n      <div class=\"loader-icon\"><i class=\"icon-reload\"></i></div>\n      <div class=\"m-wrap m-transparent\"><img class=\"m-bg\" src=\""
    + escapeExpression(((stack1 = ((stack1 = ((stack1 = (depth0 && depth0.images)),stack1 == null || stack1 === false ? stack1 : stack1.standard_resolution)),stack1 == null || stack1 === false ? stack1 : stack1.url)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "\"></div>\n    </div>\n    <div class=\"modal-view-details\">\n      <div class=\"instabinge-profile\">\n        <div class=\"instabinge-profile-img\">\n          <img src=\""
    + escapeExpression(((stack1 = ((stack1 = (depth0 && depth0.user)),stack1 == null || stack1 === false ? stack1 : stack1.profile_picture)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "\">\n        </div>\n        <div class=\"instabinge-profile-details\">\n          <div class=\"instabinge-profile-details-primary\">\n            <div class=\"instabinge-user\">@"
    + escapeExpression(((stack1 = ((stack1 = (depth0 && depth0.user)),stack1 == null || stack1 === false ? stack1 : stack1.username)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</div>\n            <div class=\"instabinge-name\">"
    + escapeExpression(((stack1 = ((stack1 = (depth0 && depth0.user)),stack1 == null || stack1 === false ? stack1 : stack1.full_name)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</div>\n          </div>\n          <div class=\"instabinge-profile-details-secondary\">\n            <div class=\"instabinge-when\">";
  options={hash:{},inverse:self.noop,fn:self.program(1, program1, data),data:data}
  if (helper = helpers.formatTime) { stack1 = helper.call(depth0, options); }
  else { helper = (depth0 && depth0.formatTime); stack1 = typeof helper === functionType ? helper.call(depth0, options) : helper; }
  if (!helpers.formatTime) { stack1 = blockHelperMissing.call(depth0, stack1, {hash:{},inverse:self.noop,fn:self.program(1, program1, data),data:data}); }
  if(stack1 || stack1 === 0) { buffer += stack1; }
  buffer += "</div>\n            <div class=\"instabinge-likes\"><i class=\"icon-likes\"></i> "
    + escapeExpression(((stack1 = ((stack1 = (depth0 && depth0.likes)),stack1 == null || stack1 === false ? stack1 : stack1.count)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</div>\n          </div>\n        </div>\n      </div>\n      <div class=\"instabinge-wrap instabinge-captions\">\n        <span class=\"instabinge-caption\">"
    + escapeExpression(((stack1 = ((stack1 = (depth0 && depth0.caption)),stack1 == null || stack1 === false ? stack1 : stack1.text)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</span>\n        <span class=\"instabinge-tags\">";
  stack1 = helpers.each.call(depth0, (depth0 && depth0.tags), {hash:{},inverse:self.noop,fn:self.program(3, program3, data),data:data});
  if(stack1 || stack1 === 0) { buffer += stack1; }
  buffer += "</span>\n      </div>\n      <div class=\"instabinge-wrap instabinge-comments\">\n        <div class=\"instabinge-secondary\">Comments</div>\n        <ul>\n          ";
  stack1 = helpers.each.call(depth0, ((stack1 = (depth0 && depth0.comments)),stack1 == null || stack1 === false ? stack1 : stack1.data), {hash:{},inverse:self.noop,fn:self.program(5, program5, data),data:data});
  if(stack1 || stack1 === 0) { buffer += stack1; }
  buffer += "\n        </ul>\n      </div>\n    </div>\n  </div>\n</div>";
  return buffer;
  });