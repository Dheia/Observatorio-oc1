<?php
namespace Tresfera\Statistics\Console;

use Illuminate\Console\Command;
use Tresfera\Clients\Models\Client;
use Tresfera\Statistics\Models\Rapport;
use Tresfera\Taketsystem\Models\Answer;
use Tresfera\Statistics\Models\RapportLine;
use Tresfera\Statistics\Models\RapportPeriod;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Testing extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'taket:testing';

    /**
     * @var string The console command description.
     */
    protected $description = 'Genera los informes y los envía';

    /**
     * Create a new command instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return void
     */
    public function fire()
    {
		$answer = new Answer();
		$answer->result_id = 48512;
		$answer->slide_id = 1324;
		$answer->question_type = 'nps';
		$answer->value_type = 1;
		$answer->save();
		exit;
	   
        $this->output->writeln('Fin');
    }

/*	protected function getArguments()
    {
        return [
            ['period', InputArgument::REQUIRED, 'Selecciona el periodo del informe: weekly|fortnightly|monthly'],
        ];
    }*/
}
?>
