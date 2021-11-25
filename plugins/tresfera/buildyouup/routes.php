<?php
use CpChart\Chart\Radar;
use CpChart\Chart\Pie;
use CpChart\Data;
use CpChart\Image;
use Tresfera\Buildyouup\Models\Rapport;
use Tresfera\Taketsystem\Models\Quiz;
use Tresfera\Buildyouup\Models\Equipo;

Route::group(['namespace' => 'Tresfera\Taketsystem\Classes\Http\Controllers'], function () {

  /*
   * API
   */
  Route::group(['prefix' => 'apiv2', 'namespace' => 'APIv2'], function () {

      // Auth
      Route::post('auth', 'Auth@auth');

      // Unauth
      Route::post('unauth', 'Auth@unauth');

      // Quizzes
      Route::group(['prefix' => 'quizzes'], function () {
          Route::post('/'	,    	'Quizzes@index');
          Route::post('get',    	'Quizzes@get');
          Route::post('save', 	'Quizzes@save');
          Route::post('saveAnswer', 'Quizzes@saveAnswer');
          Route::post('delAnswer', 	'Quizzes@delAnswer');
          Route::post('all', 		'Quizzes@all');
      });

  });

  /*
   * Slide render demo
   */
  Route::get('slide/{id}', 'Slide@show');

});

Route::get('rapport/buildyouup/', function () {
 
  $evaluacion = \Tresfera\Buildyouup\Models\Equipo::find(get("id"));
  $rapport = new Rapport();
  $rapport->evaluacion_id = $evaluacion->id;
  $rapport->save();
  $rapport->generateData(get("player"));
  $rapport->generatePdf();

  return \Redirect::to($rapport->getUrl());

});

Route::post('/quiz/savenotas/{idproyecto}', function ($idproyecto) {
  $proyecto = \Tresfera\Buildyouup\Models\Equipo::find($idproyecto);
  $proyecto->notas = post("notas");
  $proyecto->save();
});

Route::get('quiz-real/{md5}', function ($md5) {

  if(in_array($md5, ["buildyouup"]) and !get("ev") and !get("demo")) {
      //mostramos listado de proyectos y de equipos
      $equipos = \Tresfera\Buildyouup\Models\Equipo::all();
      $url = "https://buildyouup.taket.es/quiz-real/buildyouup?buildyouup=1&ev=";
      foreach($equipos as $equipo) {
          ?>
          <a href="<?=$url.$equipo->id?>">
          <?=$equipo->name?>
          </a>
          <?php
      }
      ?>
      <style>
          a {
              display: block;
              padding: 7px;
              text-align: center;
          }
      </style>
      <?php
      exit;
  }
  // Styles
  ?>
  <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <style>
  
  .alerta {
      margin-top: 100px;
      display: flex;
      justify-content: center;
      align-items: center;
  }
  .callout {
      margin: auto;
      width: 85%;
      font-size: 13px;
      margin-bottom: 20px;
  }
  .callout.callout-warning > .header {
      background: #f6e7b2;
  }
  .callout > .header {
      padding: 20px;
          padding-bottom: 20px;
      padding-bottom: 15px;
      -webkit-border-radius: 4px 4px 0 0;
      -moz-border-radius: 4px 4px 0 0;
      border-radius: 4px 4px 0 0;
      color: #2f2d26;
  }
  .callout > .header + .content {
      border-top: none;
  }
  .callout.callout-warning > .content {
      background: white;
      border: 2px solid #f8f0d5;
          border-top-width: 2px;
          border-top-style: solid;
          border-top-color: rgb(248, 240, 213);
  }
  .callout > .content {
      color: #2f2d26;
      padding: 16px 20px 15px;
  }
  .callout.callout-warning > .header i {
      color: #9f8e51;
  }
  .callout > .header i {
      font-size: 26px;
      float: left;
  }
  .fas {
      margin-top: 10;
      margin-right: 10px;
  }

  body.outer .layout > .layout-row.layout-head > .layout-cell h1.oc-logo {
      font: 0/0 a;
      color: transparent;
      text-shadow: none;
      background-color: transparent;
      border: 0;
      display: inline-block;
      width: 100%;
      max-width: 450px;
      height: 170px;
      min-height: 72px;
  }
  .cabecera {
      width: 100%;
      margin: auto;
      padding-top:50px;
      padding-bottom: 80px;
      text-align: center;
      background-color: white;
      
  }
  .logo {
      text-shadow: none;
      background-color: transparent;
      border: 0;
      display: inline-block;
      width: 100%;
      max-width: 450px;
      height: 210px;
      min-height: 72px;
  }
  .separacion {
      height: 20px;
      background-color: #BDBDBD;
  }

  </style>

    <?php

 
    $quiz = Quiz::where("md5",$md5)->first();
    //$quiz->publish();
    if(!isset($quiz->id))
        exit;

    $quiz->publish();

    $url = "//app.v3.taket.es/?id=$md5";
    foreach(get() as $key=>$value) {
        $url .= "&".$key."=".$value;
    }
    if($md5 == "buildyouup") {
        if(get("ev")) {
            $proyecto = \Tresfera\Buildyouup\Models\Equipo::find(get("ev"));
            if(isset($proyecto->id))
                $notas = $proyecto->notas;
        }

    }

    /*if(! empty($_SERVER['HTTP_USER_AGENT'])){
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        if( preg_match('@(iPad|iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)@', $useragent) ){
            header('Location: '.$url);
            exit;
        }
    }*/

    

    ?>
    <html>
      <head>
            <title><?=$quiz->title?></title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

      </head>
      <body>
      <?php if($md5 == "buildyouup" and get("ev") and isset($notas)) {  ?>
        <div class="bloc hide">
            <div class="button-bloc"><i class="fas fa-book"></i></div>
            <div class="body-bloc">
                <textarea name="notas"><?=$notas?></textarea>
            </div>
        </div>
        <style>
            .bloc {
                position: absolute;
                z-index: 10;
                right: -400px;
                width: 400px;
                top: 30px;
            }
            .button-bloc {
                position: absolute;
                left: -55px;
                padding: 10px;
                background: #393d4b;
                cursor: pointer;
            }
            .bloc textarea {
                width: 100%;
                height: 380px;
            }
            .bloc i.fas.fa-book {
                font-size: 40px;
                color: #fff;
                margin: 0;
            }
        </style>
        <script
                src="https://code.jquery.com/jquery-2.2.4.js"
                integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
                crossorigin="anonymous"></script>
        <script>
        jQuery(document).ready(function($){
            $(".button-bloc").on("click",function(){
                if($(".bloc").css("right") == '0' || $(".bloc").css("right") == '0px') {
                    $(".bloc").animate({right:'-400px'}, 700);
                    var urlOk = "/quiz/savenotas/<?=$proyecto->id?>"
                    $.ajax({
                            method: "POST",
                            url: urlOk,
                            data: { notas: $('.bloc textarea').val() }
                        })
                        .done(function( msg ) {
                            
                    });
                } else {
                    $(".bloc").animate({right:'0px'}, 700);
                    
                }
            })
            $('.bloc textarea').change(function(){
                //("changed");
            });
        });

        </script>
        <?php } ?>
        <?php 
        if(in_array($md5, ["buildyouup"]) and get("ev")) {
          $observador = Equipo::find(get("ev"));
          $teams = $observador->players;
        
          ?>
          <script>
            var team = '<?=$teams[0]['name']?>'
            function changeUrl(new_team) {
              $("#teams > button").removeClass("active");
              $("[data-team='"+new_team+"']").addClass("active");
              var url = "<?=$url?>&team="+new_team;
              $("#resultFrame").attr("src",url);
            }
          </script>
          <style>
            #teams {
              z-index: 1;
              width: 100%;
              background: white;
              text-align: center;
              
            }
            #teams button {
              background: transparent;
              border: 3px solid #393d4b;
              color: #393d4b;
              cursor: pointer;
              padding: 10px 20px;
            }
            #teams button.active {
              background: #393d4b;
              border: 3px solid #393d4b;
              color: #fff;
            }
          </style>
          <div id="teams">
            <?php foreach($teams as $key=>$team) { ?> 
            <button data-team="<?=$team['name']?>" <?php if($key==0) { ?>class="active" <?php } ?> onclick="changeUrl('<?=$team['name']?>')">
              <?=$team['name']?>
            </button>
            <?php } ?>
          </div>
          <?php
          $url.="&team=".$teams[0]['name'];
        }
        ?>
    <iframe id="resultFrame" width="1200" height="680" src="<?=$url?>">
    </iframe>
    <style>
      html, body {
        height: 100%;
        width: 100%;
        margin: 0;
      }
      iframe {
        width: 100%;
        height: 100%;
        border: none;
        position: relative;
        margin: 0;
        transform-origin: top;
      }
      @media (min-width: 460px) {
          iframe {
            width: 1200px;
            height: 680px;
            margin-left: 50%;
            position: absolute;
            left: -600px;
          }
      }
      
      @media (max-width: 460px) {
          iframe {
            width: 100%;
            height: 100$;
            margin-left: 0%;
            position: absolute;
            left: 0;
            transform: scale(1) !important;
          }
          iframe {
                height: 100% !important;
            }
          body {
                margin: 0;
            }
      }
      div#nav {
            display: block;
            position: absolute;
            z-index: 1;
            width: 300px;
            left: 50%;
            margin-left: -600px;
            height: 600px;
            overflow: auto;
        }

        body {
            background: #ffffff;
        }

        html, body {
            height: 100%;
            width: 100%;
            overflow: hidden;
        }
        /*CUSTOM*/
        <?php if($quiz->dessign_background) {
            ?>
            body {
                background-color: <?=$quiz->dessign_background?>;
            }
            <?php
        } ?>
        <?php if($quiz->dessign_radius) {
            ?>
            iframe {
                border-radius: <?=$quiz->dessign_radius?>px;
            }
            <?php
        } ?>
        <?php if($quiz->dessign_width) {
            ?>
            iframe {
                width: <?=$quiz->width?>px;
            }
            <?php
        } ?>
        <?php if($quiz->dessign_heigth) {
            ?>
            iframe {
                height: <?=$quiz->dessign_heigth?>px;
            }
            <?php
        } ?>
        <?php if($quiz->dessign_radius_color) {
            ?>
            iframe {
                box-shadow: 0px 0px 25px <?=$quiz->dessign_radius_color?>;
            }
            <?php
        } ?>
      </style>
        <script
                src="https://code.jquery.com/jquery-2.2.4.js"
                integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
                crossorigin="anonymous"></script>
        <script>
        jQuery(document).ready(function($){

              
            nsZoomZoom(); 
            
            $( window ).resize(function() { 
                nsZoomZoom();
            });
            
            
            function nsZoomZoom() {
                htmlWidth = $('html').innerWidth();
                bodyWidth = 1200;
                if(htmlWidth < 460) return;
                if (htmlWidth > bodyWidth)
                    scaleWidth = 1
                else {
                    scaleWidth = htmlWidth / bodyWidth; 
                }

                htmlHeight = $('html').innerHeight();
                bodyHeight = 750;
                
                if (htmlHeight > bodyHeight)
                    scaleHeight = 1
                else {
                    scaleHeight = htmlHeight / bodyHeight; 
                }
                scale = scaleWidth;
                if(scaleHeight < scaleWidth) {
                    mtop = scaleHeight * htmlHeight;
                    //$("iframe").css('margin-top', '-'+mtop+'px');
                    scale = scaleHeight;
                }
            
                // Req for IE9
                $("iframe").css('-ms-transform', 'scale(' + scale + ')');
                $("iframe").css('transform', 'scale(' + scale + ')');
            } 
                
        });
        </script>
      </body>   
    </html>
    <?php
});