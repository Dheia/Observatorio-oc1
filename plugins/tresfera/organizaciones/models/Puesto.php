<?php namespace Tresfera\Organizaciones\Models;

use Model;
use Tresfera\Organizaciones\Models\Empresa;
use Tresfera\Organizaciones\Models\FamiliaPuesto;

/**
 * Model
 */
class Puesto extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;
    use \October\Rain\Database\Traits\NestedTree;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_organizaciones_puesto';
    public $hasMany = [
        'personas' => 'Tresfera\Organizaciones\Models\Persona',
    ];
    public $belongsTo = [
        'empresa' => ['Tresfera\Organizaciones\Models\Empresa'],
        'familiapuesto' => ['Tresfera\Organizaciones\Models\FamiliaPuesto'],
    ];
    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    public function getEmpresaIdOptions() {
        return Empresa::all()->lists("name","id");
    }
    public function getFamiliaPuestoIdOptions() {
        return array_merge([0=>"Sin familia"],FamiliaPuesto::all()->lists("name","id"));
    }
    public function getParentIdOptions() {
        return array_merge([0=>"Raíz"],SELF::all()->lists("name","id"));
    }
}
