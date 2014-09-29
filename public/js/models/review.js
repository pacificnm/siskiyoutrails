define([
  'lodash',
  'backbone',
], function(_, Backbone) {
  var ReviewModel = Backbone.Model.extend({
	idAttribute: "review_id",
	
	defaults: {
		collection_type: '',
		collection_id: '',
		account_id:'',
		account_name:'',
		account_image:'',
		review_text: '',
		review_date: '',
		review_rate:''
	},
    initialize: function(){
    	this.on("change", function (ReviewModel) {});		
		this.on("add", function(ReviewModel) {});		
		this.on("remove", function(ReviewModel) {});		
		this.on("reset", function(ReviewModel) {});
    },
    url : function() {
		return  "/review/index/"; 
	}
  });
  return ReviewModel;
});