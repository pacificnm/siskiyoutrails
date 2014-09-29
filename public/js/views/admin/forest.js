define([
  'jquery',
  'lodash',
  'backbone',
  'collections/forests',
  'collections/account',
  'text!templates/admin/forest.html',
], function($, _, Backbone, ForestCollection, AccountCollection, ForestTpl){
  var ForestView = Backbone.View.extend({
    el: '#adminSection',
    
    initialize: function (options) {
    	this.options = options || {};
    	this.account = new AccountCollection({account_email:localStorage.getItem('accountEmail'),account_token:localStorage.getItem('accountToken') });
    	this.forests = new ForestCollection();
    	
    	this.listenTo(this.forests, 'add', this.render);
	    this.listenTo(this.forests, 'change', this.render);
	    this.listenTo(this.forests, 'remove', this.render);
	    
	    _.bindAll(this, 'render');
    },
    
    
    events: {
    	'click #createForestBtn': 'showCreateForestFrm',
    	'click #saveForestBtn': 'saveForest',
    	'click #editForestBtn': 'showEditForestFrm',
    },
    
    showEditForestFrm: function (event) {
    	event.preventDefault();
    	var selectedItem = $(event.currentTarget);
		forestId = selectedItem.data('id');
		var model = this.forests.get(forestId);
		
		$("#forest_name").val(model.get('forest_name'));
		$("#forest_street").val(model.get('forest_street'));
		$("#forest_city").val(model.get('forest_city'));
		$("#forest_state").val(model.get('forest_state'));
		$("#forest_postal").val(model.get('forest_postal'));
		$("#forest_overview").val(model.get('forest_overview'));
		$("#forest_id").val(model.get('forest_id'));
		$("#forest_slug").val(model.get('forest_slug'));
		$('#addForestModal').modal('toggle');
    },

    showCreateForestFrm: function (event) {
    	event.preventDefault();
    	$('#addForestModal').modal('toggle');
    },
    
    saveForest: function (event) {
    	var that = this;
    	event.preventDefault();
    	$('#addForestModal').modal('toggle');
    	
    	$('#addForestModal').on('hidden.bs.modal', function (e) {
    		var forestId = $("#forest_id").val(); 
    		if(forestId > 0 ) {
    			var forestSlug = $("#forest_slug").val();
    			console.log(forestSlug);
    			var model = that.forests.get(forestSlug);
    			model.save({
    				forest_id: $("#forest_id").val(),
    				forest_name: $("#forest_name").val(),
    				forest_street: $("#forest_street").val(),
    				forest_city: $("#forest_city").val(),
    				forest_state: $("#forest_state").val(),
    				forest_postal: $("#forest_postal").val(),
    				forest_overview: $("#forest_overview").val()
    				
	    			},{wait:true,
	    			    success:function(model, response, options) {
	    			    	$("#flashMessenger").html('<div class="alert alert-success">The forest was created</div>');
	    			},
	    			    error: function (model, response, options) {
	    			    	$("#flashMessenger").html('<div class="alert alert-danger">There was an error saving the forest</div>');
	    			}
    			});
    		} else {
    			that.forests.create({
    				forest_name: $("#forest_name").val(),
    				forest_street: $("#forest_street").val(),
    				forest_city: $("#forest_city").val(),
    				forest_state: $("#forest_state").val(),
    				forest_postal: $("#forest_postal").val(),
    				forest_overview: $("#forest_overview").val()
    				
	    			},{wait:true,
	    			    success:function(model, response, options) {
	    			    	$("#flashMessenger").html('<div class="alert alert-success">The forest was created</div>');
	    			},
	    			    error: function (model, response, options) {
	    			    	$("#flashMessenger").html('<div class="alert alert-danger">There was an error saving the forest</div>');
	    			}
    			});
    		}
    	});
    },
    
    render: function () {
    	var compiledTemplate = _.template(ForestTpl, {forests:this.forests});
		$(this.el).html(compiledTemplate);
		return this;
    },
    
  });

  return ForestView;
});