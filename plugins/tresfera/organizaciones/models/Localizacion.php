<?php namespace Tresfera\Organizaciones\Models;

use Model;

/**
 * Model
 */
class Localizacion extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    public $implement = ['RainLab.Location.Behaviors.LocationModel'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_organizaciones_localizacion';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
