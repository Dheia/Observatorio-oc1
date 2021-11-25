<?php namespace Tresfera\Statistics\Controllers;

use BackendMenu;
use Tresfera\Taketsystem\Classes\ControllerFilters;
use Renatio\DynamicPDF\Models\PDFTemplate;
use Tresfera\Clients\Models\Client;

/**
 * Rapports Back-end Controller
 */
class Rapports extends ControllerFilters
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Tresfera.Statistics', 'statistics', 'rapports');
    }
    public function rapportPDF() {
	    $data = [];
	    $client_id = 13;
	    $client = Client::find($client_id);

	    //get Last Monday
	    $date['start'] 	= date("Y-m-d",  strtotime('last Monday',strtotime('last Monday', time())));
	    //get Last Sunday
	    $date['end'] 	= date("Y-m-d", strtotime('last Sunday', time()));

		  $date_last['start'] = date("Y-m-d", strtotime('last Monday',strtotime('last Monday',strtotime('last Monday', time()))));
	    //get Last Sunday
	    $date_last['end'] 	= date("Y-m-d", strtotime('last Sunday',strtotime('last Sunday', time())));

  		$filter = ["tresfera_taketsystem_results.client_id"];
  		$filter_id = ["tresfera_taketsystem_results.client_id" => $client->id];

  		$model = new \Tresfera\Statistics\Models\Result();
  		$actividad 		= $model->getTotals($filter,$filter_id,$date,array());
  		$actividad_last = $model->getTotals($filter,$filter_id,$date_last,array());
  		$nps 			= $model->getTotalsNPS($filter,$filter_id,$date,array());
  		$nps_last 		= $model->getTotalsNPS($filter,$filter_id,$date_last,array());
  		$generales 		= $model->getTotalsGeneral($filter,$filter_id,$date,array());
  		$genero 		= $model->getTotalsSex($filter,$filter_id,$date,array());
  		$age	 		= $model->getTotalsAge($filter,$filter_id,$date,array());
  		$geo	 		= $model->getTotalsCities($filter,$filter_id,$date,array());
  		$comments	 	= $model->getComments($filter,$filter_id,$date,array());

  		$data = [
  			"date" 				=> $date,
  			"client" 			=> $client,
  			"actividad" 		=> $actividad[0],
  			"actividad_last" 	=> $actividad_last[0],
  			"nps" 				=> $nps[0],
  			"generales" 		=> $generales,
  			"genero" 			=> $genero[0],
  			"ages" 				=> $age,
  			"comments" 			=> $comments,
  			"geos" 				=> $geo,
  		];
  		if($nps_last->count()) {
  			$data["nps_last"] =  $nps_last[0];
  		}
	    try
        {
			return PDFTemplate::render("rapport_week", $data);
            exit;
        } catch (Exception $ex)
        {
            Flash::error($ex->getMessage());
        }

    }
    public function rapport() {

        return $this->makePartial('rapport', []);

    }

}
