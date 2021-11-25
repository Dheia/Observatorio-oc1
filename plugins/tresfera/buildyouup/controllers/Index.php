<?php namespace Tresfera\Buildyouup\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Tresfera\Buildyouup\Models\Equipo;
use Flash;
use Redirect;

use Tresfera\Buildyouup\Models\Proyecto;

class Index extends Controller
{
    public $implement = [    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Tresfera.Buildyouup', 'buildyouup');
        //$this->addCss("/plugins/tresfera/buildyouup/assets/css/custom.css", "1.0.0");
    }

    public function index() {
        $this->pageTitle = "Proyectos";
        return $this->makePartial("index");
    }
    public function rgpd() {
        $this->pageTitle = "Aceptación de las condiciones de uso de el software";
        return $this->makePartial("rgpd");
    }

    public function onConsentimiento() {
        if(post('consentimiento')) {
            $this->user->activated_at = \Carbon\Carbon::now();
            $this->user->save();
            \Flash::success(e(trans('tresfera.buildyouup::lang.evaluadores.bienvenido')));
        } else {
            \Flash::error(e(trans('tresfera.buildyouup::lang.evaluadores.lopd_error')));
        }
        return Redirect::to("/backend/tresfera/buildyouup/index/");
    }
/*
    public function onSendAviso() {
        $evaluacion = Equipo::find(get("id"));
        $stats = $evaluacion->getEvaluadores();
        if(!is_array($evaluacion->getEvaluadores())) return;
        foreach($evaluacion->getEvaluadores() as $tipo=>$evaluadores) {
            if(is_array($evaluadores))
            foreach($evaluadores as $evaluador) {
                $statsAs = $stats[$tipo][$evaluador['email']];
                if(!$evaluador['completed']) {
                    echo "Enviamos a: ".$evaluador['email']."\n";
                    $user = \Backend\Models\User::find($evaluacion->user_id);
                    $data = [
                        "name" => $evaluador['name'],
                        "username" => $user->login,
                        "name_evaluado" => $user->first_name,
                        "url" => $evaluacion->stats[$tipo][$evaluador['email']]['url'],
                        "date" => $evaluacion->proyecto->fecha_fin
                    ];
                    
                    $theme = 'buildyouup.warning.evaluador.datafinish.standard';
                    if($tipo == "autoevaluado")
                        $theme = 'buildyouup.warning.evaluado.datafinish.standard';
                    
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
                    echo $theme . "\n";
                    

                    
                    \Mail::send($theme, $data, function($message) use ($evaluador)
                    {
                        $message->to($evaluador['email'],$evaluador['name']);
                    });
                } 
            }
        }
        \Flash::success("Enviado correctamente");

        return Redirect::to("/backend/tresfera/buildyouup/administrador");
    }

    public function onSendActivacion() {
        $evaluacion = Equipo::find(get("id"));

        $theme = 'buildyouup.require.aprovacion';
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
       
        \Flash::success("Enviado correctamente");

        return Redirect::to("/backend/tresfera/buildyouup/administrador");
    }
*/
    public function onDeleteProject()
    {
        Proyecto::find( post('id_proyecto') )->delete();
        Flash::success("El proyecto '".post('nombre_proyecto')."' ha sido eliminado correctamente");
    }

    public function onActivateProject()
    {
        Proyecto::where('id', post('id_proyecto') )->update(['estado' => 1]);
        Flash::success("El proyecto ha sido activado correctamente");
        return Redirect::refresh();
    }
    
}
