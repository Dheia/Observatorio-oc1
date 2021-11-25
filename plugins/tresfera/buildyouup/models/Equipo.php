<?php namespace Tresfera\Buildyouup\Models;

use Model;

use Backend\Models\User;
use Backend\Models\UserGroup;
use Tresfera\Buildyouup\Models\Result;

use Faker\Factory;

use Validator;
/**
 * Model
 */
class Equipo extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_buildyouup_equipo';

    public $jsonable = ['tipo','players','params','stats'];

    public $hasOne = [
      'result' => [
        'Tresfera\Buildyouup\Models\Result',
        'conditions' => 'is_autoevaluacion = 1'
      ],
      'rapport' => [
        'Tresfera\Buildyouup\Models\Rapport',
      ]
    ];

    public $belongsToMany = [
      'evaluadores' => [
        'Backend\Models\User',
        'table' => 'tresfera_buildyouup_evaluacion_evaluador',
        'key' => 'eval',
        'otherKey' => 'evaluador'
      ]
    ];
    public $belongsTo = [
      'proyecto' => [
        'Tresfera\Buildyouup\Models\Proyecto'
      ]
    ];
    public function getContestadas() {
      $evals = $this->getEquipos();
      return count($evals["completadas"]);
    }
    public function getPendientes() {
      $evals = $this->getEquipos();
      return count($evals["pendientes"]);
    }

    // Nos devuelve un array con las evaluaciones pendientes y las completadas ($eval["completadas], $eval["pendientes"])
    public function getEquipos() 
    {
      $evaluadores_tmp = [];
      $evaluadores_tmp["completadas"] = [];
      $evaluadores_tmp["pendientes"] = [];

      $evaluadores = $this->stats;
      if(is_array($evaluadores))
      foreach($evaluadores as $evaluador) 
      { 
        if(!$evaluador['name']) continue;
        if( !$this->isCompletedPlayer($evaluador['name']) ) 
        {
          array_push( $evaluadores_tmp["pendientes"], $evaluador);
        }
        else
        {
          array_push( $evaluadores_tmp["completadas"], $evaluador);
        }
      }
      
      return $evaluadores_tmp;
    }


    public function getNumEvaluadores() {
      $people = $this->getPlayers();
      $num  = 0;
      if(is_array($people))
      foreach($people as $tipos) {
        if(is_array($tipos))
          $num += count($tipos);
      }
      return $num ;
    }

    public function isCompletedPlayer($email) {
      $a = \Tresfera\Buildyouup\Models\Result::where("evaluacion_id",$this->id)->where("is_evaluacion", 1)->where("email", $email)->count();
      if($a > 0) return true;
      return false;
    }

    public function getDatePlayer() {
      $a = \Tresfera\Buildyouup\Models\Result::where("evaluacion_id",$this->id)->where("is_autoevaluacion", 1)->first();
      if(isset($a->created_at)) return $a->created_at;
      return false;
    }

    public function generaPass($longitudPass = 10)
    {
        $cadena = "AzByCxDwEvFuGtHsIrJqKpLoMnNmOlPkQjRiShTgUfVeWdXcYbZ1234567890!";
        $longitudCadena=strlen($cadena);
    
        $pass = "";
        
        for($i=1 ; $i<=$longitudPass ; $i++){
            $pos=rand(0,$longitudCadena-1);
            $pass .= substr($cadena,$pos,1);
        }
        return $pass;
    }

    public function validarEmail() {
      return ["ok" => true, "emails_error" => []];

      $validator = Validator::make(
        [
            'email' => $this->email
        ],
        [
            'email' => 'required|email'
        ]
      );

      if($validator->fails()) 
      {
        \Flash::error("El email ".$this->email." no es válido");
        return ["ok" => false];
      }

      $emails_erroneos = [];

      if(is_array($this->tipo))
      {
        foreach($this->tipo as $tipo=>$text) {
          if(isset($this->$text))
          {
            $tmp = $this->$text;
            foreach($this->$text as $i => $contacto) 
            {
              //dd($contacto['email']);
              $validator = Validator::make(
                [
                    'email' => $contacto['email']
                ],
                [
                    'email' => 'required|email'
                ]
              );
              if ($validator->fails()) 
              {
                unset(($tmp)[$i]);
                array_push($emails_erroneos, $contacto['email']);
                continue;
              }
              
            }
            $this->$text = $tmp;
          }
        }
      }
      return ["ok" => true, "emails_error" => $emails_erroneos];

    }

    public function beforeCreate() {
      return true;
      $validacion = $this->validarEmail();
      $this->password = $this->generaPass();

      if(!$validacion['ok'])
      {
        return false;
      }
      else
      {
        if( !$validacion["emails_error"] && count($validacion["emails_error"]) == 0 )
        {
          \Flash::success(e(trans('tresfera.buildyouup::lang.evaluadores.save_ok')));
        }
        else
        {
          \Flash::error( e(trans('tresfera.buildyouup::lang.evaluadores.save_ko')). json_encode($validacion["emails_error"]));
        }
        return true;
      }

      return true;
    }

    public function afterSave() {

      if(isset($evaluacion->id)) {
        $eval_tmp = $this->getEquipos();
        if( count($eval_tmp["pendientes"])==0)
        {
            $this->estado = 2;
            $this->save();
            \Queue::push('\Tresfera\Buildyouup\Classes\Jobs\GenerateRapport',$this->id,"rapports");
        }
        else
        {
            $this->estado = 1;
            $this->save();
        }
      }
    }

    public function afterCreate() {
      
      //fix idioma
      
      if($this->lang != "es" && $this->lang != "en") {
        $this->lang = $this->proyecto->lang;
      }


      $username = ( strtolower( $this->email ));

      $proyecto = Proyecto::find($this->proyecto_id);
      $this->client_id = $proyecto->client_id;
      
     /* $user = User::where("login",$username)->first();

      if(!isset($user)) {
        $new = true;
        $user = new User([]);
        $faker = Factory::create();
  
        $user->first_name            = $this->name;
        $user->login                 = $username;
        $user->email                 = $this->email;
        $user->password              = $this->password;
        $user->password_confirmation = $this->password;
        $user->client_id			       = $this->id;
        $user->is_activated          = 1;
        $user->save();
  
        $user->role_id = 3;
        $user->save();



        if($this->lang == "es") {
          \DB::table('backend_user_preferences')->insert(
              [
               'user_id' => $user->id,
               'namespace' => 'backend',
               'group' => 'backend',
               'item' => 'preferences',
               'value' => '{"locale":"es","fallback_locale":"es","timezone":"UTC","editor_font_size":"12","editor_word_wrap":"fluid","editor_code_folding":"manual","editor_tab_size":"4","editor_theme":"twilight","editor_show_invisibles":false,"editor_highlight_active_line":true,"editor_use_hard_tabs":false,"editor_show_gutter":true,"editor_auto_closing":false,"editor_autocompletion":"manual","editor_enable_snippets":false,"editor_display_indent_guides":false,"editor_show_print_margin":false,"user_id":"'.$user->id.'"}'               
              ]
          );
        }
        if($this->lang == "en") {
          \DB::table('backend_user_preferences')->insert(
              [
               'user_id' => $user->id,
               'namespace' => 'backend',
               'group' => 'backend',
               'item' => 'preferences',
               'value' => '{"locale":"en","fallback_locale":"en","timezone":"UTC","editor_font_size":"12","editor_word_wrap":"fluid","editor_code_folding":"manual","editor_tab_size":"4","editor_theme":"twilight","editor_show_invisibles":false,"editor_highlight_active_line":true,"editor_use_hard_tabs":false,"editor_show_gutter":true,"editor_auto_closing":false,"editor_autocompletion":"manual","editor_enable_snippets":false,"editor_display_indent_guides":false,"editor_show_print_margin":false,"user_id":"'.$user->id.'"}'               
              ]
          );
        }
      }

      $this->user_id = $user->id;
      $msg = "Ya estás registrado. Hemos mantenido tus datos de acceso.";
      if($this->lang == "en") {
        $msg = "You are already registered. We have maintained your access data.";
      }
      $data = [
        "name" => $this->name,
        "username" => $username,
        "password" => isset($new)?$this->password:$msg,
        "url_backend" => '/backend',
      ];
      $theme = 'buildyouup.require.aprovacion';
      if($this->lang == "en")
        $theme = 'buildyouup.require.aprovacion_en';
       

      \Mail::queue($theme, $data, function($message) use ($user)
      {
          $message->to($user->email,$user->first_name);
      });
      */

      if(true) {
        $stats = [];
        if(!is_array($this->players))
          $this->players = [];

       // $validacion = $this->validarEmail();
        if(is_array($this->players))
        foreach($this->players as $contacto) {
          $stats[$contacto['name']] = [
                                                'name' => $contacto['name'],
                                                //'email'=> $contacto['email'],
                                                'url' => "",
                                                //'lang' => $contacto['lang']?$contacto['lang']:$this->lang,
                                                'send_at' => '',
                                                'completed_at' => '',
                                                'send' => 0,
                                                'completed' => 0
                                              ];
          
        }
        $this->stats = $stats;
      }
      $this->save();
    }
    
    public function beforeUpdate() {
      return true;
      $validacion = $this->validarEmail();
      if(!$validacion['ok'])
      {
        return false;
      }
      else
      {
        //dd($validacion);
        if( !$validacion["emails_error"] )
        {
          \Flash::success(e(trans('tresfera.buildyouup::lang.evaluadores.save_ok')));
        }
        else
        {
          \Flash::error( e(trans('tresfera.buildyouup::lang.evaluadores.save_ko')). json_encode($validacion["emails_error"]));
        }
      }

      if(!is_array($this->players))
        $this->players = [];

      //if($this->estado==1) {
        $stats = $this->stats;

        if(is_array($this->players)) {
          foreach($this->players as $contacto) {
            if(isset($stats[$contacto['name']])) continue;
            $stats[$contacto['name']] = [
                                                  'name' => $contacto['name'],
                                                  //'email'=> $contacto['email'],
                                                  'url' => "",
                                                  'send_at' => '',
                                                  //'lang' => $contacto['lang']?$contacto['lang']:$this->lang,
                                                  'completed_at' => '',
                                                  'send' => 0,
                                                  'completed' => 0
                                                ];
          }          
        }
        $this->stats = $stats;
    }

    public function getUrl() {
      
      
      
      if( $this->lang == 'en') {
        $url_base = "/quiz-real/buildyouup-en";
      } else {
        $url_base = "/quiz-real/buildyouup";
      }
      return ($url_base."?buildyouup=1&ev=".$this->id);
     
    }
    public function countAnswereds($player) {
      $resultBase = Result::where("evaluacion_id",$this->id)
      ->where("email",$player)->count();
      

      return $resultBase;
    }
    public function listPlayersAnswereds($player) {
      $resultBase = Result::select(\DB::raw("value, count(value) as num"))
                            ->where("evaluacion_id",$this->id)
                            ->where("tresfera_buildyouup_answers.duplicated",0)
                            ->where("email",$player)
                            ->where("question_id","observador")
                            ->join('tresfera_buildyouup_answers', 'tresfera_buildyouup_results.id', '=', 'tresfera_buildyouup_answers.result_id')
                            ->groupBy("value")
                            ->get();

          

      return $resultBase;
    }
    public function getPlayer($name)
    {
      foreach($this->getPlayers() as $player) {
        if($player['name'] == $name) return $player;
      }
    }
    public function getPlayers()
    {

      return $this->players;
      $evaluadores = [];
      $evaluadores["players"] = []; 

      if( isset($this->stats["numTotal"]) ) $evaluadores["numTotal"] = $this->stats["numTotal"];
      if( isset($this->stats["numAnswered"]) ) $evaluadores["numAnswered"] = $this->stats["numAnswered"];

      if(isset($this->stats["players"]))
      {
        foreach($this->stats["players"] as $email => $autoevaluado)
        {
          if(!$autoevaluado['email']) continue;

          if(!isset($autoevaluado["email"])) $autoevaluado["email"] = $email;
          $evaluadores[$autoevaluado["email"]] = [];
          $evaluadores[$autoevaluado["email"]]["email"] = $autoevaluado["email"];
          (isset($autoevaluado["url"])) ? $evaluadores[$autoevaluado["email"]]["url"] = $autoevaluado["url"]
                                        : $evaluadores[$autoevaluado["email"]]["url"] = "";
          (isset($autoevaluado["send_at"])) ? $evaluadores[$autoevaluado["email"]]["send_at"] = $autoevaluado["send_at"]
                                            : $evaluadores[$autoevaluado["email"]]["send_at"] = "";
          (isset($autoevaluado["lang"])) ? $evaluadores[$autoevaluado["email"]]["lang"] = $autoevaluado["lang"]
                                         : $evaluadores[$autoevaluado["email"]]["lang"] = "";
          (isset($autoevaluado["completed_at"])) ? $evaluadores[$autoevaluado["email"]]["completed_at"] = $autoevaluado["completed_at"]
                                                 : $evaluadores[$autoevaluado["email"]]["completed_at"] = "";
          (isset($autoevaluado["send"])) ? $evaluadores[$autoevaluado["email"]]["send"] = $autoevaluado["send"]
                                         : $evaluadores[$autoevaluado["email"]]["send"] = "";
          (isset($autoevaluado["completed"])) ? $evaluadores[$autoevaluado["email"]]["completed"] = $autoevaluado["completed"]
                                              : $evaluadores[$autoevaluado["email"]]["completed"] = "";
          (isset($autoevaluado["name"])) ? $evaluadores[$autoevaluado["email"]]["name"] = $autoevaluado["name"]
                                         : $evaluadores[$autoevaluado["email"]]["name"] = "";
      
        }
      }
     
      

      return $evaluadores;
    }

    // Devuelve el número de evaluaciones totales, contestadas y no contestadas de la Evaluación
    public function getStats()
    {
      $contestadas = 0;
      $no_contestadas = 0;

      foreach($this->stats as $tipo=>$values) { 
        if(is_array($values)) {
          foreach($values as $evaluador) {
              if(!$evaluador['email']) continue;
              if( !$this->isCompletedPlayer($evaluador['name']) ) 
              {
                  $no_contestadas++;
              }
              else 
              {
                  $contestadas++;
              }
          }
            
        }
      }

      return [ "total_evaluaciones" => $contestadas+$no_contestadas, "evaluaciones_cnt" => $contestadas, "evaluaciones_no_cnt" => $no_contestadas ];
    }

    // Devuelve el número total de evaluaciones contestadas, no contestadas y el total de todas las Equipos de un usuario
    public static function getNumEquipos($user_id)
    {
      $evals = Equipo::where('user_id', $user_id)->get();

      $total_evaluaciones_contestadas = 0;
      $total_evaluaciones_no_contestadas = 0;

      foreach($evals as $eval)
      {
        foreach($eval->stats as $tipo=>$values) { 
          if(is_array($values)) {
            foreach($values as $evaluador) {
                if(!$evaluador['email']) continue;
                if($tipo == "autoevaluado")
                {
                    if( !$eval->isCompletedAutoevaluado() ) 
                    {
                        $total_evaluaciones_no_contestadas++;
                    }
                    else 
                    {
                        $total_evaluaciones_contestadas++;
                    }
                }
                else 
                {
                    if($evaluador["completed"] != true)
                    {
                        $total_evaluaciones_no_contestadas++;
                    }
                    else
                    {
                        $total_evaluaciones_contestadas++;
                    }
                }
            }
              
          }
        }
      }

      return [ "num_evaluaciones_cnt" => $total_evaluaciones_contestadas, "num_evaluaciones_no_cnt" => $total_evaluaciones_no_contestadas ];

    }

    public function proyectoFinalizado()
    {
      return ( isset($this->proyecto) && $this->proyecto->finalizado() );
    }

}
