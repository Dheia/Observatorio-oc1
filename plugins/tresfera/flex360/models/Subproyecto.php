<?php namespace Tresfera\Flex360\Models;

use Model;

/**
 * Model
 */
class Subproyecto extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_flex360_subproyectos';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
