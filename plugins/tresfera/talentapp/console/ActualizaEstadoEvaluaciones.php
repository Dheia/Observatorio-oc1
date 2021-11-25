<?php namespace Tresfera\Talentapp\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Tresfera\Talentapp\Models\Evaluacion;

class ActualizaEstadoEvaluaciones extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'talentapp:actualizaestadoevaluaciones';

    /**
     * @var string The console command description.
     */
    protected $description = 'Actualiza el estado de las evaluaciones. Las que han sido completadas (Se han realizado todos los cuestionarios), con estado=2, y las que no, con estado=1';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        
        $evaluaciones = Evaluacion::all();

        foreach($evaluaciones as $evaluacion)
        {
            
            $eval_tmp = $evaluacion->getEvaluaciones();
            if( count($eval_tmp["pendientes"])==0)
            {
                $evaluacion->estado = 2;
                $evaluacion->save();
            }
            else
            {
                $evaluacion->estado = 1;
                $evaluacion->save();
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
