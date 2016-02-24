var React = require('react');

module.exports = function(props) {
  
  if (!props.data.category) {
    props.data.category = {};
  }
  
  return (
    <div className="thumb thumb-search">
      <a className="thumb-feature" href={props.data.permalink}>
        <img src={ props.data.thumbnail} />
        <div className="m-overlay blanket-light"></div>
        <span className="thumb-time">{props.data.when}</span>
      </a>
      <div className="thumb-details">
        <a className="h-5 thumb-link" href={props.data.category.permalink}>{props.data.category.name}</a>
        <a className="h-2 thumb-title" href={props.data.permalink}>{props.data.title}</a>
        <div className="h-5 thumb-caption">{props.data.subtitle}</div>
      </div>
    </div>
  );
};