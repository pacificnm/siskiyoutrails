define([
  'jquery',
  'lodash',
  'backbone',
  'events',
  'text!templates/help/page.html',
], function($, _, Backbone, Events, HelpTemplate	){
  var HelpView = Backbone.View.extend({
    el: '#main',
    intialize: function () {

    },
    render: function () {
      $(this.el).html(HelpTemplate);
    },
    
  });

  return HelpView;
});
