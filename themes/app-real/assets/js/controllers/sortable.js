.controller('sortable', function($scope, $state, Taket, $controller) {
    const $ctrl = this;
    const $base = $controller('preguntas', {$scope, $state, Taket});
  
    //Extend
    angular.extend($ctrl, $base);
  
    /**
     * On init
     */
    this.$onInit = function() {
  
      //Call parent init
      $base.$onInit.call(this);
  
      //Do other stuff
      this.somethingElse = true;
    };

    $scope.$on('$ionicView.beforeEnter', function(){
      //reset stats
     // $("[data-role=pregunta] [data-voto]").removeClass("noselect")
      
     
    });
    $scope.$on('$ionicView.loaded', function() {


        
        $(".sortable").each(function() {
            var id = $(this).attr("id");
            Zepto('#'+id).dragswap({
                element : 'li',
                dropAnimation: true,
                dropComplete: function(){
                    _pregunta = $('#'+id);
                    console.dir()
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
                    data.value = JSON.stringify(Zepto('#'+id).dragswap('toJSON'));
                    Taket.setAnswer(data);
                } 
            });
        })
        
    });
  
})
