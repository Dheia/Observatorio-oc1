<?php namespace Tresfera\Organizaciones\Models;

use Model;
use Tresfera\Organizaciones\Models\Empresa;

/**
 * Model
 */
class FamiliaPuesto extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_organizaciones_familia_puesto';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    public $hasMany = [
        'puestos' => 'Tresfera\Organizaciones\Models\Puesto',
    ];

    public function getEmpresaIdOptions() {
        return Empresa::all()->lists("name","id");
    }
    public function getParentIdOptions() {
        return array_merge([0=>"Raíz"],SELF::all()->lists("name","id"));
    }
}
