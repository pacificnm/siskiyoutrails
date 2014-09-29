define([
  'jquery',
  'underscore',
  'backbone',
  'vm',
], function ($, _, Backbone, Vm) {
  var AppRouter = Backbone.Router.extend({
    initialize: function(options) {
      this.appView = options.appView;
    },
 
    register: function (route, name, path) {
      var self = this;
 
      this.route(route, name, function () {
        var args = arguments;
 
        require([path], function (module) {
          var options = null;
          var parameters = route.match(/[:\*]\w+/g);
 
          // Map the route parameters to options for the View.
          if (parameters) {
            options = {};
            _.each(parameters, function(name, index) {
              options[name.substring(1)] = args[index];
            });
          }
 
          var page = Vm.create(self.appView, name, module, options);
          
          
          page.render();
        });
      });
    }
  });
 
  var initialize = function(options){
    var router = new AppRouter(options);
 
    // Default route goes first
    router.register('', 'defaultAction', 'views/dashboard/page');
    
 
    router.register('account', 'AccountPage', 'views/account/page');
    router.register('login', 'LoginPage', 'views/account/login');
    router.register('logout', 'LogoutPage', 'views/account/logout');
    router.register('help', 'HelpPage', 'views/help/page');
    router.register('trails', 'TrailPage', 'views/trails/page');
    router.register('trails/:trail_slug', 'ViewTrailPage', 'views/trails/view');
    router.register('forests', 'ForestPage', 'views/forests/page');
    router.register('forests/:forest_slug', 'ViewForestPage', 'views/forests/view');
    router.register('places', 'PlacePage', 'views/places/page');
    router.register('places/:id', 'ViewPlacePage', 'views/places/view');
    router.register('members', 'MembersPage', 'views/members/page');
    router.register('members/:id', 'ViewMembersPage', 'views/members/view');
    router.register('admin', 'AdminPage', 'views/admin/page');
    router.register('denied', 'DeniedPage', 'views/dashboard/denied');
    
    // Extend the View class to include a navigation method goTo
    Backbone.View.goTo = function (loc) {
    	router.navigate(loc, true);
    };
    
    Backbone.history.start();
  };
 
   
  return {
    initialize: initialize
  };
});