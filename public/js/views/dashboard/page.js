define([
  'jquery',
  'lodash',
  'backbone',
  'vm',
  'text!templates/dashboard/page.html',  
], function($, _, Backbone, Vm, DashboardTemplate){
  var DashboardPage = Backbone.View.extend({
    el: '#main',
    
    evetns: {

    },
    render: function () { 
    	
    	var compiledTemplate = _.template(DashboardTemplate);
		$(this.el).html(compiledTemplate);
        
      return this;
    }
  });
  return DashboardPage;
});
