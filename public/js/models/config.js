define([
  'lodash',
  'backbone'
], function(_, Backbone) {
  var configModel = Backbone.Model.extend({
	idAttribute: "config_id",

    defaults: {
      artist_name: 'Unknown'
    },
    
    initialize: function(){
    	this.on("change", function (artistModel) {
			//console.log("Work Order Model Changed");
		});
		
		this.on("add", function(artistModel) {
			//console.log("Work Order "+Model.get("workorder_id")+" was added to model");
		});
		
		this.on("remove", function(artistModel) {
			//console.log("Work Order  was removed from model");
		});
		
		this.on("reset", function(artistModel) {
			//console.log("Client Model reset");
		});
    },
    
    url : function() {
		return  "/config/index/"; 
	}

  });
  return configModel;
});