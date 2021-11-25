<?php namespace Tresfera\Talent\Models;

use Tresfera\Talent\Models\Evaluacion;

use Model;
use DB;

class Result extends \Tresfera\Taketsystem\Models\Result
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_talent_results';

    public $hasMany = [
      'answers'  => ['Tresfera\Talent\Models\Answer'],
    ];

    public function afterSave()
    {
        $evaluacion = Evaluacion::find($this->evaluacion_id);
        if(isset($evaluacion->id)) {
            $evaluacion->estado = 2;
            $evaluacion->save();
            \Queue::push('\Tresfera\Talent\Classes\Jobs\GenerateRapport',$evaluacion->id,"rapports");
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
                    ->join('tresfera_talent_answers', 'tresfera_talent_results.id', '=', 'tresfera_talent_answers.result_id')
                    ->get();
    }
}
