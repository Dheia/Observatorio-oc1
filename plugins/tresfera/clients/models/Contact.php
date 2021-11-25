<?php namespace Tresfera\Clients\Models;

use Model;
use Tresfera\Devices\Models\Region;
use Tresfera\Devices\Models\City;
use Tresfera\Taketsystem\Models\Sector;

/**
 * contact Model
 */
class Contact extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_clients_contacts';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */	
    protected $fillable = ['name'];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
	   "seguimientos" => [	'Tresfera\Clients\Models\Seguimiento'	],
    ];
    public $belongsTo = [
	    'city'   => ['Tresfera\Devices\Models\City'],
	    'sector'   => ['Tresfera\Taketsystem\Models\Sector'],
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
    
    public function beforeSave() {
		$this->city_id = post('Contact[city_id]');
	}
    
    public function getRegionIdOptions()
	{	
		$result = Region::all()->lists('name', 'id');
		
	    return $result;
	}
	public function getCityIdOptions($region_id = null)
	{	
		$region_id = $this->region_id;
		if(!isset($region_id))
			$region_id = post("Contact")['region_id'];
		if(!isset($region_id))
			return City::where('region_id','=',1)->lists('name', 'id');
		else	
			return  City::where('region_id','=',$region_id)->lists('name', 'id');
		
	}
    
    public function getSectorIdOptions()
	{	
		$result = Sector::all()->lists('title', 'id');
		
	    return $result;
	}
		
}