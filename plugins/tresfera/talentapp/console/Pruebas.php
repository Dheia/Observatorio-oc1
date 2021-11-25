<?php namespace Tresfera\Talentapp\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Tresfera\Talentapp\Controllers\ImportExportResultsAnswers;
use Tresfera\Talentapp\Models\Evaluacion;
use Tresfera\Talentapp\Models\Rapport;

class Pruebas extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'talentapp:pruebas';

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

        $id = 326;
        echo "Empezamos generacion del informe: ".$id."\n";
        $evaluacion = Evaluacion::find($id);
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
        exit;

        $export = new ImportExportResultsAnswers();
        $export->exportar();

        exit; 
        
        

    
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
