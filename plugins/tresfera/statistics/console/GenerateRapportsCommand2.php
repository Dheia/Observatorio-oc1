<?php
namespace Tresfera\Statistics\Console;

use Illuminate\Console\Command;
use Tresfera\Clients\Models\Client;
use Tresfera\Statistics\Models\Rapport;
use Tresfera\Statistics\Models\RapportLine;
use Tresfera\Statistics\Models\RapportPeriod;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenerateRapportsCommand extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'taket:generaterapports';

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
	    $this->info('Leyendo logs...');


			//get rapports period
			$rapportsLines = RapportLine::whereRaw("date_send <= (CURDATE())")->where("generated",0)->get();

	    //$period = $this->argument('period');
	    foreach($rapportsLines as $rapportLine) {
        $rapportPeriod = RapportPeriod::find($rapportLine->rapport_period_id);

				//$date = $rapportPeriod->getDatePeriodNow();
        echo $rapportPeriod->id."\n";
        print_r($rapportLine->attributes);
        $rapport = new Rapport();
				$rapport->client_id  				= $rapportPeriod->client_id;
				$rapport->theme		  				= "rapport";
				$rapport->type							= $rapportPeriod->period;
				$rapport->filters						= $rapportPeriod->filters;
        $rapport->rapportperiod_id	= $rapportPeriod->id;
				$rapport->date_start 				= $rapportLine->datenext_start;
				$rapport->date_end 					= $rapportLine->datenext_stop;
				$rapport->datelast_start 		= $rapportLine->datelast_start;
				$rapport->datelast_end   		= $rapportLine->datelast_stop;
				$rapport->save();

        $rapportLine->generated = 1;
        $rapportLine->send = 1;
        $rapportLine->rapport_id = $rapport->id;
        $rapportLine->save();

				$rapport->sendEmail($rapportPeriod->name, $rapportPeriod->emails);
				$filters = $rapportPeriod->filters;

				$rapportPeriod->setNextDates($rapportLine);

				//$rapportPeriod->filters = $filters;

        $rapportPeriod->save();

        //dd($rapportPeriod->filters);
			}
	   return;

	    foreach($clients as $client) {
		    //Comprobamos si tenemos que generar un informe global con este tipo de periodo
			if(isset($client->config->globals))
		    if(in_array($period, $client->config->globals) ) {
			    $rapport = new Rapport();
			    $rapport->client_id  			= $client->id;
			    $rapport->theme		  			= "rapport";
			    $rapport->type					= $period;
			    $rapport->date_start 			= $date['start'];
			    $rapport->date_end 				= $date['end'];
					$rapport->datelast_start 	= $date_last['start'];
					$rapport->datelast_end   	= $date_last['end'];
			    $rapport->save();
		    }
		    //Comprobamos si tenemos que generar un informe por tiendas con este tipo de periodo
			if(isset($client->config->shops))
			if(is_array($client->config->shops))
		    if(in_array($period, $client->config->shops) ) {
			    foreach($client->shops as $shop) {
				    $rapport = new Rapport();
				    $rapport->client_id  		= $client->id;
				    $rapport->shop_id	  		= $shop->id;
				    $rapport->theme		  		= "rapport";
				    $rapport->type				= $period;
				    $rapport->date_start 		= $date['start'];
				    $rapport->date_end 			= $date['end'];
					$rapport->datelast_start 	= $date_last['start'];
					$rapport->datelast_end   	= $date_last['end'];
				    $rapport->save();
			    }
		    }
	    }
	    $rapport->sendEmail();
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
