define([
  'jquery',
  'lodash',
  'backbone',
  'vm',
  'collections/nearby',
  'text!templates/trails/nearby.html',
], function($, _, Backbone, Vm,  NearbyCollection, NearbyTpl){
  var NearbyView = Backbone.View.extend({
    
	  initialize: function (options) {
    	this.options = options || {};
    	this.options.account_email = localStorage.getItem('accountEmail');
    	this.options.account_token = localStorage.getItem('accountToken');
    	
    	this.nearby = new NearbyCollection(this.options);   	
    	this.listenTo(this.nearby, 'add', this.render);
	    this.listenTo(this.nearby, 'change', this.render);
	    this.listenTo(this.nearby, 'remove', this.render);
	    
	    _.bindAll(this, 'render');
    },
    
    render: function () {
    	var compiledTemplate = _.template(NearbyTpl,{nearby:this.nearby});
		$("#" + this.options.section).html(compiledTemplate);
		return this;
    },   
  });

  return NearbyView;
});