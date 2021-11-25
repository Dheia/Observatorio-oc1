<?php namespace Tresfera\Talent\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Tresfera\Talent\Models\Evaluacion;
use Flash;
use Redirect;

use Tresfera\Talent\Models\Proyecto;

class Index extends Controller
{
    public $implement = [    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Tresfera.Talent', 'talent');
        $this->addCss("/plugins/tresfera/talent/assets/css/custom.css", "1.0.0");
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
            \Flash::success(e(trans('tresfera.talent::lang.evaluadores.bienvenido')));
        } else {
            \Flash::error(e(trans('tresfera.talent::lang.evaluadores.lopd_error')));
        }
        return Redirect::to("/backend/tresfera/talent/index/");
    }

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

    public function onGenerateRapport() {
        $id = get("id");

        $evaluacion = Evaluacion::find($id);
        $evaluacion->estado_informe = 1;
        $evaluacion->save();
        Queue::push('\Tresfera\Talent\Classes\Jobs\GenerateRapport',$id,"rapports");
        
        \Flash::success("Hemos empezado a procesar los informes.");
        return \Redirect::back();
    }
    
}
