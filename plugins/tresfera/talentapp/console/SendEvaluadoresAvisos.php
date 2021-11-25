<?php namespace Tresfera\Talentapp\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SendEvaluadoresAvisos extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'talentapp:sendevaluadoresavisos';

    /**
     * @var string The console command description.
     */
    protected $description = 'No description provided yet...';


    public function sendEmail($proyectos,$themeBase) {
        exit;
        foreach($proyectos as $proyecto) {
            $evaluaciones = $proyecto->evaluaciones;
            foreach($evaluaciones as $evaluacion) {
                $stats = $evaluacion->getEvaluadores();
                if(!is_array($stats)) continue;
                foreach($evaluacion->getEvaluadores() as $tipo=>$evaluadores) {
                    if(is_array($evaluadores))
                    foreach($evaluadores as $evaluador) {
                        //print_r($evaluador);
                        if(!$evaluador['email']) continue;
                        $statsAs = $stats[$tipo][$evaluador['email']];
                        if(!isset($evaluacion->proyecto->id)) continue;
                        if((!$evaluacion->isCompletedEvaluador($evaluador['email'])  && $tipo != "autoevaluado")
                            || (!$evaluacion->isCompletedAutoevaluado() && $tipo == "autoevaluado")) {
                            echo "Enviamos a: ".$evaluador['email']."\n";
                            $user = \Backend\Models\User::find($evaluacion->user_id);
                            $data = [
                                "name" => $evaluador['name'],
                                "username" => $user->login,
                                "name_evaluado" => $user->first_name,
                                "url" => $evaluacion->stats[$tipo][$evaluador['email']]['url'],
                                "date" => $evaluacion->proyecto->fecha_fin
                            ];
                            //print_r($data);
                            $theme = 'talentapp360.warning.evaluador.'.$themeBase;
                            if($tipo == "autoevaluado") 
                                $theme = 'talentapp360.warning.evaluado.'.$themeBase;
                                
                            echo $theme . "\n";
    
                            if(isset($evaluador['lang'])  && $evaluador['lang'] == "en")
                                    $theme .= "_en";
                            elseif(isset($evaluador['lang'])  && $evaluador['lang'] == "es") {

                            } else {
                                $lang = $evaluacion->lang;
                                if($lang == "en") {
                                    $theme .= "_en";
                                } elseif($lang == "es") {
                                } else {
                                    $lang = $evaluacion->proyecto->lang;
                                    if($lang == "en") {
                                        $theme .= "_en";
                                    } elseif($lang == "es") {
                                    } else {

                                    }
                                }
                            }
                            
                            \Mail::queue($theme, $data, function($message) use ($evaluador)
                            {
                                $message->to($evaluador['email'],$evaluador['name']);
                            });
                        } 
                    }
                }
            }
        }
        
    }

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $proyectos = \Tresfera\Talentapp\Models\Proyecto::
            whereRaw(\DB::raw("DATE(fecha_fin) = DATE(NOW() + INTERVAL 1 DAY)"))->get();
      
        $this->sendEmail($proyectos,"datafinish1day");

        $proyectos = \Tresfera\Talentapp\Models\Proyecto::
            whereRaw(\DB::raw("DATE(fecha_fin) = DATE(NOW() + INTERVAL 3 DAY)"))->get();
        
            
        $this->sendEmail($proyectos,"datafinish3days");
        //return;
        
    
    } 

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
