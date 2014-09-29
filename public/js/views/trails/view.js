define([
  'jquery',
  'lodash',
  'backbone',
  'vm',
  'models/attribute',
  'collections/trail',
  'views/attribute/attributeGroupItem',
  'views/trails/review',
  'text!templates/trails/view.html',
  'text!templates/trails/slider.html',
  'text!templates/trails/tabs.html',
  'text!templates/trails/modals.html',
], function($, _, Backbone, Vm, 
		AttributeModel,
		TrailCollection,
		ViewAttributeGroupItem, ReviewView,
		ViewTrailTpl, 
		TrailSliderTpl, TrailTabTpl, TrailModalTpl	){
  var ViewTrailView = Backbone.View.extend({
    el: '#main',
    
    initialize: function (options) {
    	
    	this.options = options || {};
    	
    	this.trails = new TrailCollection(this.options); 
    	this.listenTo(this.trails, 'add', this.render);
    	this.listenTo(this.trails, 'change', this.render);
	    _.bindAll(this, 'render');
    },
    
    events: {
    	'click #uploadTrailPhoto': 'showUploadTrailPhotoFrm',
    	'click #uploadTrailTrack': 'showUploadTrailTrackFrm',
    	'click #writeTrailReview': 'showWriteReviewFrm',
    	'click #editTrailDetails': 'showEditTrailDetailsFrm',
    	'click #editTrailFeatures': 'showEditTrailFeaturesFrm',
    	'click #editTrailActivities': 'showEditTrailActivitiesFrm',
    	'click #editTrailGoodFor': 'showEditTrailGoodForFrm',
    	'click #reportTrail': 'showReportTrailFrm',
    	'click #markTrailCompleted': 'showMarkTrailCompletedFrm',
    	'click #addTrailToFavs': 'showAddTrailToFavsFrm',
    	'click #addTrailToTrip': 'showAddTrailToTripFrm',
    	'click #addTrailResource': 'showAddTrailResourceFrm',
    		
    	'click #saveTrailDetailsBtn': 'saveTrailDetails',
    	'click #saveTrailFeatures': 'saveTrailFeatures',
    	'click #saveTrailActivities': 'saveTrailActivities',
    	'click #saveTrailGoodFor': 'saveTrailGoodFor'
    },
    
    showUploadTrailPhotoFrm: function (event) {
    	event.preventDefault();
    	$('#uploadTrailPhotoModal').modal('toggle');
    },
    
    showUploadTrailTrackFrm: function (event) {
    	event.preventDefault();
    	$('#uploadTrailTrackModal').modal('toggle');
    },
    
    showWriteReviewFrm: function (event) {
    	event.preventDefault();
    	$("[data-toggle='date-picker']").datepicker({});
    	$('#WriteReviewModal').modal('toggle');
    },
    
    showEditTrailDetailsFrm: function (event) {
    	event.preventDefault();
    	$('#editTrailDetailsModal').modal('toggle');
    },
    
    showReportTrailFrm: function (event) {
    	event.preventDefault();
    	$('#reportTrailModal').modal('toggle');
    },
    
    showEditTrailFeaturesFrm: function (event) {
    	event.preventDefault();
    	var model = this.trails.get(this.options.trail_slug);
    	var params = {attribute_group_id:1, trail_id:model.get('trail_id'), section:'trailFeaturesSectionFld'};
    	Vm.create(this, 'ViewAttributeGroupItem', ViewAttributeGroupItem, params);  	
    	$('#editTrailFeaturesModal').modal('toggle');
    	
    },
    
    showEditTrailActivitiesFrm: function (event) {
    	event.preventDefault();
    	var model = this.trails.get(this.options.trail_slug);
    	var params = {attribute_group_id:2, trail_id:model.get('trail_id'), section:'trailActivitiesSectionFld'};
    	Vm.create(this, 'ViewAttributeGroupItem', ViewAttributeGroupItem, params);    	
    	$('#editTrailActivitiesModal').modal('toggle');
    },
    
    showEditTrailGoodForFrm: function (event) {
    	event.preventDefault();
    	var model = this.trails.get(this.options.trail_slug);
    	var params = {attribute_group_id:3, trail_id:model.get('trail_id'), section:'trailGoodForFld'};
    	Vm.create(this, 'ViewAttributeGroupItem', ViewAttributeGroupItem, params);
    	$('#editTrailGoodForModal').modal('toggle');
    },
    
    showMarkTrailCompletedFrm: function (event) {
    	event.preventDefault();
    	$('#markTrailCompletedModal').modal('toggle');
    },
    
    showAddTrailToFavsFrm: function (event) {
    	event.preventDefault();
    	$('#addTrailToFavsModal').modal('toggle');
    },
    
    showAddTrailToTripFrm: function (event) {
    	event.preventDefault();
    	$('#addTrailToTripModal').modal('toggle');
    },
    
    showAddTrailResourceFrm: function (event) {
    	event.preventDefault();
    	$('#addTrailResourceModal').modal('toggle');
    },
    
    
    saveTrailDetails: function (event) {
    	var that = this;
    	event.preventDefault();
    	$('#editTrailDetailsModal').modal('toggle');
    	$('#editTrailDetailsModal').on('hidden.bs.modal', function (e) {
    		model = that.trails.get(that.options.trail_slug);
    		model.save({
    			trail_id: model.get('trail_id'),
    			trail_name: $("#trail_name").val(),
    			trail_overview: $("#trail_overview").val(),
    			trail_dificulty: $("#trail_dificulty").val(),
    			trail_distance: $("#trail_distance").val(),
    			trail_duration: $("#trail_duration").val(),
    			trail_elevation_gain: $("#trail_elevation_gain").val(),
    			trail_season: $("#trail_season").val(),
    			trail_usage: $("#trail_usage").val(),
    			trail_animals: $("#trail_animals").val(),
    			trail_water: $("#trail_water").val(),
    			trail_city: $("#trail_city").val(),
    			trail_state: $("#trail_state").val(),
    			trail_county: $("#trail_county").val(),
    			trail_city: $("#trail_city").val(),
    			trail_state: $("#trail_state").val(),
    			trail_county: $("#trail_county").val(),
    			trail_restrictions: $("#trail_restrictions").val(),
    			trail_forest: $("#trail_forest").val(),
    		  },{wait:true,
    			success:function(account, response, options) {
    				console.log('model was saved');
    			},
    			error: function (model, response, options) {
    				console.log(response);
    			}
    		});
    	});
    },
    
    saveTrailFeatures: function (event) { 	
    	event.preventDefault();
    	var model = this.trails.get(this.options.trail_slug);
    	$('#editTrailFeaturesModal').modal('toggle');
    	$('#editTrailFeaturesFrm input:checkbox').each(function () {
    		var attributeModel = new AttributeModel();
    	    var attribute_type_id = (this.checked ? $(this).val() : "");
    	       if(attribute_type_id > 0) {
    	    	   console.log(attribute_type_id);
    	    	   attributeModel.save({
    	    		   collection_type: 'trail',
    	    		   collection_id:model.get('trail_id'),
    	    		   attribute_type_id:attribute_type_id,
    	    		   attribute_value:1,
    	    	   });
    	       } else {
    	    	   attributeModel.save({
    	    		   collection_type: 'trail',
    	    		   collection_id:model.get('trail_id'),
    	    		   attribute_type_id:$(this).val(),
    	    		   attribute_value:0,
    	    	   });
    	       } 
    	});
    	
    },
    
    saveTrailActivities: function (event) {
    	event.preventDefault();
    	var model = this.trails.get(this.options.trail_slug);
    	$('#editTrailActivitiesModal').modal('toggle');
    	$('#editTrailActivitiesFrm input:checkbox').each(function () {
    		var attributeModel = new AttributeModel();
    	    var attribute_type_id = (this.checked ? $(this).val() : "");
    	       if(attribute_type_id > 0) {
    	    	   console.log(attribute_type_id);
    	    	   attributeModel.save({
    	    		   collection_type: 'trail',
    	    		   collection_id:model.get('trail_id'),
    	    		   attribute_type_id:attribute_type_id,
    	    		   attribute_value:1,
    	    	   });
    	       } else {
    	    	   attributeModel.save({
    	    		   collection_type: 'trail',
    	    		   collection_id:model.get('trail_id'),
    	    		   attribute_type_id:$(this).val(),
    	    		   attribute_value:0,
    	    	   });
    	       } 
    	});
    	
    },
    
    saveTrailGoodFor: function (event) {
    	event.preventDefault();
    	var model = this.trails.get(this.options.trail_slug);
    	$('#editTrailGoodForModal').modal('toggle');
    	$('#editTrailGoodForFrm input:checkbox').each(function () {
    		var attributeModel = new AttributeModel();
    	    var attribute_type_id = (this.checked ? $(this).val() : "");
    	       if(attribute_type_id > 0) {
    	    	   console.log(attribute_type_id);
    	    	   attributeModel.save({
    	    		   collection_type: 'trail',
    	    		   collection_id:model.get('trail_id'),
    	    		   attribute_type_id:attribute_type_id,
    	    		   attribute_value:1,
    	    	   });
    	       } else {
    	    	   attributeModel.save({
    	    		   collection_type: 'trail',
    	    		   collection_id:model.get('trail_id'),
    	    		   attribute_type_id:$(this).val(),
    	    		   attribute_value:0,
    	    	   });
    	       } 
    	});
    },
    
    render: function () {
    	model = this.trails.get(this.options.trail_slug);
    	
    	if(model.get('trail_name')) {
    		
    		var trailModals = _.template(TrailModalTpl, {trail:model, forests:this.forests});	
    		var compiledTemplate = _.template(ViewTrailTpl, {trail:model,sliderTpl:TrailSliderTpl, tabs:TrailTabTpl, modals:trailModals });
    		
    		$(this.el).html(compiledTemplate);
    		document.title = "Trail: " + model.get('trail_name');
    		
    		// reviews
    		review = new ReviewView({collection_type:'trail', collection_id:model.get('trail_id')});
    		
    		
    	} else {
    		console.log('no trail found');
    	}
    },
    
  });

  return ViewTrailView;
});