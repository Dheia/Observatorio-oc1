<?php namespace Tresfera\Clients\Models;

use Model;

/**
 * seguimiento Model
 */
class Seguimiento extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_clients_contacts_seguimientos';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['date'];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
	    "contact" => [	'Tresfera\Clients\Models\Contact'	]
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
    
    public function beforeSave() {
		$this->cause = post("Seguimiento[cause]", "Contact[causes]");
		$this->record = post("Seguimiento[record]");
		
	}

}