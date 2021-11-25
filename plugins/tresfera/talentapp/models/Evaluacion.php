<?php namespace Tresfera\Talentapp\Models;

use Model;

use Backend\Models\User;
use Backend\Models\UserGroup;

use Faker\Factory;

use Validator;
/**
 * Model
 */
class Evaluacion extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];
    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_talentapp_evaluacion';

    public $jsonable = ['tipo','jefe','companero','colaborador','otro','params','stats'];

    public $hasOne = [
      'result' => [
        'Tresfera\Taketsystem\Models\Result',
        'conditions' => 'is_autoevaluacion = 1'
      ],
      'rapport' => [
        'Tresfera\TalentApp\Models\Rapport',
      ]
    ];

    public $belongsToMany = [
      'evaluadores' => [
        'Backend\Models\User',
        'table' => 'tresfera_talentapp_evaluacion_evaluador',
        'key' => 'eval',
        'otherKey' => 'evaluador'
      ]
    ];
    public $belongsTo = [
      'proyecto' => [
        'Tresfera\TalentApp\Models\Proyecto'
      ]
    ];

    public function scopeType($query,$filters)
    {
        if(count($filters)) {
          $query->join("tresfera_talentapp_proyecto","tresfera_talentapp_proyecto_good.id","tresfera_talentapp_evaluacion.proyecto_id");
          $query->whereIn("type",$filters);
          return $query;
        }
        return $query;

    }

    public function getContestadas() {
      $evals = $this->getEvaluaciones();
      return count($evals["completadas"]);
    }
    public function getPendientes() {
      $evals = $this->getEvaluaciones();
      return count($evals["pendientes"]);
    }

    public function isAutoEvaluacion() {
      if(in_array('autoevaluacion',$this->tipo)) {
        return true;
      }
      return false;
    }
    // Nos devuelve un array con las evaluaciones pendientes y las completadas ($eval["completadas], $eval["pendientes"])
    public function getEvaluaciones() 
    {
      $evaluadores_tmp = [];
      $evaluadores_tmp["completadas"] = [];
      $evaluadores_tmp["pendientes"] = [];

      $evaluadores = $this->getEvaluadores();
      if(is_array($evaluadores))
      foreach($evaluadores as $tipo=>$values) 
      { 
        if(is_array($values)) {
          foreach($values as $evaluador) 
          {
            if(!$evaluador['email']) continue;
              if( ( $tipo == "autoevaluado" && !$this->isCompletedAutoevaluado() )
                      || ( $tipo != "autoevaluado" && !$this->isCompletedEvaluador($evaluador['email']))    
                  ) 
              {
                array_push( $evaluadores_tmp["pendientes"], $evaluador);
              }
              else
              {
                array_push( $evaluadores_tmp["completadas"], $evaluador);
              }
          }
        }
      }
      
      return $evaluadores_tmp;
    }


    public function getNumEvaluadores() {
      $people = $this->getEvaluadores();
      $num  = 0;
      if(is_array($people))
      foreach($people as $tipos) {
        if(is_array($tipos))
          $num += count($tipos);
      }
      return $num ;
    }

    public function isCompletedAutoevaluado() {
      $a = \Tresfera\Taketsystem\Models\Result:: where("evaluacion_id",$this->id)->where("is_autoevaluacion", 1)->count();
     
      if($a > 0) return true;
      return false;
    }

    public function isCompletedEvaluador($email) {
      $a = \Tresfera\Taketsystem\Models\Result::where("evaluacion_id",$this->id)->where("is_evaluacion", 1)->where("email", $email)->count();
      if($a > 0) return true;
      return false;
    }

    public function getDateAutoevaluado() {
      $a = \Tresfera\Taketsystem\Models\Result::where("evaluacion_id",$this->id)->where("is_autoevaluacion", 1)->first();
      if(isset($a->created_at)) return $a->created_at;
      return false;
    }
    
    public function getDateCompletedEvaluador($email) {
      $a = \Tresfera\Taketsystem\Models\Result::where("evaluacion_id",$this->id)->where("is_evaluacion", 1)->where("email", $email)->first();
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
      $validacion = $this->validarEmail();
      $this->password = $this->generaPass();

      if(!$validacion['ok'])
      {
        return false;
      }
      else
      {
        if( !$validacion["emails_error"] )
        {
          \Flash::success(e(trans('tresfera.talentapp::lang.evaluadores.save_ok')));
        }
        else
        {
          \Flash::error( e(trans('tresfera.talentapp::lang.evaluadores.save_ko')). json_encode($validacion["emails_error"]));
        }
        return true;
      }

      return true;
    }

    public function afterSave() {
      
      

      if(isset($evaluacion->id)) {
        $eval_tmp = $this->getEvaluaciones();
        if( count($eval_tmp["pendientes"])==0)
        {
            $this->estado = 2;
            $this->save();
            \Queue::push('\Tresfera\Talentapp\Classes\Jobs\GenerateRapport',$this->id,"rapports");
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
     // echo $username."-".$this->password;
     // echo "<br>";
      $proyecto = Proyecto::find($this->proyecto_id);
      $this->client_id = $proyecto->client_id;
      
      $user = User::where("email",$username)->first();

      if(!isset($user->id)) {
      
        $new = true;
        $user = new User([]);
        $faker = Factory::create();
  

        $user = \BackendAuth::register([
            'first_name' => $this->name,
            'login' => $username,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password
        ]);
      /*  $user->first_name            = $this->name;
        $user->login                 = $username;
        $user->email                 = $this->email;
        $user->password              = trim($this->password);
        $user->password_confirmation = trim($this->password);*/
       /* echo $user->password ."-".$user->password_confirmation;
        echo "<br>";*/
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

      
      $permissions = $user->permissions;
      if(!$permissions) $permissions = [];
      $permissions['rol_evaluado'] = 1;
      $permissions["backend.manage_preferences"] = 1;
      
      $user->permissions = $permissions;
      $user->save();

      $this->user_id = $user->id;
      $msg = "Ya estás registrado. Hemos mantenido tus datos de acceso.";
      if($this->lang == "en") {
        $msg = "You are already registered. We have maintained your access data.";
      }
      $data = [
        "name" => $this->name,
        "username" => $username,
        "password" => isset($new)?$this->password:$msg,
        "url_backend" => 'https://talentapp360.taket.es/backend',
      ];
      $theme = 'talentapp.require.aprovacion';
      if($this->lang == "en")
        $theme = 'talentapp.require.aprovacion_en';
      \Mail::queue($theme, $data, function($message) use ($user)
      {
          $message->to($user->email,$user->first_name);
      });

      if(true) {
        if(!is_array($this->jefe))
          $this->jefe = [];
        if(!is_array($this->companero))
          $this->companero = [];
        if(!is_array($this->colaborador))
          $this->colaborador = [];
        if(!is_array($this->otro))
          $this->otro = [];

        $stats = [];
        $stats['autoevaluado'] = [];
        $stats['autoevaluado'][$this->email] = [
                                              'name' => $this->name,
                                              'email'=> $this->email,
                                              'url' => $this->getUrl($this->email,"",$this->lang),
                                              'send_at' => $this->created_at,
                                              'lang' => $this->lang,
                                              'completed_at' => '',
                                              'send' => 1,
                                              'completed' => 0
                                            ];
        $stats["numTotal"] =1;
        $stats["numAnswered"]=0;

        $validacion = $this->validarEmail();
        if(is_array($this->tipo))
        foreach($this->tipo as $tipo=>$text) {
          if(isset($this->$text))
          foreach($this->$text as $contacto) {
            $stats[$text][$contacto['email']] = [
                                                  'name' => $contacto['name'],
                                                  'email'=> $contacto['email'],
                                                  'url' => $this->getUrl($contacto['email'],$text,$contacto['lang']?$contacto['name']:$this->lang),
                                                  'lang' => $contacto['lang']?$contacto['lang']:$this->lang,
                                                  'send_at' => '',
                                                  'completed_at' => '',
                                                  'send' => 0,
                                                  'completed' => 0
                                                ];
            $stats["numTotal"]++;
          }
        }
        $this->stats = $stats;
      }
      $this->save();
    }
    
    public function beforeUpdate() {
      $dirty = $this->getDirty();
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
          \Flash::success(e(trans('tresfera.talentapp::lang.evaluadores.save_ok')));
        }
        else
        {
          \Flash::error( e(trans('tresfera.talentapp::lang.evaluadores.save_ko')). json_encode($validacion["emails_error"]));
        }
      }

      if(!is_array($this->jefe))
        $this->jefe = [];
      if(!is_array($this->companero))
        $this->companero = [];
      if(!is_array($this->colaborador))
        $this->colaborador = [];
      if(!is_array($this->otro))
        $this->otro = [];

      //if($this->estado==1) {
        $stats = $this->stats;

        if(is_array($this->tipo)) {
          foreach($this->tipo as $tipo=>$text) {
            if(isset($this->$text)) {
              foreach($this->$text as $contacto) {
                if(isset($stats[$text][$contacto['email']])) continue;
                $stats[$text][$contacto['email']] = [
                                                      'name' => $contacto['name'],
                                                      'email'=> $contacto['email'],
                                                      'url' => $this->getUrl($contacto['email'],$text,$contacto['lang']?$contacto['lang']:$this->lang),
                                                      'send_at' => '',
                                                      'lang' => $contacto['lang']?$contacto['lang']:$this->lang,
                                                      'completed_at' => '',
                                                      'send' => 0,
                                                      'completed' => 0
                                                    ];
                $stats["numTotal"]++;
              }
            }
          }
        }
        $this->stats = $stats;
      //}

      /*if($this->estado==1) {
        $stats = [];
        $stats['autoevaluado'] = [];
        $stats['autoevaluado'][$this->email] = [
                                              'name' => $this->name,
                                              'email'=> $this->email,
                                              'url' => $this->getUrl($this->email),
                                              'send_at' => '',
                                              'completed_at' => '',
                                              'send' => 0,
                                              'completed' => 0
                                            ];
        $stats["numTotal"] =1;
        $stats["numAnswered"]=0;
        if(is_array($this->tipo))
        foreach($this->tipo as $tipo=>$text) {
          if(isset($this->$text))
          foreach($this->$text as $contacto) {
            $stats[$text][$contacto['email']] = [
                                                  'name' => $contacto['name'],
                                                  'email'=> $contacto['email'],
                                                  'url' => $this->getUrl($contacto['email'],$text),
                                                  'send_at' => '',
                                                  'completed_at' => '',
                                                  'send' => 0,
                                                  'completed' => 0
                                                ];
            $stats["numTotal"]++;
          }
        }
        $this->stats = $stats;
      }*/

    }

    public function getUrl($email, $type = "", $lang = "es") {
      
      if($this->proyecto->type == "edu") {
        if( $lang == 'en') {
          $url_base = "https://talentapp360.taket.es/quiz/talentapp360_edu-en";
        } else {
          $url_base = "https://talentapp360.taket.es/quiz/talentapp360_edu";
        }
        return ($url_base."?talentapp=1&ev=".$this->id."&a=".$email);
      }
      if(!$type) {
        if( $lang == 'en') {
          $url_base = "https://talentapp360.taket.es/quiz/iese-autoevaluado-en";
        } else {
          $url_base = "https://talentapp360.taket.es/quiz/iese-autoevaluado";
        }
        return ($url_base."?talentapp=1&ev=".$this->id."&a=".$email);
      } else {
        if( $lang == 'en') {
          $url_base = "https://talentapp360.taket.es/quiz/iese-evaluador-en";
        } else {
          $url_base = "https://talentapp360.taket.es/quiz/iese-evaluador";
        }
        return ($url_base."?talentapp=1&ev=".$this->id."&e=".$email."&t=".$type);
      }
    }

    public function getEvaluadoIdOptions()
    {
        return [];
    }

    public function getEvaluadores()
    {
      $evaluadores = [];
      $evaluadores["autoevaluado"] = []; 
      $evaluadores["jefe"] = [];
      $evaluadores["companero"] = [];
      $evaluadores["colaborador"] = [];
      $evaluadores["otro"] = [];

      if( isset($this->stats["numTotal"]) ) $evaluadores["numTotal"] = $this->stats["numTotal"];
      if( isset($this->stats["numAnswered"]) ) $evaluadores["numAnswered"] = $this->stats["numAnswered"];

      if(isset($this->stats["autoevaluado"]))
      {
        foreach($this->stats["autoevaluado"] as $email => $autoevaluado)
        {
          if(!$autoevaluado['email']) continue;

          if(!isset($autoevaluado["email"])) $autoevaluado["email"] = $email;
          $evaluadores["autoevaluado"][$autoevaluado["email"]] = [];
          $evaluadores["autoevaluado"][$autoevaluado["email"]]["email"] = $autoevaluado["email"];
          (isset($autoevaluado["url"])) ? $evaluadores["autoevaluado"][$autoevaluado["email"]]["url"] = $autoevaluado["url"]
                                        : $evaluadores["autoevaluado"][$autoevaluado["email"]]["url"] = "";
          (isset($autoevaluado["send_at"])) ? $evaluadores["autoevaluado"][$autoevaluado["email"]]["send_at"] = $autoevaluado["send_at"]
                                            : $evaluadores["autoevaluado"][$autoevaluado["email"]]["send_at"] = "";
          (isset($autoevaluado["lang"])) ? $evaluadores["autoevaluado"][$autoevaluado["email"]]["lang"] = $autoevaluado["lang"]
                                         : $evaluadores["autoevaluado"][$autoevaluado["email"]]["lang"] = "";
          (isset($autoevaluado["completed_at"])) ? $evaluadores["autoevaluado"][$autoevaluado["email"]]["completed_at"] = $autoevaluado["completed_at"]
                                                 : $evaluadores["autoevaluado"][$autoevaluado["email"]]["completed_at"] = "";
          (isset($autoevaluado["send"])) ? $evaluadores["autoevaluado"][$autoevaluado["email"]]["send"] = $autoevaluado["send"]
                                         : $evaluadores["autoevaluado"][$autoevaluado["email"]]["send"] = "";
          (isset($autoevaluado["completed"])) ? $evaluadores["autoevaluado"][$autoevaluado["email"]]["completed"] = $autoevaluado["completed"]
                                              : $evaluadores["autoevaluado"][$autoevaluado["email"]]["completed"] = "";
          (isset($autoevaluado["name"])) ? $evaluadores["autoevaluado"][$autoevaluado["email"]]["name"] = $autoevaluado["name"]
                                         : $evaluadores["autoevaluado"][$autoevaluado["email"]]["name"] = "";
      
        }
      }
      if(is_array($this->jefe))
      foreach($this->jefe as $email => $evaluador)
      {
        if(!$evaluador['email']) continue;
        $evaluadores["jefe"][$evaluador["email"]] = [];
        $evaluadores["jefe"][$evaluador["email"]]["email"] = $evaluador["email"];
        (isset($this->stats["jefe"][$evaluador["email"]]["url"])) ? $evaluadores["jefe"][$evaluador["email"]]["url"] = $this->stats["jefe"][$evaluador["email"]]["url"]
                                                                  : $evaluadores["jefe"][$evaluador["email"]]["url"] = "";
        (isset($this->stats["jefe"][$evaluador["email"]]["send_at"])) ? $evaluadores["jefe"][$evaluador["email"]]["send_at"] = $this->stats["jefe"][$evaluador["email"]]["send_at"]
                                                                      : $evaluadores["jefe"][$evaluador["email"]]["send_at"] = "";
        (isset($evaluador["lang"])) ? $evaluadores["jefe"][$evaluador["email"]]["lang"] = $evaluador["lang"]
                                    : $evaluadores["jefe"][$evaluador["email"]]["lang"] = "";
        (isset($this->stats["jefe"][$evaluador["email"]]["completed_at"])) ? $evaluadores["jefe"][$evaluador["email"]]["completed_at"] = $this->stats["jefe"][$evaluador["email"]]["completed_at"]
                                                                           : $evaluadores["jefe"][$evaluador["email"]]["completed_at"] = "";
        (isset($this->stats["jefe"][$evaluador["email"]]["send"])) ? $evaluadores["jefe"][$evaluador["email"]]["send"] = $this->stats["jefe"][$evaluador["email"]]["send"]
                                                                   : $evaluadores["jefe"][$evaluador["email"]]["send"] = "";
        (isset($this->stats["jefe"][$evaluador["email"]]["completed"])) ? $evaluadores["jefe"][$evaluador["email"]]["completed"] = $this->stats["jefe"][$evaluador["email"]]["completed"]
                                                                        : $evaluadores["jefe"][$evaluador["email"]]["completed"]  = "";
        (isset($this->stats["jefe"][$evaluador["email"]]["name"])) ? $evaluadores["jefe"][$evaluador["email"]]["name"] = $this->stats["jefe"][$evaluador["email"]]["name"]
                                                                   : $evaluadores["jefe"][$evaluador["email"]]["name"] = "";
      }
      if(is_array($this->companero))
      foreach($this->companero as $email => $evaluador)
      {
        if(!$evaluador['email']) continue;
        $evaluadores["companero"][$evaluador["email"]] = [];
        $evaluadores["companero"][$evaluador["email"]]["email"] = $evaluador["email"];
        (isset($this->stats["companero"][$evaluador["email"]]["url"])) ? $evaluadores["companero"][$evaluador["email"]]["url"] = $this->stats["companero"][$evaluador["email"]]["url"]
                                                                       : $evaluadores["companero"][$evaluador["email"]]["url"] = "";
        (isset($this->stats["companero"][$evaluador["email"]]["send_at"])) ? $evaluadores["companero"][$evaluador["email"]]["send_at"] = $this->stats["companero"][$evaluador["email"]]["send_at"]
                                                                           :  $evaluadores["companero"][$evaluador["email"]]["send_at"] = "";
        (isset($evaluador["lang"])) ? $evaluadores["companero"][$evaluador["email"]]["lang"] = $evaluador["lang"]
                                    : $evaluadores["companero"][$evaluador["email"]]["lang"] = "";
        (isset($this->stats["companero"][$evaluador["email"]]["completed_at"])) ? $evaluadores["companero"][$evaluador["email"]]["completed_at"] = $this->stats["companero"][$evaluador["email"]]["completed_at"]
                                                                                : $evaluadores["companero"][$evaluador["email"]]["completed_at"] = "";
        (isset($this->stats["companero"][$evaluador["email"]]["send"])) ? $evaluadores["companero"][$evaluador["email"]]["send"] = $this->stats["companero"][$evaluador["email"]]["send"]
                                                                        : $evaluadores["companero"][$evaluador["email"]]["send"] = "";
        (isset($this->stats["companero"][$evaluador["email"]]["completed"])) ? $evaluadores["companero"][$evaluador["email"]]["completed"] = $this->stats["companero"][$evaluador["email"]]["completed"]
                                                                             : $evaluadores["companero"][$evaluador["email"]]["completed"] = "";
        (isset($this->stats["companero"][$evaluador["email"]]["name"])) ? $evaluadores["companero"][$evaluador["email"]]["name"] = $this->stats["companero"][$evaluador["email"]]["name"]
                                                                        : $evaluadores["companero"][$evaluador["email"]]["name"] = "";
      }
      if(is_array($this->colaborador))
      foreach($this->colaborador as $email => $evaluador)
      {
        if(!$evaluador['email']) continue;

        $evaluadores["colaborador"][$evaluador["email"]] = [];
        $evaluadores["colaborador"][$evaluador["email"]]["email"] = $evaluador["email"];
        (isset($this->stats["colaborador"][$evaluador["email"]]["url"])) ? $evaluadores["colaborador"][$evaluador["email"]]["url"] = $this->stats["colaborador"][$evaluador["email"]]["url"]
                                                                         : $evaluadores["colaborador"][$evaluador["email"]]["url"] = "";
        (isset($this->stats["colaborador"][$evaluador["email"]]["send_at"])) ? $evaluadores["colaborador"][$evaluador["email"]]["send_at"] = $this->stats["colaborador"][$evaluador["email"]]["send_at"]
                                                                             : $evaluadores["colaborador"][$evaluador["email"]]["send_at"] = "";
        (isset($evaluador["lang"])) ? $evaluadores["colaborador"][$evaluador["email"]]["lang"] = $evaluador["lang"]
                                    : $evaluadores["colaborador"][$evaluador["email"]]["lang"] = "";
        (isset($this->stats["colaborador"][$evaluador["email"]]["completed_at"])) ? $evaluadores["colaborador"][$evaluador["email"]]["completed_at"] = $this->stats["colaborador"][$evaluador["email"]]["completed_at"]
                                                                                  : $evaluadores["colaborador"][$evaluador["email"]]["completed_at"] = "";
        (isset($this->stats["colaborador"][$evaluador["email"]]["send"])) ? $evaluadores["colaborador"][$evaluador["email"]]["send"] = $this->stats["colaborador"][$evaluador["email"]]["send"]
                                                                          : $evaluadores["colaborador"][$evaluador["email"]]["send"] = "";
        (isset($this->stats["colaborador"][$evaluador["email"]]["completed"])) ? $evaluadores["colaborador"][$evaluador["email"]]["completed"] = $this->stats["colaborador"][$evaluador["email"]]["completed"]
                                                                               : $evaluadores["colaborador"][$evaluador["email"]]["completed"] = "";
        (isset($this->stats["colaborador"][$evaluador["email"]]["name"])) ? $evaluadores["colaborador"][$evaluador["email"]]["name"] = $this->stats["colaborador"][$evaluador["email"]]["name"]
                                                                               : $evaluadores["colaborador"][$evaluador["email"]]["name"] = "";
      }
      if(is_array($this->otro))
      foreach($this->otro as $email => $evaluador)
      {
        if(!$evaluador['email']) continue;
        $evaluadores["otro"][$evaluador["email"]] = [];
        $evaluadores["otro"][$evaluador["email"]]["email"] =$evaluador["email"];
        (isset($this->stats["otro"][$evaluador["email"]]["url"])) ? $evaluadores["otro"][$evaluador["email"]]["url"] = $this->stats["otro"][$evaluador["email"]]["url"]
                                                                  : $evaluadores["otro"][$evaluador["email"]]["url"] = "";
        (isset($this->stats["otro"][$evaluador["email"]]["send_at"])) ? $evaluadores["otro"][$evaluador["email"]]["send_at"] = $this->stats["otro"][$evaluador["email"]]["send_at"]
                                                                      : $evaluadores["otro"][$evaluador["email"]]["send_at"] = "";
        (isset($evaluador["lang"])) ? $evaluadores["otro"][$evaluador["email"]]["lang"] = $evaluador["lang"]
                                    : $evaluadores["otro"][$evaluador["email"]]["lang"] = "";
        (isset($this->stats["otro"][$evaluador["email"]]["completed_at"])) ? $evaluadores["otro"][$evaluador["email"]]["completed_at"] = $this->stats["otro"][$evaluador["email"]]["completed_at"]
                                                                           : $evaluadores["otro"][$evaluador["email"]]["completed_at"] = "";
        (isset($this->stats["otro"][$evaluador["email"]]["send"])) ? $evaluadores["otro"][$evaluador["email"]]["send"] = $this->stats["otro"][$evaluador["email"]]["send"]
                                                                   : $evaluadores["otro"][$evaluador["email"]]["send"] = "";
        (isset($this->stats["otro"][$evaluador["email"]]["completed"])) ? $evaluadores["otro"][$evaluador["email"]]["completed"] = $this->stats["otro"][$evaluador["email"]]["completed"]
                                                                        : $evaluadores["otro"][$evaluador["email"]]["completed"] = "";
        (isset($this->stats["otro"][$evaluador["email"]]["name"])) ? $evaluadores["otro"][$evaluador["email"]]["name"] = $this->stats["otro"][$evaluador["email"]]["name"]
                                                                        : $evaluadores["otro"][$evaluador["email"]]["name"] = "";
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
              if($tipo == "autoevaluado")
              {
                  if( !$this->isCompletedAutoevaluado() ) 
                  {
                      $no_contestadas++;
                  }
                  else 
                  {
                      $contestadas++;
                  }
              }
              else 
              {
                  if($evaluador["completed"] != true)
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
      }

      return [ "total_evaluaciones" => $contestadas+$no_contestadas, "evaluaciones_cnt" => $contestadas, "evaluaciones_no_cnt" => $no_contestadas ];
    }

    // Devuelve el número total de evaluaciones contestadas, no contestadas y el total de todas las Evaluaciones de un usuario
    public static function getNumEvaluaciones($user_id)
    {
      $evals = Evaluacion::where('user_id', $user_id)->get();

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
  

    public function getFrases() {
      if($this->lang == "es") {
        $frases = [
          "Visión Estratégica" => [
            "Analiza la situación del mercado",
            "Analiza las tendencias y prácticas más relevantes del ámbito empresarial",
            "Conoce las innovaciones que producen ventaja competitiva",
            "Sabe describir en pocas líneas las características de su empresa ",
            "Sabe cuáles son las fortalezas y debilidades de su empresa ",
            "Busca información sobre el sector a nivel local, nacional e internacional",
            "Analiza los factores que crean ventaja competitiva",
            "Analiza el entorno para aprovechar las oportunidades",
            "Define los objetivos y prioridades estratégicas",
          ],
          "Visión de la Organización" => [
            "Conoce los resultados de otras áreas y/o departamentos",
            "Conoce la relación de su trabajo con el de otras áreas y/o departamentos",
            "Puede describir en pocas líneas las funciones de otras áreas y/o departamentos",
            "Informa de los temas de su área que puedan afectar a otros",
            "Acepta el feedback de otras áreas y/o departamentos",
            "Sabe que procesos inciden en otras áreas y /departamentos",
            "Respeta las funciones asignadas a otras áreas",
            "Facilita el trabajo a otras áreas y/o departamentos",
            "Concreta procesos de mejora más allá de su propia función",
            
          ],
          "Orientación al Cliente" => [
            "Resuelve las quejas y sugerencias buscando en qué y cómo mejorar",
            "Sabe ganarse el respeto y confianza de los clientes",
            "Orienta su trabajo a satisfacer las necesidades de los clientes",
            "Sabe escuchar, sin ofenderse, para conocer mejor a las personas y sus necesidades",
            "Establece y mantiene relaciones de confianza y respeto con los clientes",
            "Dedica tiempo a pensar cómo satisfacer mejor las necesidades reales (presentes y futuras)",
            "Se preocupa por mejorar constantemente la calidad de los servicios y productos",
            "Diseña los procesos y establece los plazos en función de las necesidades reales",
            "Cuida los detalles para ofrecer un buen servicio",
  
          ],
          "Networking" => [
            "Adopta una posición activa y mantiene contacto con personas clave",
            "Sabe pedir opinión a las personas adecuadas ante situaciones difíciles",
            "Algunas personas acuden habitualmente a Vd., de manera informal, para comentar asuntos profesionales",
            "Asiste con regularidad  a reuniones clave, congresos, etc.",
            "Reserva tiempo para mantener y desarrollar relaciones con profesionales de su área u otras áreas de conocimiento",
            "Mantiene reuniones informales en su empresa para estar al día de cuestiones relevantes",
            "Dedica tiempo a sus contactos ",
            "Sabe qué personas, eventos e instituciones son clave para su actividad",
            "Sabe pedir y hacer favores a sus conocidos",

          ],
          "Comunicación" => [
            "Organiza las ideas y selecciona la información",
            "Sus mensajes son concretos y tienen contenido",
            "Cuida la actitud, el lenguaje, y la expresión",
            "Adapta el mensaje a la preparación intelectual, emocional y/o edad del interlocutor...",
            "Es flexible y se asegura de que le han entendido",
            "Escoge el medio idóneo (reunión, entrevista...) y el momento adecuado",
            "Se esfuerza por entender el punto de vista del otro",
            "Muestra empatía y formula preguntas a lo largo de la conversación",
            "Deja hablar sin interrumpir, tratando de comprender y asimilar lo que le dicen",

          ],
          "Delegación" => [
            "Conoce las capacidades de sus colaboradores",
            "Sabe encajar a cada persona en el perfil del puesto más adecuado a sus capacidades",
            "Delega las tareas y proyectos en función de las capacidades de los colaboradores",
            "Establece objetivos y plazos y fomenta el sentido de responsabilidad y profesionalidad",
            "Planifica las tareas y proporciona la ayuda, los recursos y el seguimiento necesarios",
            "Transmite la información y establece límites y criterios generales de actuación",
            "Evita entrar en detalles minuciosos de cómo deben realizar su tarea",
            "Delega todo aquello que la situación lo permita, sin perder la dirección del proyecto",
            "Fomenta la iniciativa, dando el margen necesario",

          ],
          "Coaching" => [
            "Dedica tiempo y atención a sus colaboradores",
            "Está accesible y evita dejarse llevar por el exceso de trabajo o la falta de interés",
            "Pregunta y escucha para entender las circunstancias, intereses y expectativas",
            "Se centra en hechos concretos",
            "Corrige constructivamente, aportando posibles soluciones",
            "Destaca los aspectos positivos y basa su relación en la confianza",
            "Invierte tiempo en el desarrollo de las personas",
            "Ayuda a diagnosticar correctamente las fortalezas y áreas de mejora de las personas",
            "Establece una agenda de seguimiento periódico con sus colaboradores y la respeta",

          ],
          "Trabajo en Equipo" => [
            "Conoce los objetivos y la dinámica de las reuniones",
            "Participa activamente en la toma de decisiones y las asume personalmente",
            "Lleva a cabo las tareas que se le encomiendan",
            "Crea un ambiente proactivo",
            "Promueve el diálogo constructivo entre los miembros del equipo",
            "Evita las alusiones personales en los momentos de discrepancia",
            "Sabe integrar sus conocimientos y habilidades de modo que beneficien al equipo",
            "Basa su relación en la interdependencia y colaboración y disfruta de los logros de todos",
            "Confía en lo que hacen los demás miembros del equipo y escucha sus puntos de vista",

          ],
          "Gestión del Tiempo" => [
            "Prevé y decide el mejor momento para cumplir las tareas que le competen",
            "Dedica el tiempo necesario a cada tarea, respeta los plazos, es diligente",
            "Dispone de tiempo para sí mismo, la familia y los amigos",
            "Repasa periódicamente las tareas que debe hacer",
            "Sabe qué y cuándo debe hacer cada cosa",
            "Lleva su agenda con orden, respetando lo previsto",
            "Determina las prioridades de los diferentes compromisos",
            "Respeta los plazos y dedica el tiempo a lo importante, sin dejarse llevar por lo urgente",
            "Evita interrupciones innecesarias sin caer en la precipitación",

          ],
          "Gestión del Estrés" => [
            "Distingue las situaciones en las que aparece el estrés y sabe cómo hacerle frente ",
            "Sabe relajarse y utilizar las estrategias  adecuadas",
            "Ve las cosas en perspectiva evitando las circunstancias que le producen estrés",
            "Tiene voluntad para respetar los horarios de sueño, descanso...",
            "Tiene un horario para el trabajo, el descanso, la familia.... y procura cumplirlo",
            "Dedica tiempo a hobbies y ocupaciones más allá del trabajo",
            "Trata de establecer y de cuidar relaciones interpersonales profundas",
            "Es capaz de cortar con el trabajo cuando está con la familia o los amigos",
            "Dedica tiempo suficiente para hacer vida social",

          ],
          "Optimismo" => [
            "Está convencido de que las cosas saldrán",
            "Ve lo positivo de cada situación, sin dejarse llevar por el escepticismo o la experiencia",
            "Se muestra seguro cuando debe tomar decisiones",
            "No se desanima ante las dificultades ni desiste ante los obstáculos del entorno",
            "Sabe pasar página sin hundirse ante los reveses profesionales y personales",
            "Aprende de los errores y piensa más en los aciertos y éxitos que en los fracasos",
            "No se deja llevar por el pesimismo ante las primeras dificultades",
            "Saca lo mejor de cada situación",
            "Celebra las pequeñas victorias",

          ],
          "Iniciativa" => [
            "Actúa con independencia en su trabajo, sin consultar cada paso",
            "No se conforma con el estado actual de las cosas y busca cómo mejorarlas",
            "Asume nuevos retos",
            "No se deja llevar por las situaciones y cree que es posible cambiarlas",
            "No se conforma con lo que ya funciona y cree que hay margen para mejorar las cosas",
            "Dedica tiempo a pensar cómo mejorar y a encontrar nuevas formas de hacer las cosas",
            "No se conforma con la primera solución y genera diversas alternativas ",
            "Identifica posibilidades de cambio, sin dejarse dominar por el miedo al fracaso o al error",
            "Tiene una actitud de curiosidad y busca distintas soluciones para mejorar las cosas",

          ],
          "Aprendizaje" => [
            "Tiene un plan de formación a corto, medio y largo plazo",
            "Tiene un tiempo concreto para su formación personal y profesional",
            "Está al día de los conocimientos propios de sus funciones",
            "Tiene actualmente un objetivo claro y concreto de mejora personal y profesional",
            "Tiene constancia en la mejora de sus conocimientos, capacidades y habilidades",
            "Ha logrado en los últimos meses mejorar en algo concreto personal o profesional",
            "Adquirir nuevos conocimientos que le permiten mejorar",
            "Aprende nuevas formas de trabajar que le hacen más flexible",
            "Está disponible para asumir nuevas tareas o actividades laborales",

          ],
          "Autoconocimiento" => [
            "Dedica tiempo a reflexionar sobre sí mismo y su comportamiento",
            "Reflexiona sobre sus experiencias y su modo de hacer las cosas",
            "Sabe cuáles son sus puntos fuertes y sus áreas de mejora",
            "Contrasta lo que piensa de sí mismo con personas que le conocen y en las que confía",
            "Genera confianza para que le puedan decir las cosas que debe mejorar",
            "Agradece las sugerencias que le manifiestan los demás",
            "Sabe identificar y comprender sus reacciones emocionales (enfados, incomodidad...)",
            "Controla sus sentimientos de modo que no interfieran en su trabajo ni en el de los demás",
            "Sabe comportarse de acuerdo con su posición",

          ],
          "Autocrítica" => [
            "Acepta su responsabilidad ante los fallos, sin buscar otros culpables,  y pide disculpas",
            "Admite que hace cosas peor que otras y que hay errores que pueden evitarse",
            "Reconoce que hay aspectos de su actuación que puede mejorar",
            "Agradece el consejo de los demás y sabe pedir disculpas",
            "Acepta con sencillez la opinión de los demás sin ponerse a la defensiva",
            "Se deja ayudar en aquellos aspectos en los que necesita mejorar",
            "No tiene miedo a la opinión sincera ni a que los demás le conozcan",
            "Sabe reírse de sí mismo",
            "Sabe ver en las críticas razonadas oportunidades de mejora",

          ],
          "Ambición" => [
            "Asume retos difíciles pero alcanzables y los persigue con tenacidad",
            "Se propone objetivos a largo plazo, con metas concretas para alcanzarlos",
            "Sabe mantener el esfuerzo aunque el resultado no sea inmediato",
            "Acomete las tareas con decisión, sin desanimarse, acabando los proyectos hasta el final",
            "Defiende sus puntos de vista con determinación y respeto",
            "Ejercita su voluntad con pequeños retos diarios, sin dejar las cosas a medias",
            "No se conforma con la mediocridad y el continuismo",
            "Se plantea metas elevadas y las persigue con determinación",
            "Busca proyectos que le ilusionan y motivan, sin caer en la rutina",

          ],
          "Toma de Decisiones" => [
            "Selecciona la información relevante para establecer las causas del problema",
            "Dedica el tiempo suficiente a analizar las circunstancias y definir el problema",
            "Se centra en los hechos y evita caer en intuiciones o en percepciones subjetivas",
            "Desarrolla alternativas que eliminan una o varias causas principales del problema",
            "Analiza distintas alternativas y compara los pros y contras de cada una",
            "Prevé las posibles consecuencias que pueden tener las alternativas planteadas",
            "Determina qué criterios son relevantes para decidir entre diversas alternativas",
            "Escoge una alternativa en función de los criterios definidos",
            "Diseña un plan de acción realista y concreto",

          ],
          "Integridad" => [
            "No cambia su actuación en función de las circunstancias",
            "Presenta la verdad de forma amable, sin tapujos y en el momento adecuado",
            "Toma postura sin hacer promesas que no puede cumplir",
            "Es un ejemplo para los que trabajan con ella/él",
            "Hace lo que dice y asume los compromisos que ha adquirido",
            "No cambia sus principios y valores ante cualquier tipo de presión",
            "Recaba la versión de las partes implicadas y los datos precisos al hacer valoraciones",
            "Comprende y corrige en lugar de juzgar y criticar",
            "Busca el equilibrio entre el cumplimiento estricto de la norma y la flexibilidad",

          ],
          "Autocontrol" => [
            "No se deja llevar por lo que más le apetece en cada momento",
            "Se concentra a fondo en los temas, sin saltar de uno a otro",
            "Es capaz de superar  el cansancio ante tareas complejas",
            "Hace los sacrificios necesarios para lograr sus objetivos",
            "Mantiene los compromisos a pesar del esfuerzo y las dificultades  ",
            "Realiza las tareas hasta el final, procurando hacerlas bien y cuidando los detalles ",
            "No se deja engañar ni busca excusas para acometer acciones costosas",
            "Ejercita el autocontrol, haciendo lo que debe en cada momento",
            "Supera las dificultades que conlleva realizar las tareas programadas ",

          ],
          "Equilibrio Emocional" => [
            "Es paciente con las propias limitaciones y con las de los demás",
            "Apacigua los ánimos en momentos de especial tensión",
            "Ante las discusiones trata de tomar distancia y adoptar un papel conciliador, sin darse por aludido ante ataques personales",
            "Sabe ponerse en el lugar de la otra persona, buscando poder ayudar",
            "Es oportuno en sus comentarios y sabe encontrar el momento adecuado",
            "Trata de tomar distancia y adoptar un papel conciliador",
            "Evita explosiones de mal humor, manteniendo un ánimo estable",
            "Expresa sus sentimientos de manera natural, sin excentricidades ni exageraciones",
            "Reacciona de manera proporcionada ante circunstancias tensas",

          ],
        ];
      } else {
        $frases = [
          "Visión Estratégica" => [
            "You analyze the market situation",
            "You analyze the most relevant trends and practices in the world of business",
            "You know the innovations that provide a competitive edge",
            "You can describe your company's characteristics in just a few lines ",
            "You know your company's strengths and weaknesses",
            "You look for information about your industry on a local, national and international level",
            "You analyze the factors that provide a competitive edge",
            "You analyze the environment to take advantage of opportunities",
            "You define the strategic goals and priorities",
          ],
          "Visión de la Organización" => [
            "You are aware of the results of other areas/departments",
            "You are aware of how your work is related to that of other areas/departments",
            "You can describe in few words the operation lines of other areas and departments",
            "You inform those who could be affected about your area's issues",
            "You accept the feedback from other areas and/or departments",
            "You know what processes affect other areas and/or departments",
            "You respect the duties assigned to each area ",
            "You make the work of other areas and/or departments easier",
            "You provide improvement processes beyond the extent of your duties",
            
          ],
          "Orientación al Cliente" => [
            "You solve complaints and suggestions by finding room for improvement",
            "You can earn your clients’ respect and trust",
            "You direct your work to satisfying client needs",
            "You can listen, without taking offense, to understand people and their needs better",
            "You establish and maintain trusting and respectful relationships with clients",
            "You dedicate time to think about how to better satisfy real needs (present and future ones)",
            "You take care of constantly improving the quality of services and products",
            "You design procedures and set deadlines based on real needs",
            "You take care of details to offer a good service",
  
          ],
          "Networking" => [
            "You take an active position and maintain in contact with key people",
            "You can ask the opinions of the appropriate people in difficult situations",
            "Some people frequently come to you, informally, to discuss professional issues",
            "You regularly attend key meetings, congresses, symposiums, etc.",
            "You set aside some time to maintain and develop business relationships in your area and other areas of knowledge",
            "You hold informal meetings in your company to be up to date on relevant issues ",
            "You devote time to your contacts",
            "You know what people, events and institutions are key for your activity",
            "You know how to ask for and do favors to your acquaintances",

          ],
          "Comunicación" => [
            "You organize the ideas and choose the information",
            "Your messages are concrete and bear meaning",
            "You pay attention to attitude, language and expression",
            "You adapt your message to the other person’s age and/or intellectual and emotional knowledge ",
            "You are flexible and make sure that you have been understood",
            "You choose the ideal medium (meeting, interview…) and the right time",
            "You try hard to understand the other person’s point of view",
            "You show empathy and ask questions during the conversation",
            "You let other people talk uninterrupted, trying to understand and assimilate what they say",

          ],
          "Delegación" => [
            "You know your collaborators’ abilities ",
            "You know how to allocate each person in the most appropriate job profile according to their abilities",
            "You delegate tasks and projects according to the collaborators’ abilities",
            "You set objectives and deadlines and you encourage a sense of responsibility and professionalism",
            "You plan the tasks and provide the necessary supports, resources and follow-up",
            "You relay information and set limits and general action guidelines",
            "You avoid discussing thorough details about how they should do their job",
            "You delegate everything that the situation allows, without losing relinquishing control of the project’s direction ",
            "You foster initiative, providing the necessary space",

          ],
          "Coaching" => [
            "You dedicate time and attention to your collaborators",
            "You make yourself available and don’t let excessive work or lack of interest get the better of you",
            "You ask and listen to understand the circumstances, interests and expectations",
            "You focus on specific facts",
            "You correct constructively, offering possible solutions",
            "You emphasize the positive aspects and base your relationship on trust",
            "You invest time in people’s development",
            "You help to correctly diagnose people’s strengths and areas for improvement",
            "You establish and commit to a regular follow-up schedule with your collaborators",

          ],
          "Trabajo en Equipo" => [
            "You know the objectives and dynamics of meetings",
            "You actively participate in decision making and make them your",
            "You follow through with assigned tasks",
            "You create a proactive atmosphere",
            "You encourage positive dialogue between the team members",
            "You avoid personal remarks in moments of disagreement",
            "You know how to integrate your expertise and skills so that they benefit the team",
            "You base your relationships on interdependence and collaboration and enjoy everyone’s achievements",
            "You trust what other team members do and listen to their points of view",

          ],
          "Gestión del Tiempo" => [
            "You predict and decide the best moment to fulfill your tasks",
            "You dedicate each task the time it needs, are diligent and reach meet deadlines",
            "You have time for yourself, your family and your friends",
            "You periodically review the tasks you must do",
            "You know what you have scheduled and when you should do it ",
            "You keep an organized calendar and you stick to your schedule",
            "You set the priorities of the different commitments",
            "You meet deadlines and dedicate time to what’s important, without being led astray by urgent matters",
            "You avoid unnecessary interruptions and don’t rush things",

          ],
          "Gestión del Estrés" => [
            "You can identify situations in which stress appears and know how to approach it",
            "You can relax and use proper strategies",
            "You keep things in perspective avoiding circumstances that cause stress",
            "You have the will power to get proper sleep and rest",
            "You schedule time for your work, your rest, your family… and you stick to it",
            "You dedicate time to hobbies and other activities outside of work",
            "You try to establish and take care of deep interpersonal relationships",
            "You are capable of disconnecting from work when you are with friends family or friends",
            "You dedicate enough time to your social life",

          ],
          "Optimismo" => [
            "You are positive that things will be all right",
            "You see the plus side of every situation and don’t let skepticism or experience get the better of you",
            "You show confidence when making decisions",
            "You don’t feel discouraged by difficulties or give in to the obstacles in your path",
            "You can move on are not crushed by professional and personal setbacks ",
            "You learn from mistakes and focus on success rather than failure",
            "You don’t let pessimism get the better of you upon the first difficulties",
            "You make the most of every situation",
            "You celebrate small victories",

          ],
          "Iniciativa" => [
            "You take independent action in your work without consulting every step",
            "You are not content with the status quo and try to improve it",
            "You take on new challenges",
            "You don’t let situations get the better of you and think it is possible to change them",
            "You don’t simply settle for what already works and believe there is room to improve things",
            "You dedicate time to think about how to improve and find new ways to do things",
            "You don’t settle for the first solution and come up with different alternatives",
            "You identify possibilities for change and don’t let the fear of failure or mistakes control you",
            "You have a curious attitude and look for different solutions to improve things",

          ],
          "Aprendizaje" => [
            "You have a short, medium and long term training plan",
            "You set aside specific time for your personal and professional training",
            "You are up to date on the knowledge of your duties",
            "At the moment, you have a clear and concrete goal for your personal and professional improvement",
            "You persevere in improving your knowledge, skills and abilities",
            "You have managed to improve in the last months something concrete both personally and professionally",
            "You acquire new knowledge which allows you to improve",
            "You learn new ways to work which make you more flexible",
            "You are open to taking on additional work tasks or activities",

          ],
          "Autoconocimiento" => [
            "You take time to reflect about yourself and your behavior",
            "You reflect upon your experiences and your way of doing things",
            "You know what your strengths are and also your areas for improvement",
            "You contrast what you think of yourself with the people who you trust and who know you",
            "You create trust so that people can tell you what you should improve",
            "You appreciate the suggestions that others offer you",
            "You can identify and understand your emotional reactions (anger, discomfort…)",
            "You control your feelings so that they do not interfere with your work or with other people",
            "You know how to behave according to your position",

          ],
          "Autocrítica" => [
            "You accept responsibility for mistakes without blaming others and you apologize",
            "You admit that there are some things you do worse than others and that certain mistakes can be prevented",
            "You recognize that there are aspects of your behavior that can be improved",
            "You appreciate other people’s advice and know how to say sorry",
            "You sincerely accept others’ opinions without getting defensive",
            "You let others help you in those areas where you need to improve",
            "You are not afraid of sincere opinions and that others be aware of them",
            "You can laugh at yourself",
            "You can see opportunities for improvement in reasoned criticism",

          ],
          "Ambición" => [
            "You take on difficult yet reachable challenges and tenaciously go after them",
            "You set yourself long-term goals with concrete milestones to reach them",
            "You know how to maintain your effort even when the result are not immediate",
            "You approach tasks with determination, without getting discouraged, completing the projects up until the end ",
            "You defend your points of view with determination and respect",
            "You exercise your will power with little daily challenges and don’t leave things unfinished",
            "You do not settle for mediocrity and the status quo",
            "You set high goals for yourself and pursue them with determination",
            "You find exciting, motivating projects and stay away from routine",

          ],
          "Toma de Decisiones" => [
            "You select relevant information to determine the causes of the problem",
            "You take sufficient time to analyze the circumstances and define the problem",
            "You focus on the facts and avoid being led by intuitions or subjective perspectives",
            "You develop alternatives that remove one or several main causes of the problem",
            "You analyze different alternatives and compare the pros and cons of each one",
            "You foresee the possible consequences that the proposed alternatives may have",
            "You determine which criteria is relevant to choose between different alternatives",
            "You choose one alternative according to the defined criteria",
            "You design a realistic and concrete plan of action",
            
          ],
          "Integridad" => [
            "You do not change your behavior according to the circumstances",
            "You present the truth in a kindly manner, without sugar-coating and at the right moment",
            "You take sides and don’t make promises you can’t keep",
            "You are a role model for those who work with you",
            "You do what you say and stick to your commitments",
            "You don’t change your principles and values under any pressure",
            "You obtain precise facts from various parties when making an evaluation",
            "You understand and correct instead of judging and criticizing",
            "You seek balance between strict compliance with the rules and flexibility",

          ],
          "Autocontrol" => [
            "You don’t let your whims guide you",
            "You completely focus on things without jumping from one to another",
            "You are able to overcome fatigue during complex tasks",
            "You make the necessary sacrifices to reach your goals",
            "You keep your commitments regardless of the effort and difficulty",
            "You fulfill your tasks until the end, you try to do them well and with attention to detail",
            "You don’t let yourself be fooled or find excuses to undertake arduous actions",
            "You practice self-control doing what you must in each moment",
            "You overcome difficulties that come with completing scheduled tasks",

          ],
          "Equilibrio Emocional" => [
            "You are patient with your own and other people’s limitations",
            "You calm tempers in especially tense moments",
            "You take a distance in arguments and take on a mediating role and don’t take things personally",
            "You can put yourself in the other person’s shoes, trying to help",
            "You choose the appropriate comments and find the right moment to speak",
            "You try to distance yourself and adopt a mediating role",
            "You avoid bad-moods outbursts, keeping a stable attitude",
            "You express your feelings in a natural way without eccentricities or exaggerations",
            "You react proportionally in tense circumstances",
            
          ],
        ];
      }
      return $frases;
    }


    public function translateCompetencia($competencia)
    {
      $competencias = [
        "Vision Estratégica" => [
          "es" => "Vision Estratégica",
          "en" => "Strategic View"
        ],
        "Visión de la Organización" => [
          "es" => "Visión de la Organización",
          "en" => "Organization's View"
        ],
        "Orientación al Cliente" => [
          "es" => "Orientación al Cliente",
          "en" => "Client-orientation"
        ],
        "Networking" => [
          "es" => "Networking",
          "en" => "Networking"
        ],
        "Comunicación" => [
          "es" => "Comunicación",
          "en" => "Communication"
        ],
        "Delegación" => [
          "es" => "Delegación",
          "en" => "Delegation"
        ],
        "Coaching" => [
          "es" => "Coaching",
          "en" => "Coaching"
        ],
        "Trabajo en Equipo" => [
          "es" => "Trabajo en Equipo",
          "en" => "Team Work"
        ],
        "Gestión del Tiempo" => [
          "es" => "Gestión del Tiempo",
          "en" => "Time Management"
        ],
        "Gestión del Estrés" => [
          "es" => "Gestión del Estrés",
          "en" => "Stress Management"
        ],
        "Optimismo" => [
          "es" => "Optimismo",
          "en" => "Optimism"
        ],
        "Iniciativa" => [
          "es" => "Iniciativa",
          "en" => "Initiative"
        ],
        "Aprendizaje" => [
          "es" => "Aprendizaje",
          "en" => "Learning"
        ],
        "Autoconocimiento" => [
          "es" => "Autoconocimiento",
          "en" => "Self-knowledge"
        ],
        "Autocrítica" => [
          "es" => "Autocrítica",
          "en" => "Self-criticism"
        ],
        "Ambición" => [
          "es" => "Ambición",
          "en" => "Audacity"
        ],
        "Toma de Decisiones" => [
          "es" => "Toma de Decisiones",
          "en" => "Decision-making"
        ],
        "Integridad" => [
          "es" => "Integridad",
          "en" => "Integrity"
        ],
        "Autocontrol" => [
          "es" => "Autocontrol",
          "en" => "Self-control"
        ],
        "Equilibrio Emocional" => [
          "es" => "Equilibrio Emocional",
          "en" => "Emotional Balance"
        ],
      ];

      if(isset($competencias[$competencia])) {
        if(isset($competencias[$competencia][$this->lang])) return $competencias[$competencia][$this->lang];
      }
      return $competencia;
   
    }


}
