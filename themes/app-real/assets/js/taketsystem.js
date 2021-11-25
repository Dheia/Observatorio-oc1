var MD5 = function(d){result = M(V(Y(X(d),8*d.length)));return result.toLowerCase()};function M(d){for(var _,m="0123456789ABCDEF",f="",r=0;r<d.length;r++)_=d.charCodeAt(r),f+=m.charAt(_>>>4&15)+m.charAt(15&_);return f}function X(d){for(var _=Array(d.length>>2),m=0;m<_.length;m++)_[m]=0;for(m=0;m<8*d.length;m+=8)_[m>>5]|=(255&d.charCodeAt(m/8))<<m%32;return _}function V(d){for(var _="",m=0;m<32*d.length;m+=8)_+=String.fromCharCode(d[m>>5]>>>m%32&255);return _}function Y(d,_){d[_>>5]|=128<<_%32,d[14+(_+64>>>9<<4)]=_;for(var m=1732584193,f=-271733879,r=-1732584194,i=271733878,n=0;n<d.length;n+=16){var h=m,t=f,g=r,e=i;f=md5_ii(f=md5_ii(f=md5_ii(f=md5_ii(f=md5_hh(f=md5_hh(f=md5_hh(f=md5_hh(f=md5_gg(f=md5_gg(f=md5_gg(f=md5_gg(f=md5_ff(f=md5_ff(f=md5_ff(f=md5_ff(f,r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+0],7,-680876936),f,r,d[n+1],12,-389564586),m,f,d[n+2],17,606105819),i,m,d[n+3],22,-1044525330),r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+4],7,-176418897),f,r,d[n+5],12,1200080426),m,f,d[n+6],17,-1473231341),i,m,d[n+7],22,-45705983),r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+8],7,1770035416),f,r,d[n+9],12,-1958414417),m,f,d[n+10],17,-42063),i,m,d[n+11],22,-1990404162),r=md5_ff(r,i=md5_ff(i,m=md5_ff(m,f,r,i,d[n+12],7,1804603682),f,r,d[n+13],12,-40341101),m,f,d[n+14],17,-1502002290),i,m,d[n+15],22,1236535329),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+1],5,-165796510),f,r,d[n+6],9,-1069501632),m,f,d[n+11],14,643717713),i,m,d[n+0],20,-373897302),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+5],5,-701558691),f,r,d[n+10],9,38016083),m,f,d[n+15],14,-660478335),i,m,d[n+4],20,-405537848),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+9],5,568446438),f,r,d[n+14],9,-1019803690),m,f,d[n+3],14,-187363961),i,m,d[n+8],20,1163531501),r=md5_gg(r,i=md5_gg(i,m=md5_gg(m,f,r,i,d[n+13],5,-1444681467),f,r,d[n+2],9,-51403784),m,f,d[n+7],14,1735328473),i,m,d[n+12],20,-1926607734),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+5],4,-378558),f,r,d[n+8],11,-2022574463),m,f,d[n+11],16,1839030562),i,m,d[n+14],23,-35309556),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+1],4,-1530992060),f,r,d[n+4],11,1272893353),m,f,d[n+7],16,-155497632),i,m,d[n+10],23,-1094730640),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+13],4,681279174),f,r,d[n+0],11,-358537222),m,f,d[n+3],16,-722521979),i,m,d[n+6],23,76029189),r=md5_hh(r,i=md5_hh(i,m=md5_hh(m,f,r,i,d[n+9],4,-640364487),f,r,d[n+12],11,-421815835),m,f,d[n+15],16,530742520),i,m,d[n+2],23,-995338651),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+0],6,-198630844),f,r,d[n+7],10,1126891415),m,f,d[n+14],15,-1416354905),i,m,d[n+5],21,-57434055),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+12],6,1700485571),f,r,d[n+3],10,-1894986606),m,f,d[n+10],15,-1051523),i,m,d[n+1],21,-2054922799),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+8],6,1873313359),f,r,d[n+15],10,-30611744),m,f,d[n+6],15,-1560198380),i,m,d[n+13],21,1309151649),r=md5_ii(r,i=md5_ii(i,m=md5_ii(m,f,r,i,d[n+4],6,-145523070),f,r,d[n+11],10,-1120210379),m,f,d[n+2],15,718787259),i,m,d[n+9],21,-343485551),m=safe_add(m,h),f=safe_add(f,t),r=safe_add(r,g),i=safe_add(i,e)}return Array(m,f,r,i)}function md5_cmn(d,_,m,f,r,i){return safe_add(bit_rol(safe_add(safe_add(_,d),safe_add(f,i)),r),m)}function md5_ff(d,_,m,f,r,i,n){return md5_cmn(_&m|~_&f,d,_,r,i,n)}function md5_gg(d,_,m,f,r,i,n){return md5_cmn(_&f|m&~f,d,_,r,i,n)}function md5_hh(d,_,m,f,r,i,n){return md5_cmn(_^m^f,d,_,r,i,n)}function md5_ii(d,_,m,f,r,i,n){return md5_cmn(m^(_|~f),d,_,r,i,n)}function safe_add(d,_){var m=(65535&d)+(65535&_);return(d>>16)+(_>>16)+(m>>16)<<16|65535&m}function bit_rol(d,_){return d<<_|d>>>32-_}
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
	var urlBase			= '//buildyouup.taket.es';
	var urlParams;
	var evaluacion_id 	= 0;
	var result_id 		= 0;
    var bag_data = [];

	return {
		//Inicializa variables
		getAllData: function() {
			return bag_data;
		},
		setData: function(data) {
			bag_data[bag_data.length] = data;
			console.dir(bag_data);
		},
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
			var url = urlBase + '/apiv2/quizzes/save';
			var request = {'token' : options.token, 'results' : answers};
			angular.forEach(urlParams, function (val, param) {
				request[param] = val;
			})
			console.log(JSON.stringify(answers));
			taket = this;
			if(request.demo == 1) {

				return;
			}
			$http.post(url, request)
			  .success(function(response) {
				if(response.result == 'ok') {
						$localstorage.setObject('answers', answers);
						result_id = 0;
						console.log("Hemos enviado bien las respuestas... Procedemos a recargar la pag")
						$localstorage.setObject('quizzNum', 0)
				} else {
					$localstorage.setObject('quizzNum', quizzNum)
				}
				if(response.reload == '1')
					location.reload();
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
		runAction: function(element,question) {
			taket = this;

			if($(question).data("action")) {
					switch($(question).data("action")) {
							case 'clone':
							/*		data.source   = $(question).data("action-source");
									data.question = question;
									if(data.source == $(question).attr("id")) {
											data.action = 'clone';
											data.dest   = $(question).data("action-dest");
											Taket.setData(data);
									}*/
									var data = {};
									//cogemos cada uno de los sources
									var sources = $(question).data("action-source").split(",");
									var dest = $(question).data("action-dest").split(",");
									var indexOk = -1;
									sources.forEach(function(el,index){
											if($("#"+el).attr("id") == $(element).attr("id")) {
													indexOk = index;
											}
									})
									if(indexOk != -1) {
											data.source   = sources[indexOk];
											data.question = question;
											data.action = 'clone';
											data.dest   = dest[indexOk];
											taket.setData(data);
									}
							break;
				} 
			}
		},
		syncAnswer: function(answer) {
			var question_type = answer.question_type;
			var answer_type = answer.answer_type;
			taket = this;
			if(answer.id>0)
				$("[data-question-id='"+answer.question_id+"']").data("id-db", answer.id.toString())

			switch(answer_type) {
				case 'sortable':
					var order = JSON.parse(JSON.parse(answer.value));
					order.forEach(function(item,index){
						it = $("[data-question-id='"+answer.question_id+"']").find("#"+item.id).clone();
						$("[data-question-id='"+answer.question_id+"']").append(it);
						$("[data-question-id='"+answer.question_id+"']").find("#"+item.id).remove();
					})
				break;
				case 'resizabletable':
					var order = JSON.parse(answer.value);
					jQuery.each(order,function(index,item){
						$("[data-question-id='"+answer.question_id+"']").find("#"+index).css("width",item.percent + '%');
						$("[data-question-id='"+answer.question_id+"']").find("#"+index).find("input").val(item.percent);
					})
				break;
				case "draggable": 
					var order = JSON.parse(answer.value);
					jQuery.each(order,function(index,item){
						var dest = $("[data-question-id='"+answer.question_id+"']").find("#"+index);
						var srce = $("[data-question-id='"+answer.question_id+"']").find("#"+item.name);
						dest.attr("name",item.name);

						srce.attr("data-id",index.replace("drop", ""));
						srce.css("top",dest.css("top"));
						srce.css("left",dest.css("left"));
						srce.css("width",dest.css("width"));
						srce.css("height",dest.css("height"));

						taket.runAction(dest,srce.closest("[data-question-type=draggable]"));
					})
        break;
				case "drawable":
					$(".drawable > canvas").jqScribble.update({backgroundImage: answer.value});
				break;
				case 'select':
						$("[data-question-id='"+answer.question_id+"']")
						.find("[value='"+answer.value+"']")
						.prop('selected', true);
				break;
				case 'range':
						$("[data-question-id='"+answer.question_id+"']").find("input")
						.val(answer.value);
						var selected = answer.value;
						var values = $("[data-question-id='"+answer.question_id+"']").find("input").data("options");
						var _pregunta = $("[data-question-id='"+answer.question_id+"']").find("input").parent().parent();
						var span = _pregunta.find("h4").find("span")
						$(span).html(values[selected-1].title)
				break;
				case 'stars':
						$("[data-question-id='"+answer.question_id+"']")
						.find("[value='"+answer.value+"']")
						.prop('selected', true);
				break;
				case 'stars':
						$("[data-question-id='"+answer.question_id+"']")
						.find("[value='"+answer.value+"']")
						.prop('selected', true);
				break;
				case 'textarea':
						$("[data-question-id='"+answer.question_id+"']").val(answer.value)
				break;
				case 'text':
						$("[data-question-id='"+answer.question_id+"']").find("input").val(answer.value)
				break;
				default:
						 $("[data-question-id='"+answer.question_id+"']")
							.find("[data-value='"+answer.value+"']")
							.addClass("noselect");
						if(answer.id>0)
							$("[data-question-id='"+answer.question_id+"']")
								.find("[data-value='"+answer.value+"']").data("id-db", answer.id.toString())
				break;
			}
 
			
		},
		saveAnswer: function(data){
			if(!result_id) return;
			console.log("Enviamos respuestas...")
			var url = urlBase + '/apiv2/quizzes/saveAnswer';
			var request = {'token' : options.token, 'answer' : data, 'result_id': result_id};
			
			angular.forEach(urlParams, function (val, param) {
				request[param] = val;
			})
			console.log(JSON.stringify(answers));
		    taket = this;
			if(request.demo == 1) {
				return;
			}
			$.ajax({
			  method: "POST",
			  url: url,
			  data: request,
			  async: true
			})
			  .done(function(response) {  
			     if(response.result == 'ok') {
					answers[result_id].answers[response.answer_id] = data;
					answers[result_id].answers[response.answer_id].id = response.answer_id;
					$localstorage.setObject('answers', answers);
			       	console.log("Hemos enviado bien la respuesta... Procedemos a recargar la pag")
						 $localstorage.setObject('quizzNum', result_id)
						 taket.syncAnswer(answers[result_id].answers[response.answer_id]);
			      } else {
			      	$localstorage.setObject('quizzNum', result_id)
			      }
			  })
			  .error(function(data, status, headers, config) {
			    // called asynchronously if an error occurs
			    // or server returns response with an error status.
			    console.dir("SAVE: Sin conexión con el servidor Taket");
			    isOffline = true;

			  });
		},
		delAnswer: function(id) {
			if(!result_id) return;
			console.log("Enviamos respuestas...")
			var url = urlBase + '/apiv2/quizzes/delAnswer';
			var request = {
					'token' : options.token, 
					'id' : id, 
					'result_id': result_id
				};
		  taket = this;
      if(request.demo == 1) {
        return;
      }
			$http.post(url, request)
			  .success(function(response) {  
			     if(response.result == 'ok') {
							 console.log("Borrado ok")
							 taket.removeAnswerLocal(id);
							 //buscamos el id en los answers locales para eliminarlo
			      } else {
			      }
			  })
			  .error(function(data, status, headers, config) {
			    // called asynchronously if an error occurs
			    // or server returns response with an error status.
			    console.dir("SAVE: Sin conexión con el servidor Taket");
			    isOffline = true;

			  });
		},
		getSlideId: function() {
			return slides[activeStep].slide_id;
		},
		removeAnswerLocal: function(id) {
			slide_id = slides[activeStep].slide_id
			quizz_id = slides[activeStep].quizz_id
			quizzNum = 0;
			if(result_id != 0) {
				quizzNum = result_id;
			}
			if(data.num == undefined) data.num = '';
			if(answers[quizzNum] != undefined) 
			answers[quizzNum].answers.forEach(function(answer1, index){
				if(answer1.id_db == id) {
						answers[quizzNum].answers.splice(index, 1);
				}
			})
			
		},
		removeAnswer: function(data) {
			slide_id = slides[activeStep].slide_id
			quizz_id = slides[activeStep].quizz_id
			quizzNum = 0;
			if(result_id != 0) {
				quizzNum = result_id;
			}
			if(data.num == undefined) data.num = '';
			if(answers[quizzNum] != undefined) 
			answers[quizzNum].answers.forEach(function(answer1, index){
				if(answer1.question_id == data.question_id) {
					if(answer1.value == data.value) {
						this.delAnswer(answer1.id);
						answers[quizzNum].answers.splice(index, 1);
					}
				}
			})
			
		},
		setAnswer: function(data) {
			slide_id = slides[activeStep].slide_id
			slide_id2 = slides[activeStep].id
			quizz_id = slides[activeStep].quizz_id
			quizzNum = 0;
			
			if(data.num == undefined) data.num = '';
			//data.md5 = MD5(slide_id.toString()+data.question_id.toString()+data.num.toString())
			
			data.slide_id = slide_id2;

			if(result_id != 0) {
				quizzNum = result_id;
			}

			if(answers[quizzNum] == undefined) {
				answers[quizzNum] = {}
				answers[quizzNum].answers = []
			}

			if(answers[quizzNum].answers[data.md5] != undefined) {
				data.id = answers[quizzNum].answers[data.md5].id;
				data.slide_id = slide_id2;
				data.create_at = new Date()
				data.quizzNum = quizzNumId;
			} else {
				data.slide_id = slide_id2;
				data.create_at = new Date()
				data.quizzNum = quizzNumId;
			}

			
			answers[quizzNum].quizz_id = quizz_id;
			if(result_id != 0) {
				return this.saveAnswer(data);
			} else {
				answers[quizzNum].answers.push(data);
			}
			console.log("Guardamos respuestas...")
			console.dir(answers)
			console.log("Fin Guardamos respuestas...")

		},
		getAnswersActive: function() {
				return this.getAnswersSlide(activeStep);
			
		},
		getAnswersSlide: function(slide) {
			console.log(activeStep);
			answers = $localstorage.getObject('answers');
			if(answers[result_id])
			if(answers[result_id].answers != undefined) {
				answers_all = answers[result_id].answers;
				answers_good = [];
				angular.forEach(answers_all, function (answer, index) {
					if(answer != null)
					if(answer.slide_id == slides[slide].id)
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
	      	  var url = urlBase + "/apiv2/auth"
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
			var url = urlBase + "/apiv2/quizzes/get/"
			var request 	= {'token' : options.token, 'quiz_md5' : this.getUrlQuizz()};
			if(this.getParameterByName('lang'))
		  	  var request 	= {'token' : options.token, 'quiz_md5' : this.getUrlQuizz(), 'lang': this.getParameterByName('lang')};
			 
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
				if(response.result_id != undefined) {
					result_id = response.result_id;
					answers[result_id] = {};
					answers[result_id].answers = response.answers;
				}
				$localstorage.setObject('answers',answers);
				if(response.quizzes[0].slides_mobile != undefined)
							var slidesObj = response.quizzes[0].slides_mobile;
					if(response.quizzes[0].slides_reducido != undefined)
			        var slidesObj = response.quizzes[0].slides_reducido;
							
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
										id: slide2.id,
										campos: slide.campos,
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
			        		var nextStep = "start_ES";
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
		    					campos: slide.campos,
		    					quizz_id: quizz_id,
		    					slide_id: slide_id,
		    					id: slide.id,
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
	    	return lang;
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
				window.parent.postMessage({step: activeStep - 1}, 'https://saltor.taket.es');

		},
	    nextStep: function() {
	    	if(slides[steps[activeStep]] == undefined)  steps[activeStep]=0;
	    	console.log("Siguiente slide: " + slides[steps[activeStep]].name + "_" + this.getLang())
			console.dir(slides)
			
	    	/*if(steps[steps[activeStep]] == 0) {
	    		location.reload();
			}*/
			
			window.parent.postMessage({step: activeStep}, 'https://saltor.taket.es');

	    	if(slides[steps[activeStep]].name == "start") {

	    		this.saveAnswers();

	    		return;
	    	}  else {
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
		goToStep: function(step) {
			this.goTo(step)
		},
		
		goTo: function(id) {
			if(isNaN(id)) return;
			activeStep = id;
			$state.go(slides[activeStep].name+ "_ES");
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
			                    template: view.replace(/&#8216;/g,"'")
						   }
									
				/*	if(slide.campos != undefined && slide.campos[0].layer_mecanics != undefined && slide.campos[0].layer_mecanics == 'resizabletable')
						data.controller = slide.campos[0].layer_mecanics;
					else if(slide.campos != undefined && slide.campos[0].layer_mecanics != undefined && slide.campos[0].layer_mecanics == 'sortable')
					   data.controller = slide.campos[0].layer_mecanics;
					else if(slide.campos != undefined && slide.campos[0].layer_mecanics != undefined && slide.campos[0].layer_mecanics == 'drawable')
					   data.controller = slide.campos[0].layer_mecanics;
					else if(slide.campos != undefined && slide.campos[0].layer_mecanics != undefined && slide.campos[0].layer_mecanics == 'dragable')
					   data.controller = 'draggable';
					else*/
						data.controller = "preguntas";

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
				$state.go("start_ES");
				activeStep = 0;
				return;
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
					} else {
						$state.go("start_ES");
						activeStep = 0;
					}
				} 
			}  else {
				$state.go("start_ES");
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
