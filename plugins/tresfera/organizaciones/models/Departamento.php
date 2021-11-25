<?php namespace Tresfera\Organizaciones\Models;

use Model;
use Tresfera\Organizaciones\Models\Empresa;
/**
 * Model
 */
class Departamento extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;
    use \October\Rain\Database\Traits\NestedTree;
    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_organizaciones_departamento';
    public $belongsTo = [
        'empresa' => ['Tresfera\Organizaciones\Models\Empresa'],
    ];
    public $hasMany = [
        'personas' => 'Tresfera\Organizaciones\Models\Persona',
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    public function getEmpresaIdOptions() {
        return Empresa::all()->lists("name","id");
    }
    public function getParentIdOptions() {
        return array_merge([0=>"Raíz"],SELF::all()->lists("name","id"));
    }
}
