<?php namespace Tresfera\Envios\Models;

use Model;
use Tresfera\Alertas\Models\Alerta;
use Taket\Structure\Models\Question;
use Taket\Creator\Models\Quiz;

/**
 * Model
 */
class Dato extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at','enviar_at','enviado_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_envios_datos';
    public $belongsTo = [
        "envio" => ["Tresfera\Envios\Models\Envio"]
    ];
    public $hasOne = [
        "result" => ["Tresfera\Taketsystem\Models\Result","key"=>"user_id"]
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function markCompleted() {
        $this->completado = \Carbon\Carbon::now();
        $this->save();
        
        //comprobamos alertas
        $alertas = Alerta::all();
        foreach($alertas as $alerta) {
            $alerta->checkAndRun($this->result);
        }
    }
    public function runSend() {
        $data = [
            "link" => $this->getUrl(),
            "email" => $this->email,
            "nom" => $this->nom,
        ];
        $user = $this;
        try {
            \Mail::send("claror.enquesta.baixa_cat", $data, function($message) use ($user)
            {
                $message->to($user->email, "");
                //$message->to("fgomezserna@gmail.com", "soy el mejor");
                $message->from("claror@taket.es");
            });
            $this->enviado = 1;
            $this->enviado_at = \Carbon\Carbon::now();
            $this->save();
        } catch(\Exception $ex) {
            $this->enviado = -1;
            $this->enviado_at = \Carbon\Carbon::now();
            $this->save();
        }
    }
    public function getUrl() {
        $quiz = Quiz::find($this->envio->quiz_id);
        return "https://claror.taket.es/quiz/".$quiz->url."/?u=".$this->id;
    }
    public function filters($query,$filters) {
        $no_filter = ["quizzes","quizzes_status",'date_range'];
        $transform = [
            'antiguitat' => 'antiguetat',
            'sexe' => 'es_home',
        ];
        $segmentaciones = [
            "seguiras-practicant-activitat-fisica","no-vull-rebre-mes-comunicacions","possibilitat-de-repesca"
        ];
        $has_segmentaciones = false;
        if(is_array($filters))
        foreach($filters as $name=>$values) {

            if(in_array($name,$no_filter)) continue;
            if(in_array($name,$segmentaciones)) {
                if(!count($values)) continue;
                if(!$has_segmentaciones) {
                    $query->join("tresfera_taketsystem_results","tresfera_envios_datos.id","tresfera_taketsystem_results.user_id");
                    $query->join("tresfera_taketsystem_answers","tresfera_taketsystem_answers.result_id","tresfera_taketsystem_results.id");
                    $query->groupBy("result_id");
                    $has_segmentaciones = true;
                }
                $subSql = "SELECT a1.result_id FROM tresfera_taketsystem_answers as a1 WHERE a1.question_id = '".$name."' AND a1.type = 'button' ";
                foreach($values as $key=>$value) {
                    if(isset($value['id']))
                        if($key == 0)
                            $subSql.= " AND a1.answer_id = '".$value['id']."'";
                        else
                            $subSql.= " OR a1.answer_id = '".$value['id']."'";
                    }
                $query->whereRaw("result_id IN (".$subSql.")");
            } else {
                $values_array = [];
                foreach($values as $val) {
                    $values_array[] = $val;
                }
                if(in_array($name, array_keys($transform)))
                    $name = $transform[$name];
    
                $question = Question::find($name);
                if(isset($question->id) and $question->slug) {
                    $name = $question->slug;
                    if(count($values_array))
                       $query->whereIn(str_replace("-","_",$name),$values_array);
                }

            }
        }
        return $query;
    }
    public function isSendFilters($filters) {
        return $this->filters($this->isSend(),$filters);

    }
    public function isOpenFilters($filters) {
        return $this->filters($this->isOpen(),$filters);

    }
    public function isCompletedFilters($filters) {
        return $this->filters($this->isCompleted(),$filters);
    }

    public function scopeIsOpen($query)
    {
        return $query->whereRaw(\DB::raw("UNIX_TIMESTAMP(apertura_at)"));
    }
    public function scopeIsCompleted($query)
    {
        return $query->whereRaw(\DB::raw("UNIX_TIMESTAMP(completado)"));
    }
    public function scopeIsSend($query)
    {
        return $query->whereRaw(\DB::raw("UNIX_TIMESTAMP(enviado_at)"));
    }
}
