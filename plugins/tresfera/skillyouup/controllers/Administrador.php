<?php namespace Tresfera\Skillyouup\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Queue;

use Tresfera\Skillyouup\Models\Equipo;


class Administrador extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend\Behaviors\ImportExportController'
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $importExportConfig = 'config_import_export.yaml';
    
    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Tresfera.Skillyouup', 'skillyouup', 'administrador');
        $this->addCss("/plugins/tresfera/skillyouup/assets/css/custom.css", "1.0.0");
    }

    public function importar() {
        $this->pageTitle = "Importar Proyectos desde fichero .CSV";
        return $this->makePartial("importar", []);
    }

    public function onFilter()
    {
         return ['#estadisticas' => $this->makePartial('estadisticas')];
        //return $this->makePartial("estadisticas");
    }
    public function onGenerateRapports() {
        $ids = post("checked");

        foreach($ids as $id) {
            $evaluacion = Equipo::find($id);
            $evaluacion->estado_informe = 1; 
            $evaluacion->save();
            Queue::push('\Tresfera\Skillyouup\Classes\Jobs\GenerateRapport',$id,"rapports");
        }
        \Flash::success("Hemos empezado a procesar los informes.");
        return $this->listRefresh();
    }
    public function onDownloadRapports() {
        $ids = post("checked");

        Queue::push('\Tresfera\Skillyouup\Classes\Jobs\SendRapport',$ids,"sendrapports");
       
        \Flash::success("Preparando informes para descargar. Se enviarán a tu email.");
        return $this->listRefresh();
    }

    public function onSendEmailActivacion($ambos = false)
    {
        $ids = post("checked");
        if(!$ids)
        {
            $ids = [];
            array_push($ids, get("id"));
        }

        foreach($ids as $id)
        {
            $evaluacion = Equipo::find($id);

            $theme = 'skillyouup.require.aprovacion';
            if($evaluacion->lang == "en") $theme .= "_en";
    
            $user = \Backend\Models\User::find($evaluacion->user_id);
            $data = [
                "name" => $evaluacion->name,
                "username" => $user->login,
                "name_evaluado" => $user->first_name,
                "url_backend" => url("/backend"),
                "date" => $evaluacion->proyecto->fecha_fin,
                "password" => $evaluacion->password
            ];
    
            \Mail::send($theme, $data, function($message) use ($evaluacion)
            {
                $message->to($evaluacion->email,$evaluacion->name);
            });
           
        }
        
        if(!$ambos)
        {
            \Flash::success("Hemos enviado los correos de activación a los usuarios seleccionados.");
            return \Redirect::to("/backend/tresfera/skillyouup/administrador");
        }
        
    }

    public function onSendEmailRecordatorio($ambos = false) 
    {
        $ids = post("checked");
        if(!$ids)
        {
            $ids = [];
            array_push($ids, get("id"));
        }
       
        foreach($ids as $id)
        {
            $evaluacion = Equipo::find($id);
            $stats = $evaluacion->getEvaluadores();
            if(!is_array($evaluacion->getEvaluadores())) return;
            foreach($evaluacion->getEvaluadores() as $tipo=>$evaluadores) {
                if(is_array($evaluadores))
                foreach($evaluadores as $evaluador) {
                    $statsAs = $stats[$tipo][$evaluador['email']];
                    if(
                        (!$evaluacion->isCompletedEvaluador($evaluador['email']) && $tipo != "autoevaluado")
                        || 
                        (!$evaluacion->isCompletedAutoevaluado() && $tipo == "autoevaluado"))  {
                        $user = \Backend\Models\User::find($evaluacion->user_id);
                        $data = [
                            "name" => $evaluador['name'],
                            "username" => $user->login,
                            "name_evaluado" => $user->first_name,
                            "url" => $evaluacion->stats[$tipo][$evaluador['email']]['url'],
                            "date" => $evaluacion->proyecto->fecha_fin
                        ];
                        
                        $theme = 'skillyouup.warning.evaluador.datafinish.standard';
                        if($tipo == "autoevaluado")
                            $theme = 'skillyouup.warning.evaluado.datafinish.standard';
                        
                        if(isset($evaluador['lang'])  && $evaluador['lang'] == "en")
                            $theme .= "_en";
                        elseif(isset($evaluador['lang'])  && $evaluador['lang'] == "es") {

                        } else {
                            $lang = $evaluacion->lang;
                            if($lang == "en") {
                                $theme .= "_en";
                            } elseif($lang == "es") {
                            } else {
                                $lang = $evaluacion->proyecto->lang;
                                if($lang == "en") {
                                    $theme .= "_en";
                                } elseif($lang == "es") {
                                } else {

                                }
                            }
                        }    

                        \Mail::send($theme, $data, function($message) use ($evaluador)
                        {
                            $message->to($evaluador['email'],$evaluador['name']);
                        });
                    } 
                }
            }
        }

        if(!$ambos)
        {
            \Flash::success("Hemos enviado los correos de recordatorio a los usuarios seleccionados.");
            return \Redirect::to("/backend/tresfera/skillyouup/administrador");
        }
    }

    public function onSendEmailActivacionRecordatorio()
    {
        $this->onSendEmailActivacion(true);
        $this->onSendEmailRecordatorio(true);
        \Flash::success("Hemos enviado los correos de activación y de recordatorio a los usuarios seleccionados.");
        return \Redirect::to("/backend/tresfera/skillyouup/administrador");
    }

    public function onPermisoVerInforme()
    {
        $ids = post("checked");
        $permiso = post("permiso");
        if(!$ids)
        {
            $ids = [];
            array_push($ids, get("id"));
        }
        if(!$permiso)
        {
            $permiso = get("permiso");
        }

        foreach($ids as $id)
        {
            $evaluacion = Equipo::find($id);

            $tmp = [];
            foreach($evaluacion->params as $t => $permisos)
            {
                if($t == "permissions")
                {
                    if($permiso == 1)
                    {
                        $tmp = $permisos;
                        if(!in_array("view_report", $tmp)) array_push($tmp, "view_report");
                    }
                    else if($permiso == 0)
                    {
                        foreach($permisos as $p)
                        {
                            if($p != "view_report")
                            {
                                array_push($tmp, $p);
                            }
                        }
                    }
                }
            }
            $evaluacion->params = [ "permissions" => $tmp ];
            $evaluacion->save();
        }
        

        if($permiso == 0) \Flash::success("Hemos eliminado el permiso para ver informes a todos los seleccionados.");
        if($permiso == 1) \Flash::success("Hemos dado permiso para ver informes a todos los seleccionados.");

        return \Redirect::to("/backend/tresfera/skillyouup/administrador");
    }

    public function onDownloadDatosBrutos()
    {
        Queue::push('\Tresfera\Skillyouup\Classes\Jobs\ExportResultAnswer',[],"exportdatosbrutos");
        \Flash::success("Hemos empezado a generar el informe. Enviaremos un email a tu correo cuando esté listo para descargar.");
    }
    public function onSendEmailInformePlayers() {
        $ids = post("checked");
        if(!$ids)
        {
            $ids = [];
            array_push($ids, get("id"));
        }
        foreach($ids as $id)
        {
            $equipo = \Tresfera\Skillyouup\Models\Equipo::find($id);
            if(!isset($equipo->id)) {
              \Flash::error("No existe este equipo.");
              return [];
            }
      
            $players = $equipo->players;
          
            foreach($players as $player) {
              if(!isset($player['email']) || $player['email'] == "") continue;
              $data = [
                  "name" => $player['name'],
                  "url" => ('https://skillyouup.taket.es/rapport/skillyouup/?id='.$equipo->id.'&player='.urlencode($player['name'])),
              ]; 
              \Mail::queue('skillyouup.sendrapport.player', $data, function($message) use ($player)
                {
                    $message->to($player['email'],$player['name']);
               });
            }
        }
        \Flash::success("Hemos enviado los correos de recordatorio de asignación a los usuarios seleccionados que no aun han asignado ningún evaluador.");
        return \Redirect::to("/backend/tresfera/skillyouup/administrador");
    }
    public function onSendEmailRecordatorioAsignacion()
    {
        $ids = post("checked");
        if(!$ids)
        {
            $ids = [];
            array_push($ids, get("id"));
        }
        foreach($ids as $id)
        {
            $evaluacion = Equipo::find($id);
            $min = count($evaluacion->jefe )+count($evaluacion->companero)+count($evaluacion->colaborador)+count($evaluacion->otro);

            if( $min < 9
                && !in_array("autoevaluacion",$evaluacion->tipo) 
                && isset($evaluacion->params['permissions']) 
                && is_array($evaluacion->params['permissions']) 
                && in_array("change_evaluadores",$evaluacion->params['permissions'])
                && isset($evaluacion->proyecto) 
                && !$evaluacion->proyectoFinalizado() // proyecto no finalizado
            )
            {
                Queue::push('\Tresfera\Skillyouup\Classes\Jobs\SendRecordatorioAsignacion',$id,"sendemailasignacion");
            }
        }
        \Flash::success("Hemos enviado los correos de recordatorio de asignación a los usuarios seleccionados que no aun han asignado ningún evaluador.");
        return \Redirect::to("/backend/tresfera/skillyouup/administrador");
    }


    public function pruebas()
    {
        $this->makePartial('pruebas');
    }
    
}
