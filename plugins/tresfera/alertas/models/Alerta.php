<?php namespace Tresfera\Alertas\Models;

use Model;
use Tresfera\Envios\Models\Dato;
use Tresfera\Taketsystem\Models\Answer;
use Taket\Structure\Models\Question;
use Taket\Structure\Models\Option;
use Taket\Creator\Models\Quiz;
use Mail;
use Twig;
/**
 * Model
 */
class Alerta extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_alertas_alertas';
    public $jsonable = ["conditions","action","mail_to"];
    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function checkAndRun($result) {
        $validated = true;
        foreach($this->conditions as $condition) {
            $answers = $result->answers();
            if(!isset($condition['question'])) { $validated = false; break; }
            $question = $condition['question'];
            if(!isset($condition['answer'])) { $validated = false; break; }
            $answer = $condition['answer'];
            if($answer != "Contestado")
            if(!count($answers->where("question_id",$question)->where("answer_id",$answer)->get())) {
                $validated = false;
                break;
            }
            if($answer == "Contestado")
            if(!count($answers->where("question_id",$question)->where("value","<>","")->get())) {
                $validated = false;
                break;
            }
        }
        if($validated) {
            $answer = $result->answers()->where("question_id",66)->first();
            $dato = Dato::find($result->user_id);
            try
                {
                    $this->send($dato,$answer);
                } catch(\Exception $x) {
                    trace_log( "No hemos podido enviar el email: ".$result->user_id);
                }
        } else {
            trace_log( "No toca enviar alerta: ".$result->user_id);
        }
    }
    public function send($dato,$answer=null) {
        if($this->event=="question") {
            foreach($this->mail_to as $mail_to) {
                $vars['email']       = $dato->email;
                $vars['id_usuari']   = $dato->id_usuari;
                $vars['email']       = $dato->email;
                $vars['phone ']      = $dato->phone ;
                $vars['to']          = $mail_to['email'];
                $vars['subject']     = $this->mail_subject;
                if(isset($answer->value))
                    $vars['answer']     = $answer->value;

                $html = Twig::parse( $this->mail_content, $vars );
                try
                {
                    Mail::raw([
                        'html' => $html
                    ], function ($message) use($vars) {
                        $message->to($vars['to']);
                        $message->subject($vars['subject']);
                    });
                } catch(\Exception $x) {
                    trace_log( "No hemos podido enviar el email: ".$result->user_id);
                }
            }
        }
        if($this->event=="envios") {
            $vars['email']       = $dato->email;
            $vars['id_usuari']   = $dato->id_usuari;
            $vars['email']       = $dato->email;
            $vars['name']        = $dato->nom;
            $vars['club']        = $dato->club;
            $vars['link']        = $dato->getLink();
            $vars['phone ']      = $dato->phone ;
            $vars['to']          = $dato->email;
            $vars['subject']     = $this->mail_subject;
            
            if($this->mail_content) {

                try
                {
                    $html = Twig::parse( $this->mail_content, $vars );
                    Mail::raw([
                        'html' => $html
                    ], function ($message) use($vars) {
                        $message->to($vars['to']);
                        $message->subject($vars['subject']);
                    });
                } catch(\Exception $x) {
                    trace_log( "No hemos podido enviar el email: ".$result->user_id);
                }
            }
            
        }
    }
    public function filterFields($fields, $context = null)
    {
    }


    public function getQuizOptions() {
        return Quiz::all()->lists("name","id");
    }

    public function getQuestionOptions() {
        
        return Question::selectRaw('CONCAT(id, " - ", name) as concatname, id')
                ->get()->lists("concatname","id");
        return Question::all()->lists("name","id");
        return [
            "idUsuari" => "idUsuari",
            "EsHome" => "EsHome",
            "edat" => "edat",
            "antiguetat" => "antiguetat",
            "servei" => "servei",
            "EsFamiliar" => "EsFamiliar",
            "EsQuotaParcial" => "EsQuotaParcial",
            "accessos_mes" => "accessos_mes",
            "email" => "email",
            "mobil" => "mobil",
            "club" => "club",
            "El motiu de la teva baixa és atribuïble al club?" => "El motiu de la teva baixa és atribuïble al club?",
            "Pots especificar el motiu de la teva insatisfacció?" => "Pots especificar el motiu de la teva insatisfacció?",
            "En podries indicar el motiu?" => "En podries indicar el motiu?",
            "Seguiràs practicant activitat física?" => "Seguiràs practicant activitat física?",
            "Vols fer algún comentari a la direcció del Club?" => "Vols fer algún comentari a la direcció del Club?",
            "La teva baixa s'hagués pogut evitar si..." => "La teva baixa s'hagués pogut evitar si...",
            "correu electrònic" => "correu electrònic",
            "número de telèfon" => "número de telèfon",
            "No vull rebre més comunicacions" => "No vull rebre més comunicacions",
        ];
    }
    public function getAnswerOptions($a, $fields = null) {
        if(isset($fields->question)) {
            if(Option::where("question_id",$fields->question)->count() > 0)
                return Option::where("question_id",$fields->question)->get()->lists("value","id");

            return [
                "Contestado" => "All",
            ];
        } else {
            return [];
        }
        
    }
}
