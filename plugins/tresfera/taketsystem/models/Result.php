<?php

namespace Tresfera\Taketsystem\Models;

use Tresfera\Talentapp\Models\Evaluacion;

use Model;
use DB;

/**
 * Result Model.
 */
class Result extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_results';

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * Has Many relations.
     *
     * @var array
     */
    public $hasMany = [
        'answers'  => ['Tresfera\Taketsystem\Models\Answer'],
    ];

    /**
     * Belongs To relations.
     *
     * @var array
     */
    public $belongsTo = [
        'device' => ['Tresfera\Taketsystem\Models\Device'],
        'quiz'   => ['Tresfera\Taketsystem\Models\Quiz'],
        'city'   => ['Tresfera\Taketsystem\Models\City'],
        'region' => ['Tresfera\Taketsystem\Models\Region'],
        'shop'   => ['Tresfera\Taketsystem\Models\Shop'],
    ];

    protected $is_scoped = false;
	
	/**
     * Before save event.
     */
    public function beforeSave()
    {
        if (isset($this->device->shop->id)) {
            $shop = $this->device->shop()->with('city.region')->first();
            $this->shop()->associate($shop);
            $this->city()->associate($shop->city);
            $this->region()->associate($shop->city->region);
        }
    }

    // Cada nuevo result comprobamos si la evaluacion en cuestion tiene evaluaciones pendientes
    // Si no tiene evaluaciones pendientes es que ha finalizado y actualizamos estado
    public function afterSave()
    {
        $evaluacion = Evaluacion::find($this->evaluacion_id);
        if(isset($evaluacion->id)) {
            $eval_tmp = $evaluacion->getEvaluaciones();
            if( count($eval_tmp["pendientes"])==0)
            {
                $evaluacion->estado = 2;
                $evaluacion->save();
                \Queue::push('\Tresfera\Talentapp\Classes\Jobs\GenerateRapport',$evaluacion->id,"rapports");
            }
            else
            {
                $evaluacion->estado = 1;
                $evaluacion->save();
            }
        }
    }
	public function calcPercent()
    {
        $this->completed = 100;
        if ($this->quiz->slides()->count()) {
            $this->completed = $this->answers()->groupBy('slide_id')->count() * 100 / $this->quiz->slides()->count();
        }

        return $this->save();
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
                    ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id')
                    ->get();
    }

    //public function afterFetch() { $this->name = htmlspecialchars($this->name); }
}
