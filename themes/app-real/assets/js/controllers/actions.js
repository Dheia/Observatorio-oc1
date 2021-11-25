.controller('actions', function($scope, $state, Taket, $controller) {
    
    $scope.$on('$ionicView.afterEnter', function() {
        console.log("Data:")
        var bag_data = Taket.getAllData();
        console.dir(bag_data);
        if(Array.isArray(bag_data))
        bag_data.forEach(function(element) {
            console.log(element);
            switch(element.action) {
                case 'clone':
                    if($("[nav-view=active]").find("#"+element.dest).length > 0) {
                        if($(element.question).data("type") == "draggable") {
                            source = $(element.question).find("#"+element.source);
                            source2 = $(source).attr("name");
                            $("#"+element.dest).css("background-image",$("#"+source2).css("background-image"))
                        } else {
                            $("#"+element.dest).html($('#'+element.source).html())
                        }
                        
                    }
                break;
            } 
        });
         
    });

  
})
