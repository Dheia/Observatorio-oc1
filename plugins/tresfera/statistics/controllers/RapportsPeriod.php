<?php namespace Tresfera\Statistics\Controllers;

use BackendMenu;
use Tresfera\Taketsystem\Classes\ControllerFilters;
use Renatio\DynamicPDF\Models\PDFTemplate;
use Tresfera\Clients\Models\Client;
use Flash;
use Tresfera\Statistics\Models\Rapport;
use Tresfera\Statistics\Models\RapportPeriod;
use Session;
use Redirect;

/**
 * Rapports Back-end Controller
 */
class RapportsPeriod extends ControllerFilters
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function onFilterUpdate() {
  		$numSession = "Taket.statistics.filters";
  		$session = Session::get($numSession);
  		//echo "<pre>";print_r($session);echo "</pre>";
  		$filters = post();

  		foreach($filters as $key => $filter) {
  			if($key == 'scopeName') $f = $filter;
  			else {
  				if(isset($filter['active']))
  					$session[$f] = $filter['active'];
  				else
  					$session[$f] = array();
  				//echo "<pre>";print_r($session);echo "</pre>";
  			}
  		}
  		$session['date_range'] = $this->getDateRange();

  		Session::put($numSession, $session);

      //miramos cual es
      $url = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH);
      $urlA = explode("/",$url);
      $rapport_id = ($urlA[count($urlA)-1]);
      $rapportPeriod = RapportPeriod::find($rapport_id);
      if(isset($rapportPeriod->id)) {
        $rapportPeriod->save();
      }

  		return Redirect::to("//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
  	}

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Tresfera.Statistics', 'rapportsperiod', 'rapportsperiod');
    }
    public function onDeleteRapport() {
      $id = post('id');
      $rapport = Rapport::find($id);
      if(isset($rapport->id)) {
        $rapport->delete();
        Flash::success('Borrado correctamente.');
      } else
        Flash::error('No hemos podido. No existe.');
    }

    public function index() {
      $this->_cleanFilters();
      parent::index();

    }
    public function onSendRapport() {
      $id = post('id');
      $rapport = Rapport::find($id);
      if(isset($rapport->id)) {
        $rapportPeriod = RapportPeriod::find($rapport->rapportperiod_id);
        if(isset($rapportPeriod->id)) {
          $rapport->sendEmail($rapportPeriod->name, $rapportPeriod->emails);
          //$rapport->sendEmail($rapportPeriod->name, [['email'=>'fgomezserna@gmail.com']]);
          Flash::success('Enviado correctamente');
        } else {
          Flash::error('No existe');
        }
      } else {
        Flash::error('No existe');
      }

    }
    public function onReloadRapport() {
      $id = post('id');
      $rapport = Rapport::find($id);
      $rapportPeriod = RapportPeriod::find($rapport->rapportperiod_id);



      if(isset($rapport->id)) {

     
        $rapport->filters						= $rapportPeriod->filters;

        $rapport->save();


        if(is_file(__DIR__."/../../../informes/".$rapport->md5.".pdf")) {
  				unlink(__DIR__."/../../../informes/".$rapport->md5.".pdf");
  			}


        Flash::success('Se ha regenerado el informe.');
				/*$rapportPeriod->setNextDates();

				//$rapportPeriod->filters = $filters;
				$rapportPeriod->save();*/
      }
      return \Redirect::to("/backend/tresfera/statistics/rapportsperiod/update/".$rapport->rapportperiod_id);

    }
    public function onGenerateFecha() {
      $id = post('id');
      $rapportPeriod = RapportPeriod::find($id);

      if(isset($rapportPeriod->id)) {
        $date = $rapportPeriod->getDatePeriodNow();

        $rapport = new Rapport();
        $rapport->client_id  				= $rapportPeriod->client_id;
        $rapport->theme		  				= "rapport";
        $rapport->type							= $rapportPeriod->period;
        $rapport->filters						= $rapportPeriod->filters;
        $rapport->rapportperiod_id	= $rapportPeriod->id;
        $rapport->date_start 				= $date['date_start']['start'];
        $rapport->date_end 					= $date['date_start']['end'];
        $rapport->datelast_start 		= $date['date_last']['start'];
        $rapport->datelast_end   		= $date['date_last']['end'];
        $rapport->save();

        $filters = $rapportPeriod->filters;

				$rapportPeriod->setNextDates();

				//$rapportPeriod->filters = $filters;
				$rapportPeriod->save();
      }
    }
    public function listExtendQuery($query, $definition = null){
       $user = \BackendAuth::getUser();
     if($user->client_id)
      $query->where('client_id', '=', $user->client_id);
    }

}
