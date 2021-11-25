<?php
namespace Gerard\Comunicacion\Classes\Jobs;

use Queue;

use Tresfera\Talentapp\Models\Evaluacion;


class FinalizaEvaluaciones
{
    public function fire($job, $data)
    {
      try {
        if ($job->attempts() > 10) {
          $job->delete();
        }
        
        $evaluacion = Evaluacion::find($data['eval_id']);
        $evaluacion->estado = 2;
        $evaluacion->save();

        $job->delete();
      } catch (Exception $e) {
        $job->delete();
      }
    }

    public function failed($data)
    {
      echo "esto no va :(\n";
    }

}
?>
