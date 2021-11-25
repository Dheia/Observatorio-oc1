<?php

namespace Tresfera\Statistics\Controllers;

use BackendMenu;
use Tresfera\Taketsystem\Classes\ControllerFilters;
use Flash;
use Backend;
use Redirect;
use DB;
use Session;
use Tresfera\Statistics\Models\Result;
use Tresfera\Devices\Models\Shop;
use Tresfera\Taketsystem\Models\Quiz;
use Tresfera\Clients\Models\Client;
use BackendAuth;
use Renatio\DynamicPDF\Classes\PDF;

/**
 * Stats Back-end Controller.
 */
class Stats extends ControllerFilters
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

	   public $typePage = [
						'quiz_id' => 'Cuestionarios',
						'shop_id' => 'Tiendas',
						'citycp_name' => 'Ciudades',
						'question_title' => 'Preguntas',
						'free' => 'Comentarios',
						];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Tresfera.Statistics', 'statistics', 'stats');

        $this->addCss('/plugins/tresfera/taketsystem/assets/css/taket.css');


        $this->addCss('/plugins/tresfera/taketsystem/assets/css/global.css');
        $this->addCss('/plugins/tresfera/taketsystem/assets/css/stats.css');

        $this->addJs('//cdn.jsdelivr.net/momentjs/2.9.0/moment.min.js', 'Tresfera.Taketsystem');
        $this->addJs('//cdn.jsdelivr.net/bootstrap.daterangepicker/1/daterangepicker.js', 'Tresfera.Taketsystem');
        $this->addCss('//cdn.jsdelivr.net/bootstrap.daterangepicker/1/daterangepicker-bs3.css');

        $this->addJs('//cdn.amcharts.com/lib/3/amcharts.js', 'Tresfera.Taketsystem');
        $this->addJs('//www.amcharts.com/lib/3/serial.js', 'Tresfera.Taketsystem');
        $this->addJs('//www.amcharts.com/lib/3/plugins/dataloader/dataloader.min.js', 'Tresfera.Taketsystem');

    }

    public function index()
	{
	    //
	    // Do any custom code here
	    //

	    // Call the ListController behavior index() method
	    $this->asExtension('ListController')->index();
	}

	public function ranking()
	{
	    //
	    // Do any custom code here
	    //
		$this->getTopTiendas();
		$this->getMetricas();
	    // Call the ListController behavior index() method
	    $this->makeView("ranking");
	}

	public function preview()
	{
	    //
	    // Do any custom code here
	    //

	    // Call the ListController behavior index() method
	    $this->asExtension('ListController')->index();
	}

	public function comparativas() {
		$this->getTiendas();
		$this->getMetricas();
		$this->makeView("comparativas");
	}

	public function dashboardDetail()
	{
	    //
	    // Do any custom code here
	    //

	    // Call the ListController behavior index() method
	    $this->makeView("dashboard_detail");
	}
	public function sondeos()
	{
	    //
	    // Do any custom code here
	    //

	    // Call the ListController behavior index() method
	    $this->makeView("sondeos");
	}

	public function dashboard()
	{
	    //
	    // Do any custom code here
	    //

      $user = BackendAuth::getUser();
	    // Call the ListController behavior index() method
      if($user->client_id == "204") {
       return $this->makePartial("dashboardtest");
      } else {
       // $this->makeView("dashboard");
      }
	}

	public function cleanFilters()
	{
	    //
	    // Do any custom code here
	    //
		$test = $this->onFilterGetOptions();
	    $base = [
		    	"quizzes" 	=> [],
		    	"sex"		=> [],
		    	"age"		=> [],
		    	"shop"		=> [],
		    	"geo"		=> [],
		    	"hour"		=> [],
		    	"sondeo"	=> [],
	    	];
	    foreach($base as $key=>$value) {
		   $test[$key] = [];
	    }
			$numSession = "Taket.statistics.filters";
			$session = Session::get($numSession);
			//echo "<pre>";print_r($session);echo "</pre>";
			$filters = $test;
			foreach($filters as $key => $filter) {
				$session[$key] = array();
			}

			Session::put($numSession, $session);
	    // Call the ListController behavior index() method
	    return Redirect::to("//$_SERVER[HTTP_HOST]/backend/tresfera/statistics/stats/dashboard");
	}

	public function listExtendColumns($list)
    {

	   $groupBy = $this->getGroupBy();


	    $select = "name";
	    $list->recordUrl = null;
	    switch($groupBy) {
		    case 'device_id':
			    $list->removeColumn("question_title");
			    $list->removeColumn("question_value");
			    $list->removeColumn("created_at");
			    $list->removeColumn("shop");
			    $list->removeColumn("quiz");
			    $list->removeColumn("num");
			    $list->removeColumn("percent");
			    $list->removeColumn("email");
			    $list->removeColumn("room");
		    break;
		    case 'citycp_name':
		   		$list->recordUrl .= "tresfera/statistics/stats/dashboard/?detalles=1&type=specific&filter=citycp_name&filterId=:citycp_name&filterName=:citycp";
			    $list->removeColumn("device");
			    $list->removeColumn("question_title");
			    $list->removeColumn("created_at");
			    $list->removeColumn("shop");
			    $list->removeColumn("question_value");
		    	$list->removeColumn("free");
			    $list->removeColumn("quiz");
			    $list->removeColumn("num");
			    $list->removeColumn("percent");
			    $list->removeColumn("email");
			    $list->removeColumn("room");
		    break;
		    case 'region_id':
			    $list->removeColumn("device");
			    $list->removeColumn("city");
			    $list->removeColumn("shop");
		    	$list->removeColumn("free");
			    $list->removeColumn("question_title");
			    $list->removeColumn("created_at");
			    $list->removeColumn("question_value");
			    $list->removeColumn("quiz");
			    $list->removeColumn("num");
			    $list->removeColumn("percent");
			    $list->removeColumn("email");
			    $list->removeColumn("room");
		    break;
		    case 'shop_id':
		    	$list->recordUrl .= "tresfera/statistics/stats/dashboard/?detalles=1&type=specific&filter=shop_id&filterId=:shop_id&filterName=:shop";
			    $list->removeColumn("device");
			    $list->removeColumn("quiz");
			    $list->removeColumn("question_title");
			    $list->removeColumn("question_value");
		    	$list->removeColumn("free");
			    $list->removeColumn("region");
			    $list->removeColumn("citycp");
			    $list->removeColumn("num");
			    $list->removeColumn("created_at");
			    $list->removeColumn("percent");
			    $list->removeColumn("email");
			    $list->removeColumn("room");
		    break;
		    case 'question_title':

			    $list->removeColumn("region");
			    $list->removeColumn("quiz");
			    $list->removeColumn("citycp");
			    $list->removeColumn("result");
			    $list->removeColumn("device");
			    $list->removeColumn("city");
			    $list->removeColumn("shop");
			    $list->removeColumn("num");
		    	$list->removeColumn("free");
			    $list->removeColumn("question_value");
			    $list->removeColumn("percent");
			    $list->removeColumn("emails");
			    $list->removeColumn("created_at");
			    $list->removeColumn("numQuestions");
			    $list->removeColumn("email");
			    $list->removeColumn("room");
		    break;
		    case 'quiz_id':
		    	$list->removeColumn("question_title");
		    	$list->removeColumn("device");
		    	$list->removeColumn("citycp");
			    $list->removeColumn("city");
			    $list->removeColumn("shop");
			    $list->removeColumn("region");
		    	$list->removeColumn("free");
			    $list->removeColumn("num");
			    $list->removeColumn("question_value");
			    $list->removeColumn("percent");
			    $list->removeColumn("created_at");
			    $list->removeColumn("email");
			    $list->removeColumn("room");
		    break;
		    case 'value':
		    	//$list->recordUrl .= "tresfera/statistics/stats/dashboardSpecific/?type=specific&filter=question&filterId=:question_value&filterName=:question_value";

		    	$list->removeColumn("question_title");
		    	$list->removeColumn("device");
			    $list->removeColumn("city");
			    $list->removeColumn("quiz");
			    $list->removeColumn("shop");
			    $list->removeColumn("region");
			    $list->removeColumn("numQuestions");
			    $list->removeColumn("emails");
			    $list->removeColumn("numOk");
			    $list->removeColumn("numKo");
			    $list->removeColumn("numMix");
			    $list->removeColumn("percentOk");
			    $list->removeColumn("percentKo");
			    $list->removeColumn("percentMix");
		    	$list->removeColumn("free");
			    $list->removeColumn("num");
			    $list->removeColumn("created_at");
			    $list->removeColumn("email");
			    $list->removeColumn("room");

		    break;
		    case 'free':
		    	//$list->recordUrl .= "tresfera/statistics/stats/dashboardSpecific/?type=specific&filter=question&filterId=:question_value&filterName=:question_value";

		    	$list->removeColumn("question_title");
		    	$list->removeColumn("device");
			    $list->removeColumn("city");
				$list->removeColumn("quiz");
				$list->removeColumn("shop");
			    $list->removeColumn("room");

			    $list->removeColumn("region");
			    $list->removeColumn("numQuestions");
			    $list->removeColumn("emails");
			    $list->removeColumn("numOk");
			    $list->removeColumn("numKo");
			    $list->removeColumn("numMix");
			    $list->removeColumn("percentOk");
			    $list->removeColumn("percentKo");
			    $list->removeColumn("percentMix");
			    $list->removeColumn("num");
			    $list->removeColumn("citycp");
			    $list->removeColumn("numQuizzs");
			    $list->removeColumn("numQuestions");
			    $list->removeColumn("percent");
			    $list->removeColumn("question_value");

		    break;
	    }


		/*$list->addColumns([
            $groupBy => [
                'label' => $label,
                'relation' => $relation,
                'select' => $select,
            ]
        ]);*/

    }
    public function getRankingData() {
	    $dateRange 		= $this->getDateRange();
	    $metricas 		= $this->getMetricas();
		$tiendas 		= $this->getTiendas();
		$cuestionario 	= $this->getCuestionario();
		$topTiendas		= $this->getTopTiendas();

		$result 		= new Result();
	    $results = $result->getRankingData($topTiendas,$metricas,$dateRange,$cuestionario);

		$i = 0;
		$data = array();
		$tienda_id = 0;
	    foreach($results as $result) {
     	    $shop = Shop::find($result->shop_id);
     	    if(isset($shop->name)) {
			    $data[$i]['category'] 	= $shop->name;
			    $data[$i]['value'] 		= $result->shop;
			}
		    $i++;
	    }

	    echo json_encode($data);
		exit;
	}
    public function getComparativaData() {
	    $dateRange 		= $this->getDateRange();
	    $metricas 		= $this->getMetricas();
		$tiendas 		= $this->getTiendas();
		$cuestionario 	= $this->getCuestionario();
		$result 		= new Result();


	    $results = $result->getComparativaData($tiendas,$metricas,$dateRange,$cuestionario);

		$data = [];
		$i = 0;
	    foreach($results as $result) {

		    $data[$i] = [
			    'date' => $result->date,
		    ];

		    foreach($tiendas as $tienda) {
			    $var = "shop_".$tienda;
			    $data[$i]['shop_'.$tienda] = $result->$var?$result->$var:'0.0';
		    }

		    $data[$i]['global'] = $result->global;

		    $i++;
	    }

	    echo json_encode($data);
	    exit;

    }
    public function getStatsData() {
	    $dateRange 	= $this->getDateRange();
	    $filter 	= $this->getFilter();
			$filterId 	= $this->getFilterId();
			$cuestionario 	= $this->getCuestionario();
			$result = new Result();


	    $results = $result->getDataStats($filter,$filterId,$dateRange,$cuestionario);

	    foreach($results as $result) {
		    $data[] = [
			    'ko' => $result->numKo,
			    'ok' => $result->numOk,
			    'mix' => $result->numMix,
			    'date' => $result->date,
		    ];
	    }

	    echo json_encode($data);
	    exit;

    }
	public function listExtendQuery($query, $scope)
	{
		$groupBy 	= $this->getGroupBy();
		$filter 	= $this->getFilter();
		$filterId 	= $this->getFilterId();
		$dateRange 	= $this->getDateRange();
		$cuestionario 	= $this->getCuestionario();

		/*if(get("detalles")!=1)
			$this->widget->list->recordUrl .= "&filter=".$groupBy."&filterId=:".$groupBy."&filterName=:".str_replace("_id","",$groupBy);
		else
			$this->widget->list->recordUrl = null;
		*/
	    $query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

	    if(get("detalles")==1)
	    	$query->where($filter, '=', $filterId);

	    if($cuestionario!=null) {
		    $query->where("quiz_id", '=', $cuestionario);
	    }
	    $user = BackendAuth::getUser();

	    switch($groupBy) {
			case 'value':
		    	$query->where(function($query)
				{
					$query->addSelect(DB::raw('value_type'));
				    $query->where("question_type", '=', DB::raw("'specific'"));
				    $query->orderBy("value_type", DB::raw("'desc'"));
				});
			break;
			case 'question_title':
				$query->where(function($query)
				{
				    $query->where("question_type", '=', DB::raw("'general'"));
				    $query->orWhere("question_type", '=', DB::raw("'nps'"));
				    $query->orWhere("question_type", '=', "specific");
				    $query->orWhere("question_type", '=', DB::raw("'line'"));
				});
			break;
			case 'shop_id':
			$groupBy='tresfera_taketsystem_results.'.$groupBy;
			break;
		}


        if ($user->client_id) {
            $query->where('tresfera_taketsystem_quizzes.client_id', "=", DB::raw($user->client_id));
            $query->join('tresfera_taketsystem_quizzes', 'tresfera_taketsystem_results.quiz_id', '=', 'tresfera_taketsystem_quizzes.id');
            //filter by shop user
	        $userShops = \Tresfera\Taketsystem\Models\UserShop::where("user_id","=",$user->id)->get();
	        if(isset($userShops)) {
		        $query->where(function ($query) use ($userShops) {
					foreach($userShops as $userShop)
						$query->orWhere("tresfera_taketsystem_results.shop_id", '=', $userShop->shop_id);
				});
			}
			$userQuizs = \Tresfera\Taketsystem\Models\UserQuiz::where("user_id","=",$user->id)->get();
	        if(isset($userQuiz)) {
		        $query->where(function ($query) use ($userQuizs) {
					foreach($userQuizs as $userQuiz)
						$query->orWhere("tresfera_taketsystem_results.quiz_id", '=', $userQuiz->quiz_id);
				});
	        }
        }


		if(is_array($dateRange)) {
			$query->whereRaw("DATE(tresfera_taketsystem_answers.created_at) >= DATE('".$dateRange['start']."') AND DATE(tresfera_taketsystem_answers.created_at) <= DATE('".$dateRange['end']."')");
		}
	    $numSession = "Taket.statistics.filters";
	    $session = \Session::get($numSession);
	    if(is_array($session))
		foreach($session as $filter => $data) {
			switch($filter) {
				case 'quizzes':
					$query->where(function ($query) use ($data) {
						foreach($data as $quiz)
							$query->orWhere("tresfera_taketsystem_results.quiz_id", '=', $quiz['id']);
					});
				break;
				case 'sex':
					$query->where(function ($query) use ($data) {
						foreach($data as $sex)
							$query->orWhere("tresfera_taketsystem_results.sex", '=', $sex['id']);
					});
				break;
				case 'age':
					$query->where(function ($query) use ($data) {
						foreach($data as $key => $age) {
							$ini = (int)($age['id']/10)*10;
							$fin = $ini+9;

							$query->orWhere(function ($query) use ($ini, $fin) {
									$query->where("tresfera_taketsystem_results.age", '>=', $ini)
					          			->where("tresfera_taketsystem_results.age", '<=', $fin);
					        });
						}
					});
				break;
				case 'sondeo':
					if(count($data)>0) {
						$subSql = "SELECT a1.result_id FROM tresfera_taketsystem_answers as a1 WHERE a1.question_type = 'sondeo' ";
						foreach($data as $key => $value) {
							$subSql.= " AND a1.value = '".$value['id']."'";
						}
						$query->whereRaw("result_id IN (".$subSql.")");
					}

				break;
				case 'shop':
					$query->where(function ($query) use ($data) {
						foreach($data as $shop)
							$query->orWhere("tresfera_taketsystem_results.shop_id", '=', $shop['id']);
					});
				break;
				case 'geo':
					$query->where(function ($query) use ($data) {
						foreach($data as $geo)
							$query->orWhere("tresfera_taketsystem_results.citycp_id", '=', $geo['id']);
					});
				break;
				case 'hour':
					$query->where(function ($query) use ($data) {
						foreach($data as $hour)
							$query->orWhereRaw(DB::raw("HOUR(tresfera_taketsystem_results.created_at) = ".$hour['id']));
					});
				break;
			}

		}


	    $query->groupBy($groupBy);
	//	dd($query->toSql());
	   /* print_r($dateRange);
	    */
	}
	public function onChangeDimension() {
		Stats::extendListColumns(function($list, $model) {

	        if (!$model instanceof MyModel)
	            return;

	        $this->listExtendColumns();

	    });

		return $this->listRefresh();
	}
	/* Sessions */
	public function rapport() {
	    $data = [];
	    $user = BackendAuth::getUser();

		$filter 		= $this->getFilter();
		$filter_id 		= $this->getFilterId();
		$date 			= $this->getDateRange();
		$cuestionario 	= $this->getCuestionario();
		$shop 			= $this->getTiendas();

		$filters		= $this->getFilters();
	    if($user->client_id) {
		    $client = Client::find($user->client_id);
	    } else {
		    if($cuestionario) {
			    $quiz = Quiz::find($cuestionario);
			    $client = Client::find($quiz->client_id);
		    }

	    }

		$range = (int)((strtotime($date['end']) - strtotime($date['start']))/(60*60*24));

		$date_last['start'] = date("Y-m-d", strtotime($date['start'].' - '.$range.' days'));
	    //get Last Sunday
	    $date_last['end'] 	= date("Y-m-d", strtotime($date['end'].' - '.($range+2).' days'));

		$rapport = new \Tresfera\Statistics\Models\Rapport();
	   // $rapport->client_id  		= $client->id;
	    $rapport->theme		  		= "rapport";
	    $rapport->type				= "custom";
	    $rapport->date_start 		= $date['start'];
	    $rapport->date_end 			= $date['end'];
		$rapport->datelast_start 	= $date_last['start'];
		$rapport->datelast_end   	= $date_last['end'];
		$rapport->cuestionario   	= $cuestionario;


		if(count($filters['shop'])==1) {
			$rapport->shop_id = $filters['shop'][0]['id'];
		}

      	$rapport->filters = $filters;
	    $rapport->save();

	    try
        {
			return PDF::loadTemplate("rapport", $rapport->data)->stream('download.pdf');
            exit;
        } catch (Exception $ex)
        {
            Flash::error($ex->getMessage());
        }
    }


}
