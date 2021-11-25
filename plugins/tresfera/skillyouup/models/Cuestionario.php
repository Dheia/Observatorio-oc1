<?php namespace Tresfera\Skillyouup\Models;

use Model;

/**
 * Model
 */
class Cuestionario extends Model
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
    public $table = 'tresfera_skillyouup_cuestionario';
}
