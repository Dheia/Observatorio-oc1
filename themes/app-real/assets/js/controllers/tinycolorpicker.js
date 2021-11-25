.controller('tinycolorpicker', function($scope, $state, Taket, $controller) {
    const $ctrl = this;
    const $base = $controller('preguntas', {$scope, $state, Taket});
  
    //Extend
    angular.extend($ctrl, $base);
    
    $scope.$on('$ionicView.afterEnter', function(){
      //reset stats
     // $("[data-role=pregunta] [data-voto]").removeClass("noselect")
     var $box = $('#colorPicker');
     $box.tinycolorpicker();
     $box.bind("change", function()
     {
         $scope.changeCustomColor();
     });
     
    });
    $scope.$on('$ionicView.loaded', function() {
       
    });
  

    
})