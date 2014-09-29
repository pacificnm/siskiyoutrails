define([
  'lodash',
  'backbone',
], function(_, Backbone) {
  var TrailModel = Backbone.Model.extend({
	idAttribute: "trail_slug",
	
	defaults: {
		trail_id: 0,
		trail_name: '',
		trail_slug: '',
		trail_overview: '',
		trail_coordinates: '',
		trail_head: '',
		trail_create_by: 0,
		trail_create_date: 0,
		trail_elevation_gain: 0,
		trail_season: '',
		trail_usage: '',
		trail_animals: '',
		trail_water: '',
		trail_city: '',
		trail_state: '',
		trail_county: '',
		trail_restrictions: '',
		trail_forest: ''
	},
    initialize: function(){
    	this.on("change", function (TrailModel) {});		
		this.on("add", function(TrailModel) {});		
		this.on("remove", function(TrailModel) {});		
		this.on("reset", function(TrailModel) {});
    },
    url : function() {
		return  "/trail/index/"; 
	}
  });
  return TrailModel;
});