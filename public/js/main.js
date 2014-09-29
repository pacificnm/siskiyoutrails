// Require.js allows us to configure shortcut alias
// Their usage will become more apparent futher along in the tutorial.
require.config({
  paths: {
    // Major libraries
    jquery: 'libs/jquery/jquery-min','jquery.ui.widget':'libs/jquery.ui.widget',
    //underscore: 'libs/underscore/underscore-min', // https://github.com/amdjs
    underscore: "libs/underscore/1.6.0/underscore-min",
    lodash: 'libs/lodash/lodash', // alternative to underscore
    //backbone: 'libs/backbone/backbone-min', // https://github.com/amdjs
    backbone: "libs/backbone/1.1.2/backbone-min",
    sinon: 'libs/sinon/sinon.js',
    bootstrap: 'libs/bootstrap/bootstrap',
    datepicker: 'libs/bootstrap/bootstrap-datepicker',
    bootstrapvalidator: 'libs/bootstrap/bootstrapValidator.min',
    fileupload: 'libs/jquery.fileupload',
    // Require.js plugins
    text: 'libs/require/text',

    // Just a short cut so we can put our html outside the js dir
    // When you have HTML/CSS designers this aids in keeping them out of the js directory
    templates: '../templates'
  },
  shim: {
	  'backbone' : {
			deps : [ 'underscore', 'jquery', ],
			exports : 'Backbone'
		},
		'bootstrap':{
			deps: ['jquery'],
			exports : 'Bootstrap',
			enforceDefine: true,
			exports: "$.fn.tooltip",
		},
		'datepicker': {
			deps: ['jquery'],
		},
		'bootstrapvalidator' : {
			deps: ['jquery'],
			exports : 'BsValidator'
		},
		'fileupload': {
			deps: ["jquery"],
			exports: "FileUpload"
		}
}

});

// Let's kick off the application

require([
  'views/app',
  'router',
  'vm',
  'bootstrap',
  'bootstrapvalidator',
  'datepicker',
], function(AppView, Router, Vm, Bootstrap,BsValidator, DatePicker){
  var appView = Vm.create({}, 'AppView', AppView);
  appView.render();
  Router.initialize({appView: appView});  // The router now has a copy of all main appview
  
  $.ajaxSetup({
	    statusCode: {
	        401: function(){
	            // Redirec the to the login page.
	            window.location.replace('/#login');
	         
	        },
	        403: function() {
	            // 403 -- Access denied
	            window.location.replace('/#denied');
	        }
	    }
	});
});
