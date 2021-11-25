<?php namespace Tresfera\Buildyouup\Classes\Jobs;

use Tresfera\Buildyouup\Models\Equipo;
use Tresfera\Buildyouup\Models\Rapport;

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
            $equipo = Equipo::find($id);
            echo "ID:".$id."\n";
            if(isset($equipo->id)) {
                //generamos informe por informe si no existe para cada player del equipo
                foreach($equipo->players as $player) {
                    print_r($player);
                    $rapport = new Rapport();
                    $rapport->evaluacion_id = $equipo->id;
                    $rapport->save();
                    $rapport->generateData($player['name']);
                    $rapport->generatePdf();

                    echo $rapport->getFile()."\n";
                    if(is_file($rapport->getFile())) {
                        $rename = base_path("/informes/Skill_".snake_case($player['name']).".pdf");
                        rename($rapport->getFile(),$rename);
                        $zip->add($rename);
                    }
                        
                    else
                        echo "queisekillo\n";
                }      
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
            $message->cc("fgomezserna@gmail.com","Copia ZIP Fran");
        });

        $job->delete();

    }



}
?>