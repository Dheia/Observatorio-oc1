<?php namespace Tresfera\Skillyouup\Models;

use Model;
use \Backend\Models\User;


use Mja\Mail\Models\Email;

/**
 * Model
 */
class Proyecto extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    public $hasMany = [
      'gestores' => ['Tresfera\Skillyouup\Models\Gestor'],
      'equipos' => ['Tresfera\Skillyouup\Models\Equipo'],
    ];
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_skillyouup_proyecto';
    public $attachOne = [
        'logo' => 'System\Models\File'
    ];
    // Relaciones

    public function getClientIdOptions($keyValue = null)
    {
      // Retornar sólo usuarios con rol Empresa
      $empresas = \Tresfera\Clients\Models\Client::lists("name","id");
      return $empresas;
    }


    public function getEmpresaIdOptions($keyValue = null)
    {
      // Retornar sólo usuarios con rol Empresa
      $empresas = User::join('backend_user_roles', 'backend_users.role_id', '=', 'backend_user_roles.id')
                        ->where("backend_user_roles.name","=", "Empresa")
                        ->lists("login", "backend_users.id");
      return $empresas;
    }

    public function getGestorIdOptions($keyValue = null)
    {
      $empresa_id= $this->empresa_id;
      $gestores_empresa = User::join('backend_user_roles', 'backend_users.role_id', '=', 'backend_user_roles.id')
                        ->where('backend_user_roles.name','=', 'Gestor')
                        ->where('backend_users.empresa_id','=', $empresa_id)
                        ->lists('login', 'backend_users.id');

      $gestores_empresa = [ 0 => "- Ningún gestor asignado -" ] + $gestores_empresa;
      return $gestores_empresa;
    }

    /*
    public function afterSave()
    {
      \Queue::later($this->fecha_fin, '\Tresfera\Skillyouup\Classes\Jobs\FinalizaEquipos', ['proyecto_id' => $this->id]);
    }
    */

    public function afterFetch() { $this->name = htmlspecialchars($this->name); } // str_replace("&quot;", '"', $this->name)


    public static function getCurrentFilters($lista = null) {
      $filters = [];
      foreach (\Session::get('widget', []) as $name => $item) {
        
        if (str_contains($name, 'Filter')) {
            $filter = @unserialize(@base64_decode($item));
            if ($filter) {
                $filters[$name][] = $filter;
            }
        }
      }
      if(!$lista) return $filters;
      else if(isset($filters[$lista])) return $filters[$lista];
      return [];
    }

    public static function getEstadisticas($lista)
    {
      $filters = self::getCurrentFilters($lista);

      if(isset($filters[0]['scope-proyecto']) and count($filters[0]['scope-proyecto'])) {
        $ids = array_keys($filters[0]['scope-proyecto']);
        if(!isset($query))
        {
            $query = Equipo::whereIn("proyecto_id",$ids);
            $query_proyectos = Proyecto::whereIn("tresfera_skillyouup_proyecto.id", $ids);
        }
        else
        {
            $query->whereIn("proyecto_id",$ids);
            $query_proyectos->whereIn("tresfera_skillyouup_proyecto.id",$ids);
        }
      }
      if(isset($filters[0]['scope-cliente']) and count($filters[0]['scope-cliente'])) {
          $ids = array_keys($filters[0]['scope-cliente']);
          if(!isset($query))
          {
              $query = Equipo::whereIn("client_id",$ids);
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
              $query = Equipo::whereIn("estado",$ids);
              $query_proyectos = Proyecto::join('tresfera_skillyouup_evaluacion', 'tresfera_skillyouup_proyecto.id', '=', 'tresfera_skillyouup_evaluacion.proyecto_id')
                                          ->whereIn('tresfera_skillyouup_evaluacion.estado', $ids)
                                          ->groupBy('tresfera_skillyouup_proyecto.id')
                                          ->select('tresfera_skillyouup_proyecto.name');
          }
          else
          {
              $query->whereIn("estado",$ids);
              $query_proyectos->join('tresfera_skillyouup_evaluacion', 'tresfera_skillyouup_proyecto.id', '=', 'tresfera_skillyouup_evaluacion.proyecto_id')
                              ->whereIn('tresfera_skillyouup_evaluacion.estado', $ids)
                              ->groupBy('tresfera_skillyouup_proyecto.id')
                              ->select('tresfera_skillyouup_proyecto.name');
          }
      }
      if(isset($filters[0]['scope-evaluado']) and count($filters[0]['scope-evaluado'])) {
          $ids = array_keys($filters[0]['scope-evaluado']);
          if(!isset($query))
          {
              $query = Equipo::whereIn("user_id",$ids);
              $query_proyectos = Proyecto::join('tresfera_skillyouup_evaluacion', 'tresfera_skillyouup_proyecto.id', '=', 'tresfera_skillyouup_evaluacion.proyecto_id')
                                          ->whereIn('tresfera_skillyouup_evaluacion.user_id', $ids);
          }
          else
          {
              $query->whereIn("user_id",$ids);
              $query_proyectos->join('tresfera_skillyouup_evaluacion', 'tresfera_skillyouup_proyecto.id', '=', 'tresfera_skillyouup_evaluacion.proyecto_id')
              ->whereIn('tresfera_skillyouup_evaluacion.user_id', $ids);
          }
      }
      
      if(!isset($query)) {
          $query = new Equipo();
      }
      if(!isset($query_proyectos)) {
          $query_proyectos = new Proyecto();
      }
      
      $estadisticas['proyectos_en_curso'] = count( with(clone $query_proyectos)->where("fecha_fin", ">", \Carbon\Carbon::now())->get() );
      $estadisticas['proyectos_finalizados'] = count( with(clone $query_proyectos)->where("fecha_fin", "<=", \Carbon\Carbon::now())->get() );
      $estadisticas['evaluados_activos'] = with(clone $query)->where('estado', '=', 1)->count();
      $estadisticas['evaluados_finalizadas'] = with(clone $query)->where('estado', '=', 2)->count();
      
      // RECORREMOS TODAS LAS EVALUACIONES
      $estadisticas['evaluaciones_completadas'] = 0;
      $estadisticas['evaluaciones_pendientes'] = 0;
      
      $evaluaciones = with(clone $query)->get();
      
      foreach($evaluaciones as $eval)
      {
          $tmp = $eval->getEquipos();
          $estadisticas['evaluaciones_completadas'] += count($tmp['completadas']);
          $estadisticas['evaluaciones_pendientes'] += count($tmp['pendientes']);
      }

      return $estadisticas;
    }

    /*
        Devuelve array con los emails leidos, no leidos y no enviados clasificados segun evaluados y evaluadores
    */
    public function getEmailsActivacion()
    {
        // Mails activación evaluados leídos

        $emails = [];
        $emails['evaluados'] = [];
        $emails['evaluadores'] = [];
        $emails['evaluados']['leidos'] = [];
        $emails['evaluados']['no_leidos'] = [];
        $emails['evaluados']['no_enviados'] = [];
        $emails['evaluadores']['leidos'] = [];
        $emails['evaluadores']['no_leidos'] = [];
        $emails['evaluadores']['no_enviados'] = [];

        foreach($this->evaluaciones as $evaluacion)
        {
            $evaluadores = $evaluacion->getEvaluadores();

            if(is_array($evaluadores))
            {
                foreach($evaluadores as $tipo=>$values) 
                { 
                    if(is_array($values)) {
                        foreach($values as $evaluador) 
                        {
                            if($tipo == "autoevaluado") 
                            {
                                if(!$evaluador['email'] || !isset($evaluador['send_at']) || !isset($evaluador['send_at']['date']))               
                                    $email = Email::whereIn("code", ['skillyouup.require.aprovacion','skillyouup.require.aprovacion_en'])
                                            ->whereRaw(\DB::raw("`to` LIKE '%".$evaluador['email']."%'"))
                                            ->whereRaw(\DB::raw("DATE(date) = DATE('".$evaluacion->created_at."')"))
                                            ->first();
                                else
                                    $email = Email::whereIn("code", ['skillyouup.require.aprovacion','skillyouup.require.aprovacion_en'])
                                                ->whereRaw(\DB::raw("`to` LIKE '%".$evaluador['email']."%'"))
                                                ->whereRaw(\DB::raw("DATE(date) = DATE('".$evaluador['send_at']['date']."')"))
                                                ->first();
                                    
                                if( isset($email->id) )
                                {
                                    if($email->getTimesOpenedAttribute() > 0) array_push($emails['evaluados']['leidos'], $evaluador['email']);
                                    else array_push($emails['evaluados']['no_leidos'], $evaluador['email']);
                                } else {
                                    array_push($emails['evaluados']['no_enviados'], $evaluador['email']);
                                }
                            } else {
                                if(!$evaluador['email'] || !isset($evaluador['send_at']) || !isset($evaluador['send_at']['date'])) continue;
                                $email = Email::whereIn("code", ['skillyouup.require.aprovacion','skillyouup.require.aprovacion_en','skillyouup.require.answer.evaluado_en','skillyouup.require.answer.evaluador','skillyouup.require.answer.evaluador_en'])
                                            ->whereRaw(\DB::raw("`to` LIKE '%".$evaluador['email']."%'"))
                                            ->whereRaw(\DB::raw("DATE(date) = DATE('".$evaluador['send_at']['date']."')"))
                                            ->first();
                                
                                if( isset($email->id) )
                                {
                                    if($email->getTimesOpenedAttribute() > 0) array_push($emails['evaluadores']['leidos'], $evaluador['email']);
                                    else array_push($emails['evaluadores']['no_leidos'], $evaluador['email']);
                                } else {
                                    array_push($emails['evaluadores']['no_enviados'], $evaluador['email']);
                                }
                            }
                        }
                    }
                } 
            }
        }
        
        return $emails;
    }

    /* 
        Devuelve un array con las evaluaciones de este proyecto que tienen algún evaluador asignado
    */
    public function getUsuariosEvaluadoresAsignados()
    {
        // Usuarios con evaluadores asignados
        $usuarios = [];
        foreach($this->evaluaciones as $evaluacion)
        {
            if( $evaluacion->jefe 
                || $evaluacion->companero 
                || $evaluacion->colaborador 
                || $evaluacion->otro
            )
            array_push($usuarios, $evaluacion);

        }
        return $usuarios;
    }

    public function getEvaluadosTotales()
    {
        // Evaluados totales
        return count($this->evaluaciones);
    }

    // Numero de evaluaciones (Cuestionarios) totales, completadas y pendientes de este proyecto
    public function getNumEquipos()
    {
        
        $evaluaciones = [];
        $evaluaciones['completadas'] = 0;
        $evaluaciones['pendientes'] = 0;
        $evaluaciones['totales'] = 0;
        foreach($this->evaluaciones as $eval)
        {
            $tmp = $eval->getEquipos();
            $evaluaciones['completadas'] += count($tmp['completadas']);
            $evaluaciones['pendientes'] += count($tmp['pendientes']);
        }
        
        $evaluaciones['totales'] = $evaluaciones['completadas'] + $evaluaciones['pendientes'];

        return $evaluaciones;
    }


    
    public function finalizado()
    {
        return ( $this->fecha_fin <= \Carbon\Carbon::now() );
    }




}

