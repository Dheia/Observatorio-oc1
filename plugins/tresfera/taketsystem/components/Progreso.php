<?php namespace Tresfera\Taketsystem\Components;

use Cms\Classes\ComponentBase;
use Tresfera\Taketsystem\Models\Result as Result;
use Tresfera\Taketsystem\Models\Answer as Answer;
use Auth;
use Tresfera\Envios\Models\Dato;
use Session;

class Progreso extends ComponentBase
{
    var $quiz = 33;
    var $proyecto = "claror";
    var $user;
    var $result_id;
    public function init() {
        //$this->user = \Auth::getUser();
        $this->user = get("u");
        if($this->user) {
            Session::put('user_claror', get("u"));
        } else {
            $this->user = Session::get('user_claror');
        }
        $dato = Dato::find($this->user);
        $result = Result::where("user_id",$this->user)->first();
        if(!isset($result->id)) {
            $result = new Result();
            $result->user_id = $this->user;
            $result->quiz_id = 33;
            $result->save();
            //le metemos todas las segmentaciones
            $segmentaciones = [
                "club","id_usuari","es_home","edat","antiguetat","servei","es_familiar","es_quota_parcial","accessos_mes","email","mobil","nom"
            ];
            if(count($result->answers) == 0) {
                foreach($segmentaciones as $segmentacion) {
                    $answer = new Answer();
                    $answer->question_type = "segmentacion";
                    $answer->question_title = $segmentacion;
                    $answer->result_id = $result->id;
                    $answer->question = $segmentacion;
                    $answer->answer_type = str_slug($segmentacion);
                    $answer->value = $dato->$segmentacion;
                    $answer->save();
                }
            }
        }

        $this->result_id = $result->id;

        if(isset($dato->id) and ($dato->apertura_at == "0000-00-00 00:00:00" or !$dato->apertura_at)) {
            $dato->apertura_at = \Carbon\Carbon::now();
            $dato->save();
        }

        //finish
        $u = explode("-",$this->page->id);
        if(isset($u[1]) and $u[1] == "pag9" and ($dato->completado == "0000-00-00 00:00:00" or !$dato->completado) ){
            $dato = Dato::find($this->user);
            $dato->markCompleted();
        }
       

        /*if(!$this->user)
            $this->user = Auth::registerGuest(['email' => 'person@acme.tld']);*/
    }
    public function componentDetails()
    {
        return [
            'name'        => 'Progreso Component',
            'description' => 'No description provided yet...'
        ];
    }
    public function answersOk($pags) {
        $user = \Auth::getUser();
        return Answer::where("user_id",$this->user)->where("points",">","0")
                ->where("bonus","0")->whereIn("pag",$pags)->count();
    }
    public function getPag() {
        $u = explode("-",$this->page->id);
        return str_replace("pag","",$u[1]);
    }
    public function lastpag($quiz = "") {
        //$this->getPag();
        $quiz = $this->quiz;
        $user = \Auth::getUser();
        $progreso = Result::where("user_id",$this->user)->orderBy("created_at","DESC")
                            ->where("quiz_id",$quiz)->first();
        return $progreso;
    }
    public function finishlastpag() {
        
        $progreso = $this->lastpag();
        
        $user = \Auth::getUser();
       // if($this->user == 1261)  dd();
        if(isset($progreso->id) ) {
            $progreso->stop_at = \Carbon\Carbon::now();
            $progreso->save();
            
            $progreso2 = new Result();
            $progreso2->user_id = $progreso->user_id;
            $progreso2->quiz = $this->quiz;
            $progreso2->pag = $progreso->pag+1;
            $progreso2->save();
            $progreso2->start_at = $progreso2->created_at;
            $progreso2->save();
        }
        if(isset($progreso2->pag) and $progreso2->pag == "9") {
            $dato = Dato::find($this->user);
            if(isset($dato->id) and !$dato->apertura_at) {
                $dato->completado = \Carbon\Carbon::now();
                $dato->save();
            }
        }
        
    }
    public function currentpag($quiz = "") {
        $user = \Auth::getUser();
        $progreso = $this->lastpag($quiz);
        if(!$quiz) {
            $quiz = $this->quiz;
        } else {
            $quiz = $this->proyecto."-".$quiz;
        }
        if(!isset($progreso)) {
            $progreso = new Result();
            $progreso->user_id = $this->user;
            $progreso->quiz = $this->quiz;
            $progreso->pag = 0;
            $progreso->save();
            $progreso->start_at = $progreso->created_at;
            $progreso->save();
            
            return "pag0";
        } else {
            return "pag".$progreso->pag;
        }
    }
    public function onSaveAnswers() {
        $datas = post();
        foreach($datas as $data) {
            $this->onSaveAnswer($data);
        }
        return ["ok"];
    }
    public function onSaveAnswer($data=[]) {
        $user = \Auth::getUser();
        if(!count($data))
            $data = post();

        if(isset($data['id'])) {
            $answer = Answer::find($data['id']);
        } 
        if(!isset($answer->id)) {
            $answer = new Answer();
        }
        foreach($data as $name=>$value) {
            $answer->$name = $value;
        }
        
        $answer->result_id = $this->result_id;
        $answer->slide_id = $this->getPag();
        $answer->save();
        return ["id"=>$answer->id];
    }

    public function onRemoveAnswer() {
        $data = post();
        if(isset($data['id'])) {
            $answer = Answer::find($data['id']);
            $answer->delete();
        }
    }

    public function bonus() {
        
    }

    public function onRun()
    {
        $dato = Dato::find($this->user);
        if($this->page->id == "baja" and ($dato->completado != "0000-00-00 00:00:00" and $dato->completado)) {
            return \Redirect::to("/quiz/baja-ca/pag9");
        }
        // This code will be executed when the page or layout is
        // loaded and the component is attached to it.
        $user = \Auth::getUser();
        
        $url = $this->page->id;
        $u = explode("-",$url);
        $this->quiz = "baja";
        if(get("finish"))
            $this->finishlastpag();
        else {
            //borramos posibles respuestas previas
            //Answer::where("result_id",$this->result_id)->delete();
        }
     /*   if($this->user == 1261) {
            $answers_page = Answer::where("user_id",$this->user)
                        ->where("quiz",$this->quiz)
                        ->where("pag",$url)->get();
            if(count($answers_page)) {
                $url_new = "/cofidis/";
                //$url_new = "/cofidis//";
                switch($this->quiz) {
                    case 'cofidis-competencia2':
                        $url_new .= "competencia2/";
                    break;
                    case 'cofidis-competencia1':
                        $url_new .= "competencia2/";
                    break;
                }
                $url_new .= $this->currentpag();
                dd(url($url_new));                
                
                return \Redirect::to(url($url_new));
                exit;
            }
    }*/
                
        //$this->bonus();
        
    }
    public function defineProperties()
    {
        return [
            'competencia' => [
                'title'             => 'Competencia',
                'description'       => 'Competencia que se va a generar el informe',
                'default'           => 'competencia1',
                'type'              => 'string',
           ]
        ];
    }
}
