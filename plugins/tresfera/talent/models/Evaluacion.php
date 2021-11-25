<?php namespace Tresfera\Talent\Models;

use Backend\Models\UserRole;

use Model;
use Validator;
use Backend\Models\User;
use Backend\Models\UserGroup;
/**
 * Model
 */
class Evaluacion extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \Tresfera\Talentapp\Traits\TraitEvaluacion;
    
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_talent_evaluacion';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $jsonable = ['params', 'stats'];

    public $hasOne = [
        'result' => [
            'Tresfera\Talent\Models\Result',
        ],
        'rapport' => [
            'Tresfera\Talent\Models\Rapport',
        ]
    ];

    public $belongsTo = [
        'proyecto' => [
            'Tresfera\Talent\Models\Proyecto'
        ]
    ];

    public function isCompleted()
    {
        $a = \Tresfera\Talent\Models\Result::where("evaluacion_id",$this->id)->count();
        if($a > 0) return true;
        return false;
    }
    public function getLang() {
        if($this->lang)
         return $this->lang;
        else
         return $this->proyecto->lang;
  
      }
    public function validarEmail() 
    {
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
            return false;
        }

        return true;
    }

    public function beforeCreate() 
    {
      
        $validacion = $this->validarEmail();
        $this->password = $this->generaPass();
  
        if($validacion)
        {
            \Flash::success(e(trans('tresfera.talent360::lang.evaluadores.save_ok')));
        }
        
        return $validacion;
    }
    
    public function afterCreate() 
    {
        if($this->lang != "es" && $this->lang != "en") {
            $this->lang = $this->proyecto->lang;
        }

        $username = ( strtolower( $this->email ));
  
        $proyecto = Proyecto::find($this->proyecto_id);
        $this->client_id = $proyecto->client_id;
        
        $user = User::where("login",$username)->first();
        if(!isset($user)) {
            $new = true;
            $user = new User([]);
            //$faker = Factory::create();

            $rol = UserRole::where("code", "talentapp:evaluado")->first();
            if( isset($rol->id) ) $user->role_id = $rol->id;

            $user->first_name            = $this->name;
            $user->login                 = $username;
            $user->email                 = $this->email;
            $user->password              = $this->password;
            $user->password_confirmation = $this->password;
            $user->client_id	         = $this->id;
            $user->is_activated          = 1;
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
        } else {
            /*$rol = UserRole::where("code", "talentapp:evaluado")->first();
            if( isset($rol->id) ) { 
                $user->role_id = $rol->id;
                $user->save();
            }*/
            $permissions = $user->permissions;
            if(!$permissions) $permissions = [];
            $permissions['talent.access'] = 1;
            $permissions["backend.manage_preferences"] = 1;
            
            $user->permissions = $permissions;
            $user->save();
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
            "url_backend" => 'https://talentapp.taket.es/backend',
        ];
        $theme = 'talent.require.aprovacion';
        if($this->lang == "en")
            $theme = 'talent.require.aprovacion_en';

        \Mail::queue($theme, $data, function($message) use ($user)
        {
            $message->to($user->email,$user->first_name);
        });
  
        $this->save();
    }
      
    public function beforeUpdate() 
    {
        $validacion = $this->validarEmail();
        $this->password = $this->generaPass();
  
        if($validacion)
        {
            \Flash::success(e(trans('tresfera.talent360::lang.evaluadores.save_ok')));
        }
        else
        {
            e(trans('tresfera.talent360::lang.evaluadores.save_ko'))." ".$this->email;
        }
        
        return $validacion;
    }


    public function getUrl($email = null, $lang = null) 
    {
        if(!$lang) $lang = $this->lang;
        if(!$email) $email = $this->email;

        if( $lang == 'en') 
        {
            $url_base = url("quiz/talentapp?lang=EN&");
        } else {
            $url_base = url("quiz/talentapp/?");
        }
        return ($url_base."talent=1&ev=".$this->id."&e=".$email);
    }
}
