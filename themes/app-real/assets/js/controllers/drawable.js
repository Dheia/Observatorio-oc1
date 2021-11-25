
.controller('drawable', function($scope, $state, Taket, $controller) {
    const $ctrl = this;
    const $base = $controller('preguntas', {$scope, $state, Taket});
    const $tinypicker = $controller('tinycolorpicker', {$scope, $state, Taket});
  
    //Extend
    angular.extend($ctrl, $base);
    angular.extend($ctrl, $tinypicker);
    
    $scope.$on('$ionicView.afterEnter', function(){
      //reset stats
     // $("[data-role=pregunta] [data-voto]").removeClass("noselect")
     $scope.paint();
     
    });
    $scope.changeCustomColor = function() {
      var $color = $(".colorInner").css("background-color");
        
      $(".drawable > canvas").jqScribble.update({brushColor: $color,brushSize: 2});
      $(".drawable button").removeClass("noselect");

    };
    
    $scope.$on('$ionicView.loaded', function() {
        $(".drawable > canvas").jqScribble();	
    });
    $scope.clear = function() {
        $(".drawable > canvas").jqScribble.clear();
    };
    $scope.color = function(color) {
        $(".drawable > canvas").jqScribble.update({brushColor: '#'+color,brushSize: 2});
        $(".drawable button").removeClass("noselect");
        $(".drawable #color_"+color).addClass("noselect");
      
    };
    $scope.erase = function() {
        $(".drawable > canvas").jqScribble.update({brushColor: 'rgb(255,255,255)',brushSize: 10});
        $(".drawable button").removeClass("noselect");
        $(".drawable > #erase").addClass("noselect");
    };
    $scope.paint = function() {
        $(".drawable > canvas").jqScribble.update({brushColor: 'rgb(0,0,0)',brushSize: 2});
        $(".drawable button").removeClass("noselect");
        $(".drawable #color_000000").addClass("noselect");
        
    };
    $scope.save = function() {
        _pregunta = $("[data-question-type=drawable]");
        var data = {
            answer_type:            _pregunta.data("answer-type"),
            question_id:            _pregunta.data("question-id"),
            id_db:                  _pregunta.data("id-db"),
            id:                     _pregunta.data("id-db"),
            question:               _pregunta.data("question"),
            question_title:         _pregunta.data("question-title"),
            question_type:          _pregunta.data("question-type"),
            question_dimension:     _pregunta.data("question-dimension"),
            question_competencia:   _pregunta.data("question-competencia"),
            value_type:             _pregunta.data("value-type"),
            lang:                    Taket.getLang(),
            question_number:        _pregunta.data("question-number")
        }
            
            var canvas = document.getElementById(_pregunta.data("question-id"));
            var dataURL = canvas.toDataURL();

            data.value = dataURL;

            Taket.setAnswer(data);
    };
})