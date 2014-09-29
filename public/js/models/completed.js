define([
  'lodash',
  'backbone',
], function(_, Backbone) {
  var CompletedModel = Backbone.Model.extend({
	idAttribute: "completed_id",
	
	defaults: {
		'completed_id': 0,
		'collection_type': 'trail',
		'collection_id': 0,
		'completed_by': 0,
		'completed_date': 0,
		'completed_comment': ''
	},
    initialize: function(){
    	this.on("change", function (TrailModel) {});		
		this.on("add", function(TrailModel) {});		
		this.on("remove", function(TrailModel) {});		
		this.on("reset", function(TrailModel) {});
    },
    url : function() {
		return  "/completed/index/"; 
	}
  });
  return CompletedModel;
});