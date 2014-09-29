define([
  'jquery',
  'lodash',
  'backbone',
  'events',
  'text!templates/footer/footer.html',
  'text!templates/dashboard/tos.html'
], function($, _, Backbone, Events, footerTemplate, TOSTemplate	){
  var FooterView = Backbone.View.extend({
    el: '#footer',
    intialize: function () {

    },
    
    
    
    render: function () {
    	var compiledTemplate = _.template(footerTemplate, {tos: TOSTemplate});
      $(this.el).html(compiledTemplate);
      
     
    },
  
    clean: function () {
      
    }
    
  });

  return FooterView;
});
