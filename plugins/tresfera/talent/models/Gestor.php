<?php namespace Tresfera\Talent\Models;

use Model;
use Backend\Models\User;
use Backend\Models\UserGroup;

use Faker\Factory;

use \Tresfera\Talent\Models\Proyecto;
use \Tresfera\Talent\Models\ProyectoGestor;

/**
 * Model
 */
class Gestor extends Model
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
    public $table = 'tresfera_talent_gestores';

    public $belongsToMany = [
      "proyectos" => [
          'Tresfera\Talent\Models\Proyecto',
          'table' => 'tresfera_talent_proyectos_gestores',
          'timestamps' => true
      ]
    ];

    static function getProyectos() {
      $user = \BackendAuth::getUser();
      $gestor = Gestor::where("user_id",$user->id)->first();
      return ProyectoGestor::where("gestor_id",$gestor->id)->lists("proyecto_id");
    }

    public function beforeCreate() {
      //check que no exista el email
      $user = User::where("email",$this->email)->first();
      if(!isset($user->id)) {
        $user = new User([]);
        $faker = Factory::create();

        $username = ( strtolower( $this->email ));

        $proyecto = Proyecto::find($this->proyecto_id);

        $user->first_name            = $this->name;
        $user->login                 = $username;
        $user->email                 = $this->email;
        $user->password              = $this->password;
        $user->password_confirmation = $this->password;
        $user->client_id			       = $this->id;
        $user->is_activated          = 1;
        $user->save();
      }
      $this->user_id = $user->id;
      $permissions = $user->permissions;
      if(!$permissions) $permissions = [];
      $permissions['talent.gestor'] = 1;
      $permissions["backend.manage_preferences"] = 1;
      
      $user->permissions = $permissions;
      $user->save();

    }
}
