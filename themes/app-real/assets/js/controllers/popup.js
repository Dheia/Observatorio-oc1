.controller('popup', function($scope, $state, Taket, $controller) {
  
    $scope.$on('$ionicView.loaded', function() {

        $(".popup-click").on("click", function(e) {
            e.preventDefault();
            var selector = $(this).data("id-popup");
            $(this).simplePopup({ type: "html", htmlSelector: "#"+selector });
        });
        
    });
  
})
