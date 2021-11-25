.controller('resizabletable', function($scope, $state, Taket, $controller) {
    const $ctrl = this;
    const $base = $controller('preguntas', {$scope, $state, Taket});
  
    //Extend
    angular.extend($ctrl, $base);
    
    $scope.$on('$ionicView.afterEnter', function(){
        //reset stats
        // $("[data-role=pregunta] [data-voto]").removeClass("noselect")
        $('.rezible').find('input').on("change",function(){
            var percent = $(this).val();
            $(this).parent().parent().css('width', percent + "%");
           
        })
     
    });
    $scope.setPercent = function() {
        var width = $('.rezible').width();
        $('.rezible').find('th').each(function(){
            var width2 = $(this).width();
            
            $(this).css('width', width2+"px");
            
            var percent = width2/width*100;
            var txt = parseInt(percent) + '%';

            if($(this).find("span").length > 0) 
                $(this).find("span").html("<input type='number' min=10 max=60 value='"+parseInt(percent)+"'/>%")
            else
                $(this).prepend("<span><input type='number' min=10 max=60 value='"+parseInt(percent)+"'/>%</span>")
        })
        
    };
    $scope.$on('$ionicView.loaded', function() {
        $scope.setPercent()
        $('.rezible').find('th').resizableTableColumns({
            resize: function( event, ui ) {
                $scope.setPercent(); 
            }
          });
    });
  
})