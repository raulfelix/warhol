this["Handlebars"] = this["Handlebars"] || {};

this["Handlebars"]["instabinge_thumb"] = Handlebars.template(function (Handlebars,depth0,helpers,partials,data) {
  this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Handlebars.helpers); data = data || {};
  var stack1, functionType="function", escapeExpression=this.escapeExpression, self=this;

function program1(depth0,data) {
  
  var buffer = "", stack1;
  buffer += "\n<li>\n  <a href=\"javascript:void(0)\" data-id=\""
    + escapeExpression(((stack1 = ((stack1 = (depth0 && depth0.user)),stack1 == null || stack1 === false ? stack1 : stack1.id)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "\">\n    <img src=\""
    + escapeExpression(((stack1 = ((stack1 = ((stack1 = (depth0 && depth0.images)),stack1 == null || stack1 === false ? stack1 : stack1.low_resolution)),stack1 == null || stack1 === false ? stack1 : stack1.url)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "\">\n    <div class=\"instabinge-link\">@"
    + escapeExpression(((stack1 = ((stack1 = (depth0 && depth0.user)),stack1 == null || stack1 === false ? stack1 : stack1.username)),typeof stack1 === functionType ? stack1.apply(depth0) : stack1))
    + "</div>\n  </a>\n</li>\n";
  return buffer;
  }

  stack1 = helpers.each.call(depth0, (depth0 && depth0.data), {hash:{},inverse:self.noop,fn:self.program(1, program1, data),data:data});
  if(stack1 || stack1 === 0) { return stack1; }
  else { return ''; }
  });