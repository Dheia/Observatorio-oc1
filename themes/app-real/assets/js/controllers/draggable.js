.controller('draggable', function($scope, $state, Taket, $controller) {
    const $ctrl = this;
    const $base = $controller('preguntas', {$scope, $state, Taket});
  
    //Extend
    angular.extend($ctrl, $base);
  
    var question;
    /**
     * On init
     */
    this.$onInit = function() {
  
      //Call parent init
      $base.$onInit.call(this);
  
      //Do other stuff
      this.somethingElse = true;
    };
    $scope.$on('$ionicView.leave', function(){
       if($("[nav-view=cached] .draggable").length>0) {
          $("[nav-view=cached] .draggable").draggable("option", "revert", false);
          $("[nav-view=cached] .droppable").droppable("option", "revert", false);
        }
      });
    $scope.$on('$ionicView.beforeEnter', function(){
     if($("[nav-view=stage] .draggable").length>0) {
        $("[nav-view=stage] .draggable").draggable({
            revert:"invalid",
            start:function(){
            }
        });
        $("[nav-view=stage] .droppable").droppable({
            accept:".draggable",
            hoverClass:"active",
            drop:function(ev,ui){
                $scope.drop(this,ev,ui);
            }
        });
      }
    });
    $scope.drop = function(element, ev, ui) {
        var dpid=$(element).attr("data-id")-1;
        var y = $(element).css("top");
        var x = $(element).css("left");
        var width = $(element).css("width");
        var height= $(element).css("height");
        _pregunta = $("[data-type='draggable']");

        //espacio al que es arrastrado
        if($(element).attr("name")!=null){
            //elemento seleccionado
            var d=$(element).attr("name");
            //espacio del que viene
            var destino= "[nav-view=active] #drop"+$(element).attr("data-id");
            var origen = "[nav-view=active] #"+$(ui.draggable).attr("data-id");
            if(!origen.includes("drop"))
                origen = "[nav-view=active] #drop"+$(ui.draggable).attr("data-id");
            console.log("asdasd");
            console.dir($(destino).attr("name"));

            //comprobamos si en destino hay algun elemento
            if($(destino).attr("name")) {
                //si hay elemento y hay origen intercambiamos
                if($(origen).attr("name")) {
                    var y1 = $(origen).css("top");
                    var x1 = $(origen).css("left");
                    var width1 = $(origen).css("width");
                    var height1= $(origen).css("height");   
                    //si hay elemento y hay origen intercambiamos
                    $("[nav-view=active] #"+$(destino).attr("name")).animate({padding: 0,left:x1,top:y1,width:width1,height:height1},300);
                    $("[nav-view=active] #"+$(destino).attr("name")).attr("name",$(element).attr("name"));
                    $("[nav-view=active] #"+$(destino).attr("name")).attr("data-id",$(ui.draggable).attr("data-id"));
                } else {
                    background = $("#"+$(destino).attr("name")).css('background-image');  
                    $("[nav-view=active] #"+$(destino).attr("name")).removeAttr('style');  
                    $("[nav-view=active] #"+$(destino).attr("name")).removeAttr('data-id');  
                    $("[nav-view=active] #"+$(destino).attr("name")).css('background-image',background);

                }
                //Taket.setAnswer(data);
               
            } 
            
            //movemos el elemento de origen a la nueva posicion
            $("[nav-view=active] #"+$(origen).attr("name"))
                .animate({padding: 0,left:x,top:y,width:width,height:height},300);
            $("[nav-view=active] #drop"+$(ui.draggable).attr("data-id")).attr("name",$(element).attr("name"));
           /* $("#"+$(origen).attr("name")).attr("data-id",$(ui.draggable).attr("data-id"));
            $(element).attr("name",$(ui.draggable).attr("id"));*/
        } else {
            if($("[nav-view=active] #drop"+$(ui.draggable).attr("data-id")).attr("name")) {
                $("[nav-view=active] #drop"+$(ui.draggable).attr("data-id")).attr("name","");
            }
            if($("[nav-view=active] #"+$(ui.draggable).attr("data-id")).attr("name")) {
                $("[nav-view=active] #"+$(ui.draggable).attr("data-id")).attr("name","");
            }
        }
            
        

        //asignamos al elemento desplazado el drop al que se le ha puesto
        $(ui.draggable).attr("data-id",$(element).attr("data-id"));
        //hacemos animacion de desplazamiento del elemento desplazado a la posicion
        $(ui.draggable).animate({padding: 0,left:x,top:y,width:width,height:height},300);
        //asignamos al drop de destino el nuevo valor
        $(element).attr("name",$(ui.draggable).attr("id"));

        //guardamos datos en el bag
        $scope.setAnswer(element,$(element).closest("[data-question-type=draggable]"));
        
    };
    $scope.setAnswer = function(element, question) {
        Taket.runAction(element, question);
    };
  

    /*$scope.runAction = function(element,question) {
        if($(question).data("action")) {
            switch($(question).data("action")) {
                case 'clone':
                    //cogemos cada uno de los sources
                    var sources = $(question).data("action-source").split(",");
                    var dest = $(question).data("action-dest").split(",");
                    var indexOk = -1;
                    sources.forEach(function(el,index){
                        if($("#"+el).attr("id") == $(element).attr("id")) {
                            indexOk = index;
                        }
                    })
                    if(indexOk != -1) {
                        data.source   = sources[indexOk];
                        data.question = question;
                        data.action = 'clone';
                        data.dest   = dest[indexOk];
                        Taket.setData(data);
                    }
                break;
            } 
        }
    };*/
})
