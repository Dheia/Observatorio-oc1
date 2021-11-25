<?php

namespace Tresfera\Clients\Models;

use Model;
use Tresfera\Taketsystem\Models\Sector;
use Tresfera\Devices\Models\Region;
use Tresfera\Devices\Models\City;
use Backend\Models\User;
use Backend\Models\UserGroup;
use Faker\Factory;
use DB;
/**
 * Client Model.
 */
class Client extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_clients_clients';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['name', 'max_devices'];

    /**
     * @var array Rules
     */
    public $rules = [
        'name' => 'required',
    ];
	public $hasOne = [
	//	'config'   => ['Tresfera\Statistics\Models\Config'],
	//	'alerts'   => ['Tresfera\Statistics\Models\Alert'],
    ];
    /**
     * Has Many relations.
     *
     * @var array
     */
    public $hasMany = [
    //    'campaigns' => ['Tresfera\Taketsystem\Models\Campaign'],
    //    'quizzes'   => ['Tresfera\Taketsystem\Models\Quiz'],
        'users'     => ['Backend\Models\User', 'delete'=>true],
    //    'devices'   => ['Tresfera\Devices\Models\Device'],
    //    'shops'  	=> ['Tresfera\Devices\Models\Shop'],
    ];

    public $belongsTo = [
        //'sector'     => ['Tresfera\Taketsystem\Models\Sector'],
    ];

    public function beforeDelete() {
	    $users = User::where("client_id","=",$this->id)->get();
	    foreach($users as $user) {
		    $user->delete();
	    }
    }

    public function afterCreate() {
	    $user = new User([]);
        $faker = Factory::create();

        if(isset($this->persona_contacto)) {
	        $name = explode(" ", $this->persona_contacto);

	        $first_name = $name[0];
	        if(count($name) > 2) {
		        $last_name = $name[1]." ".$name[2];
	        } if(count($name) == 1) {
            $last_name  = "";
          } else {
		        $last_name = $name[1];
	        }
        } else {
	        $first_name = $this->name;
	        $last_name  = "";
        }

		    $username = snake_case( strtolower( $this->name ));

        $user->first_name            = $first_name;
        $user->last_name             = $last_name;
        $user->login                 = $username;
        $user->email                 = $this->email;
        $user->password              = $username;
        $user->password_confirmation = $username;
        $user->client_id			       = $this->id;
        $user->is_activated          = 1;
        $user->save();

        $user->role_id = 5;
        $this->user_id = $user->id;
        $user->save();

    }
    public function getRegionIdOptions()
	{
	//	$result = Region::all()->lists('name', 'id');
        $result = [];
	    return $result;
	}
	public function getCityIdOptions($region_id = null)
	{
        $result = [];
	    return $result;
		$region_id = post("Client")['region_id'];
		if(!isset($region_id))
			return City::where('region_id','=',1)->lists('name', 'id');
		else
			return  City::where('region_id','=',$region_id)->lists('name', 'id');

	}
    public function getSectorIdOptions()
	{
		//$result = Sector::all()->lists('title', 'id');
        $result = [];
	    return $result;
	}

}
