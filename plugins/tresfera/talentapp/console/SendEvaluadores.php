<?php namespace Tresfera\Talentapp\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SendEvaluadores extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'talentapp:sendevaluadores';

    /**
     * @var string The console command description.
     */
    protected $description = 'No description provided yet...';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        while(true) {
            $evaluaciones = \Tresfera\Talentapp\Models\Evaluacion::all();
            foreach($evaluaciones as $evaluacion) {
                $stats = $evaluacion->getEvaluadores();
                if(!is_array($stats)) continue;
                foreach($evaluacion->getEvaluadores() as $tipo=>$evaluadores) {
                    if(is_array($evaluadores))
                    foreach($evaluadores as $evaluador) {
                        $statsAs = $stats[$tipo][$evaluador['email']];
                        if(!isset($evaluacion->stats[$tipo])) continue;
                        if(!isset($evaluacion->proyecto->id)) continue;
                        if(!$evaluador['send']) {
                            if($tipo != "autoevaluado") {

                                echo "Enviamos a: ".$evaluador['email']."\n";
                                $user = \Backend\Models\User::find($evaluacion->user_id);
                                $data = [
                                    "name" => $evaluador['name'],
                                    "username" => $user->login,
                                    "name_evaluado" => $user->first_name,
                                    "url" => $evaluacion->stats[$tipo][$evaluador['email']]['url'],
                                    "date" => $evaluacion->proyecto->fecha_fin,
                                    "lang" => isset($evaluador['lang'])?$evaluador['lang']:"",
                                ];
                                print_r($data);
                                $theme = 'talentapp.require.answer.evaluador';
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

                                    //$theme = 'talentapp.require.answer.evaluado';
                                

                                echo $theme . "\n";

                                $statsAs['send'] = 1;
                                $statsAs['send_at'] = \Carbon\Carbon::now();

                                $stats[$tipo][$evaluador['email']] = $statsAs;
                                $evaluacion->stats = $stats;

                                $evaluacion->save();
                                
                                \Mail::queue($theme, $data, function($message) use ($evaluador)
                                {
                                    $message->to($evaluador['email'],$evaluador['name']);
                                });
                            }
                        } 
                    }
                }
            }
            sleep(5);
            //return;
        }
    
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
