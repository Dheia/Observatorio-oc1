<?php namespace Tresfera\Talentapp\Classes\Jobs;

use Tresfera\TalentApp\Models\Proyecto;
use Tresfera\TalentApp\Models\Rapport;

class GenerateRapportGlobal
{
    public function fire($job, $id)
    {
        echo "Empezamos generacion del informe Global: \n";
            $rapport = new Rapport();
            $rapport->save();
            $rapport->global = $rapport->created_at;
            $rapport->save();
            echo "Asociamos la proyecto con el rapport nuevo...".$rapport->id."\n";
            
            //generamos los datos
            echo "Generamos los datos.."."\n";
            $rapport->generateData();
            echo "Generamos PDF.."."\n";
            $rapport->generatePdf();
            echo "Informe guardad en: ".$rapport->getFile()."\n";
            echo "Indicamos al proyecto que el informe está listo"."\n";
            $proyecto->estado_informe = 3;
            $proyecto->save();

            $rapport->generated_at = date('Y-m-d h:i:s');
            $rapport->save();
            

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

        
        $job->delete();
    }
}
?>