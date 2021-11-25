angular.module('starter.controllers', [])
.directive("widgit", function ($sce, $timeout) {
  return {
    link: function (scope, element, attrs) {
      scope.$watch("attrs.widgit", function () {
        $.getScript('http://www.tripadvisor.es/WidgetEmbed-cdswritereviewlg?border=true&locationId=662969&display_version=2&uniq=958&lang=es');
        //element.append(angular.element(scope[attrs.widgit].widgit));
      });
    }
  };
})
.directive('ngClick', function ($timeout) {
    var delay = 500;

    return {
        restrict: 'A',
        priority: -1,
        link: function (scope, elem) {
            var disabled = false;

            function onClick(evt) {
                if (disabled) {
                    evt.preventDefault();
                    evt.stopImmediatePropagation();
                } else {
                    disabled = true;
                    $timeout(function () { disabled = false; }, delay, false);
                }
            }

            scope.$on('$destroy', function () { elem.off('click', onClick); });
            elem.on('click', onClick);
        }
    };
})
.controller('preguntas', function($scope, $state, Taket) {
  
  $scope.$on('$ionicView.beforeEnter', function(){
    //reset stats
   // $("[data-role=pregunta] [data-voto]").removeClass("noselect")
    $("[data-role=pregunta]").attr("data-contestado",0)
    //  $("section").find("[data-question]").val("");
    
  });
  $scope.$on('$ionicView.afterEnter', function(){
    if($("[nav-view=entering] .smile").length==4)
	    $( "<br/>" ).insertAfter("[nav-view=entering] .smile:nth-child(3)")
  
      //nextstep en videos al finalizar
      $("[data-video-endnext]").bind("ended", function() {
        //TO DO: Your code goes here...
        Taket.nextStep();
      });
      $("[nav-view=entering]").find(".noselect").removeClass("noselect");
      $("[nav-view=entering]").find("[type=range]").val(1);
      $("[nav-view=entering]").find("[type=text]").val("");
      $("[nav-view=entering]").find(".br-selected").removeClass("br-selected");
      
      
      $("[cache-src]").each(function() {
        $(this).attr("src", $(this).attr("cache-src"))
      });

      console.log("Respuestas en esta pantalla")
      var answers = Taket.getAnswersActive()
      console.dir(answers)
      angular.forEach(answers, function (answer, index) {
        var question_type = answer.question_type;
        var answer_type = answer.answer_type;
        if(question_type == "select") {
          $("[data-question-title='"+answer.question_title+"']")
            .find("[value='"+answer.value+"']")
            .prop('selected', true);
        } else if(answer_type == "range") {
          $("[data-question-title='"+answer.question_title+"']").find("input")
            .val(answer.value);
        } else if(answer_type == "stars") {
          $("[data-question-title='"+answer.question_title+"']")
            .find("[value='"+answer.value+"']")
            .prop('selected', true);
        } else {
          $("[data-question-title='"+answer.question_title+"']")
              .find(".noselect")
              .toggleClass("noselect");
          $("[data-question-title='"+answer.question_title+"']")
              .find("[data-value='"+answer.value+"']")
              .addClass("noselect");
        }
				/*if(answer.slide_id == slides[activeStep].slide_id)
          answers_good.push(answer);*/
          //buscamos el elemento que está respondido
      })
      
      ;

      var numPreguntas = $("[nav-view=entering] [data-question-title]").length;
      var numPreguntasContestadas = $("[nav-view=entering] [data-question-title] .noselect").length;
      
      if(numPreguntas == numPreguntasContestadas) {
        $(".pane[nav-view='entering']").find(".ion-chevron-right").show()
        $( "[nav-view=entering]" ).find(".button-dark").show()
      }
      var init_run = $("[nav-view=entering]").find("[data-init-run]").data("init-run");
      if(init_run) {
        switch (init_run) { 
          case "save": 

            Taket.saveAnswers();
            $(".noselect").removeClass("noselect");
            $("[type=range]").val(1);
            $("[type=text]").val("");
            $(".br-selected").removeClass("br-selected");
         
          break;
        }
      }
      /*$("input[type=text], textarea").on( "focusin", function(){
        $("input, textarea").parent().parent().parent().hide();
        $(this).parent().parent().parent().show();
      })
      $("input[type=text], textarea").on( "focusout", function(){
        $("input, textarea").parent().parent().parent().show();
      })*/
      //Obligatorios
      if($("[nav-view=entering] [data-answer-block=1]").length > 0) {
        $('.bar-footer').hide();
      }
      

      $(document).on("input","input[type=range]",function() {
        var selected = $(this).val();
        var values = $(this).data("options");
        var _pregunta = $(this).parent().parent();
        var span = _pregunta.find("h4").find("span")
        $(span).html(values[selected-1].title)
      });

      $('.bar-stars').barrating({
        theme: 'fontawesome-stars'
      });

      $(document).on("change","[data-calc-type]",function() {
        var source = $(this).find("input").val();
        var dest = $(this).data("calc-dest");
        switch ($(this).data("calc-type")) { 
          case "mult": 
              $("[name="+dest+"]").val(source * $(this).data("calc-calc"));
          break 
          case "sum": 
              $("[name="+dest+"]").val(source + $(this).data("calc-calc"));
          break;
          case "div": 
              $("[name="+dest+"]").val(source / $(this).data("calc-calc"));
          break;
          case "custom":
              var custom = $(this).data("calc-calc");
              var elements = custom.split(' ');
              var result = parseInt($("[name="+elements[0]+"]").val());
              for (i = 0; i < elements.length; i++) { 
                switch (elements[i]) { 
                 
                  case '+':
                    
                      var operator = $("[name="+elements[i+1]+"]").val();
                      if(!operator) operator = 0;
                      result = result + parseInt(operator);
                  break;
                  case '-':
                    
                      var operator = $("[name="+elements[i+1]+"]").val();
                      if(!operator) operator = 0;
                      result = result - parseInt(operator);
                  break;
                  case '*':
                    
                      var operator = $("[name="+elements[i+1]+"]").val();
                      if(!operator) operator = 0;
                      result = result * parseInt(operator);
                  break;
                  case '/':
                    
                      var operator = $("[name="+elements[i+1]+"]").val();
                      if(!operator) operator = 0;
                      result = result / parseInt(operator);
                  break;
                  default:
                  break;
                }
              }
              if(result != "NaN")
                $("[name="+dest+"]").val(result);

          break;
         
        }
        $("[name="+dest+"]").trigger("change");
      });

  });
  $scope.goTo = function(id) {
    window.setTimeout(function() {
      Taket.goTo(id)
    }, 100); 
    
  }
  $scope.nextStep = function(timeout) {
    window.setTimeout(function() {
            Taket.nextStep()
        }, timeout);  
  }
  $scope.nextStepLopd = function(timeout) {
    if($('#lopd:checked').length == 1) { 
      window.setTimeout(function() {
        Taket.nextStep()
      }, timeout);  
    } 
    else {
      alert('Es necesario que aceptes la política de privacidad para poder continuar')
    }
    
  }
 
  $scope.prevStep = function(timeout) {
    window.setTimeout(function() {
            Taket.prevStep()
        }, timeout);  
  }
  $scope.respuestas = function() {
    $("[nav-view=active]").find("[data-question]").data("require-complete",0)
    var exito  = true;
    $("[nav-view=active]").find("[data-question]").each(function(){
      var _pregunta         = $(this);

      var data = {
                    answer_type:      _pregunta.data("answer-type"),
                    question_id:      _pregunta.data("question-id"),
                    question:         _pregunta.data("question"),
                    question_title:   _pregunta.data("question-title"),
                    question_type:    _pregunta.data("question-type"),
                    value_type:       _pregunta.data("question-type"),
                    require:          _pregunta.data("require"),
                    lang:             Taket.getLang(),
                    question_number:  _pregunta.data("question-number")
                 }

      switch (data.answer_type) { 
          case "free": 
              data.value = $(this).find("textarea").val()
          break 
          case "age": 
              data.value = $(this).find(".ng-valid-parse").val()
          break;
          case "sondeo": 
              data.value = $(this).find(":selected").text()
          break 
          case 'range':
              data.value = $(this).find("input[type=range]").val()
          break;
          case 'stars':
              data.value = $(this).find(":selected").val();
          break;
          case 'textarea':
              data.value = $(this).val();
          break;
          default:
              data.value = $(this).find("input").val()
          break;
      }
      if(data.value != "" && data.value != undefined
          && data.value != "- Seleccione una opción -" 
          && data.value != "- Select one option -") {
	     Taket.setAnswer(data) ;
        return true;
      } else {
        if(data.require) {
          if(data.value != "- Select one option -")
            alert("Debes rellenar los campos obligatorios");
          else
            alert("You must fill in the required fields");
          _pregunta.data("require-complete",1)
          exito = false;
          return false;
        }
              
      }
        
    });
    if(exito)
      $scope.nextStep()
  }
  $scope.wellcome = function($event, $lang) {
    Taket.setLang($lang);
    //Taket.render();
    Taket.nextStep();
   // alert($(window).width() + 'x' + $(window).height())
  }
  $scope.voto = function($event) {
    
  	
  	var _this = $($event.target);
    _this.addClass("clicked")
    //tenemos que buscar el target correto...
    //Comprobamos que sea un sondeo con imagen
    if(_this.parent().hasClass("voto-img") && _this.context.nodeName != "BUTTON") {
      _this = _this.parent().find("img");
      if(_this.hasClass("noselect")) {
        return;
      }
    }
    
    //el evento voto puede activarlo un child y entonces _this será este en lugar del que toca
    if(_this.attr("ng-click") === undefined) {
      if(_this.parent().attr("ng-click") === undefined) {
        if(_this.parent().parent().attr("ng-click") !== undefined) {
          _this = _this.parent().parent();
        }
      } else {
        _this = _this.parent();
      }
    }
    
  	
    var _preguntas        = _this.parent().parent().parent().parent()
    var _pregunta         = _this.parent()
    
    if(_this.data("value-type")=="sondeo") {
    	var _pregunta         = _this.parent().parent()
      if(_pregunta.data("role")!="pregunta")
        var _pregunta         = _this.parent().parent().parent()
  	}   
  	  
    var numPregunta       = _this.attr("data-voto");
    var maxRespuestas     = _pregunta.data("max-answers");
	  
    var saltarStep = _this.data("nextstep-follow");
	
	
	  if(_this.hasClass("noselect") && _pregunta.data("question-type")=='specific') return;
    if(_pregunta.attr("data-contestado") == maxRespuestas) return;
    
	
    var numSubPreguntas   = _preguntas.find('section').find("[data-role=pregunta]").length;
    var numPreguntas      = _preguntas.find("[data-role=pregunta]").length - numSubPreguntas;


    var data = {
                answer_type:      _pregunta.data("answer-type"),
                question_id:      _pregunta.data("question-id"),
                value:            _this.data("value"),
                question:         _pregunta.data("question"),
                question_title:   _pregunta.data("question-title"),
                question_type:    _pregunta.data("question-type"),
                question_dimension:    _pregunta.data("question-dimension"),
                question_competencia:  _pregunta.data("question-competencia"),
                question_categoria:    _pregunta.data("question-categoria"),
                no_analizable:    _pregunta.data("no-analizable"),
                value_type:       _this.data("value-type"),
                lang:             Taket.getLang(),
                question_number:  _pregunta.data("question-number")
                }

    //si antes no se había contestado lo marcamos como contestado
    //if($('[data-voto='+numPregunta+']').find(".noselect").length==0) {
        _pregunta.data("contestado", parseInt(_pregunta.data("contestado"))+1);
    // }
    //Mostramos el boton continuar si ya ha contestado una pregunta y se puede mas de una
    if(!maxRespuestas) maxRespuestas=1;
    if(maxRespuestas > 1 && _pregunta.data("contestado")>0
    || maxRespuestas == 1) {
      _pregunta.closest( "section" ).find("#button-nextStep").show()
      $( "[nav-view=active]" ).find(".button-dark").show()
    }

    var numPreguntas = $("[nav-view=active] [data-question-title]").length;
    var numPreguntasContestadas = $("[nav-view=active] [data-question-title] .noselect").length;
    
    if(numPreguntas  - 1 == numPreguntasContestadas) {
      $(".pane[nav-view='active']").find(".ion-chevron-right").show()
    }
    _pregunta.find('[data-voto='+numPregunta+']').each(function(){
      if(maxRespuestas > 1 && _pregunta.data("contestado")>1){
        if(!$(this).hasClass("noselect"))
          $(this).removeClass("noselect");
      }
      else
        $(this).removeClass("noselect");
    })
   
    _this.addClass("noselect")
    
    
    //Repregunta por respuesta
    if(_this.find('section')) {
       _this.find('section').each(function(){
          $(this).css("display","block");
          var html = $(this)[0].outerHTML;
          $(this).css("display","none");
          //$(this).remove();

          slide = {
            view: html
          };

          Taket.addSlide(slide);
          

        })    
    } else if(_pregunta.find('section')) {
        
        _pregunta.find('section').each(function(){
          $(this).css("display","block");
          var html = $(this)[0].outerHTML;
          $(this).css("display","none");
          //$(this).remove();

          slide = {
            view: html
          };

          if(data.value_type == "1" || data.value_type == "2"){
            Taket.addSlide(slide);
          }

        })    
    }
	
    Taket.setAnswer(data)    

    //Si es una pantalla con multiples preguntas
    if(_preguntas.children().children().children("[data-question-type=general]").length > 1) {
        //miramos si se han votado todos los puntos
       if(_preguntas.children().children().children("[data-question-type=general]").find("[class*=noselect]").length==numPreguntas
      ) {
	     if(_this.data("no-nextstep") == undefined) {
	        setTimeout(function(){
	           $scope.nextStep()
            for (i = 0; i < saltarStep; i++) { 
                 $scope.nextStep()
            }
	        }, 500);
		    }
      }
    } else { //Si solo hay una pregunta
      if(_pregunta.data("contestado") >= maxRespuestas) {
        if(_this.data("no-nextstep") == undefined) {
	        setTimeout(function(){
	           $scope.nextStep()
            for (i = 0; i < saltarStep; i++) { 
                 $scope.nextStep()
            }
	        }, 500);
		 }
      }
    }
        _this.removeClass("clicked")
 
    
  }	
})
.controller('setupController', function($scope, Taket) {
      //$scope
      $scope.mac = Taket.getMac();
      $scope.submit = function(secret, mac) {
        
        Taket.setSecret(secret);
        Taket.setMac(mac);
        Taket.init();
        /*if ($scope.text) {
          $scope.list.push(this.text);
          $scope.text = '';
        }*/
      };
})
.controller('nonQuizzController', function($scope, Taket) {
      //$scope
      $scope.submit = function(secret, mac) {
        
        Taket.init();
        /*if ($scope.text) {
          $scope.list.push(this.text);
          $scope.text = '';
        }*/
      };
})

.controller('MyCtrl', function($scope) {
  ionic.Platform.ready(function() {
    // hide the status bar using the StatusBar plugin

    //Screen on

  });
});