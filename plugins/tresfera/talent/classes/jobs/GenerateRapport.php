<?php namespace Tresfera\Talent\Classes\Jobs;

use Tresfera\Talent\Models\Evaluacion;
use Tresfera\Talent\Models\Rapport;

class GenerateRapport
{
    public function fire($job, $id)
    {
        echo "Empezamos generacion del informe: ".$id."\n";
        $evaluacion = Evaluacion::find($id);
        //comprobamos si tiene licencias disponibles su proyecto
        if(!$evaluacion->proyecto->hasLicencias()) {
            echo "Sin licencias disponibles\n";
            //Enviamos email a alguien???
         //   return;
        }
        if(isset($evaluacion->id)) {
            $rapport = new Rapport();
            $rapport->evaluacion_id = $evaluacion->id;
            $rapport->save();
            echo "Asociamos la evaluacion con el rapport nuevo...".$rapport->id."\n";
            
            $evaluacion->rapport_id = $rapport->id;
            $evaluacion->estado_informe = 2;
            $evaluacion->save();
            //generamos los datos
            echo "Generamos los datos.."."\n";
            $rapport->generateData();
            echo "Generamos PDF.."."\n";
            $rapport->generatePdf();
            echo "Informe guardad en: ".$rapport->getFile()."\n";
            echo "Indicamos a la evaluacion que el informe está listo"."\n";
            $evaluacion->estado_informe = 3;
            $evaluacion->save();

            if(is_array($evaluacion->params['permissions']) and in_array("view_report",$evaluacion->params['permissions'])) {
                //Enviamos email
                $theme = 'talentapp.informe.ok';
                if($evaluacion->lang == "en") $theme .= "_en";
                if($evaluacion->lang == "fr") $theme .= "_fr";
                echo $theme."\n";
                $user = \Backend\Models\User::find($evaluacion->user_id);
                $data = [
                    "name" => $evaluacion->name,
                ];
        
                \Mail::queue($theme, $data, function($message) use ($evaluacion)
                {
                    $message->to($evaluacion->email,$evaluacion->name);
                   // $message->to("fgomezserna@gmail.com",$evaluacion->name);
                });
            }
        }
        $job->delete();
    }
}
?>