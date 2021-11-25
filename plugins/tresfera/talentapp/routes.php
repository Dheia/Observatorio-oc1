<?php
use CpChart\Chart\Radar;
use CpChart\Chart\Pie;
use CpChart\Data;
use CpChart\Image;
use Tresfera\Talentapp\Models\Rapport;
use Tresfera\Talentapp\Models\Evaluacion;
Route::get('draw/radius/{md5}', function ($md5) {
  $rapport = Rapport::find($md5);
  $evaluacion = new Evaluacion();
  $evaluacion->tipo = [];
  if($rapport->evaluacion_id) $evaluacion = Evaluacion::find($rapport->evaluacion_id);

  $data = ($rapport->data); 

  /* if(in_array('autoevaluacion',$evaluacion->tipo)) {

    $data = \Tresfera\TalentApp\Controllers\Evaluaciones::getDataAutoevaluadoRapport($md5);

 } else {
    $data = \Tresfera\TalentApp\Controllers\Evaluaciones::getDataRapport($md5);

  }*/


  //$data = \Tresfera\TalentApp\Controllers\Evaluaciones::getDataRapport($md5);
  $coord = [
    "Visión estratégica",
    "Visión de la organización",
    "Networking",
    "Orientación al cliente",

    "Comunicacion",
    "Delegación",
    "Coatching",
    "Trabajo en equipo",
    "Optimismo",
  
    "Gestión del tiempo",
    "Gestión del estrés",
    "Iniciativa",
    "Adaptabilidad",
    "Autoconocimiento",
    "Autocrítica",
    "Ambición",
    "Integridad",
    "Toma de decisiones",
    "Equilibro emocianal",
    "Autocontrol",
    
  ];
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu')) {
    $data1_1 = new Data();
  }
  $data1_2 = new Data();
  $data1_3 = new Data();
  //estrategica
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu')) {
    $data1_1->addPoints(
    [
      number_format($data['estrategica_estrategica_evaluadores']?$data['estrategica_estrategica_evaluadores']:(0.5),1), 
      number_format($data['estrategica_organizacion_evaluadores']?$data['estrategica_organizacion_evaluadores']:(0.5),1), 
      number_format($data['estrategica_networking_evaluadores']?$data['estrategica_networking_evaluadores']:(0.5),1), 
      number_format($data['estrategica_cliente_evaluadores']?$data['estrategica_cliente_evaluadores']:(0.5),1), 
      null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null], "ScoreA");
    //$data->addRandomValues("ScoreA",["values" => 4, "Min"=>0,"Max"=>5,"withFloat"=>TRUE]);
    $data1_1->setSerieDescription("ScoreA", "Puntuacion promedio");
  }
  $data1_2->addPoints(
    [
      number_format($data['estrategica_estrategica_autoevaluador'],1),
      number_format($data['estrategica_organizacion_autoevaluador'],1), 
      number_format($data['estrategica_networking_autoevaluador'],1), 
      number_format($data['estrategica_cliente_autoevaluador'],1), 
      null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null], "ScoreB");
  //$data->addRandomValues("ScoreB",["values" => 4, "Min"=>0,"Max"=>5,"withFloat"=>TRUE]);
  $data1_2->setSerieDescription("ScoreB", "Autoevaluacion");

  $data1_3->addPoints(
    [
      number_format($data['estrategica_estrategica_total'],1), 
      number_format($data['estrategica_organizacion_total'],1), 
      number_format($data['estrategica_networking_total'],1), 
      number_format($data['estrategica_cliente_total'],1), 
      null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null], "ScoreC");
  //$data->addRandomValues("ScoreC",["values" => 4, "Min"=>0,"Max"=>5,"withFloat"=>TRUE]);
  $data1_3->setSerieDescription("ScoreC", "Media TalentApp");
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu')) 
    $data1_1->loadPalette("estrategica.arana.color", TRUE);
  $data1_2->loadPalette("estrategica.arana.color", TRUE);
  $data1_3->loadPalette("estrategica.arana.color", TRUE);

  //interpersonal
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu')) {
    $data2_1 = new Data();
  }
    $data2_2 = new Data();
  $data2_3 = new Data();
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu')) {
    $data2_1->addPoints([null, null, null, null, 
        number_format($data['interpersonal_estrategica_evaluadores']?$data['interpersonal_estrategica_evaluadores']:(0.5),1), 
        number_format($data['interpersonal_organizacion_evaluadores']?$data['interpersonal_organizacion_evaluadores']:(0.5),1), 
        number_format($data['interpersonal_networking_evaluadores']?$data['interpersonal_networking_evaluadores']:(0.5),1), 
        number_format($data['interpersonal_cliente_evaluadores']?$data['interpersonal_cliente_evaluadores']:(0.5),1),
        null, null, null, null, null, null, null, null, null, null, null, null], "ScoreA");
    //$data2->addRandomValues("ScoreA",["values" => 4, "Min"=>0,"Max"=>5,"withFloat"=>TRUE]);
    $data2_1->setSerieDescription("ScoreA", "Puntuacion promedio");
  }
  $data2_2->addPoints([null, null, null, null, 
        number_format($data['interpersonal_estrategica_autoevaluador'],1), 
        number_format($data['interpersonal_organizacion_autoevaluador'],1), 
        number_format($data['interpersonal_networking_autoevaluador'],1), 
        number_format($data['interpersonal_cliente_autoevaluador'],1),
        null, null, null, null, null, null, null, null, null, null, null, null], "ScoreB");
  //$data2->addRandomValues("ScoreB",["values" => 4, "Min"=>0,"Max"=>5,"withFloat"=>TRUE]);
  $data2_2->setSerieDescription("ScoreB", "Autoevaluacion");

  $data2_3->addPoints([null, null, null, null, 
                    number_format($data['interpersonal_estrategica_total'],1), 
                    number_format($data['interpersonal_organizacion_total'],1), 
                    number_format($data['interpersonal_networking_total'],1), 
                    number_format($data['interpersonal_cliente_total'],1),
                    null, null, null, null, null, null, null, null, null, null, null, null], "ScoreC");
  //$data2->addRandomValues("ScoreC",["values" => 4, "Min"=>0,"Max"=>5,"withFloat"=>TRUE]);
  $data2_3->setSerieDescription("ScoreC", "Media TalentApp");
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu'))
    $data2_1->loadPalette("interpersonal.arana.color", TRUE);
  
  $data2_2->loadPalette("interpersonal.arana.color", TRUE);
  $data2_3->loadPalette("interpersonal.arana.color", TRUE);

  //interpersonal
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu'))
    $data3_1 = new Data();
  $data3_2 = new Data();
  $data3_3 = new Data();
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu'))
    $data3_1->addPoints([null, null, null, null, null, null, null, null, 
  
          number_format($data['autogestion_estrategica_evaluadores']?$data['autogestion_estrategica_evaluadores']:(0.5),1), 
          number_format($data['autogestion_organizacion_evaluadores']?$data['autogestion_organizacion_evaluadores']:(0.5),1), 
          number_format($data['autogestion_networking_evaluadores']?$data['autogestion_networking_evaluadores']:(0.5),1), 
          number_format($data['autogestion_cliente_evaluadores']?$data['autogestion_cliente_evaluadores']:(0.5),1),
          null, null, null, null, null, null, null, null], "ScoreA");
  //$data2->addRandomValues("ScoreA",["values" => 4, "Min"=>0,"Max"=>5,"withFloat"=>TRUE]);
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu'))
    $data3_1->setSerieDescription("ScoreA", "Puntuacion promedio");

  $data3_2->addPoints([null, null, null, null, null, null, null, null, 
          number_format($data['autogestion_estrategica_autoevaluador'],1), 
          number_format($data['autogestion_organizacion_autoevaluador'],1), 
          number_format($data['autogestion_networking_autoevaluador'],1), 
          number_format($data['autogestion_cliente_autoevaluador'],1), 
          null, null, null, null, null, null, null, null], "ScoreB");
  //$data2->addRandomValues("ScoreB",["values" => 4, "Min"=>0,"Max"=>5,"withFloat"=>TRUE]);
  $data3_2->setSerieDescription("ScoreB", "Autoevaluacion");

  $data3_3->addPoints([null, null, null, null, null, null, null, null, 
          number_format($data['autogestion_estrategica_total'],1), 
          number_format($data['autogestion_organizacion_total'],1), 
          number_format($data['autogestion_networking_total'],1), 
          number_format($data['autogestion_cliente_total'],1),
            null, null, null, null, null, null, null, null], "ScoreC");
  //$data2->addRandomValues("ScoreC",["values" => 4, "Min"=>0,"Max"=>5,"withFloat"=>TRUE]);
  $data3_3->setSerieDescription("ScoreC", "Media TalentApp");
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu'))
    $data3_1->loadPalette("autogestion.arana.color", TRUE);
  $data3_2->loadPalette("autogestion.arana.color", TRUE);
  $data3_3->loadPalette("autogestion.arana.color", TRUE);

  //autogestion
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu'))
    $data4_1 = new Data();
  $data4_2 = new Data();
  $data4_3 = new Data();
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu'))
    $data4_1->addPoints([null, null, null, null, null, null, null, null, null, null, null, null, 
          number_format($data['autodesarrollo_estrategica_evaluadores']?$data['autodesarrollo_estrategica_evaluadores']:(0.5),1), 
          number_format($data['autodesarrollo_organizacion_evaluadores']?$data['autodesarrollo_organizacion_evaluadores']:(0.5),1), 
          number_format($data['autodesarrollo_networking_evaluadores']?$data['autodesarrollo_networking_evaluadores']:(0.5),1), 
          number_format($data['autodesarrollo_cliente_evaluadores']?$data['autodesarrollo_cliente_evaluadores']:(0.5),1),
          null, null, null, null], "ScoreA");
  //$data2->addRandomValues("ScoreA",["values" => 4, "Min"=>0,"Max"=>5,"withFloat"=>TRUE]);
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu'))
    $data4_1->setSerieDescription("ScoreA", "Puntuacion promedio");

  $data4_2->addPoints([null, null, null, null, null, null, null, null, null, null, null, null,  
          number_format($data['autodesarrollo_estrategica_autoevaluador'],1), 
          number_format($data['autodesarrollo_organizacion_autoevaluador'],1), 
          number_format($data['autodesarrollo_networking_autoevaluador'],1), 
          number_format($data['autodesarrollo_cliente_autoevaluador'],1), 
          null, null, null, null], "ScoreB");
  //$data2->addRandomValues("ScoreB",["values" => 4, "Min"=>0,"Max"=>5,"withFloat"=>TRUE]);
  $data4_2->setSerieDescription("ScoreB", "Autoevaluacion");

  $data4_3->addPoints([null, null, null, null, null, null, null, null, null, null, null, null, 
          number_format($data['autodesarrollo_estrategica_total'],1), 
          number_format($data['autodesarrollo_organizacion_total'],1), 
          number_format($data['autodesarrollo_networking_total'],1), 
          number_format($data['autodesarrollo_cliente_total'],1),
          null, null, null, null], "ScoreC");
  //$data2->addRandomValues("ScoreC",["values" => 4, "Min"=>0,"Max"=>5,"withFloat"=>TRUE]);
  $data4_3->setSerieDescription("ScoreC", "Media TalentApp");
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu'))
    $data4_1->loadPalette("autodesarrollo.arana.color", TRUE);
  $data4_2->loadPalette("autodesarrollo.arana.color", TRUE);
  $data4_3->loadPalette("autodesarrollo.arana.color", TRUE);
  
  //autogestion
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu'))
    $data5_1 = new Data();
  $data5_2 = new Data();
  $data5_3 = new Data();
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu')) 
    $data5_1->addPoints([null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 
          number_format($data['autoliderazgo_estrategica_evaluadores']?$data['autoliderazgo_estrategica_evaluadores']:(0.5),1), 
          number_format($data['autoliderazgo_organizacion_evaluadores']?$data['autoliderazgo_organizacion_evaluadores']:(0.5),1), 
          number_format($data['autoliderazgo_networking_evaluadores']?$data['autoliderazgo_networking_evaluadores']:(0.5),1), 
          number_format($data['autoliderazgo_cliente_evaluadores']?$data['autoliderazgo_cliente_evaluadores']:(0.5),1)], "ScoreA");
  //$data2->addRandomValues("ScoreA",["values" => 4, "Min"=>0,"Max"=>5,"withFloat"=>TRUE]);
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu'))
    $data5_1->setSerieDescription("ScoreA", "Puntuacion promedio");

  $data5_2->addPoints([null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 
        number_format($data['autoliderazgo_estrategica_autoevaluador'],1), 
        number_format($data['autoliderazgo_organizacion_autoevaluador'],1), 
        number_format($data['autoliderazgo_networking_autoevaluador'],1), 
        number_format($data['autoliderazgo_cliente_autoevaluador'],1)
      ], "ScoreB");
  //$data2->addRandomValues("ScoreB",["values" => 4, "Min"=>0,"Max"=>5,"withFloat"=>TRUE]);
  $data5_2->setSerieDescription("ScoreB", "Autoevaluacion");

  $data5_3->addPoints([null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 
        number_format($data['autoliderazgo_estrategica_total'],1), 
        number_format($data['autoliderazgo_organizacion_total'],1), 
        number_format($data['autoliderazgo_networking_total'],1), 
        number_format($data['autoliderazgo_cliente_total'],1)], "ScoreC");
  //$data2->addRandomValues("ScoreC",["values" => 4, "Min"=>0,"Max"=>5,"withFloat"=>TRUE]);
  $data5_3->setSerieDescription("ScoreC", "Media TalentApp");
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu'))
    $data5_1->loadPalette("autoliderazgo.arana.color", TRUE);
  $data5_2->loadPalette("autoliderazgo.arana.color", TRUE);
  $data5_3->loadPalette("autoliderazgo.arana.color", TRUE);


  /* Define the absissa serie */
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu'))
    $data1_1->addPoints($coord, "Coord");
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu'))
    $data1_1->setAbscissa("Coord");
  $data1_2->addPoints($coord, "Coord");
  $data1_2->setAbscissa("Coord");
  $data1_3->addPoints($coord, "Coord");
  $data1_3->setAbscissa("Coord");
  /* Define the absissa serie */
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu'))
    $data2_1->addPoints($coord, "Coord");
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu'))
    $data2_1->setAbscissa("Coord");
  $data2_2->addPoints($coord, "Coord");
  $data2_2->setAbscissa("Coord");
  $data2_3->addPoints($coord, "Coord");
  $data2_3->setAbscissa("Coord");
  /* Define the absissa serie */
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu'))
    $data3_1->addPoints($coord, "Coord");
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu'))
    $data3_1->setAbscissa("Coord");
  $data3_2->addPoints($coord, "Coord");
  $data3_2->setAbscissa("Coord");
  $data3_3->addPoints($coord, "Coord");
  $data3_3->setAbscissa("Coord");
  /* Define the absissa serie */
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu'))
    $data4_1->addPoints($coord, "Coord");
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu'))
    $data4_1->setAbscissa("Coord");
  $data4_2->addPoints($coord, "Coord");
  $data4_2->setAbscissa("Coord");
  $data4_3->addPoints($coord, "Coord");
  $data4_3->setAbscissa("Coord");
  /* Define the absissa serie */
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu'))
    $data5_1->addPoints($coord, "Coord");
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu'))
    $data5_1->setAbscissa("Coord");
  $data5_2->addPoints($coord, "Coord");
  $data5_2->setAbscissa("Coord");
  $data5_3->addPoints($coord, "Coord");
  $data5_3->setAbscissa("Coord");

  /* Create the Image object */
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu')) 
    $image = new Image(800, 800, $data1_1, true);
  else
    $image = new Image(800, 800, $data1_2, true);
  /* Draw a solid background */
 

  

  /* Add a border to the picture */

  /* Write the picture title */
  $image->setFontProperties(["FontName" => "Silkscreen.ttf", "FontSize" => 6]);


  /* Set the default font properties */
  $image->setFontProperties(["FontName" => "Forgotte.ttf", "FontSize" => 10,
      "R" => 80, "G" => 80, "B" => 80]);

  /* Enable shadow computing */
  /*$image->setShadow(true, ["X" => 2, "Y" => 2, "R" => 0, "G" => 0, "B" => 0,
      "Alpha" => 10]);*/

  /* Create the pRadar object */
  $radarChart = new Radar();

  /* Draw a polar chart */
  $image->setGraphArea(80, 50, 600, 600);
  
  $options = [
    "FixedMax" => 5,
    "LabelPos" => RADAR_LABELS_HORIZONTAL,
    "BackgroundAlpha" => true,
    "DrawLines" => false,
    "Layout" => RADAR_LAYOUT_CIRCLE,
    "PointRadius" => 0,
    "PointSurrounding" => -30,
    "DrawAxisValues" => false,
    "DrawPoly"=>TRUE,
    //"WriteValues"=>TRUE,
    "ValueFontSize"=>12,
    "WriteLabels" => false,

  ];
  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu')) {
    $radarChart->drawRadar($image, $data1_1, $options);
    $radarChart->drawRadar($image, $data2_1, $options);
    $radarChart->drawRadar($image, $data3_1, $options);
    $radarChart->drawRadar($image, $data4_1, $options);
    $radarChart->drawRadar($image, $data5_1, $options);
  }

  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu')) 
    $options = [
      "FixedMax" => 5,
      "LabelPos" => RADAR_LABELS_HORIZONTAL,
      "BackgroundAlpha" => true,
      "DrawLines" => false,
      "Layout" => RADAR_LAYOUT_CIRCLE,
      "PointRadius" => 20,
      "PointSurrounding" => -30,
      "DrawAxisValues" => false,
      //"WriteValues"=>TRUE,
      "ValueFontSize"=>12,
      "WriteLabels" => false,
    ];
  else
    $options = [
      "FixedMax" => 5,
      "LabelPos" => RADAR_LABELS_HORIZONTAL,
      "BackgroundAlpha" => true,
      "DrawLines" => false,
      "Layout" => RADAR_LAYOUT_CIRCLE,
      "PointRadius" => 0,
      "PointSurrounding" => -30,
      "DrawAxisValues" => false,
      "DrawPoly"=>TRUE,
      //"WriteValues"=>TRUE,
      "ValueFontSize"=>12,
      "WriteLabels" => false,
  ];

  $radarChart->drawRadar($image, $data1_2, $options);
  $radarChart->drawRadar($image, $data2_2, $options);
  $radarChart->drawRadar($image, $data3_2, $options);
  $radarChart->drawRadar($image, $data4_2, $options);
  $radarChart->drawRadar($image, $data5_2, $options);

  if(!isset($evaluacion->id) or ((isset($evaluacion->id) and !in_array('autoevaluacion',$evaluacion->tipo)) or $evaluacion->proyecto->type == 'edu')) 
    $options = [
      "FixedMax" => 5,
      "LabelPos" => RADAR_LABELS_HORIZONTAL,
      "BackgroundAlpha" => true,
      "DrawLines" => false,
      "Layout" => RADAR_LAYOUT_CIRCLE,
      "PointRadius" => 5,
      "PointSurrounding" => -30,
      "WriteValues"=>TRUE,
      "ValueFontSize"=>1,
      "ValuePadding" => 5,
      "OuterBubbleRadius" => 5,
      "InnerBubbleAlpha" => 100,
      "InnerBubbleR" => 241,
      "InnerBubbleG" => 231,
      "InnerBubbleB" => 219,
      "DrawAxisValues" => false,
      "DrawPoly"=>false,
      //"WriteValues"=>TRUE,
      "ValueFontSize"=>18,
      "WriteLabels" => false,

    ];
  else
    $options = [
      "FixedMax" => 5,
      "LabelPos" => RADAR_LABELS_HORIZONTAL,
      "BackgroundAlpha" => true,
      "DrawLines" => false,
      "Layout" => RADAR_LAYOUT_CIRCLE,
      "PointRadius" => 10,
      "PointSurrounding" => -30,
      "WriteValues"=>TRUE,
      "ValueFontSize"=>1,
      "ValuePadding" => 5,
      "OuterBubbleRadius" => 5,
      "InnerBubbleAlpha" => 100,
      "InnerBubbleR" => 241,
      "InnerBubbleG" => 231,
      "InnerBubbleB" => 219,
      "DrawAxisValues" => false,
      "DrawPoly"=>false,
      //"WriteValues"=>TRUE,
      "ValueFontSize"=>18,
      "WriteLabels" => false,

    ];
  $radarChart->drawRadar($image, $data1_3, $options);
  $radarChart->drawRadar($image, $data2_3, $options);
  $radarChart->drawRadar($image, $data3_3, $options);
  $radarChart->drawRadar($image, $data4_3, $options);
  $radarChart->drawRadar($image, $data5_3, $options);

  
  /* Write the chart legend */
  $image->setFontProperties(["FontName" => "pf_arma_five.ttf", "FontSize" => 6]);
  $image->drawLegend(800, 800, ["Style" => LEGEND_BOX, "Mode" => LEGEND_HORIZONTAL]);

  /* Render the picture (choose the best way) */
  $image->stroke();
});

Route::get('draw/barcicle/{val1}/{val2}/{val3}/{val4}/{class}', function ($val1,$val2,$val3,$val4,$class) {

  $data = new Data();
  $data->addPoints([$val1, 6.6 - $val1], "ScoreA");
  $data->setSerieDescription("ScoreA", "Application A");
  $data->loadPalette($class.".1.color", TRUE);

  $data2 = new Data();
  $data2->addPoints([$val2, 6.6 - $val2], "Score2");
  $data2->setSerieDescription("Score2", "Application 2");

  $data2->addPoints(["A0", "B1"], "Labels");
  $data2->setAbscissa("Labels");
  $data2->loadPalette($class.".2.color", TRUE);

  $data3 = new Data();
  $data3->addPoints([$val3, 6.6 - $val3], "Score3");
  $data3->setSerieDescription("Score3", "Application A");

  $data3->addPoints(["A0", "B1"], "Labels");
  $data3->setAbscissa("Labels");
  $data3->loadPalette($class.".3.color", TRUE);

  $data4 = new Data();
  $data4->addPoints([$val4, 6.6 - $val4], "Score4");
  $data4->setSerieDescription("Score4", "Application A");


  $data4->addPoints(["A0", "B1"], "Labels");
  $data4->setAbscissa("Labels");
  $data4->loadPalette($class.".4.color", TRUE);

  /* Define the absissa serie */
  $data->addPoints(["A0", "B1"], "Labels");
  $data->setAbscissa("Labels");
  /* Create the Image object */
  $image = new Image(300, 300, $data, true);

  /* Draw a solid background */

  /* Write the picture title */

  /* Set the default font properties */
  $image->setFontProperties([
      "FontName" => "Forgotte.ttf",
      "FontSize" => 10,
      "R" => 80,
      "G" => 80,
      "B" => 80
  ]);

  /* Enable shadow computing */
  /* Create the pPie object */
  $pieChart = new Pie($image, $data);

  /* Draw an AA pie chart */
  $pieChart->draw2DRing(100, 100, [
                                  "DrawLabels" => false, 
                                  "LabelStacked" => false, 
                                  "Border" => false,
                                  "BackgroundAlpha" => true,
                                  "OuterRadius" => 100,
                                  "InnerRadius" => 90,
                                  "WriteValues" => false]);
  
  $pieChart2 = new Pie($image, $data2);

  /* Draw an AA pie chart */
  $pieChart2->draw2DRing(100, 100, [
                                  "DrawLabels" => false, 
                                  "LabelStacked" => false, 
                                  "BackgroundAlpha" => true,
                                  "OuterRadius" => 80,
                                  "InnerRadius" => 70,
                                  "Border" => false,
                                  "WriteValues" => false]);

  $pieChart3 = new Pie($image, $data3);

  /* Draw an AA pie chart */
  $pieChart3->draw2DRing(100, 100, [
                                  "DrawLabels" => false, 
                                  "LabelStacked" => false, 
                                  "OuterRadius" => 60,
                                  "InnerRadius" => 50,
                                  "Border" => false,
                                  "WriteValues" => false]); 
                                  
  $pieChart4 = new Pie($image, $data4);

  /* Draw an AA pie chart */
  $pieChart4->draw2DRing(100, 100, [
                                  "DrawLabels" => false, 
                                  "LabelStacked" => false, 
                                  "OuterRadius" => 40,
                                  "InnerRadius" => 30,
                                  "Border" => false,
                                  "WriteValues" => false]); 

  /* Write the legend box */
  $image->setShadow(false);
  /* Render the picture (choose the best way) */
  $image->stroke();
  exit;
});


Route::get('draw/barcicle/{val1}/{val2}/{val3}/{class}', function ($val1,$val2,$val3,$class) {
 
  $data = new Data();
  $data->addPoints([$val1, 6.6 - $val1], "ScoreA");
  $data->setSerieDescription("ScoreA", "Application A");
  $data->loadPalette($class.".1.color", TRUE);

  $data2 = new Data();
  $data2->addPoints([$val2, 6.6 - $val2], "Score2");
  $data2->setSerieDescription("Score2", "Application 2");

  $data2->addPoints(["A0", "B1"], "Labels");
  $data2->setAbscissa("Labels");
  $data2->loadPalette($class.".2.color", TRUE);

  $data3 = new Data();
  $data3->addPoints([$val3, 6.6 - $val3], "Score3");
  $data3->setSerieDescription("Score3", "Application A");

  $data3->addPoints(["A0", "B1"], "Labels");
  $data3->setAbscissa("Labels");
  $data3->loadPalette($class.".3.color", TRUE);

  /* Define the absissa serie */
  $data->addPoints(["A0", "B1"], "Labels");
  $data->setAbscissa("Labels");
  /* Create the Image object */
  $image = new Image(300, 300, $data, true);

  /* Draw a solid background */

  /* Write the picture title */

  /* Set the default font properties */
  $image->setFontProperties([
      "FontName" => "Forgotte.ttf",
      "FontSize" => 10,
      "R" => 80,
      "G" => 80,
      "B" => 80
  ]);

  /* Enable shadow computing */
  /* Create the pPie object */
  $pieChart = new Pie($image, $data);

  /* Draw an AA pie chart */
  $pieChart->draw2DRing(100, 100, [
                                  "DrawLabels" => false, 
                                  "LabelStacked" => false, 
                                  "Border" => false,
                                  "BackgroundAlpha" => true,
                                  "OuterRadius" => 100,
                                  "InnerRadius" => 90,
                                  "WriteValues" => false]);
  
  $pieChart2 = new Pie($image, $data2);

  /* Draw an AA pie chart */
  $pieChart2->draw2DRing(100, 100, [
                                  "DrawLabels" => false, 
                                  "LabelStacked" => false, 
                                  "BackgroundAlpha" => true,
                                  "OuterRadius" => 72,
                                  "InnerRadius" => 62,
                                  "Border" => false,
                                  "WriteValues" => false]);

  $pieChart3 = new Pie($image, $data3);

  /* Draw an AA pie chart */
  $pieChart3->draw2DRing(100, 100, [
                                  "DrawLabels" => false, 
                                  "LabelStacked" => false, 

                                  "OuterRadius" => 45,
                                  "InnerRadius" => 35,
                                  "Border" => false,
                                  "WriteValues" => false]);                                

  /* Write the legend box */
  $image->setShadow(false);
  /* Render the picture (choose the best way) */
  $image->stroke();
  exit;
});
Route::get('draw/barcicle/{val1}/{val2}/{class}', function ($val1,$val2,$class) {
 
  $data = new Data();
  $data->addPoints([$val1, 6.6 - $val1], "ScoreA");
  $data->setSerieDescription("ScoreA", "Application A");
  $data->loadPalette($class.".1.color", TRUE);

  $data2 = new Data();
  $data2->addPoints([$val2, 6.6 - $val2], "Score2");
  $data2->setSerieDescription("Score2", "Application 2");

  $data2->addPoints(["A0", "B1"], "Labels");
  $data2->setAbscissa("Labels");
  $data2->loadPalette($class.".2.color", TRUE);


  /* Define the absissa serie */
  $data->addPoints(["A0", "B1"], "Labels");
  $data->setAbscissa("Labels");
  /* Create the Image object */
  $image = new Image(300, 300, $data, true);

  /* Draw a solid background */

  /* Write the picture title */

  /* Set the default font properties */
  $image->setFontProperties([
      "FontName" => "Forgotte.ttf",
      "FontSize" => 10,
      "R" => 80,
      "G" => 80,
      "B" => 80
  ]);

  /* Enable shadow computing */
  /* Create the pPie object */
  $pieChart = new Pie($image, $data2);

  /* Draw an AA pie chart */
  $pieChart->draw2DRing(100, 100, [
                                  "DrawLabels" => false, 
                                  "LabelStacked" => false, 
                                  "Border" => false,
                                  "BackgroundAlpha" => true,
                                  "OuterRadius" => 100,
                                  "InnerRadius" => 85,
                                  "WriteValues" => false]);
  
  $pieChart2 = new Pie($image, $data);

  /* Draw an AA pie chart */
  $pieChart2->draw2DRing(100, 100, [
                                  "DrawLabels" => false, 
                                  "LabelStacked" => false, 
                                  "BackgroundAlpha" => true,
                                  "OuterRadius" => 62,
                                  "InnerRadius" => 47,
                                  "Border" => false,
                                  "WriteValues" => false]);

  /* Write the legend box */
  $image->setShadow(false);
  /* Render the picture (choose the best way) */
  $image->stroke();
  exit;
});

Route::get('draw/piechart/{val1}/{val2}/{val3}', function ($val1,$val2,$val3) {
 
  $data = new Data();
  $data->addPoints([$val1, $val2, $val3], "ScoreA");
  $data->setSerieDescription("ScoreA", "Application A");
  $data->loadPalette("grande.color", TRUE);


  /* Define the absissa serie */
  $data->addPoints(["A0", "B1", "C1"], "Labels");
  $data->setAbscissa("Labels");
  /* Create the Image object */
  $image = new Image(800, 800, $data, true);

  /* Draw a solid background */

  /* Write the picture title */

  /* Set the default font properties */
  $image->setFontProperties([
      "FontName" => "Forgotte.ttf",
      "FontSize" => 30,
      "R" => 255,
      "G" => 255,
      "B" => 255
  ]);

  /* Enable shadow computing */
  /* Create the pPie object */
  $pieChart = new Pie($image, $data);

  /* Draw an AA pie chart */
  $pieChart->draw2DRing(300, 300, [
                                  "DrawLabels" => false, 
                                  "LabelStacked" => false, 
                                  "Border" => false,
                                  "BackgroundAlpha" => true,
                                  "OuterRadius" => 300,
                                  "InnerRadius" => 200,
                                  "WriteValues" => true,
                                  "ValuePosition" => PIE_VALUE_INSIDE]);
  

  
  /* Write the legend box */
  $image->setShadow(false);
  /* Render the picture (choose the best way) */
  $image->stroke();
  exit;
});

