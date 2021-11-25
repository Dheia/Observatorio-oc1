<?php
use CpChart\Chart\Radar;
use CpChart\Chart\Pie;
use CpChart\Data;
use CpChart\Image;
use Tresfera\Talentapp\Models\Rapport;

Route::get('draw/graph/{val1}/{val2}/{val3}/{val4}', function ($val1,$val2,$val3,$val4) {
  $data = new Data();
  $data->addPoints([-3,1,0,-2], "ScoreA");
  $myPicture = new Image(930,646,$data, true); 
 // $myPicture->setGraphArea(20,20,480,210);
  //$myPicture->drawFilledRectangle(0,0,270,190,array("R"=>255,"G"=>255,"B"=>255,"Surrounding"=>-200,"Alpha"=>10));
 // $myPicture->drawScale(array("Pos"=>SCALE_POS_TOPBOTTOM,"DrawSubTicks"=>FALSE));
  //$myPicture->setShadow(TRUE,array("X"=>-1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>0));
 // $myPicture->drawLineChart(["DisplayValues"=>FALSE,"DisplayColor"=>DISPLAY_AUTO]);
 // $myPicture->setShadow(FALSE);
 /* $AxisBoundaries = array(0=>array("Min"=>0,"Max"=>3),1=>array("Min"=>-3,"Max"=>3));
  $scaleSettings  = array("GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE,"Mode"=>SCALE_MODE_MANUAL, "ManualScale"=>$AxisBoundaries);
  $myPicture->drawScale($scaleSettings);
*/



  $positions['val1']["x"] = ($val1+3)*910/6;
  $positions['val1']["y"] = 10;
  $positions['val1']["CircleSettings"] = array("R"=>238,"G"=>46,"B"=>170,"Alpha"=>100,"Surrounding"=>30);

  $positions['val2']["x"] = ($val2+3)*910/6;
  $positions['val2']["y"] = 140;
  $positions['val2']["CircleSettings"] = array("R"=>124,"G"=>122,"B"=>255,"Alpha"=>100,"Surrounding"=>30);

  $positions['val3']["x"] = ($val3+3)*910/6;
  $positions['val3']["y"] = 275;
  $positions['val3']["CircleSettings"] = array("R"=>103,"G"=>215,"B"=>173,"Alpha"=>100,"Surrounding"=>30);

  $positions['val4']["x"] = ($val4+3)*910/6;
  $positions['val4']["y"] = 415;
  $positions['val4']["CircleSettings"] = array("R"=>243,"G"=>205,"B"=>86,"Alpha"=>100,"Surrounding"=>30);

  foreach($positions as $position) {
    if($position["x"] < 5) $position["x"] = 5; 
  }  

  $myPicture->drawLine($positions['val1']["x"],$positions['val1']["y"],$positions['val2']["x"],$positions['val2']["y"]);
  $myPicture->drawLine($positions['val2']["x"],$positions['val2']["y"],$positions['val3']["x"],$positions['val3']["y"]);
  $myPicture->drawLine($positions['val3']["x"],$positions['val3']["y"],$positions['val4']["x"],$positions['val4']["y"]);
  foreach($positions as $position) {
    $CircleSettings = $position["CircleSettings"];
    $myPicture->drawFilledCircle($position["x"],$position["y"],10,$CircleSettings);
  }  
  /* Render the picture (choose the best way) */
  $myPicture->stroke();
  exit;
});

Route::get('draw/barcicle/{val1}/{class}', function ($val1,$class) {
 
  $data = new Data();
  $data->addPoints([$val1, 100 - $val1], "ScoreA");
  $data->setSerieDescription("ScoreA", "Application A");
  $data->loadPalette($class.".color", TRUE);


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
                                  "InnerRadius" => 45,
                                  "WriteValues" => false]);

  /* Write the legend box */
  $image->setShadow(false);
  /* Render the picture (choose the best way) */
  $image->stroke();
  exit;
});


