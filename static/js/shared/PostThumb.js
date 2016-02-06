var React = require('react');

module.exports = function(props) {
  
  var breadcrumb;
  
  if (props.data.category.parent) {
    breadcrumb = <div>
      <a className="h-5 thumb-link" href={props.data.category.parentPermalink}>{props.data.category.parent}</a>
      <span className="colon">:</span>
      <a className="h-5 thumb-link" href={props.data.category.permalink}>{props.data.category.name}</a>
    </div>
  } else {
    breadcrumb = 
      <a className="h-5 thumb-link" href={props.data.category.permalink}>{props.data.category.name}</a>
  }
  
  return (
    <div className="thumb">
      {breadcrumb}
      <a href={props.data.permalink} className="thumb-feature">
        <img src={props.data.thumbnail} />
        <div className="m-overlay blanket-light"></div>
        <span className="thumb-time">{props.data.when}</span>
      </a>
      <a href={props.data.permalink} className="h-2 thumb-title">{props.data.title}</a>
      <div className="thumb-caption">{props.data.subtitle}</div>
    </div>
  );
  
};