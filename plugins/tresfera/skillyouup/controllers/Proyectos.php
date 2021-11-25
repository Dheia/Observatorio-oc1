<?php namespace Tresfera\Skillyouup\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Flash;
use Redirect;
use Backend;
use Renatio\DynamicPDF\Classes\PDF;
use Session;

// Models
use Tresfera\Skillyouup\Models\Proyecto;
use Tresfera\Skillyouup\Models\Equipo;
use Tresfera\Skillyouup\Models\Cuestionario;
use Tresfera\Skillyouup\Models\Equipo_Evaluador;
use Tresfera\Skillyouup\Classes\UserControl;

class Proyectos extends Controller
{
    public $implement = [
      'Backend\Behaviors\ListController',
      'Backend\Behaviors\FormController',
      'Backend.Behaviors.RelationController',
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $dates = ['fecha_inicio','fecha_fin'];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Tresfera.Skillyouup', 'skillyouup');
        // $this->addCss("/plugins/tresfera/skillyouup/assets/css/custom.css", "1.0.0");
    }

    public function generateRapport($model_id) {

      $model = \Tresfera\Skillyouup\Models\Proyecto::with("equipos")->find($model_id); 
      $equipos = Session::get('skillyouup::proyecto::'.$model_id, $model->equipos->lists("id","name"));
      if(isset($equipos[0])) {
        $equipos = $equipos[count($equipos)-1];
      }

      $data = \Tresfera\Skillyouup\Models\Rapport::getDataRapport($equipos);

      //num teams
      $numTeams = $model->equipos->count();
      if(count($equipos) == 1) { //si solo hay un equipo seleccionado
        foreach($equipos as $equipo => $id) {
          $data['name_equipo'] = $equipo;
          $equipoObj = \Tresfera\Skillyouup\Models\Equipo::find($id);
          $players = [];
          foreach($equipoObj->getPlayers() as $player)
            $players[] = $player['name'];
          $data['name_players'] = implode(" | ", $players);
        }
      } else {
        $data['name_proyecto'] = $model->name;
        $data['name_equipos'] = implode(" | ", array_keys($equipos));
      }

      return PDF::loadTemplate('skillyouup',$data)
                            ->setOptions(['isRemoteEnabled' => true,'dpi' => 150])
                            ->stream();


    }

    public function onFilterUpdate($model_id) {
      $model = \Tresfera\Skillyouup\Models\Proyecto::with("equipos")->find($model_id); 
     
      $equipos = $model->equipos;
      if(post("options[active]")) {
        $options = [];
        foreach(post("options[active]") as $option) {
          $options[] = $option['id'];
        }
        $equipos = $equipos->filter(function ($item) use ($options) {
          return in_array($item->id,$options);
        });
      }

      Session::push('skillyouup::proyecto::'.$model_id, $equipos->lists("id","name"));
      
      $data = \Tresfera\Skillyouup\Models\Rapport::getDataRapport($equipos->lists("id","name"));

      return [
        '#stats_partial' => $this->makePartial('stats_partial',["equipos"=>$equipos,"data"=>$data])
      ];
    }
    /*
    public function crear_equipo()
    {
      $this->pageTitle = "Nueva Evaluación";
      $id = $this->params[0];
      $model = Proyecto::find($id);
      if(!$model) return Redirect::back();
      return $this->makePartial('create_eval', ['model' => $model]);
    }

    public function editar_equipo()
    {
      $this->pageTitle = "Editar Evaluación";
      $id = $this->params[0];
      $model = Equipo::find($id);
      if(!$model) return Redirect::back();
      return $this->makePartial('edit_eval', ['model' => $model]);
    }
*/
    public function muestra()
    {
      return $this->makePartial('muestra/index');
    }

    public function onSend() {
      $form = request();
      $equipo = \Tresfera\Skillyouup\Models\Equipo::find($form['id']);
      if(!isset($equipo->id)) {
        \Flash::error("No existe este equipo.");
        return [];
      }

      $players = $equipo->players;
    
      foreach($players as $player) {
        if(!isset($player['email']) || $player['email'] == "") continue;
          \Mail::queue('skillyouup.require.answer.evaluador', $data, function($message) use ($player)
          {
              $message->to($player['email'],$player['name']);
          });
        
      }

     \Flash::success("Informes enviados correctamente.");
      return \Redirect::back();
    }

    public function p()
    {
      $id = $this->params[0];
      if( isset($this->params[1]) && $this->params[1]=="equipo")
      {
        $equipo_id = $this->params[2];
        $model = Equipo::where('id',$equipo_id)->where('proyecto_id',$id)->first();
        if(!$model) return Redirect::back();
        $evaluado = UserControl::getFullName($model->evaluado_id);
        $this->pageTitle = "Evaluación: ".$evaluado;
        return $this->makePartial('detalles_eval', ['model' => $model, 'evaluado' => $evaluado]);
      }
      else if( isset($this->params[1]) && $this->params[1]=="gestion_equipo")
      {
        $equipo_id = $this->params[2];
        $model = Equipo::where('id',$equipo_id)->where('proyecto_id',$id)->first();
        if(!$model) return Redirect::back();
        $evaluado = UserControl::getFullName($model->evaluado_id);
        $this->pageTitle = "Gestión de la Evaluación: ".$evaluado;
        return $this->makePartial('gestion_equipo', ['model' => $model, 'evaluado' => $evaluado]);
      }
      else
      {
        $model = Proyecto::find($id);
        if(!$model) return Redirect::back();
        $this->pageTitle = $model->name;
        return $this->makePartial('detalles_proyecto', ['model' => $model]);
      }
    }

    public function gestion()
    {
      $id = $this->params[0];
      $model = Proyecto::find($id);
      if(!$model) return Redirect::back();
      $this->pageTitle = "Gestión del Proyecto: ".$model->name;
      return $this->makePartial('proyecto_gestor', ['model' => $model]);
    }

    public function formExtendFields($form)
    {
      if($this->user->role_id == 4) {
        $form->removeField("gestores");
        $form->removeField("num_licencias");
        $form->removeField("client_id");
      }
      if($this->user->role_id == 3) {
        $form->removeField("gestores");
        $form->removeField("num_licencias");
        $form->removeField("client_id");
        $form->removeField("description");
        $form->removeField("description");
      }
      if($this->user->role_id == 5) {
        $field = $form->fields["client_id"];
        $field['type'] =  "number";
        $field['default'] = $this->user->client_id;
        $field['cssClass'] = "hidden";


        $form->removeField("client_id");
        $form->removeField("num_licencias");
        $form->addFields(["client_id" => $field]);

      }
    }

    // Handlers

    /*
    public function onSaveEval()
    {
      $post = post();
      $proyecto_id = $post['proyecto_id'];
      $evaluado_id = $post['evaluado_id'];
      $preguntas_evaluado = $post['preguntas_evaluado'];
      $preguntas_evaluador = $post['preguntas_evaluador'];
      if( isset($post['list_incluidos']) ) $list_incluidos = $post['list_incluidos'];
      else $list_incluidos = null;

      $equipo = [
                      'proyecto_id' => $proyecto_id,
                      'evaluado_id' => $evaluado_id
                    ];
      $equipo_id = Equipo::insertGetId( $equipo );

      $cuestionario_evaluado = [
                                  'equipo_id' => $equipo_id,
                                  'preguntas' => $preguntas_evaluado
                               ];
      $cuestionario_evaluado_id = Cuestionario::insertGetId( $cuestionario_evaluado );

      $cuestionario_evaluador = [
                                  'equipo_id' => $equipo_id,
                                  'preguntas' => $preguntas_evaluador
                               ];
      $cuestionario_evaluador_id = Cuestionario::insertGetId( $cuestionario_evaluador );

      Equipo::where('id', $equipo_id)->update(['cuestionario_evaluado_id' => $cuestionario_evaluado_id, 'cuestionario_evaluador_id' => $cuestionario_evaluador_id]);


      if($list_incluidos != null)
      {
        $lista = array_map( function($evaluador_id) use ($equipo_id) {
                              return [ 'eval' => $equipo_id, 'evaluador' => $evaluador_id ];
                            },
                            $list_incluidos
                          );
        Evaluacion_Evaluador::insert($lista);
      }

      Flash::success('Evaluación añadida correctamente');
      return Redirect::to( Backend::url('tresfera/skillyouup/proyectos/update/'.$proyecto_id) );

      // [{"pregunta":"pregunta 1 evaluado","tipoRespuesta":"1"},{"pregunta":"pregunta 2 evaluado","tipoRespuesta":"2","respuestas":["respuesta 1","respuesta 2"]}]

    }*/

    public function onDeleteEval()
    {
      Equipo::find( post('id_equipo') )->delete();
      return Flash::success("La evaluación ha sido eliminado correctamente");
    }

}
