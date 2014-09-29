define([
  'jquery',
  'lodash',
  'backbone',
  'collections/files',
  'text!templates/admin/upload.html',
  'fileupload'
], function($, _, Backbone, FileCollection, UploadTpl, FileUpload){
  var AdminView = Backbone.View.extend({
    el: '#adminSection',
    
    intialize: function () {
    	_.bindAll(this, 'render');
    },
    
    
    events: {
    	
    },

    render: function () {
    	
    	var compiledTemplate = _.template(UploadTpl);
		$(this.el).html(compiledTemplate);
		
		that = this; 	  
	  	var method = ['PUT'];
	  	var accountId = localStorage.getItem('accountId');
		
		$("#fileupload").fileupload({
	          dataType: 'json',
	          // type: method,
	          url: "/file/index",
	          
	          formData: {"_method": method, account_id: accountId, collection_type: $("#collection_type").val()  },
	          
	          done: function(e, data) {
	          	console.log('Done');
	          },
	          progressall: function (e, data) {
	              var progress = parseInt(data.loaded / data.total * 100, 10);
	              $('#progress .progress-bar').css( 'width', progress + '%');
	          },
	          error: function(response) {
	          	$("#flashMessenger").html('<div class="alert alert-danger" role="alert">'+response.responseText+'</div>'); 	
	          },
	          success: function (response) {
	          	$("#flashMessenger").html('<div class="alert alert-success" role="alert">File was uploaded</div>'); 	
	          }
	          
	        });
		
		return this;
    },
    
  });

  return AdminView;
});