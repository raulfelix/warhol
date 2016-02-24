var React = require('react');
var PostThumb = require('../shared/PostThumb');
var ButtonLoader = require('../shared/ButtonLoader.react');
var FeedMixin = require('./FeedMixin');

module.exports = React.createClass({
  
  mixins: [FeedMixin],
  
  getInitialState: function() {
    var width = document.body.offsetWidth > 1160 ? 1160 : document.body.offsetWidth;
    
    if (width <= 700) {
      width = (width - 40);
    } else {
      width = (width - 60) / 2;
    }
      
    return {
      page: 1,
      posts: [],
      width: width
    }
  },
  
  componentDidMount: function() {
    this.load('get_next_featured_posts');
  },
  
  render: function() {
    var nodes = [];
    
    for (var i = 0; i < this.state.posts.length; i++) {
      var id = this.state.posts[i].id;
      if (i % 2 === 0) {
        nodes.push(<div key={'f' + id} className="thumb-inline-fix"></div>);
      }
      nodes.push(
        <div key={id} className="f-1-2 bp1-1">
          <PostThumb
            data={this.state.posts[i]}
            width={this.state.width} />
        </div>
      );
    }
    
    return (
      <section className="f-grid section-thumb">
        <div className="f-row">
          {nodes}
        </div>
        <div className="button-row">
          <ButtonLoader
            ref="submit"
            label="load more features"
            onClick={this.onLoad} />
        </div>
      </section>
    );
  },
  
  
  onLoad: function() {
    this.load('get_next_featured_posts', this.done);
  },
  
  
  done: function() {
    if (this.state.page === false) {
      this.refs.submit.kill();
    } else {
      this.refs.submit.stop();
    }
  }
    
});