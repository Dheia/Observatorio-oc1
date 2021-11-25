<?php namespace Tresfera\Talent\Models;

use Model;
use BackendAuth;
use Tresfera\Talent\Models\Gestor;

/**
 * Model
 */
class Proyecto extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \Tresfera\Talentapp\Traits\TraitProyecto;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_talent_proyecto';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $hasMany = [
        'evaluaciones' => ['Tresfera\Talent\Models\Evaluacion'],
        'evaluaciones_rapport' => ['Tresfera\Talent\Models\Evaluacion', 'condition'=>'rapport_id <> 0'],
    ];
    public $belongsTo = [
        'client' => [
            'Tresfera\Clients\Models\Client',
        ]
    ];
    public $belongsToMany = [
        'gestores' => [
            'Tresfera\Talent\Models\Gestor',
            'table' => 'tresfera_talent_proyectos_gestores'
        ]
    ];
    public function getNumLicenciasUsadasAttribute() {
        return $this->evaluaciones_rapport()->count();
    }
    public function hasLicencias() {
        return $this->evaluaciones_rapport()->count() < $this->num_licencias;
    }
    public static function getEstadisticas($lista)
    {
        $filters = self::getCurrentFilters($lista);
        $user = BackendAuth::getUser();
        if(isset($user->id)) {
            if($user->hasPermission(["talent.gestor"])) {
                $proyectos_gestor = Gestor::getProyectos();
                $query = Evaluacion::whereIn('proyecto_id', $proyectos_gestor);
                $query_proyectos = Proyecto::whereIn('id', $proyectos_gestor);

            }
        }
        if(isset($filters[0]['scope-proyecto']) and count($filters[0]['scope-proyecto'])) {
            $ids = array_keys($filters[0]['scope-proyecto']);
            if(!isset($query))
            {
                $query = Evaluacion::whereIn("proyecto_id",$ids);
                $query_proyectos = Proyecto::whereIn("tresfera_talent_proyecto.id", $ids);
            }
            else
            {
                $query->whereIn("proyecto_id",$ids);
                $query_proyectos->whereIn("tresfera_talent_proyecto.id",$ids);
            }
        }
        if(isset($filters[0]['scope-cliente']) and count($filters[0]['scope-cliente'])) {
            $ids = array_keys($filters[0]['scope-cliente']);
            if(!isset($query))
            {
                $query = Evaluacion::whereIn("client_id",$ids);
                $query_proyectos = Proyecto::whereIn("client_id",$ids);
            }
            else
            {
                $query->whereIn("client_id",$ids);
                $query_proyectos->whereIn("client_id",$ids);
            }
        }
        if(isset($filters[0]['scope-estado']) and count($filters[0]['scope-estado'])) {
            $ids = array_keys($filters[0]['scope-estado']);
            if(!isset($query))
            {
                $query = Evaluacion::whereIn("estado",$ids);
                $query_proyectos = Proyecto::join('tresfera_talent_evaluacion', 'tresfera_talent_proyecto.id', '=', 'tresfera_talent_evaluacion.proyecto_id')
                                            ->whereIn('tresfera_talent_evaluacion.estado', $ids)
                                            ->groupBy('tresfera_talent_proyecto.id')
                                            ->select('tresfera_talent_proyecto.name');
            }
            else
            {
                $query->whereIn("estado",$ids);
                $query_proyectos->join('tresfera_talent_evaluacion', 'tresfera_talent_proyecto.id', '=', 'tresfera_talent_evaluacion.proyecto_id')
                                ->whereIn('tresfera_talent_evaluacion.estado', $ids)
                                ->groupBy('tresfera_talent_proyecto.id')
                                ->select('tresfera_talent_proyecto.name');
            }
        }
        if(isset($filters[0]['scope-evaluado']) and count($filters[0]['scope-evaluado'])) {
            $ids = array_keys($filters[0]['scope-evaluado']);
            if(!isset($query))
            {
                $query = Evaluacion::whereIn("user_id",$ids);
                $query_proyectos = Proyecto::join('tresfera_talent_evaluacion', 'tresfera_talent_proyecto.id', '=', 'tresfera_talent_evaluacion.proyecto_id')
                                            ->whereIn('tresfera_talent_evaluacion.user_id', $ids);
            }
            else
            {
                $query->whereIn("user_id",$ids);
                $query_proyectos->join('tresfera_talent_evaluacion', 'tresfera_talent_proyecto.id', '=', 'tresfera_talent_evaluacion.proyecto_id')
                ->whereIn('tresfera_talent_evaluacion.user_id', $ids);
            }
        }
        
        if(!isset($query)) {
            $query = new Evaluacion();
        }
        if(!isset($query_proyectos)) {
            $query_proyectos = new Proyecto();
        }
        

        $estadisticas['proyectos_en_curso'] = count( with(clone $query_proyectos)->where("fecha_fin", ">", \Carbon\Carbon::now())->get() );
        $estadisticas['proyectos_finalizados'] = count( with(clone $query_proyectos)->where("fecha_fin", "<=", \Carbon\Carbon::now())->get() );
        $estadisticas['evaluados_activos'] = with(clone $query)->where('estado', '=', 1)->count();
        $estadisticas['evaluados_finalizadas'] = with(clone $query)->where('estado', '=', 2)->count();
        

        return $estadisticas;
    }



}
