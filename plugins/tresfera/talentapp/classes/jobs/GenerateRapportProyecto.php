<?php namespace Tresfera\Talentapp\Classes\Jobs;

use Tresfera\TalentApp\Models\Proyecto;
use Tresfera\TalentApp\Models\Rapport;

class GenerateRapportProyecto
{
    public function fire($job, $id)
    {
        echo "Empezamos generacion del informede proyecto: ".$id."\n";
        $proyecto = Proyecto::find($id);
        if(isset($proyecto->id)) {
          /*  $rapport = Rapport::find(59677);
            $proyecto->rapport_id = $rapport->id;
            $proyecto->estado_informe = 2;
            $proyecto->save();
            $rapport->generatePdf();
            $proyecto->estado_informe = 3;
            $proyecto->save();
            return;*/
            $rapport = new Rapport();
            $rapport->proyecto_id = $proyecto->id;
            $rapport->save();
            echo "Asociamos la proyecto con el rapport nuevo...".$rapport->id."\n";
            
            $proyecto->rapport_id = $rapport->id;
            $proyecto->estado_informe = 2;
            $proyecto->save();
            //generamos los datos
            echo "Generamos los datos.."."\n";
            $rapport->generateData();
            echo "Generamos PDF.."."\n";
            $rapport->generatePdf();
            echo "Informe guardad en: ".$rapport->getFile()."\n";
            echo "Indicamos al proyecto que el informe está listo"."\n";
            $proyecto->estado_informe = 3;
            $proyecto->save();


           /* if(is_array($proyecto->params['permissions']) and in_array("view_report",$proyecto->params['permissions'])) {
            //Enviamos email
                $theme = 'talentapp360.informe.ok';
                if($proyecto->lang == "en") $theme .= "_en";
                if($proyecto->lang == "fr") $theme .= "_fr";
        
                $user = \Backend\Models\User::find($proyecto->user_id);
                $data = [
                    "name" => $proyecto->name,
                    "url_backend" => url("/backend"),
                    "date" => $proyecto->proyecto->fecha_fin,
                ];
        
                \Mail::send($theme, $data, function($message) use ($proyecto)
                {
                    $message->to($proyecto->email,$proyecto->name);
                    //$message->to("fgomezserna@gmail.com",$proyecto->name);
                });
            }*/

        }
        $job->delete();
    }
}
?>