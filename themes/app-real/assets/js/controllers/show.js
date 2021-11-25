.controller('show', function($scope, $state, Taket, $controller) {
    /*
    data = {
        index: {
            action: ['load','calc','clone'],
            value: String, 
            source: String, (id element)
            dest: String (id element)
        }
    }
    */
    $scope.$on('$ionicView.afterEnter', function() {
        if($("[nav-view=active] .show").length) {
            $("[nav-view=active] .show").each(function(index){
                slide = $(this).data("show-slide");
                elemento = $(this).data("show-elemento");
                num = $(this).data("show-num");
                console.log(slide);
                console.log(elemento);
                console.log(num);
                var answers = Taket.getAnswersSlide(slide)
                ele = this;
                console.dir(answers[num]);
                $(ele).html(answers[num].answer_title);
                angular.forEach(answers, function (answer, index) {
                    
                            /*if(answer.slide_id == slides[activeStep].slide_id)
                    answers_good.push(answer);*/
                    //buscamos el elemento que está respondido
                })
            })
        }
    });
    
  
})
