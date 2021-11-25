<?php namespace Tresfera\Statistics\Models;

use Model;
use Mail;
use Tiipiik\SmsSender\Classes\Sender as SmsSender;
use System\Models\MailTemplate;
use BackendAuth;
use Tresfera\Clients\Models\Client;
/**
 * alert Model
 */
class Punto extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_puntos_tatenis';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];
	
    /**
     * @var array Fillable fields
     */
    protected $fillable = [];
    //protected $jsonable = ['phones','emails'];

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
	
	
	
}