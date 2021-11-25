<?php namespace Tresfera\Organizaciones\Models;

use Model;

/**
 * Model
 */
class Empresa extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_organizaciones_empresa';
    public $hasMany = [
        'departamentos' => 'Tresfera\Organizaciones\Models\Departamento',
        'familia_puestos' => 'Tresfera\Organizaciones\Models\FamiliaPuesto',
        'localizaciones' => 'Tresfera\Organizaciones\Models\Localizacion',
        'puestos' => 'Tresfera\Organizaciones\Models\Puesto',
        'personas' => 'Tresfera\Organizaciones\Models\Persona',
    ];
    
    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
