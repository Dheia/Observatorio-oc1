angular.module('starter.services', ['ionic.utils'])
.factory('Taket', function($http, $localstorage, $q, $state, $rootScope, $location) {

	var slides = [];
	var steps = [];
	var numSubsteps = 1;
	var options = {
					"mac"			: 'APPWEB',
					"secret"		: 'secret',
					"token"			: 'hd79S1PFMISQAiSV6bAQmbgBCwwA8Oy1',
					"push_token"	: 'hd79S1PFMISQAiSV6bAQmbgBCwwA8Oy1'
					};
	var activeStep 		= null;
	var answers 		= [];
	var numSlides 		= [];
	var quizzNum 		= 0;
	var quizzNumId 		= null;
	var originalSteps 	= [];
	var originalSlides 	= [];
	var isOffline 		= false;
	var lang 			= 'ES';
	var urlBase			= '//talentapp360.taket.es';
	var urlParams;
	var evaluacion_id = 0;

	return {
		//Inicializa variables
		init: function() {
			
        //capturamos las variables de la url
        var match,
            pl     = /\+/g,  // Regex for replacing addition symbol with a space
            search = /([^&=]+)=?([^&]*)/g,
            decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); },
            query  = window.location.search.substring(1);

        urlParams = {};
        while (match = search.exec(query))
           urlParams[decode(match[1])] = decode(match[2]);

				if(this.getParameterByName('lang'))
					this.lang = this.getParameterByName('lang');
				else
					this.lang = 'ES'
			  console.log("Inicializamos...")

		    name = "nonQuizz";
		    data = {
		                templateUrl: 'templates/nonQuizz.html',
		                controller: "nonQuizzController",
		                url: '/nonQuizz'
		            }

		    $stateProviderRef.state(name, data);

			answers = $localstorage.getObject('answers');
			quizzNumId = this.newGuid();
			//quizzNum = $localstorage.get('quizzNum');
			quizzNum = this.getParameterByName("ev");
			if(answers[0] != undefined) {
				answers[quizzNum] = answers[0];
				//console.dir(answers);
				delete answers[0];
				$localstorage.setObject('answers', answers);
				
			}

			console.log("quizzNum: " + quizzNum)
			console.dir(options);
			if(options.mac == null || options.secret == null) {
				options.push_token = this.newGuid();
    			$state.go("setup");
    			console.log("No tenemos settings... configuramos")
    			return;
			}
			//Si tenemos la configuración básica procedemos al registro de la tablet en el sistema
			taket = this;
			if(options.token == null) {
				this.auth();
			}

		    taket.render();

		},
		getNumQuiz: function() {
			if(this.getParameterByName("ev") != undefined)
				return this.getParameterByName("ev");
			else
				return 0;
		},
		checkOnline: function() {
			isOffline = 'onLine' in navigator && !navigator.onLine;
		},
		getUrlQuizz: function() {
			return this.getParameterByName('id');
		},
		getParameterByName: function (name) {
		    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
		    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		        results = regex.exec(location.search);
		    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
		},
		saveAnswers: function(){
			console.log("Enviamos respuestas...")
			var url = urlBase + '/api/quizzes/save';
			var request = {'token' : options.token, 'results' : answers};
			angular.forEach(urlParams, function (val, param) {
				request[param] = val;
			})
			console.dir(request);
			//console.log(JSON.stringify(answers));
			taket = this;
			if(request.demo == 1) {

				return;
			}
			$http.post(url, request)
			  .success(function(response) {
			     if(response.result == 'ok') {
						  delete answers[quizzNum];
			       	$localstorage.setObject('answers', answers);
			       	console.log("Hemos enviado bien las respuestas... Procedemos a recargar la pag")
			       	$localstorage.setObject('quizzNum', 0)
			      } else {
			      	$localstorage.setObject('quizzNum', quizzNum)
			      } 
			      //if(response.reload == '1')
			      	//location.reload();
			  })
			  .error(function(data, status, headers, config) {
			    // called asynchronously if an error occurs
			    // or server returns response with an error status.
			    console.dir("SAVE: Sin conexión con el servidor Taket");
			    isOffline = true;
			    $localstorage.setObject('quizzNum', quizzNum)
			    //location.reload();

			  });
		},
		goTo: function(id) {
			activeStep = id;
			$state.go(slides[activeStep].name+ "_"+taket.lang);
		},
		setAnswer: function(data) {
			slide_id = slides[activeStep].slide_id
			quizz_id = slides[activeStep].quizz_id

			data.slide_id = slide_id;
			data.create_at = new Date();
			data.quizzNum = quizzNumId;
			data.activeStep = activeStep;

			if(answers[quizzNum] == undefined) {
				answers[quizzNum] = {}
				answers[quizzNum].answers = []
			}

			answers[quizzNum].quizz_id = quizz_id;
			answers[quizzNum].answers.push(data);

			console.log("Guardamos respuestas...")
			console.dir(answers)
			console.log("Fin Guardamos respuestas...")

			$localstorage.setObject('answers', answers);

		},
		getAnswersActive: function() {
			answers = $localstorage.getObject('answers');
			if(answers[quizzNum])
			if(answers[quizzNum].answers != undefined) {
				answers_all = answers[quizzNum].answers;
				answers_good = [];
				angular.forEach(answers_all, function (answer, index) {
					if(answer.slide_id == slides[activeStep].slide_id)
						answers_good.push(answer);
				})
				return answers_good;
			}
		},
		setSecret: function(secret){
			options.secret = secret;
			this.saveOptions();
		},
		setMac: function(mac){
			options.mac = mac;
			this.saveOptions();
		},
		getMac: function(mac){
			return cordovaDeviceService.uuid();
		},
		saveOptions: function() {
			console.log("Guardamos options");
			$localstorage.setObject('options',options);
		},
		loadOptions: function() {
			console.log("Cargamos options");
			options = $localstorage.getObject('options');
		},
		// get token
	    auth: function() {
	      var deferred = $q.defer();
	      // si ya tenemos el token no hacemos peticion
	      console.log("Empezamos auth...")
	      if(options.token != null) deferred.resolve(options.token);
	      else {
	      	  var url = urlBase + "/api/auth"
		      var request = {'mac' : options.mac, 'secret': options.secret, 'push_token': options.push_token};

		      console.log("Solicitamos token...")

		      taket = this;
			  var promise = $http.post(url, request)
				  .success(function(response) {
			        if(response.result == 'ok') {
			        	options.token = response.token;
			        	console.log("Token capturado: " + options.token)
			        	taket.saveOptions();

			        	deferred.resolve(options.token);
			        }
				  })
				  .error(function(data, status, headers, config) {
				    // called asynchronously if an error occurs
				    // or server returns response with an error status.
				    console.dir("AUTH: Sin conexión con el servidor Taket");
				    isOffline = true;
				  });
	      }


		  return deferred.promise; },
	    // getSquizz
	    syncSquizz: function() {
	      var deferred = $q.defer();
	      var url = urlBase + "/api/quizzes/get/"
        var request 	= {'token' : options.token, 'quiz_md5' : this.getUrlQuizz()};
        /*if(this.getParameterByName('lang'))
		      var request 	= {'token' : options.token, 'quiz_md5' : this.getUrlQuizz(), 'lang': this.getParameterByName('lang')};*/
			 
				angular.forEach(urlParams, function (val, param) {
					request[param] = val;
				})
				console.log("Empezamos actualización slides...");

	      taket = this;

	      $.ajax({
			  method: "POST",
			  url: url,
			  data: request,
			  async: false
			})
			  .done(function( response ) {
			   slides = [];
		  		console.log("Slides recibidos...");
				//comprobamos que hayan Quizzes
				if(response.quizzes.length == 0) {
					location.reload();
					console.log("No hay encuestas");
					return;
				}

				if(response.quizzes[0].slides_mobile != undefined)
			        var slidesObj = response.quizzes[0].slides_mobile;

			    if(response.quizzes[0].slides_multi != undefined)
			        var slidesObj = response.quizzes[0].slides_multi;

				if(response.quizzes[0].slides != undefined)
					var slidesObj = response.quizzes[0].slides;

				if(response.quizzes[0].slides_quiz != undefined)
			        var slidesObj = response.quizzes[0].slides_quiz;
					
		        var quizz_id = response.quizzes[0].id;
		        var index = 0;
		       	var indexFix = 0;

		       	console.dir(response);

		        angular.forEach(slidesObj, function (slide, index1) {
							console.dir(slide.view)
							if(angular.isObject(slide.view)) {
								var viewLangs = slide.view;
								var views = slide.view;

							} else {
								var viewLangs = jQuery.parseJSON(slide.view);
								var views = jQuery.parseJSON(slide.view)
								
							}

		        	//comprobamos si es un slide multivista
		        	if(angular.isObject(viewLangs.views)) {
		        		views = viewLangs.views;
		        		angular.forEach(views, function(slide2, index2) {
				        	var nextStep = "step"+(index+1);
				        	var indexNextStep = index+1;

				        	if(index == 0)
				        		var name = "start";
				        	else
				        		var name = "step"+(index);

				        	var slide_id = index;
				        	steps[index] = indexNextStep;
				        	originalSteps[index] = indexNextStep;
				        	slide2 = {
				    					view: slide2,
				    					index: index,
				    					nextStep: nextStep,
				    					quizz_id: quizz_id,
				    					slide_id: slide_id,
				    					indexNextStep: indexNextStep,
				    					name: name
			    					};

						    slides[index] = slide2

						    console.dir(slide2);
				        	originalSlides[index] = slide2;
				        	taket.isOffline = false;
				        	index++;
				        	indexFix++;
			        	});
		        	} else {
			        	if(index1 == (slidesObj.length-1)) {
			        		var nextStep = "start_"+taket.lang;
			        		var indexNextStep = 0;
			        	}
			        	else {
			        		var nextStep = "step"+(index+1);
			        		var indexNextStep = index+1;
			        	}

			        	if(index == 0)
			        		var name = "start";
			        	else
			        		var name = "step"+(index);



			        	var slide_id = index;
			        	steps[index] = indexNextStep;
			        	originalSteps[index] = indexNextStep;

								if(angular.isObject(slide.view)) {
									viewObj = slide.view;
								} else {
									viewObj = jQuery.parseJSON(slide.view);
								}

			        	slide = {
		    					view: viewObj,
		    					index: index,
		    					nextStep: nextStep,
		    					quizz_id: quizz_id,
		    					slide_id: slide_id,
		    					indexNextStep: indexNextStep,
		    					name: name
		    					};

					    	slides[index] = slide
			        	originalSlides[index] = slide;
			        	taket.isOffline = false;
			        	index++;
			        }
				});
				console.log("Slides actualizados...");
				$localstorage.setObject('slides',slides);

			  });


		  /*$http.post(url, request)
		  	.success(function(response) {

				deferred.resolve(options.token);
		   	})
			.error(function(data, status, headers, config) {
			    // called asynchronously if an error occurs
			    // or server returns response with an error status.
			    console.dir("SYNC: Sin conexión con el servidor Taket");
			    isOffline = true;
			    deferred.reject(status);
			}); */

		  return deferred.promise;
		 },
		//getSlides
		getSlides: function() {
			return $localstorage.getObject('slides');
		},
		getLang: function() {
			return this.lang;
		},
		setLang: function(l) {
	    	lang = l;
		},
		prevStep: function() {
	    	if(slides[steps[activeStep]] == undefined)  steps[activeStep]=0;
	    	console.log("Prev slide: "+slides[activeStep - 1].name + "_" + this.getLang())
	    	console.dir(slides)
	    	/*if(steps[steps[activeStep]] == 0) {
	    		location.reload();
	    	}*/
	    	if(slides[activeStep - 1].name == "start") {
	    		return;
	    	}  else {
	    		$state.go(slides[activeStep - 1].name + "_" + this.getLang());
	    	}
	    	activeStep = activeStep - 1;
	    },
	    nextStep: function() {
	    	if(slides[steps[activeStep]] == undefined)  steps[activeStep]=0;
	    	console.log("Siguiente slide: " + slides[steps[activeStep]].name + "_" + this.getLang())
			console.dir(slides)
			
	    	/*if(steps[steps[activeStep]] == 0) {
	    		location.reload();
	    	}*/
	    	if(slides[steps[activeStep]].name == "start" || slides[steps[activeStep]].name == "start_"+taket.lang) {

	    		this.saveAnswers();

	    		return;
	    	}  else {
					if(slides[steps[activeStep+1]].name == "start" || slides[steps[activeStep+1]].name == "start_"+taket.lang) {

						this.saveAnswers();
					}
					console.log("Go to: "+slides[steps[activeStep]].name + "_" + this.getLang())
	    		$state.go(slides[steps[activeStep]].name + "_" + this.getLang());
	    	}
	    	activeStep = steps[activeStep];
	    },
	    newGuid: function() {
		  return Math.floor((Math.random() * 100) + 1);
		},
		addSlide: function(slide) {
			slide['quizz_id'] = slides[0].quizz_id;
			slide['name'] = "subquestion_" + numSubsteps;
			slide['slide_id'] = slides.length;
			//slide['slide_id_s'] =



			steps.push(slide['slide_id']);

			if(numSubsteps==1) {
				//intercambio nuevo por activo
				steps[steps.length-1] = steps[activeStep];
				//activo por el nuevo
				steps[activeStep] = slide['slide_id'];
			} else {
				steps[steps.length-1] = steps[steps.length-2];
				steps[steps.length-2] = slide['slide_id'];
			}
			//nextStepTmp = slide['slide_id']+1;

			//steps.splice(steps[activeStep]+numSubsteps, 0, nextStepTmp);
		    slides[slide['slide_id']] = slide

		    numSubsteps++;
		    data = {
	                    template: slide.view,
	                    controller: "preguntas"
	                 }
	        try {
		         $stateProviderRef.state(slide.name + "_" + this.getLang(), data);
		        } catch (e) {
		          console.log("No ha podido cargar el subslide." + slide.name + "_" + this.getLang())
			          var st = $state.get(slide.name + "_" + this.getLang());
			          st.template = slide.view[this.getLang()];
			          console.log("Recargamos template: " + slide.view[this.getLang()])
		        }
		},
	    render: function() {
    		// Get slides
    		console.log("cargamos encuestas...");

    		var slides = taket.syncSquizz()

	    	var slides = this.getSlides();

	    	//Reseteamos

    		quizzNumId = this.newGuid();
    		numSubsteps = 1;
    		steps = originalSteps.slice(0);
    		//slides = originalSlides.slice(0);
    		activeStep = 0;
    		console.log("reseteamos pasos para la siguiente encuesta...");



	    	if(slides.length == 0 || slides.length == undefined) {
				//location.reload();
				return;
			}

	    	console.log("Empezamos renderizacion...")
	    	console.log("num slides: " + slides.length)
	    	angular.forEach(slides, function (slide, index) {
		        // first
				angular.forEach(slide.view, function (view, lang) {
			        data = {
			                    template: view.replace(/&#8216;/g,"'"),
			                    controller: "preguntas"
			               }
			        try {
			        	console.log("Cargamos: " + slide.name + "_" + lang)
			        	console.dir(slide);
				           $stateProviderRef.state(slide.name + "_" + lang, data);

				      } catch (e) {
				          console.log("No ha podido cargar el slide." + slide.name + "_" + this.taket.getLang())
				          var st = $state.get(slide.name + "_" + this.taket.getLang());
				          st.template = slide.view[this.taket.getLang()];
				          console.log("Recargamos template: " + slide.view[this.taket.getLang()])
				      }

				});

			});
			  
			//buscamos en que pantalla se quedo
			
			//slides[activeStep - 1].name
			var request = {'token' : options.token, 'results' : answers};
			angular.forEach(urlParams, function (val, param) {
				request[param] = val;
			})
			console.log(JSON.stringify(answers));
			taket = this;
			if(request.demo == 1) {
				if(urlParams['step']>0) {
					activeStep = urlParams['step'];
					$state.go(slides[activeStep].name+ "_"+taket.lang);
					return;
				} 
				else {
					$state.go("start_"+taket.lang);
					activeStep = 0;
					return;
				}
			}
			var answersAll = $localstorage.getObject('answers');
			console.log("Miramos si hay respuestas previas")
			console.dir(answersAll);
			
			 if(answersAll[quizzNum] != undefined) {
				console.log("Hay respuestas previas")
				var answers = answersAll[quizzNum].answers;
				console.dir(answers);
				if(answers.length) {
					var answer = answers[answers.length - 1];
					console.dir(answers);
					console.dir(answer.slide_id);
					console.dir(slides)
					activeStep = answer.activeStep + 1;
					console.log("Step activo: "+activeStep)
					if(slides[activeStep]  != undefined) {
						var slideName = slides[activeStep].name;
						$state.go(slideName + "_" + this.getLang());
						if(slides[steps[activeStep]].name == "start" || slides[steps[activeStep]].name == "start_"+taket.lang) {
							this.saveAnswers();
						}
					} else {
						$state.go("start_"+taket.lang);
						activeStep = 0;
					}
				} 
				}  else {
					$state.go("start_"+taket.lang);
					activeStep = 0;
				}
			
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
