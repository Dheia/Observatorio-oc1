<?php namespace Tresfera\Taketsystem\Models;

use Model;

/**
 * Model
 */
class Timming extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_timming';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
