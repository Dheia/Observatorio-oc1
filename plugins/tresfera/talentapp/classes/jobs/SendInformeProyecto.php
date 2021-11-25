<?php namespace Tresfera\Talentapp\Classes\Jobs;

use Tresfera\Talentapp\Models\Proyecto;
use Tresfera\Clients\Models\Client;

class SendInformeProyecto
{
    public function fire($job, $data)
    {

        // FALTA ADJUNTAR CSV

        $proyecto_id = $data['proyecto_id'];
        $proyecto = Proyecto::find($proyecto_id);
        $cliente = Client::find($proyecto->client_id);

        // Si el proyecto no tiene un email asignado cogemos el correo del cliente
        if(!$proyecto->email)
        {
            if(isset($cliente->email) && $cliente->email)
            {
                $email = $cliente->email;
            }
        }
        else
        {
            $email = $proyecto->email;
        }

        $emails_activacion = $proyecto->getEmailsActivacion();
        $users_eval_asignados = $proyecto->getUsuariosEvaluadoresAsignados();
        $num_evaluaciones = $proyecto->getNumEvaluaciones();

        $theme = "talentapp360.sendinformeproyecto";
        if($proyecto->lang == "en") $theme .= "_en";
        $data = [
            "emails_activacion_evaluado_leidos" => count($emails_activacion['evaluados']['leidos']),
            "emails_activacion_evaluado_no_leidos" => count($emails_activacion['evaluados']['no_leidos']),
            "emails_activacion_evaluado_no_enviados" => count($emails_activacion['evaluados']['no_enviados']),
            "emails_activacion_evaluador_leidos" => count($emails_activacion['evaluadores']['leidos']),
            "emails_activacion_evaluador_no_leidos" => count($emails_activacion['evaluadores']['no_leidos']),
            "emails_activacion_evaluador_no_enviados" => count($emails_activacion['evaluadores']['no_enviados']),
            "evaluaciones_con_evaluadores_asignados" => count($users_eval_asignados),
            "evaluados_totales" => $proyecto->getEvaluadosTotales(),
            "evaluaciones_completadas" => $num_evaluaciones['completadas'],
            "evaluaciones_pendientes" => $num_evaluaciones['pendientes'],
            "evaluaciones_totales" => $num_evaluaciones['totales'],
            "project_name" => $proyecto->name,
        ];
        $to = [
            "email" => $email,
            "name" => $cliente->name
        ];
        \Mail::queue($theme, $data, function($message) use ($to, $proyecto)
        {
            $message->to($to['email'],$to['name']);
            $message->cc("fgomezserna@gmail.com","Informe del proyecto ".$proyecto->name);
        });


        $job->delete();

    }



}
?>