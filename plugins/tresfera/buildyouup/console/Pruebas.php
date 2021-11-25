<?php namespace Tresfera\Buildyouup\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Tresfera\Buildyouup\Controllers\ImportExportResultsAnswers;
use Tresfera\Buildyouup\Models\Equipo;
use Tresfera\Buildyouup\Models\Rapport;

class Pruebas extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'buildyouup:pruebas';

    /**
     * @var string The console command description.
     */
    protected $description = 'Comando para realizar pruebas';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {

        $export = new ImportExportResultsAnswers();
        $export->exportar();

        exit; 
        
        $id = 303;
        echo "Empezamos generacion del informe: ".$id."\n";
        $evaluacion = Equipo::find($id);
        if(isset($evaluacion->id)) {
            $rapport = new Rapport();
            $rapport->evaluacion_id = $evaluacion->id;
            $rapport->save();
    
            echo "Asociamos la evaluacion con el rapport nuevo...".$rapport->id."\n";
            
            $evaluacion->rapport_id = $rapport->id;
            $evaluacion->estado_informe = 2;
            $evaluacion->save();
            //generamos los datos
            echo "Generamos los datos.."."\n";
            $rapport->generateData();
            echo "Generamos PDF.."."\n";
            $rapport->generatePdf();
            echo "Informe guardad en: ".$rapport->getFile()."\n";
            echo "Indicamos a la evaluacion que el informe está listo"."\n";
            $evaluacion->estado_informe = 3;
            $evaluacion->save();
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
