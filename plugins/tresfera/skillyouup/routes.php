<?php
use CpChart\Chart\Radar;
use CpChart\Chart\Pie;
use CpChart\Data;
use CpChart\Image;
use Tresfera\Skillyouup\Models\Rapport;

Route::get('rapport/skillyouup/', function () {
 
  $evaluacion = \Tresfera\Skillyouup\Models\Equipo::find(get("id"));

  $rapport = new Rapport();
  $rapport->evaluacion_id = $evaluacion->id;
  $rapport->save();
  $rapport->generateData(get("player"));
  $rapport->generatePdf();

  return \Redirect::to($rapport->getUrl());

});

