define([
  'jquery',
  'lodash',
  'backbone',
  'vm',
  'collections/completed',
  'text!templates/trails/completed.html',
], function($, _, Backbone, Vm,  CompletedCollection, CompletedTpl){
  var CompletedView = Backbone.View.extend({
    el: '#trailCompletedSection',
    initialize: function (options) {
    	this.options = options || {};
    	this.options.account_email = localStorage.getItem('accountEmail');
    	this.options.account_token = localStorage.getItem('accountToken');
    	this.completed = new CompletedCollection(this.options);   	
    	this.listenTo(this.completed, 'add', this.render);
	    this.listenTo(this.completed, 'change', this.render);
	    this.listenTo(this.completed, 'remove', this.render);
	    
	    _.bindAll(this, 'render');
    },
    
    events: {
    	'click #saveTrailCompletedBtn': 'saveTrailCompleted'
    },
    
    saveTrailCompleted: function (event) {
    	event.preventDefault();
    	var that = this;
    	
    	$('#markTrailCompletedModal').modal('toggle');
    	$('#markTrailCompletedModal').on('hidden.bs.modal', function (e) {
    		that.completed.create({
    			account_id: localStorage.getItem('accountId'),
    			account_email: localStorage.getItem('accountEmail'),
    			account_token: localStorage.getItem('accountToken'),
    			account_name: localStorage.getItem('accountName'),
    			completed_by:localStorage.getItem('accountId'),
    			completed_comment: $("#completed_comment").val(),
    			completed_date: $("#completed_date").val(),
    			collection_type: 'trail',
    			collection_id: that.options.collection_id,
    		});
    		// hide button
    		$("#markTrailCompleted").hide();
    	});
    	console.log('saved review');
    },
    
    render: function () {
    	var compiledTemplate = _.template(CompletedTpl,{completed:this.completed, trailName:this.options.trailName});
		$(this.el).html(compiledTemplate);
		return this;
    },   
  });

  return CompletedView;
});