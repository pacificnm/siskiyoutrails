define([
  'jquery',
  'lodash',
  'backbone',
  'vm',
  'views/header/menu',
  'text!templates/account/login.html'
], function($, _, Backbone, Vm, MenuView, LoginTemplate){
  var LoginPage = Backbone.View.extend({
    el: '#main',
    render: function () {
    	localStorage.removeItem('accountId');
        localStorage.removeItem('accountName');
        localStorage.removeItem('accountEmail');
        localStorage.removeItem('accountToken');
        localStorage.removeItem('accountAdmin');
        Vm.create(this, 'MenuView', MenuView).render(); 
        window.location.replace('/');
    },
  });
  return LoginPage;
});