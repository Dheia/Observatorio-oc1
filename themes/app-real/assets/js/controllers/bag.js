.controller('bag', function($scope, $state, Taket, $controller) {
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
    $scope.$on('$ionicView.afterEnter', function(){
        //reset stats
    // $("[data-role=pregunta] [data-voto]").removeClass("noselect")
        $("[data-role=pregunta]").attr("data-contestado",0)
        //  $("section").find("[data-question]").val("");
        
        
    
    });
    
  
})
