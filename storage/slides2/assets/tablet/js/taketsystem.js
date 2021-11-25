angular.module('starter.services', ['ionic.utils'])
.factory('Taket', function($http, $localstorage, $q) { 

	var config = 	{
						mac : "asdasdaasdasdasd445",
						secret : "FHTVXY",
						push_token : "SDWq!qsd241SAa",
						token : null
					}
	return {
		init: function() {
			options = $localstorage.getObject('options');
			if(options.secret == null)
				$localstorage.setObject('options',config);
		},
	    auth: function() {
	      var deferred = $q.defer();
	      options = $localstorage.getObject('options')
	      // si ya tenemos el token no hacemos peticion
	      if(options.token !== null) deferred.resolve(options.token);
	      else {
	      	  var url = "http://www.3fera.com/clients/taketsystem/api/auth"
		      var request = {'mac' : options.mac, 'secret': options.secret, 'push_token': options.push_token};
			  var promise = $http.post(url, request)
				  .success(function(response) {  
				   	console.dir(response);
			        if(response.result == 'ok') {
			        	options.token = response.token;
			        	console.dir("Token capturado: "+options.token)
			        	$localstorage.setObject('options',options);
			        	deferred.resolve(options.token);
			        }
				  });
	      }
	      
		  
		  return deferred.promise;

	    },
	    syncSquizz: function() {
	      options = $localstorage.getObject('options');
	      var request 	= {'token' : options.token};
	      var url 		= 'http://www.3fera.com/clients/taketsystem/api/quizzes';

		  $http.post(url, request).success(function(response) {
		        console.dir(response);
		   }); 
	    }
	};

});

angular.module('ionic.utils', [])

.factory('$localstorage', ['$window', function($window) {
  return {
    set: function(key, value) {
      $window.localStorage[key] = value;
    },
    get: function(key, defaultValue) {
      return $window.localStorage[key] || defaultValue;
    },
    setObject: function(key, value) {
      $window.localStorage[key] = JSON.stringify(value);
    },
    getObject: function(key) {
      return JSON.parse($window.localStorage[key] || '{}');
    }
  }
}]);