<?php namespace Tresfera\Buildyouup\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Tresfera\Buildyouup\Controllers\ImportExportResultsAnswers;

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
