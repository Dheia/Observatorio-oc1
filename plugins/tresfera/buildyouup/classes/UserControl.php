<?php namespace Tresfera\Buildyouup\Classes;

use Backend\Classes\Controller;
use Backend\Models\User;
use Backend\Models\UserRole;
use Tresfera\Buildyouup\Models\Proyecto;
use Tresfera\Buildyouup\Models\Equipo_Evaluador;

class UserControl extends Controller {

  public function __construct()
  {
      parent::__construct();
  }
  public static function isAdmin($user)
  {
    $rol = UserRole::where("id", $user->role_id)->first();
    if( isset($rol->code) && $rol->code == "admin" || ($user->is_superuser)) return true;
    return false;
  }
  // Retorna rol (String) de un usuario
  public static function getRole($user)
  {
    if(isset(UserRole::where("id",$user->role_id)->first()->id))
      return UserRole::where("id",$user->role_id)->first()->id;
    return 0;
  }
  // Retorna array con todos los usuarios con Rol Evaluador inscritos en una evaluación
  public static function getEvaluadoresInscritos($idEvaluacion)
  {
    $evaluadores = Evaluacion_Evaluador::where('eval', $idEvaluacion)
                                        ->join('backend_users', 'evaluador', '=', 'backend_users.id')
                                        ->select('backend_users.*')
                                        ->get();
    return $evaluadores;
  }
  // Retorna array con todos los usuarios con Rol Evaluador NO inscritos en una evaluación
  public static function getEvaluadoresNoInscritos($idEmpresa, $idEvaluacion)
  {
    $rol_evaluador_id = UserRole::where('name','Evaluador')->first()->id;
    $evaluadores_inscritos = Evaluacion_Evaluador::where('eval', $idEvaluacion)->select('evaluador')->get()->toArray();
    $evaluadores_inscritos = array_map( function( $evaluador ) { return $evaluador['evaluador']; }, $evaluadores_inscritos );
    $evaluadores_no_inscritos = User::where('empresa_id',$idEmpresa)->where('role_id', $rol_evaluador_id)->whereNotIn('id', $evaluadores_inscritos)->get();

    /*$evaluadores_no_inscritos = Evaluacion_Evaluador::whereNotIn('evaluador', $evaluadores_inscritos)
                                                    ->join('backend_users', 'evaluador', '=', 'backend_users.id')
                                                    ->select('backend_users.*')
                                                    ->get();*/
    return $evaluadores_no_inscritos;
  }

  // Retorna array con todos los usuarios con Rol EVALUADOR de una empresa
  public static function getAllEvaluadores($idEmpresa)
  {
    $rol_evaluador_id = UserRole::where('name','Evaluador')->first()->id;
    $evaluadores = User::where('empresa_id',$idEmpresa)->where('role_id', $rol_evaluador_id)->get();
    return $evaluadores;
  }


  // Retorna array con todos los usuarios con Rol EVALUADO de una empresa
  public static function getAllEvaluados($idEmpresa)
  {
    $rol_evaluado_id = UserRole::where('name','Evaluado')->first()->id;
    $evaluados = User::where('empresa_id',$idEmpresa)->where('role_id', $rol_evaluado_id)->get();
    return $evaluados;
  }

  public static function getGestores($idEmpresa)
  {
    $rol_gestor_id = UserRole::where('name','Gestor')->first()->id;
    $gestores = User::where('empresa_id', $idEmpresa)->where('role_id', $rol_gestor_id)->get();
    return $gestores;
  }

  public static function getEmpresas()
  {
    $rol_gestor_id = UserRole::where('name','Cliente')->first()->id;
    
    $empresas = User::where('role_id', $rol_gestor_id)->get();
    return $empresas;
  }

  public static function getFirstName($idUser)
  {
    return User::find($idUser)->first_name;
  }

  public static function getFullName($idUser)
  {
    $user = User::find($idUser);
    return ($user) ? $user->first_name.' '.$user->last_name : "";
  }

  public function onGetOptions()
  {
      $exchangerId = get("exchangerId");
      $results = [
          'key' => 'value'
      ];

      return ['result' => $results];
  }

  public function onTipoRespuestaSelect()
  {
      if (Request::input('someVar') != 'someValue') {
          throw new ApplicationException('Invalid value');
      }

      $this->vars['foo'] = 'bar';

      return [
          'partialContents' => $this->makePartial('some-partial')
      ];
  }

}
