<?php namespace Tresfera\Buildyouup\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Renatio\DynamicPDF\Classes\PDF;
use Tresfera\Taketsystem\Models\Result;
use Tresfera\Buildyouup\Models\Rapport;
use Queue;

class Equipos extends Controller
{
    public $implement = [        
      'Backend\Behaviors\ListController',        
      'Backend\Behaviors\FormController'    
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        //$this->addCss("/plugins/tresfera/buildyouup/assets/css/custom.css", "1.0.0");
    }

    public function onSendEmailInformePlayer() {
      $id = get("id");
      $player1 = get("player");
     
      $equipo = \Tresfera\Buildyouup\Models\Equipo::find($id);
      if(!isset($equipo->id)) {
        \Flash::error("No existe este equipo.");
        return [];
      }

      $players = $equipo->players;
    
      foreach($players as $player) {
        if(!isset($player['email']) || $player['email'] == "") continue;
        if($player['name'] != $player1) continue;

        $data = [
            "name" => $player['name'],
            "url" => ('https://buildyouup.taket.es/rapport/buildyouup/?id='.$equipo->id.'&player='.urlencode($player['name'])),
        ]; 
        \Flash::success("Hemos enviado el informe");
        \Mail::queue('buildyouup.sendrapport.player', $data, function($message) use ($player)
          {
              $message->to($player['email'],$player['name']);
          });
      }
      
      return \Redirect::back();
    }
    public function showRapport() {
      $evaluacion = \Tresfera\Buildyouup\Models\Equipo::find(get("id"));

      $rapport = new Rapport();
      $rapport->evaluacion_id = $evaluacion->id;
      $rapport->save();
      $rapport->generateData(get("player"));
      $rapport->generatePdf();

      return \Redirect::to($rapport->getUrl());

      if(in_array('autoevaluacion',$evaluacion->tipo)) {

        $data = SELF::getDataAutoevaluadoRapport(get("id"));

        //$data['competencias_masvaloradas'] = $competencias_masvaloradas->toArray();
   
        return PDF::loadTemplate('buildyouup:autoevaluacion',$data)
                               ->setOptions(['isRemoteEnabled' => true,'dpi' => 150])
                               ->setPaper('a4', 'landscape')->stream();
      }
      $data = SELF::getDataRapport(get("id"));

     //$data['competencias_masvaloradas'] = $competencias_masvaloradas->toArray();

     return PDF::loadTemplate('renatio::invoice',$data)
                            ->setOptions(['isRemoteEnabled' => true,'dpi' => 150])
                            ->setPaper('a4', 'landscape')->stream();
    }

    public function onCompleted() {
      $evaluacion = \Tresfera\Buildyouup\Models\Equipo::find(get("id"));
      $stats = $evaluacion->stats;
      $stats["numAnswered"]++;
      $stats[get("tipo")][get("email")]["completed"] = true;
      $stats[get("tipo")][get("email")]["completed_at"] = \Carbon\Carbon::now();
      $evaluacion->stats = $stats;
      if($stats["numAnswered"] == $stats["numTotal"]) {
        $evaluacion->estado = 3;
      }
      $evaluacion->save();
    }
    public function formExtendFields($form,$record)
    {
      if(isset($this->params[0])) {
        $evaluacion = \Tresfera\Buildyouup\Models\Equipo::find($this->params[0]);
      }
      if($this->user->role_id == 3) {
        
        if(isset($evaluacion->tipo))
          foreach($record['tipo']->config['options'] as $name=>$null) {
            if(!in_array($name,$evaluacion->tipo))
              $form->removeField($name);
          }

        $form->removeField('params[permissions]');
        if($form->model->estado == 1 || true) {
          if(!is_array($record['params[permissions]']->value)) $record['params[permissions]']->value = [];
          if(!in_array("change_evaluadores",$record['params[permissions]']->value)) {
            
            $form->removeField('jefe');
            $form->removeField('companero');
            $form->removeField('colaborador');
            $form->removeField('otro');

          }
          if(!in_array("change_tipo",$record['params[permissions]']->value)) {
            $fields = $form->fields;
            foreach($form->fields as $name => $field) {
              if($name == 'tipo')
                $fields[$name]['readOnly'] = true;
              $form->removeField($name);
            }
            $form->addFields($fields);

            $form->removeField('stats_partial');
          }
        } else {
          $fields = $form->fields;
          foreach($form->fields as $name => $field) {
            $fields[$name]['readOnly'] = true;
            $form->removeField($name);
          }
          $form->addFields($fields);
          $form->removeField('jefe');
          $form->removeField('companero');
          $form->removeField('colaborador');
          $form->removeField('otro');

        }

      }
    }

    
}
