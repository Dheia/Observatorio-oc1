<?php

namespace Tresfera\Datos\Controllers;

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
use Renatio\DynamicPDF\Models\PDFTemplate;
use Tresfera\Statistics\Models\Punto;

/**
 * Stats Back-end Controller.
 */
class Datos extends ControllerFilters
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

        BackendMenu::setContext('Tresfera.Datos', 'datos', 'datos');

        $this->addCss('/plugins/tresfera/taketsystem/assets/css/taket.css');
        $this->addCss('/plugins/tresfera/taketsystem/assets/css/global.css');
        $this->addCss('/plugins/tresfera/taketsystem/assets/css/stats.css');

        $this->addJs('//cdn.jsdelivr.net/momentjs/2.9.0/moment.min.js', 'Tresfera.Taketsystem');
        $this->addJs('//cdn.jsdelivr.net/bootstrap.daterangepicker/1/daterangepicker.js', 'Tresfera.Taketsystem');
        $this->addCss('//cdn.jsdelivr.net/bootstrap.daterangepicker/1/daterangepicker-bs3.css');

        $this->addJs('//cdn.amcharts.com/lib/3/amcharts.js', 'Tresfera.Taketsystem');
        $this->addJs('//www.amcharts.com/lib/3/serial.js', 'Tresfera.Taketsystem');
        $this->addJs('//www.amcharts.com/lib/3/plugins/dataloader/dataloader.min.js', 'Tresfera.Taketsystem');

				$this->addCss('/plugins/tresfera/taketsystem/assets/jqcloud.css');
        $this->addJs('https://devel.taket.es/plugins/tresfera/taketsystem/assets/jqcloud.js');
    }

    public function index()
	{
	    //
	    // Do any custom code here
	    //

	    // Call the ListController behavior index() method
	    $this->asExtension('ListController')->index();
	}
	public function puntosCsv() {
		$this->download_send_headers("points_" . date("Y-m-d_his") . ".csv");
		$data = $this->_puntos();
		echo utf8_decode($this->array2csv($data));
		exit;
	}
	public function _puntos() {
		$data = [];
		$user = BackendAuth::getUser();

		$filter 		  = $this->getFilter();
		$filter_id 		= $this->getFilterId();
		$date 			  = $this->getDateRange();
		$cuestionario = $this->getCuestionario();
		$shop 			  = $this->getTiendas();

		$filters		  = $this->getFilters();
		if($user->client_id) {
			$client = Client::find($user->client_id);
		} else {
			if($cuestionario) {
				$quiz = Quiz::find($cuestionario);
				$client = Client::find($quiz->client_id);
			}

		}
	//	dd($filters);
		$range = (int)((strtotime($date['end']) - strtotime($date['start']))/(60*60*24));

		$dateRange['start'] = date("Y-m-d", strtotime($date['start'].' - '.$range.' days'));
		//get Last Sunday
		$dateRange['end'] 	= date("Y-m-d", strtotime($date['end'].' - '.($range+2).' days'));


		if($user->client_id == 232) {
			$query = Punto::addSelect("nombre")
			->addSelect("torneo")
			->where("client_id",$user->client_id)
			->addSelect("club")
			->addSelect("categoria")
			->addSelect(\DB::raw("sum(identificarme) as Identificarme"))				 //numero de identificaciones
			->addSelect(\DB::raw("sum(valores) as Valores"))				 //numero de identificaciones
			->addSelect(\DB::raw("sum(comportamiento) as Comportamiento"))				 //numero de identificaciones
			->addSelect(\DB::raw("sum(rendimiento) as Rendimiento"))				 //numero de identificaciones
			->addSelect(\DB::raw("sum(rendimiento+comportamiento+valores+identificarme) as `Total torneo`"))				 //numero de identificaciones
			->addSelect(\DB::raw("(select sum(a.rendimiento+a.comportamiento+a.valores+a.identificarme) from tresfera_taketsystem_puntos_tatenis as a where a.nombre = tresfera_taketsystem_puntos_tatenis.nombre group by a.nombre ) as Total"))				 //numero de identificaciones
			->groupBy("nombre","torneo");
		}
		if($user->client_id == 240) {
			$query = Punto::addSelect("nombre")
			->where("client_id",$user->client_id)
			->addSelect("club")
			->addSelect("categoria")
			->addSelect(\DB::raw("FORMAT(sum(identificarme)/(SELECT count(nombre) FROM tresfera_taketsystem_puntos_tatenis as p1 WHERE p1.identificarme = 10 and p1.client_id = ".$user->client_id." and p1.nombre = tresfera_taketsystem_puntos_tatenis.nombre),2) as Identificarme"))				 //numero de identificaciones
			->addSelect(\DB::raw("FORMAT(sum(valores)/(SELECT count(nombre) FROM tresfera_taketsystem_puntos_tatenis as p1 WHERE p1.identificarme = 10 and p1.client_id = ".$user->client_id." and p1.nombre = tresfera_taketsystem_puntos_tatenis.nombre),2) as Valores"))				 //numero de identificaciones
			->addSelect(\DB::raw("FORMAT(sum(comportamiento)/(SELECT count(nombre) FROM tresfera_taketsystem_puntos_tatenis as p1 WHERE p1.identificarme = 0 and p1.client_id = ".$user->client_id." and p1.nombre = tresfera_taketsystem_puntos_tatenis.nombre),2) as Comportamiento"))				 //numero de identificaciones
			->addSelect(\DB::raw("FORMAT(sum(rendimiento)/(SELECT count(nombre) FROM tresfera_taketsystem_puntos_tatenis as p1 WHERE p1.identificarme = 0 and p1.client_id = ".$user->client_id." and p1.nombre = tresfera_taketsystem_puntos_tatenis.nombre),2) as Rendimiento"))				 //numero de identificaciones
			->addSelect(\DB::raw("FORMAT(sum(rendimiento+comportamiento+valores+identificarme)/(SELECT count(nombre) FROM tresfera_taketsystem_puntos_tatenis as p1 WHERE p1.identificarme = 0 and p1.client_id = ".$user->client_id." and p1.nombre = tresfera_taketsystem_puntos_tatenis.nombre),2) as `Total`"))				 //numero de identificaciones
			->groupBy("nombre");
		}
		
		if(is_array($date)) {
			$query->whereRaw("DATE(created_at) >= DATE('".$date['start']."') AND DATE(created_at) <= DATE('".$date['end']."')");
		}
		if(isset($filters["club-propio"]) and count($filters["club-propio"])) {
			$query->where(function ($query) use ($filters) {
				foreach($filters["club-propio"] as $club) {
					$query->where("club",$club['id']);
			}
     }); 
		}
		if(isset($filters["torneos"]) and count($filters["torneos"])) {
			$query->where(function ($query) use ($filters) {
				foreach($filters["torneos"] as $torneo) {
					$query->where("torneo",$torneo['id']);
			}
     }); 
		}
		if(isset($filters["categoria"]) and count($filters["categoria"])) {
			$query->where(function ($query) use ($filters) {
				foreach($filters["categoria"] as $categoria) {
					$query->where("categoria",$categoria['id']);
			}
     }); 
		}
		if(isset($filters["jugador-propio"]) and count($filters["jugador-propio"])) {
			$query->where(function ($query) use ($filters) {
				foreach($filters["jugador-propio"] as $categoria) {
					$query->where("nombre",$categoria['id']);
			}
     }); 
		}
		$puntos = $query->get()->toArray();
		return $puntos;
		dd($puntos);

		//Creamos la sentencia SQL para poder sacar los datos sin tratar
		$query = new \Tresfera\Statistics\Models\Result();
		$data = [];
		//torneos
		$segmentacion_torneo = \Tresfera\Taketsystem\Models\Segmentacion::find(109);
		$torneos = $segmentacion_torneo->values;
		if(count($filters['torneos'])) {
			$torneos_filter = [];
			foreach($filters['torneos'] as $torn) {
				$torneos_filter[] = $torn['id'];
			}
			$torneos = $torneos->whereIn("id",$torneos_filter);
		}
		$jugadoresPuntosTotal = [];
		foreach($torneos as $torneo) {
			
			$filters['torneos'] = [
				"id" => $torneo->value,
	      "name" => $torneo->value
			];
			
			$q = $query->getQueryCustom($filters);
			if(count($filters)>0) {
				$subSql = "SELECT a1.result_id FROM tresfera_taketsystem_answers as a1 WHERE a1.question_type = 'segmentacion' ";
				foreach($filters as $key => $value) {
					if(isset($value['id']))
						if($key == 0)
							$subSql.= " AND a1.value = '".$value['id']."'";
						else
							$subSql.= " OR a1.value = '".$value['id']."'";
					}
				$q->whereRaw("result_id IN (".$subSql.")");
			}
			$q->addSelect("value")
				->addSelect(\DB::raw("count(*) as num"))				 //numero de identificaciones
				->addSelect(\DB::raw("count(*) * 10 as points")) //puntos por identificarse
				->where("answer_type","select_search")
				//->where("slide_id","2920")
				->groupBy("value");
				$jugadores = $q->get();
			foreach($jugadores as $jugador) {
				$d = [
					"Nombre" => $jugador->value,
					"Torneo" => $torneo->value,
					"Puntos por identificarme" => 0
				];
				
				if($jugador->slide_id == 2920)
					$d["Puntos por identificarme"] = $jugador->points;
	
				
	
				//Puntos valores
				$query = new \Tresfera\Statistics\Models\Result();
				$q = $query->getQueryCustom($filters);
				if(count($filters)>0) {
					$subSql = "SELECT a1.result_id FROM tresfera_taketsystem_answers as a1 WHERE a1.question_type = 'segmentacion' ";
					foreach($filters as $key => $value) {
						if(isset($value['id']))
							if($key == 0)
								$subSql.= " AND a1.value = '".$value['id']."'";
							else
								$subSql.= " OR a1.value = '".$value['id']."'";
						}
					$q->whereRaw("result_id IN (".$subSql.")");
				}
				$q->addSelect("value")
					->addSelect(\DB::raw("sum(value_type) as points")) //puntos valores
					->whereRaw(\DB::raw("result_id in (SELECT a.result_id FROM tresfera_taketsystem_answers as a WHERE a.slide_id = 2920 and a.value = '".$jugador->value."')"))	// pillamos solo los results que tocan
					->where("answer_type", "valores")
					->groupBy("answer_type");
				$result = $q->first();
				if($result) {
					$d['Puntos valores'] = $result->points;
				} else {
					$d['Puntos valores'] = "";
				}
	
				//Puntos comportamiento
				$query = new \Tresfera\Statistics\Models\Result();
				$q = $query->getQueryCustom($filters);
				if(count($filters)>0) {
					$subSql = "SELECT a1.result_id FROM tresfera_taketsystem_answers as a1 WHERE a1.question_type = 'segmentacion' ";
					foreach($filters as $key => $value) {
						if(isset($value['id']))
							if($key == 0)
								$subSql.= " AND a1.value = '".$value['id']."'";
							else
								$subSql.= " OR a1.value = '".$value['id']."'";
						}
					$q->whereRaw("result_id IN (".$subSql.")");
				}
				$q->addSelect("value")
					->addSelect(\DB::raw("sum(value_type) as points")) //puntos comportamiento
					->whereRaw(\DB::raw("result_id in (SELECT a.result_id FROM tresfera_taketsystem_answers as a WHERE a.slide_id = 2922 and a.value = '".$jugador->value."')"))	// pillamos solo los results que tocan
					->where("answer_type", "comportamiento")
					->groupBy("answer_type");
				$result = $q->first();
				if($result) {
					$d['Comportamiento'] = $result->points;
				} else {
					$d['Comportamiento'] = "";
				}
				
	
				//Puntos comportamiento
				$query = new \Tresfera\Statistics\Models\Result();
				$q = $query->getQueryCustom($filters);
				if(count($filters)>0) {
					$subSql = "SELECT a1.result_id FROM tresfera_taketsystem_answers as a1 WHERE a1.question_type = 'segmentacion' ";
					foreach($filters as $key => $value) {
						if(isset($value['id']))
							if($key == 0)
								$subSql.= " AND a1.value = '".$value['id']."'";
							else
								$subSql.= " OR a1.value = '".$value['id']."'";
						}
					$q->whereRaw("result_id IN (".$subSql.")");
				}
				$q->addSelect("value")
					->addSelect(\DB::raw("sum(IF(value_type = 3, 10, IF(value_type = 2, 5, 0))) as points")) //puntos comportamiento
					->whereRaw(\DB::raw("result_id in (SELECT a.result_id FROM tresfera_taketsystem_answers as a WHERE a.slide_id = 2922 and a.value = '".$jugador->value."')"))	// pillamos solo los results que tocan
					->where("question_type", "general")
					->groupBy("answer_type");
				$result = $q->first();
				if($result) {
					$d['Rendimiento'] = $result->points;
				} else {
					$d['Rendimiento'] = "";
				}
				
				$d['Total Torneo'] = $d['Puntos por identificarme'] + $d['Puntos valores'] + $d['Comportamiento'] + $d['Rendimiento'];
				if(!isset($jugadoresPuntosTotal[$jugador->value])) $jugadoresPuntosTotal[$jugador->value] = 0;
				$jugadoresPuntosTotal[$jugador->value] += $d['Total Torneo'];
				$d['Total Tatenis'] = 0;
				$data[] = $d;
			}
		}
		foreach($data as $i=>$d) {
			if(isset($jugadoresPuntosTotal[$d['Nombre']])) {
				$data[$i]['Total Tatenis'] += $jugadoresPuntosTotal[$d['Nombre']];
			}
		}

		return $data;
	}
	public function puntos($return = false) {
		BackendMenu::setContext('Tresfera.Datos', 'datos', 'puntos');
		
		
		$data = $this->_puntos();
		//NOMBRE JUGADOR 	CATEGORÍA 	CLUB	TORNEO 	FECHA 	PUNTOS POR IDENTIFICARSE 	VALORES ESFUERZO 	VALOR N12 	TOTAL PUNTOS VALORES 	COMPORTAMIENTO 1 	COMPORTAMIENTO N8	RENDIMIENTO 1	RENDIMIENTO N6	RANKING TATENIS POR TORNEO 	RANKING TATENIS TOTAL 
		$this->vars['data'] = $data;

		$this->makeView("puntos",["data"=>$data]);
	}
	public function cloud()
	{
	    //
	    // Do any custom code here
	    //

	    // Call the ListController behavior index() method
		  $data = [];
			$user = BackendAuth::getUser();

			$filter 		  = $this->getFilter();
			$filter_id 		= $this->getFilterId();
			$date 			  = $this->getDateRange();
			$cuestionario = $this->getCuestionario();
			$shop 			  = $this->getTiendas();

			$filters		  = $this->getFilters();

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

			//Creamos la sentencia SQL para poder sacar los datos sin tratar
			$query = new \Tresfera\Statistics\Models\Result();
			$data = $query->getFreeFields($date);
	   		$this->makeView("cloud",["data"=>$data]);
	
  	}
	public function dashboard()
	{
	    //
	    // Do any custom code here
	    //

	    // Call the ListController behavior index() method
		  $data = [];
			$user = BackendAuth::getUser();

			$filter 		  = $this->getFilter();
			$filter_id 		= $this->getFilterId();
			$date 			  = $this->getDateRange();
			$cuestionario = $this->getCuestionario();
			$shop 			  = $this->getTiendas();

			$filters		  = $this->getFilters();

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

			//Creamos la sentencia SQL para poder sacar los datos sin tratar
			$query = new \Tresfera\Statistics\Models\Result();
			 $data = $query->getDataCSV($date_last);
			
			
			

	   // return $this->makeView("dashboard",["data"=>$data]);
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
			    $list->removeColumn("region");
			    $list->removeColumn("numQuestions");
			    $list->removeColumn("emails");
			    $list->removeColumn("numOk");
          $list->removeColumn("numKo");
          $list->removeColumn("room");
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
        case 'clients':
					$query->where(function ($query) use ($data) {
						foreach($data as $client)
							$query->orWhere("tresfera_taketsystem_results.email", '=', $client);
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

		$filter 		  = $this->getFilter();
		$filter_id 		= $this->getFilterId();
		$date 			  = $this->getDateRange();
		$cuestionario = $this->getCuestionario();
		$shop 			  = $this->getTiendas();

		$filters		  = $this->getFilters();

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
	  $rapport->client_id  		  = $client->id;
	  $rapport->theme		  		  = "rapport";
	  $rapport->type				    = "custom";
	  $rapport->date_start 		  = $date['start'];
	  $rapport->date_end 			  = $date['end'];
		$rapport->datelast_start 	= $date_last['start'];
		$rapport->datelast_end   	= $date_last['end'];
		$rapport->cuestionario   	= $cuestionario;


		if(count($filters['shop'])==1) {
			$rapport->shop_id = $filters['shop'][0]['id'];
		}

    $rapport->save();

    try {
			return PDFTemplate::render("rapport", $rapport->data);
      exit;
    } catch (Exception $ex)
    {
        Flash::error($ex->getMessage());
    }
  }
function array2csv(array &$array)
  {
     if (count($array) == 0) {
       return null;
     }
     ob_start();
     $df = fopen("php://output", 'w');

     //buscamos el elemento con mas valores
     $max = 0;
	 $max_key = 0;
	 $keys = [];
     foreach ($array as $key=>$value) {
		 foreach($array[$key] as $k=>$v) {
			 if(!isset($keys[$k]))
				$keys[$k] = $k;
		 }
        /*$max = max(count($value),$max);
        if($max == count($value))
          $max_key = $key;*/
      }
    fputcsv($df,$keys, ";");
	foreach ($array as $id => $result) { //filas
		foreach($keys as $col) { //columnas
			if(isset($result[$col])) {
				if(is_array($result[$col])) 
					$csv_fields[$id][$col] = str_replace("::".$col,"",implode("\n", $result[$col]));
				else
					$csv_fields[$id][$col] = $result[$col];

				}
			else
				$csv_fields[$id][$col] = "";
		}
    	fputcsv($df, $csv_fields[$id], ";");
    }
    fclose($df);
    return ob_get_clean();
  }
  function download_send_headers($filename) {
      // disable caching
      $now = gmdate("D, d M Y H:i:s");
      header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
      header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
      header("Last-Modified: {$now} GMT");

      // force download
      header("Content-Type: application/force-download");
      header("Content-Type: application/octet-stream");
      header("Content-Type: application/download");

      // disposition / encoding on response body
      header("Content-Disposition: attachment;filename={$filename}");
      header("Content-Transfer-Encoding: binary");
  }
	public function csv() {
		$data = [];
		$user = BackendAuth::getUser();

		$filter 		  	= $this->getFilter();
		$filter_id 			= $this->getFilterId();
		$date 			  	= $this->getDateRange();
		$cuestionario 		= $this->getCuestionario();
		$shop 			  	= $this->getTiendas();

		$filters		  	= $this->getFilters();

		if($user->client_id) {
			$client = Client::find($user->client_id);
		} else {
			if($cuestionario) {
				$quiz = Quiz::find($cuestionario);
				$client = Client::find($quiz->client_id);
			}
		}

		$range = (int)((strtotime($date['end']) - strtotime($date['start']))/(60*60*24));

		$d = $date;

		/*$date['start']	= $d['end'];
		$date['end']	= $d['start'];*/ 
		
		$date_last['start'] = date("Y-m-d", strtotime($date['start'].' - '.$range.' days'));
		//get Last Sunday
		$date_last['end'] 	= date("Y-m-d", strtotime($date['end'].' - '.($range).' days'));

    
			//Creamos la sentencia SQL para poder sacar los datos sin tratar
		$query = new \Tresfera\Statistics\Models\Result();
		$data = $query->getDataCSV($date);
		foreach($data as $id=>$d) {
			foreach($d as $key=>$value) {
				$keyGood = explode("::",$key);
				if($keyGood[0] != $key) {
					$data[$id][$keyGood[0]] = $data[$id][$key];
					unset($data[$id][$key]);
				}	
			}
		}
	
		$filters = $this->getFilters();
		if(isset($filters['quizzes'])) {
			$etiquetas = [];
			foreach($filters['quizzes'] as $quiz) {
				
			}
		}


		$this->download_send_headers("data_export_" . date("Y-m-d_his") . ".csv");
		echo utf8_decode($this->array2csv($data));
		die();


		/*$rapport = new \Tresfera\Statistics\Models\Rapport();
		if(isset($client->id))
			$rapport->client_id  		  = $client->id;

		$rapport->theme		  		  = "rapport";
		$rapport->type				    = "custom";
		$rapport->date_start 		  = $date['start'];
		$rapport->date_end 			  = $date['end'];
			$rapport->datelast_start 	= $date_last['start'];
			$rapport->datelast_end   	= $date_last['end'];
			$rapport->cuestionario   	= $cuestionario;


			if(count($filters['shop'])==1) {
				$rapport->shop_id = $filters['shop'][0]['id'];
			}

		$rapport->save();

		try {
				return PDFTemplate::render("rapport", $rapport->data);
		exit;
		} catch (Exception $ex)
		{
			Flash::error($ex->getMessage());
		}*/
  }


}
