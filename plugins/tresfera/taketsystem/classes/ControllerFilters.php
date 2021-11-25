<?php namespace Tresfera\Taketsystem\Classes;
use Backend\Classes\Controller;
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
/**
 * Dynamic Syntax parser
 */
class ControllerFilters extends Controller
{
	public function __construct()
    {
        parent::__construct();


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
	public function getDateRange() {
		// manipule session
		$numSession = "Taket.dateRange";
	    if(post('dateRange')) {
		    $dateRange1 = json_decode(post('dateRange'));
		    if(isset($dateRange1)) {
			    $dateRange["start"] = date('Y-m-d H:i:s', strtotime($dateRange1->start) + (3600*24));

			    $dateRange["end"] = date('Y-m-d H:i:s', strtotime($dateRange1->end));

			    Session::put($numSession, ($dateRange));
		    }

	    }
	   // dd(Session::get($numSession));
	   $return = Session::get($numSession);


	   //si no hay session
	   if(!$return) {
		   $dateRange["end"] = date('Y-m-d H:i:s');
		   $user = BackendAuth::getUser();
		   $dateRange["start"] = $user->created_at;
		   Session::put($numSession, ($dateRange));
	   }

	    return Session::get($numSession);
	}
	public function getSondeos() {
		// manipule session
		$numSession = "Taket.sondeos";
		//dd(post('tiendas'));
	    if(post('sondeos')) {
		    Session::put($numSession, (post('sondeos')));
	    }
	    $test = Session::get($numSession);
	    if(!$test)
	    	return array();

	    return Session::get($numSession);
	}
	public function getTiendas() {
		// manipule session
		$numSession = "Taket.tiendas";
		//dd(post('tiendas'));
	    if(post('tiendas')) {
		    Session::put($numSession, (post('tiendas')));
	    }
	    $test = Session::get($numSession);
	    if(!$test)
	    	return array();

	    return Session::get($numSession);
	}
	public function getTopTiendas() {
		// manipule session
		$numSession = "Taket.topTiendas";

		if(post('topTiendas')) {

		    Session::put($numSession, (post('topTiendas')));
	    }
	    if(Session::get($numSession))
	    	return Session::get($numSession);
	    else
	    	return "5|DESC";
	}
	public function getCuestionario() {
		// manipule session
		$numSession = "Taket.cuestionario";
		if(post('cuestionario')=='Todos') {
		    Session::put($numSession, 0);
	    } elseif(post('cuestionario')) {
		    Session::put($numSession, (post('cuestionario')));
	    }
	    return Session::get($numSession);
	}
	public function getMetricas() {
		// manipule session
		$numSession = "Taket.metrica";

	    if(post('metrica')) {
		    Session::put($numSession, (post('metrica')));
	    }
	    if((Session::get($numSession)))
	        return Session::get($numSession);
	    else
	    	return 'nps';
	}
	public function getFilters() {
		// manipule session
		$numSession = "Taket.statistics.filters";

	    $test = Session::get($numSession);
    
	    $base = [
				"quizzes" 	=> [],
				"quizzes_status" => [],
		    	"sex"		=> [],
		    	"age"		=> [],
		    	"shop"		=> [],
		    	"geo"		=> [],
		    	"hour"		=> [],
		    	"sondeo"	=> [],
	    	];
    
      	$user = BackendAuth::getUser();
		$segmentaciones = \Taket\Structure\Models\Question::with("options")->where("is_filter",1)->get();
		if(count($segmentaciones)) {
		foreach($segmentaciones as $segmentacion) {
			$slug = str_slug($segmentacion->id);
			$base[$slug] = [];
		}
		} 

	    foreach($base as $key=>$value) {
		    if(!isset($test[$key]))   $test[$key] = [];
	    }

	    return $test;
	}

	public function getFiltersData() {
		$groupBy = $this->getGroupBy();
		$dateRange = $this->getDateRange();

		$quizzes = \Tresfera\Statistics\Models\Result::getCuestionarios()->lists("title","id");
		$sexs = ['1'=>'Hombre','2'=>'Mujer'];
		$ages = [
					'15'=>'Menos de 20',
					'25'=>'20 - 29',
					'35'=>'30 - 39',
					'45'=>'40 - 49',
					'55'=>'50 - 59',
					'65'=>'60 - 69',
					'75'=>'70 - 79',
					'85'=>'Más de 80',
					'0'=>'No especificado',
				];
		$geoO = \Tresfera\Statistics\Models\Result::getGeo();
		$geo =array();
		if(is_object($geoO))
			$geo = $geoO->lists("citycp_name","citycp_id");



		$sondeos0 = \Tresfera\Statistics\Models\Result::getSondeosFilter();

		$sondeos = array();
		if(is_object($sondeos0)) {
			$sondeos_list = $sondeos0->get();
		
			foreach($sondeos_list as $sondeo) {
				if(!isset($sondeo->quiz_id)) continue;
				$quiz = \Tresfera\Taketsystem\Models\Quiz::find($sondeo->quiz_id);
				$value = $sondeo->value;

				if($sondeo->value) {
					$answerSondeo = \Tresfera\TaketSystem\Models\QuizMulti::find($sondeo->value);
					if(isset($answerSondeo->title))
						$value = $answerSondeo->title;
				}
				$sondeos[$sondeo->value] = $quiz->title." - ".$sondeo->question_title."::".$value;
			}
			//$sondeos = $sondeos0->lists("question_title","value");
			//
		}


		//dd($sondeos0->lists("question_title","value"));

		$shop = \Tresfera\Statistics\Models\Result::getTiendas()->lists("name","id");
		$hour = [6=>8,7=>9,8=>10,9=>11,10=>12,11=>13,12=>14,13=>15,14=>16,15=>17,16=>18,17=>19,18=>20,19=>21,20=>22,21=>23];

		$data = [
			'quizzes' 	=> $quizzes,
			"quizzes_status" => [
				'open' => "Abiertos",
				'completed' => "Completados"					
			],
			'sex' 		=> $sexs,
			'age' 		=> $ages,
			'geo' 		=> $geo,
			'shop'		=> $shop,
			'hour' 		=> $hour,
			'sondeo' 	=> $sondeos,
		];



		$filter_cuestionario = $this->getCuestionario();
		$filters = $this->getFilters();
		$actual_link = "//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		$user = BackendAuth::getUser();

			$segmentaciones = \Tresfera\Taketsystem\Models\Segmentacion::with("values")->where("is_filter",1)->get();
			if(count($segmentaciones)) {
				foreach($segmentaciones as $segmentacion) {
					$slug = str_slug($segmentacion->name);
					$data[$slug] = [];
					
					foreach($segmentacion->values as $value) {
						$data[$slug][str_replace("'","\'",$value->value)] = $value->value;
					}
				}
			}
		return $data;
	}

	public function onFilterGetOptions() {
		$numSession = "Taket.statistics.filters";
		$session = Session::get($numSession);
		if(post("search")) {
			$data = $this->getFiltersData();
			if(isset($data[post("scopeName")])) {
				//$data_search = array_search(post("search"),$data[post("scopeName")]);
				$input = preg_quote(post("search"), '~'); // don't forget to quote input string!
				$data_search = preg_filter('~' . $input . '~i', null, $data[post("scopeName")]);

				//$data_search = preg_grep('/^'.post("search").'\s.*/',$data[post("scopeName")]);
				$data_s = array();
				foreach($data_search as $key=>$value) {
					$data_s[] = [
						"id" => $key,
						"name" => $data[post("scopeName")][$key]
					];
				}
				return ["scopeName"=>post("scopeName"), "options"=>
										[
											"available"=>$data_s,
											//"active"=>$session[post("scopeName")]
										]
						];
			}
		}
		
		return Session::get($numSession);
	}
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
		return Redirect::to("https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
	}

	public function getGroupBy() {
		// manipule session
		$numSession = "Taket.stats";

		if(get('group_by')) {
		     Session::put($numSession, get('group_by'));
	    }
	    if(post('group_by')) {
		     Session::put($numSession, post('group_by'));
	    }

	    $groupBy = Session::get($numSession);
	    if($groupBy == null)
	    	$groupBy = 'device_id';

	    return $groupBy;
	}

	public function getFilter() {
		// manipule session
		$numSession = "Taket.filter";

		if(get('filter')) {
			 if(get('multipleFilter')) {
				 if(is_array(Session::get($numSession))) {
					 return Session::get($numSession);
				 }
				 $filters[] = Session::get($numSession);
				 $filters[] = get('filter');
				 Session::put($numSession, $filters);
			 }
			 else
				Session::put($numSession, get('filter'));
		}
		if(get('detalles'))
	    return Session::get($numSession);
	}
	public function _cleanFilters()
	{
	    //
	    // Do any custom code here
		//
		$numSession = "Taket.statistics.filters";
		
			$test = Session::get($numSession);
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
			$session = Session::get($numSession);
			//echo "<pre>";print_r($session);echo "</pre>";
			$filters = $test;
			foreach($filters as $key => $filter) {
				$session[$key] = array();
			}

			Session::put($numSession, $session);
	    // Call the ListController behavior index() method
	}
	public function getFilterId() {
		// manipule session
		$numSession = "Taket.filterId";

	    if(get('filterId')) {
		     if(get('multipleFilter')) {
			     $f = $this->getFilter();

			     if(is_array(Session::get($numSession))) {
				    $filters = Session::get($numSession);
				    $filters[get('filter')] = get('filterId');
						Session::put($numSession, $filters);

				    return Session::get($numSession);
				 }

			     $filters[$f[0]] = Session::get($numSession);
			     $filters[get('filter')] = get('filterId');
			     Session::put($numSession, $filters);
		     }
		     else
		     	Session::put($numSession, get('filterId'));
	    }
		if(get('detalles'))
	    	return Session::get($numSession);
	}

}
