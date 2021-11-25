<?php namespace Tresfera\Talent\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Flash;
use Redirect;
use Backend;

// Models
use Tresfera\Talent\Models\Proyecto;
use Tresfera\Talent\Models\Evaluacion;
use Tresfera\Talent\Models\Cuestionario;
use Tresfera\Talent\Models\Evaluacion_Evaluador;
use Tresfera\Talent360\Classes\UserControl;

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
        BackendMenu::setContext('Tresfera.Talent', 'talent');
        // $this->addCss("/plugins/tresfera/talent/assets/css/custom.css", "1.0.0");
    }
    /*
    public function crear_evaluacion()
    {
      $this->pageTitle = "Nueva Evaluación";
      $id = $this->params[0];
      $model = Proyecto::find($id);
      if(!$model) return Redirect::back();
      return $this->makePartial('create_eval', ['model' => $model]);
    }

    public function editar_evaluacion()
    {
      $this->pageTitle = "Editar Evaluación";
      $id = $this->params[0];
      $model = Evaluacion::find($id);
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
      $evaluacion = \Tresfera\Talent\Models\Evaluacion::find($form['id']);
      if(!isset($evaluacion->id)) {
        \Flash::error("No existe esta evaluación.");
        return [];
      }
      $user = \Backend\Models\User::find($evaluacion->user_id);

      if($evaluacion->estado != 1) {
        \Flash::error("Ya se ha enviado esta evaluación.");
        return [];
      }
      $stats = $evaluacion->getEvaluadores();
      if(!is_array($stats)) $stats = [];
      $stats['autoevaluado'][$evaluacion->email] = [
                                            'name' => $evaluacion->name,
                                            'email'=> $evaluacion->email,
                                            'url' => $evaluacion->getUrl($evaluacion->email),
                                            'send_at' => \Carbon\Carbon::now(),
                                            'completed_at' => '',
                                            'send' => 1,
                                            'completed' => 0
                                          ];
      
      $stats["numTotal"] =1;
      $stats["numAnswered"]=0;
      foreach($evaluacion->tipo as $tipo=>$text) {
        if(isset($evaluacion->$text))
        foreach($evaluacion->$text as $contacto) {
          $stats[$text][$contacto['email']] = [
                                                'name' => $contacto['name'],
                                                'email'=> $contacto['email'],
                                                'url' => $evaluacion->getUrl($contacto['email'],$text),
                                                'send_at' => \Carbon\Carbon::now(),
                                                'completed_at' => '',
                                                'send' => 1,
                                                'completed' => 0
                                              ];

          
          $data = [
            "name" => $contacto['name'],
            "username" => $user->login,
            "url" => $stats[$text][$contacto['email']]['url'],
            "date" => $evaluacion->proyecto->fecha_fin,
            "name_evaluado" => $user->first_name,
          ];
          \Mail::queue('talent.require.answer.evaluador', $data, function($message) use ($contacto)
          {
              $message->to($contacto['email'],$contacto['name']);
          });
          $stats["numTotal"]++;
        }
      }


      $evaluacion->stats = $stats;
      //$evaluacion->estado = 2;
      $evaluacion->save();
      \Flash::success("Evaluación enviada correctamente.");
      return \Redirect::back();
    }

    public function p()
    {
      $id = $this->params[0];
      if( isset($this->params[1]) && $this->params[1]=="evaluacion")
      {
        $evaluacion_id = $this->params[2];
        $model = Evaluacion::where('id',$evaluacion_id)->where('proyecto_id',$id)->first();
        if(!$model) return Redirect::back();
        $evaluado = UserControl::getFullName($model->evaluado_id);
        $this->pageTitle = "Evaluación: ".$evaluado;
        return $this->makePartial('detalles_eval', ['model' => $model, 'evaluado' => $evaluado]);
      }
      else if( isset($this->params[1]) && $this->params[1]=="gestion_evaluacion")
      {
        $evaluacion_id = $this->params[2];
        $model = Evaluacion::where('id',$evaluacion_id)->where('proyecto_id',$id)->first();
        if(!$model) return Redirect::back();
        $evaluado = UserControl::getFullName($model->evaluado_id);
        $this->pageTitle = "Gestión de la Evaluación: ".$evaluado;
        return $this->makePartial('gestion_evaluacion', ['model' => $model, 'evaluado' => $evaluado]);
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
    public function listExtendQuery($query)
    {
        $user = \BackendAuth::getUser();
        if(isset($user->id)) {
            if($user->hasPermission(["talent.gestor"])) {
                $proyectos_gestor = \Tresfera\Talent\Models\Gestor::getProyectos();
                $query->whereIn('id', $proyectos_gestor);
            }
        }
    }
    public function formExtendFields($form)
    {
      $user = \BackendAuth::getUser();
        if(isset($user->id)) {
          if($user->hasPermission(["talent.gestor"])) {
            $form->removeField("gestores");
            $field = $form->fields["num_licencias"];
            $field['readOnly'] =  true;
            $form->addFields(["num_licencias" => $field]);

            $field = $form->fields["client_id"];
            $field['readOnly'] =  true;
            $form->addFields(["client_id" => $field]);
          }
        }
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

      $evaluacion = [
                      'proyecto_id' => $proyecto_id,
                      'evaluado_id' => $evaluado_id
                    ];
      $evaluacion_id = Evaluacion::insertGetId( $evaluacion );

      $cuestionario_evaluado = [
                                  'evaluacion_id' => $evaluacion_id,
                                  'preguntas' => $preguntas_evaluado
                               ];
      $cuestionario_evaluado_id = Cuestionario::insertGetId( $cuestionario_evaluado );

      $cuestionario_evaluador = [
                                  'evaluacion_id' => $evaluacion_id,
                                  'preguntas' => $preguntas_evaluador
                               ];
      $cuestionario_evaluador_id = Cuestionario::insertGetId( $cuestionario_evaluador );

      Evaluacion::where('id', $evaluacion_id)->update(['cuestionario_evaluado_id' => $cuestionario_evaluado_id, 'cuestionario_evaluador_id' => $cuestionario_evaluador_id]);


      if($list_incluidos != null)
      {
        $lista = array_map( function($evaluador_id) use ($evaluacion_id) {
                              return [ 'eval' => $evaluacion_id, 'evaluador' => $evaluador_id ];
                            },
                            $list_incluidos
                          );
        Evaluacion_Evaluador::insert($lista);
      }

      Flash::success('Evaluación añadida correctamente');
      return Redirect::to( Backend::url('tresfera/talent/proyectos/update/'.$proyecto_id) );

      // [{"pregunta":"pregunta 1 evaluado","tipoRespuesta":"1"},{"pregunta":"pregunta 2 evaluado","tipoRespuesta":"2","respuestas":["respuesta 1","respuesta 2"]}]

    }*/

    public function onDeleteEval()
    {
      Evaluacion::find( post('id_evaluacion') )->delete();
      return Flash::success("La evaluación ha sido eliminado correctamente");
    }

}
