<?php namespace Tresfera\Talentapp\Classes\Jobs;

use Tresfera\TalentApp\Models\Evaluacion;
use Tresfera\TalentApp\Models\Rapport;

class GenerateRapport
{
    public function fire($job, $id)
    {
        echo "Empezamos generacion del informe: ".$id."\n";
        $evaluacion = Evaluacion::find($id);
        if(isset($evaluacion->id) ) {
            $rapport = Rapport::where("evaluacion_id",$evaluacion->id)->latest('created_at')->first();
            if(!isset($rapport->id) or true) {
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
            } else {
                dd($rapport->data);
            }
            echo "Generamos PDF.."."\n";
            try { 
                $rapport->generatePdf();
            } catch(\Exception $ex) {
                dd($ex->getMessage());
            } 
            echo "Informe guardad en: ".$rapport->getFile()."\n";
            echo "Indicamos a la evaluacion que el informe está listo"."\n";
            $evaluacion->estado_informe = 3;
            $evaluacion->save();

            echo "Tenemos que enviar email?"."\n";

            if(is_array($evaluacion->params['permissions']) and in_array("view_report",$evaluacion->params['permissions'])) {
            //Enviamos email
                echo "SI"."\n";
                $theme = 'talentapp360.informe.ok';
                if($evaluacion->lang == "en") $theme .= "_en";
                if($evaluacion->lang == "fr") $theme .= "_fr";
        
                $user = \Backend\Models\User::find($evaluacion->user_id);
                $data = [
                    "name" => $evaluacion->name,
                    "url_backend" => url("/backend"),
                    "date" => $evaluacion->proyecto->fecha_fin,
                ];
                echo $theme."\n";
                \Mail::queue($theme, $data, function($message) use ($evaluacion, $data)
                {
                    $message->to($evaluacion->email,$evaluacion->name);
                    //$message->to("fgomezserna@gmail.com",$evaluacion->name);
                });
            }

        }
        $job->delete();
    }
}
?>