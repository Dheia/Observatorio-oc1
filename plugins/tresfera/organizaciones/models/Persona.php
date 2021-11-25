<?php namespace Tresfera\Organizaciones\Models;

use Model;


use Tresfera\Organizaciones\Models\Empresa;
use Tresfera\Organizaciones\Models\Puesto;
/**
 * Model
 */
class Persona extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\NestedTree;
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_organizaciones_persona';

    public $belongsTo = [
        'empresa' => ['Tresfera\Organizaciones\Models\Empresa'],
        'departamento' => ['Tresfera\Organizaciones\Models\Departamento'],
        'responsable' => ['Tresfera\Organizaciones\Models\Persona',"key"=>"responsable_id"],
        'puesto' => ['Tresfera\Organizaciones\Models\Puesto'],
    ];

    public $hasMany = [
        'subordinados' => ['Tresfera\Organizaciones\Models\Persona',"key"=>"parent_id"],
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function getEmpresaIdOptions() {
        return Empresa::all()->lists("name","id");
    }
    public function getPuestoIdOptions() {
        return array_merge([0=>"Sin familia"],Puesto::all()->lists("name","id"));
    }
    public function getParentIdOptions() {
        return array_merge([0=>"Raíz"],SELF::all()->lists("name","id"));
    }
}
