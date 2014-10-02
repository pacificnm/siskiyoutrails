define([
  'jquery',
  'lodash',
  'backbone',
  'vm',
  'events',
  'collections/trails',
  'text!templates/trails/list.html',
], function($, _, Backbone, Vm, Events,  TrailCollection, TrailListTpl){
  var TrailListView = Backbone.View.extend({
    el: '#trailList',
    initialize: function (options) {
    	this.options = options || {};

    	this.options.account_email = localStorage.getItem('accountEmail');
    	this.options.account_token = localStorage.getItem('accountToken');
    	
    	this.trails = new TrailCollection(this.options);   	
    	this.listenTo(this.trails, 'add', this.render);
	    this.listenTo(this.trails, 'change', this.render);
	    this.listenTo(this.trails, 'remove', this.render);
	    _.bindAll(this, 'render');
    },
    
    events: {
    	
    },
    
    render: function () {
    	var compiledTemplate = _.template(TrailListTpl, {trails:this.trails, totalItemCount:this.trails.getTotalItemCount()});
		$(this.el).html(compiledTemplate);
		return this;
    },   
  });

  return TrailListView;
});