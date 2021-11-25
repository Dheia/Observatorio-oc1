<?php namespace Tresfera\Talentapp\Classes\Jobs;

use Tresfera\Talentapp\Controllers\ImportExportResultsAnswers;

class ExportResultAnswer
{
    public function fire($job, $data)
    {
        $export = new ImportExportResultsAnswers();
        $response = $export->exportar($data["proyecto_id"]);

        //$response = ['ok'=>true, "path" => "asdasd" ];

        if($response['ok'])
        {
            $theme = "talentapp360.sendinformeanswers";
            $data = [
                "url" => url($response['path'])
            ];
            $to = [
                "email" => "marta.sala@cookiebox.es",
                "name" => "Marta Sala"
            ];
            
            \Mail::queue($theme, $data, function($message) use ($to)
            {
                $message->to($to['email'],$to['name']);
                //$message->cc("gerard.3fera@gmail.com","Descargar informe");
                //$message->cc("fran.3fera@gmail.com","Descargar informe");
            });
            

            $to = [
                "email" => "fgomezserna@gmail.com",
                "name" => "Datos brutos para Fran"
            ];
            \Mail::queue($theme, $data, function($message) use ($to)
            {
                $message->to($to['email'],$to['name']);
                $message->cc("gerard.3fera@gmail.com","Descargar informe");
                //$message->cc("fran.3fera@gmail.com","Descargar informe");
            });
        }
        
        
        $job->delete();

    }



}
?>