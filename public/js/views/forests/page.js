define([
  'jquery',
  'lodash',
  'backbone',
  'collections/forest',
  'text!templates/forests/page.html',
  'text!templates/forests/list.html',
  'text!templates/forests/filter.html',
], function($, _, Backbone, ForestCollection, ForestTpl, ListForestTpl, FilterForestTpl	){
  var ForestView = Backbone.View.extend({
    el: '#main',
    initialize: function (options) {
    	this.forests = new ForestCollection(this.options);
    	
    	this.listenTo(this.forests, 'add', this.render);
	    this.listenTo(this.forests, 'change', this.render);
	    this.listenTo(this.forests, 'remove', this.render);
	    
	    _.bindAll(this, 'render');
    },
    
    events: {
    	
    },
    
    render: function () {
    	var compliedForestListTpl = _.template(ListForestTpl, {forests: this.forests});
    	
    	
    	var compiledTemplate = _.template(ForestTpl, { listForestTpl:compliedForestListTpl, filterForestTpl:FilterForestTpl});
		$(this.el).html(compiledTemplate);
		document.title = "Siskiyou Trails: Browse Forests";
		return this;
    },
    
  });

  return ForestView;
});
