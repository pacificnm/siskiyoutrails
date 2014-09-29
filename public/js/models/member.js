define([
  'lodash',
  'backbone',
], function(_, Backbone) {
  var MemberModel = Backbone.Model.extend({
	idAttribute: "account_id",
	
	defaults: {
	},
    initialize: function(){
    	this.on("change", function (MemberModel) {});		
		this.on("add", function(MemberModel) {});		
		this.on("remove", function(MemberModel) {});		
		this.on("reset", function(MemberModel) {});
    },
    url : function() {
		return  "/account/index/"; 
	}
  });
  return MemberModel;
});