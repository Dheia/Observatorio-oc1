<?php namespace Tresfera\Talentapp\Classes\Jobs;

use Tresfera\TalentApp\Models\Evaluacion;

class SendRecordatorioAsignacion
{
    public function fire($job, $id)
    {
        $evaluacion = Evaluacion::find($id);
        if(isset($evaluacion->id)) {
            $theme = 'talentapp360.warning.evaluador.asignacion.pendiente';
            if($evaluacion->lang == "en") $theme .= "_en";
    
            $user = \Backend\Models\User::find($evaluacion->user_id);
            $data = [
                "name" => $evaluacion->name,
                "username" => $user->login,
                "name_evaluado" => $user->first_name,
                "url" => url("/backend"),
                "date" => $evaluacion->proyecto->fecha_fin,
                "password" => $evaluacion->password
            ];
            \Mail::send($theme, $data, function($message) use ($evaluacion)
            {
                $message->to($evaluacion->email,$evaluacion->name);
            });
        }
        $job->delete();
    }
}
?>