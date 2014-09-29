define([
  'lodash',
  'backbone',
], function(_, Backbone) {
  var PlaceModel = Backbone.Model.extend({
	idAttribute: "place_id",
	
	defaults: {
	},
    initialize: function(){
    	this.on("change", function (PlaceModel) {});		
		this.on("add", function(PlaceModel) {});		
		this.on("remove", function(PlaceModel) {});		
		this.on("reset", function(PlaceModel) {});
    },
    url : function() {
		return  "/place/index/"; 
	}
  });
  return PlaceModel;
});