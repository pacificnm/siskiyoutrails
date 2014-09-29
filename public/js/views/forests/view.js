define([
  'jquery',
  'lodash',
  'backbone',
  'collections/forest',
  'text!templates/forests/view.html',
  'text!templates/forests/slider.html',
  'text!templates/forests/tabs.html',
], function($, _, Backbone, ForestCollection, ViewForestTpl, ForestSliderTpl, ForestTabTpl){
  var ViewForestView = Backbone.View.extend({
    el: '#main',
    initialize: function (options) {
    	this.options = options || {};
    	this.forests = new ForestCollection(this.options);
    	
    	this.listenTo(this.forests, 'add', this.render);
	    this.listenTo(this.forests, 'change', this.render);
	    this.listenTo(this.forests, 'remove', this.render);
	    
	    _.bindAll(this, 'render');
    },
    
    events: {
    	
    },
    
    render: function () {
    	model = this.forests.get(this.options.forest_slug);
    	if(model.get('forest_name')) {
    		
    		var compiledTemplate = _.template(ViewForestTpl, {forest: model, sliderTpl:ForestSliderTpl, tabs:ForestTabTpl});
    		$(this.el).html(compiledTemplate);
    		
    		document.title = "Forest: " + model.get('forest_name');
    	}
    	
    	
    	
		return this;
    },
    
  });

  return ViewForestView;
});
