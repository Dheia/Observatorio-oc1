angular.module('starter.controllers', [])

.controller('preguntas', function($scope, $state) {

  
  $scope.$on('$ionicView.afterEnter', function(){
    $('[data-voto]').click(function(){
        	
            var _this = $(this);
            var _preguntas 		= _this.parent().parent().parent().parent()
            var numPreguntas	= _preguntas.find("[data-role=pregunta]").length;
            var numPregunta		= _this.attr("data-voto");
 	    	
          	
            //si antes no se había contestado lo marcamos como contestado
            if($('[data-voto='+numPregunta+']').find(".noselect").length==0) {
	            _this.parent().attr("data-contestado",1);
            }
            
            _this.parent().find('[data-voto='+numPregunta+']').each(function(){
	            $(this).addClass("noselect");
            })
            
            _this.removeClass("noselect")

            //miramos si se han votado todos los puntos
            if(_preguntas.find("[data-contestado=1]").length==numPreguntas
            	&& 
            	_preguntas.find("[data-contestado=1]").length>0
            ) {
            	 setTimeout(function(){
					   //$.mobile.changePage("#"+action);
					   var action = _preguntas.attr("data-siguiente");
					   var fin = _preguntas.attr("data-fin");
					   if(fin == 'true')
					   	action = "start"
					   
					   console.dir(action)

					   $state.transitionTo(action);
					   alert("cambiamos")
					}, 500);
	            
            }
            
        });
  });
})

.controller('DashCtrl', function($scope) {})

.controller('ChatsCtrl', function($scope, Chats) {
  $scope.chats = Chats.all();
  $scope.remove = function(chat) {
    Chats.remove(chat);
  }
})

.controller('ChatDetailCtrl', function($scope, $stateParams, Chats) {
  $scope.chat = Chats.get($stateParams.chatId);
})

.controller('AccountCtrl', function($scope) {
  $scope.settings = {
    enableFriends: true
  };
});
