<?php namespace Tresfera\Talentapp\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


use Tresfera\Talentapp\Models\Proyecto;

class SendInformesProyectos extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'talentapp:sendinformesproyectos';

    /**
     * @var string The console command description.
     */
    protected $description = 'Envía un informe sobre los proyectos no finalizados que con periodicidad asignada';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $proyectos = Proyecto::where("periodicidad","<>","")
                             ->where("periodicidad","<>","none")
                             ->get();
       
        foreach($proyectos as $proyecto)
        {
            if(!$proyecto->finalizado())
            {
                if($proyecto->periodicidad == "diario" 
                    || ( $proyecto->periodicidad == "semanal" && date("N") == 1 ) // Es lunes
                    || ( $proyecto->periodicidad == "mensual" && date("j") == 1 ) // Es dia 1
                )
                {
                    \Queue::push('Tresfera\Talentapp\Classes\Jobs\SendInformeProyecto', ['proyecto_id' => $proyecto->id], 'sendinformesproyectos');
                }
            }
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
