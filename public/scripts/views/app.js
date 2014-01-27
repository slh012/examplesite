define(['backbone'], function(){
    var App = Backbone.View.extend({
        initialize: function(){
                console.log('success');
            }
    });
    
    return App;
});

// define(function(require){
// 	var alerter = require("alerter");
// 	alerter("Hello from the app");
// })