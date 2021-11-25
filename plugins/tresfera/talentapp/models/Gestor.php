<?php namespace Tresfera\Talentapp\Models;

use Model;
use Backend\Models\User;
use Backend\Models\UserGroup;

use Faker\Factory;
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
    public $table = 'tresfera_talentapp_proyectos_gestores';

    public function beforeCreate() {
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

      $user->role_id = 4;
      $this->user_id = $user->id;
      $user->save();

      


    }
}
