define([
  'lodash',
  'backbone',
], function(_, Backbone) {
  var FileModel = Backbone.Model.extend({
	idAttribute: "file_id",
	
	defaults: {
		'file_id': 0,
		'collection_type': 'trail',
		'collection_id': 0,
		'file_type': 'kml',
		'file_name': '',
		'file_path': '',
		'file_create': 0,
		'file_create_by': 0,
	},
    initialize: function(){
    	this.on("change", function (TrailModel) {});		
		this.on("add", function(TrailModel) {});		
		this.on("remove", function(TrailModel) {});		
		this.on("reset", function(TrailModel) {});
    },
    url : function() {
		return  "/file/index/"; 
	}
  });
  return FileModel;
});