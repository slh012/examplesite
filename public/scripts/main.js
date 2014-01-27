require.config({
    paths:{
        "jquery":"vendor/jquery/jquery",
        "underscore":"vendor/underscore-amd/underscore",
        "backbone":"vendor/backbone-amd/backbone",
        "bootstrap":"vendor/bootstrap/dist/bootstrap.min",
         "jquery": "require-jquery"
        
    },

	shim:{
		'bootstrap':['jquery']
	}
});

require(['views/app'], function(AppView){
    new AppView;
});

require(["jquery"], function($) {
    
    $(document).ready( function() { 
	   $('body').append('sean');
	});
});
