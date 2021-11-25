<?php namespace Tresfera\Talentapp\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Queue;

use Tresfera\Talentapp\Models\Evaluacion;
use Tresfera\Talentapp\Models\Proyecto;


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
        BackendMenu::setContext('Tresfera.Talentapp', 'talentapp', 'administrador');
        $this->addCss("/plugins/tresfera/talentapp/assets/css/custom.css", "1.0.0");
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
            $evaluacion = Evaluacion::find($id);
            $evaluacion->estado_informe = 1; 
            $evaluacion->save();
            Queue::push('\Tresfera\Talentapp\Classes\Jobs\GenerateRapport',$id,"rapports");
        }
        \Flash::success("Hemos empezado a procesar los informes.");
        return $this->listRefresh();
    }
    public function onDownloadRapports() {
        $ids = post("checked");

        Queue::push('\Tresfera\Talentapp\Classes\Jobs\SendRapport',$ids,"sendrapports");
       
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
            $evaluacion = Evaluacion::find($id);

            $theme = 'talentapp.require.aprovacion';
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
            return \Redirect::to("https://talentapp360.taket.es/backend/tresfera/talentapp/administrador");
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
            $evaluacion = Evaluacion::find($id);
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
                        
                        $theme = 'talentapp360.warning.evaluador.datafinish.standard';
                        if($tipo == "autoevaluado")
                            $theme = 'talentapp360.warning.evaluado.datafinish.standard';
                        
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
            return \Redirect::to("https://talentapp360.taket.es/backend/tresfera/talentapp/administrador");
        }
    }

    public function onSendEmailActivacionRecordatorio()
    {
        $this->onSendEmailActivacion(true);
        $this->onSendEmailRecordatorio(true);
        \Flash::success("Hemos enviado los correos de activación y de recordatorio a los usuarios seleccionados.");
        return \Redirect::to("https://talentapp360.taket.es/backend/tresfera/talentapp/administrador");
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
            $evaluacion = Evaluacion::find($id);

            $tmp = [];
            foreach($evaluacion->params as $t => $permisos)
            {
                if($t == "permissions")
                {
                    if($permiso == 1)
                    {
                        $tmp = $permisos;
                        if(!is_array($tmp)) $tmp = [];
                        if(!in_array("view_report", $tmp)) array_push($tmp, "view_report");
                    }
                    else if($permiso == 0)
                    {
                        if(is_array($permisos))
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
        
            if($permiso == 0) \Flash::success("Hemos eliminado el permiso para ver informes a todos los seleccionados.");
            if($permiso == 1) {
                //Enviamos email
                $theme = 'talentapp360.informe.ok';
                if($evaluacion->lang == "en") $theme .= "_en";
                if($evaluacion->lang == "fr") $theme .= "_fr";
        
                $user = \Backend\Models\User::find($evaluacion->user_id);
                $data = [
                    "name" => $evaluacion->name,
                    "url_backend" => url("/backend"),
                    "date" => $evaluacion->proyecto->fecha_fin,
                ];
        
                \Mail::queue($theme, $data, function($message) use ($evaluacion)
                {
                    $message->to($evaluacion->email,$evaluacion->name);
                    //$message->to("fgomezserna@gmail.com",$evaluacion->name);
                });
            }
        }
        return \Redirect::to("/backend/tresfera/talentapp/administrador");
    }

    public function onDownloadDatosBrutos()
    {
        $proyectos = Proyecto::all();
        
      //  Queue::push('\Tresfera\Talentapp\Classes\Jobs\ExportResultAnswer',["proyecto_id"=>126],"exportdatosbrutos");
       // return;
        foreach($proyectos as $proyecto) {
            Queue::push('\Tresfera\Talentapp\Classes\Jobs\ExportResultAnswer',["proyecto_id"=>$proyecto->id],"exportdatosbrutos");
        }
        \Flash::success("Hemos empezado a generar el informe. Enviaremos un email a tu correo cuando esté listo para descargar.");
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
            $evaluacion = Evaluacion::find($id);
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
                Queue::push('\Tresfera\Talentapp\Classes\Jobs\SendRecordatorioAsignacion',$id,"sendemailasignacion");
            }
        }
        \Flash::success("Hemos enviado los correos de recordatorio de asignación a los usuarios seleccionados que no aun han asignado ningún evaluador.");
        return \Redirect::to("https://talentapp360.taket.es/backend/tresfera/talentapp/administrador");
    }


    public function pruebas()
    {
        $this->makePartial('pruebas');
    }
    
}
