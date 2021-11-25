<?php namespace Tresfera\Skillyouup\Models;

use Tresfera\Skillyouup\Models\Equipo;

use Model;
use DB;

class Result extends \Tresfera\Taketsystem\Models\Result
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_skillyouup_results';

    public $hasMany = [
      'answers'  => ['Tresfera\Skillyouup\Models\Answer'],
    ];

    public function afterSave()
    {
        $evaluacion = Equipo::find($this->evaluacion_id);
        if(isset($evaluacion->id)) {
            $eval_tmp = $evaluacion->getEquipos();
            if( count($eval_tmp["pendientes"])==0)
            {
                $evaluacion->estado = 2;
                $evaluacion->save();
                \Queue::push('\Tresfera\Skillyouup\Classes\Jobs\GenerateRapport',$evaluacion->id,"rapports");
            }
            else
            {
                $evaluacion->estado = 1;
                $evaluacion->save();
            }
        }
    }

    public function getTotals()
    {
        return $this->addSelect(DB::raw('count(distinct result_id) as numQuizz'))
                    ->addSelect(DB::raw('SUM(if(value = 3, 1, 0)) as numOk'))
                    ->addSelect(DB::raw('SUM(if(value = 1, 1, 0)) as numKo'))
                    ->addSelect(DB::raw('SUM(if(question_type = \'smiles\', 1, 0)) as numQuestions'))
                    ->addSelect(DB::raw("CONCAT(FORMAT(SUM(if(value = 1, 1, 0))/SUM(if(question_type = 'smiles', 1, 0))*100,2),'%') as percentKo"))
                    ->addSelect(DB::raw("CONCAT(FORMAT(SUM(if(value = 3, 1, 0))/SUM(if(question_type = 'smiles', 1, 0))*100,2),'%') as percentOk"))
                    ->addSelect(DB::raw("CONCAT(FORMAT(SUM(if(value = 2, 1, 0))/SUM(if(question_type = 'smiles', 1, 0))*100,2),'%') as percentMix"))
                    ->addSelect(DB::raw('SUM(if(value = 2, 1, 0)) as numMix'))
                    ->join('tresfera_skillyouup_answers', 'tresfera_skillyouup_results.id', '=', 'tresfera_skillyouup_answers.result_id')
                    ->get();
    }
}
