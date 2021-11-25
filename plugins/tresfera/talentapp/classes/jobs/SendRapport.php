<?php namespace Tresfera\Talentapp\Classes\Jobs;

use Tresfera\TalentApp\Models\Evaluacion;
use Tresfera\TalentApp\Models\Rapport;

use ZanySoft\Zip\Zip;

class SendRapport
{
    public function fire($job, $ids)
    {
        // Creamos zip
        $name = "informes/".date("d-m-Y_h:i:s").".zip";
        $name_tmp = base_path($name);
        $zip = Zip::create($name_tmp);

        foreach($ids as $id)
        {
            echo "Empezamos generacion del informe: ".$id."\n";
            $evaluacion = Evaluacion::find($id);
            echo "ID:".$id."\n";
            if(isset($evaluacion->id)) {
                $rapport = Rapport::find($evaluacion->rapport_id);
                if(!isset($rapport->id)) continue;
              
                echo $rapport->getFile()."\n";
                if(is_file($rapport->getFile()))
                    $zip->add($rapport->getFile());
                else
                    echo "queisekillo\n";
            }
        }
        //$zip->close();

        echo "ARCHIVOS:";
        print_r($zip->listFiles());

        $zip->close();


        $theme = "talentapp360.sendrapports";
        $data = [
            "url" => url($name)
        ];
        $evaluador = [
            "email" => "marta.sala@cookiebox.es",
            "name" => "Tarta Sala"
        ];
        \Mail::queue($theme, $data, function($message) use ($evaluador)
        {
            $message->to($evaluador['email'],$evaluador['name']);
            $message->cc("gerard.3fera@gmail.com","Copia ZIP Gerard");
        });

        $job->delete();

    }



}
?>