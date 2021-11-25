// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
// 'starter.services' is found in services.js
// 'starter.controllers' is found in controllers.js
var $stateProviderRef = null;
var $urlRouterProviderRef = null;

angular.module('starter', ['ionic',
                            'ionic.service.core',
                            'starter.controllers',
                            'starter.services'])

.run(function($ionicPlatform, Taket, $state, $rootScope) {
  $ionicPlatform.ready(function() {
    // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
    // for form inputs)
    if (window.cordova && window.cordova.plugins && window.cordova.plugins.Keyboard) {
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
    }
    if (window.StatusBar) {
      // org.apache.cordova.statusbar required
      StatusBar.styleLightContent();
    }
    console.log("Arrancamos...")
   
    //alert("asdasdasd");
    /*$ionicDeploy.watch().then(function() {}, function() {},
    function(hasUpdate) {
      alert(hasUpdate);
      if (hasUpdate) {
        $ionicDeploy.update().then(function(res) {
          alert('Ionic Deploy: Update Success! ', res);
        }, function(err) {
          alert('Ionic Deploy: Update error! ', err);
        }, function(prog) {
          console.log('Ionic Deploy: Progress... ', prog);
        });
     }
    });*/
 

    Taket.init();

    });
}).config(function($stateProvider, $urlRouterProvider, $ionicConfigProvider) {
    $urlRouterProviderRef = $urlRouterProvider;
    $stateProviderRef = $stateProvider;
    $ionicConfigProvider.views.transition('fade-in-out');
    $ionicConfigProvider.views.forwardCache(true);
  // Ionic uses AngularUI Router which uses the concept of states
  // Learn more here: https://github.com/angular-ui/ui-router
  // Set up the various states which the app can be in.
  // Each state's controller can be found in controllers.js
  /*$stateProvider

  // Each tab has its own nav history stack:

  .state('start', {
    url: '/start',
    templateUrl: 'templates/start.html'
  })

  .state('step1', {
    url: '/step1',
    controller: 'preguntas',
    templateUrl: 'templates/step1.html'
  })*/

  // if none of the above states are matched, use this as the fallback
 // $urlRouterProvider.otherwise('/start');

});
