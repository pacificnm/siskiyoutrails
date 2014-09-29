define([
  'lodash',
  'backbone',
], function(_, Backbone) {
  var ForestModel = Backbone.Model.extend({
	idAttribute: "forest_slug",
	
	defaults: {
		forest_id: 0,
		forest_name: '',
		forest_overview: '',
		forest_create_date: '',
		forest_create_by: '',
		forest_street: '',
		forest_city: '',
		forest_state: '',
		forest_postal: '',
	},
    initialize: function(){
    	this.on("change", function (ForestModel) {});		
		this.on("add", function(ForestModel) {});		
		this.on("remove", function(ForestModel) {});		
		this.on("reset", function(ForestModel) {});
    },
    url : function() {
		return  "/forest/index/"; 
	}
  });
  return ForestModel;
});