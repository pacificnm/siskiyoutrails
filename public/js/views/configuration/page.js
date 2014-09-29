define([
  'jquery',
  'lodash',
  'backbone',
  'models/config',
  'collections/account',
  'text!templates/configuration/page.html'
], function($, _, Backbone, Model, Account, configurationPageTemplate){
  var ConfigurationPage = Backbone.View.extend({
    el: '#main',
    initialize: function (options) {
        this.options = options || {};
        
        this.configuration = new Model();
        
        this.account = new Account({account_email:localStorage.getItem('accountEmail'),account_token:localStorage.getItem('accountToken') });
        
    },
    
    render: function () {
    	var that = this;
    	console.log(that.configuration);
    	$("#email").val(that.configuration.get('email'));
        $(this.el).html(configurationPageTemplate);
    },
    
    events: {
    	'click #saveConfigBtn': 'saveConfig'
    },
    
    saveConfig: function (event) {
    	 var that = this;
    	 event.preventDefault();
    	console.log('Save')
    }
  
  });
  return ConfigurationPage;
});
