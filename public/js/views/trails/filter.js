define([
  'jquery',
  'lodash',
  'backbone',
  'collections/forests',
  'text!templates/trails/filter.html',
], function($, _, Backbone,  ForestCollection, FilterTrailTpl){
  var TrailFilterView = Backbone.View.extend({
    el: '#filterTrail',
    initialize: function (options) {
    	this.options = options || {};
    	
    	console.log(options);
    	
    	this.forests = new ForestCollection();
    	
    	this.listenTo(this.forests, 'add', this.render);
    	
	    _.bindAll(this, 'render');
    },
    
    events: {
    	
    },
    
    render: function () {
    	
    	var compiledFilterTpl = _.template(FilterTrailTpl, {forests: this.forests});
    	
    	$(this.el).html(compiledFilterTpl);
    	$("#previous").prop("disabled",true);
		return this;
    },
    
  });

  return TrailFilterView;
});