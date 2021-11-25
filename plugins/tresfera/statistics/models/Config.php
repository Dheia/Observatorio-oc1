<?php namespace Tresfera\Statistics\Models;

use Model;
use BackendAuth;

/**
 * config Model
 */
class Config extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_statistics_configs';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];
	
	
	protected $jsonable = ['globals','shops', 'config'];
    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
	
	public function beforeCreate() {
		$user = BackendAuth::getUser();
		$this->client_id = $user->client_id;
	}
	
}