define([
  'jquery',
  'lodash',
  'backbone',
  'vm',
  'text!templates/dashboard/denied.html',  
], function($, _, Backbone, Vm, DeniedTpl){
  var DeniedPage = Backbone.View.extend({
    el: '#main',
    evetns: {

    },
    render: function () { 
    	var compiledTemplate = _.template(DeniedTpl);
		$(this.el).html(compiledTemplate);
        
      return this;
    }
  });
  return DeniedPage;
});
