<?php namespace Tresfera\Organizaciones\Models;

use Model;

/**
 * Model
 */
class PersonaPuesto extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_organizaciones_persona_puesto';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
