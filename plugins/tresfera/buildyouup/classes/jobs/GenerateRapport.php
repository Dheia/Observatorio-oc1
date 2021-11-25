<?php namespace Tresfera\Buildyouup\Classes\Jobs;

use Tresfera\Buildyouup\Models\Equipo;
use Tresfera\Buildyouup\Models\Rapport;

class GenerateRapport
{
    public function fire($job, $id)
    {
        echo "Empezamos generacion del informe: ".$id."\n";
        $evaluacion = Equipo::find($id);
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
        }
        $job->delete();
    }
}
?>