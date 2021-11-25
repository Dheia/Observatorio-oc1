<?php namespace Tresfera\Taketsystem\Models;

use Model;

/**
 * Model
 */
class ProgresoAnswer extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_progresos_answers';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
