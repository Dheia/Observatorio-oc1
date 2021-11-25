<?php

namespace Tresfera\Statistics\Models;

use Model;
use DB;
use BackendAuth;
use Tresfera\Devices\Models\Shop;
use Session;
/**
 * Result Model.
 */
class Result extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_results';

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * Has Many relations.
     *
     * @var array
     */
    public $hasMany = [
        'answers'  => ['Tresfera\Taketsystem\Models\Answer'],
    ];

    /**
     * Belongs To relations.
     *
     * @var array
     */
    public $belongsTo = [
        'device' 		=> ['Tresfera\Devices\Models\Device'],
        'quiz'   		=> ['Tresfera\Taketsystem\Models\Quiz'],
        'city'   		=> ['Tresfera\Devices\Models\City'],
        'region' 		=> ['Tresfera\Devices\Models\Region'],
        'shop'   		=> ['Tresfera\Devices\Models\Shop'],
        'citycp'   		=> ['Tresfera\Devices\Models\Citycp'],
        'regioncp'   	=> ['Tresfera\Devices\Models\Regioncp'],
    ];

    protected $is_scoped = false;

	/**
     * Before save event.
     */
    public function beforeSave()
    {

        if (isset($this->device->shop->id)) {
          $shop = $this->device->shop()->with('city')->first();

          $this->shop_id = $shop->id;
          $this->city_id = $shop->city_id;
          if(isset($shop->city))
            $this->region_id = $shop->city->region_id;
        } else {
	        if(isset($this->quiz->shop_id)) {
		        $shop = Shop::find($this->quiz->shop_id);
            $this->shop_id = $shop->id;
            $this->city_id = $shop->city_id;
            if(isset($shop->city))
              $this->region_id = $shop->city->region_id;
          }
        }
	}
	public function getFreeFields() {
		$query = $this->query();
  
	  /* if(is_array($dateRange)) {
		 $query->whereRaw("DATE(tresfera_taketsystem_results.created_at) >= DATE('".$dateRange['start']."') AND DATE(tresfera_taketsystem_results.created_at) <= DATE('".$dateRange['end']."')");
	   }*/
  
	  // $query = $this->setFilters($query, $dateRange);
	   $query = $this->setFilters($query);

	   $query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');
	   $query->where("type", '=', "textarea");
	   $query->limit(200);
	   
	   $data = $query->get(); 
	  
	   $csv = [];
	   foreach($data as $row) {
			if(!isset($csv[$row->question_title]) && $row->value) 
				$csv[$row->question_title] = [];
		    $palabras = explode(" ",str_replace(".","",str_replace(",","",$this->clean($row->value))));
		    foreach($palabras as $palabra) {
			    if(strlen($palabra)>3) {
				   	if(!isset($csv[$row->question_title][$palabra]))
				   		$csv[$row->question_title][$palabra] = ["text"=>"","weight"=>0];
					$csv[$row->question_title][$palabra]['text'] = $palabra;
					$csv[$row->question_title][$palabra]['weight']++;
				}
		    }
			/*if(!isset($csv[$row->question_title]) && $row->value) 
					$csv[$row->question_title] = "";
			$csv[$row->question_title] .= " ".$row->value;*/
	   }
	   
	   return $csv;
  
	}
  public function getDataCSV($dateRange=null) {
	$query = $this->query();

	if(is_array($dateRange)) {
	  $query->whereRaw("DATE(tresfera_taketsystem_results.created_at) >= DATE('".$dateRange['start']."') AND DATE(tresfera_taketsystem_results.created_at) <= DATE('".$dateRange['end']."')");
	}
	$query->select(\DB::raw("*"));
	$query->addSelect(\DB::raw("tresfera_taketsystem_results.created_at as fecha"));

	// $query = $this->setFilters($query, $dateRange);
	$query = $this->setFilters($query);
	$query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

	$data = $query->get();
	$csv = [];
	$questions = [];
	foreach($data as $d) {
	   if(!in_array($d->question_id,array_keys($questions))) {
		   $question = \Taket\Structure\Models\Question::find($d->question_id);
		   if(isset($question->id)) {
			   $questions[$d->question_id] = $question->title?$question->title:$question->name;
		   }
	   }
	   $csv[$d->result_id]["result"][0] = $d->result_id;
	   $csv[$d->result_id]["fecha"][1] = $d->fecha;
	   if(isset($questions[$d->question_id])) {
		   $content = $d->value_string?$d->value_string:$d->value;
		   $content = preg_replace("/<img[^>]+\>/i", "", $content); 
		   $csv[$d->result_id][$questions[$d->question_id]][$d->id] = $content;

	   }
				   
	}

	return $csv;
     $query = $this->query();

     if(is_array($dateRange)) {
       $query->whereRaw("DATE(tresfera_taketsystem_results.created_at) >= DATE('".$dateRange['start']."') AND DATE(tresfera_taketsystem_results.created_at) <= DATE('".$dateRange['end']."')");
     }

     // $query = $this->setFilters($query, $dateRange);
     $query = $this->setFilters($query);
     $query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');
     $query->limit(10000);

     $data = $query->get();
     $csv = [];

     foreach($data as $d) {
       
          $csv[$d->result_id]["result"][0] = $d->result_id;
          $csv[$d->result_id]["fecha"][1] = $d->created_at;

        if($d->question_type == "general") {
          $csv[$d->result_id][$d->question_title?$d->question_title:$d->question_type][$d->id] = $d->value_type;
        } elseif($d->question_type == "sondeo") {
          $respuesta = \Tresfera\Taketsystem\Models\QuizMulti::find($d->value);
          if(isset($respuesta->id)) {
            if(isset($respuesta->icon->id))
                $image_url = $respuesta->icon->getPath();

            $title = $respuesta->title;
          } else {
            $title = $d->value;
          }
          $csv[$d->result_id][$d->question_title?$d->question_title:$d->question_type][$d->id] = $title;
        } else {
						$csv[$d->result_id][$d->question_title?$d->question_title:$d->question_type][$d->id] = $d->value;
						
						if( !in_array( $d->question, ["sementacion","fecha","result","sondeo"] ) && $d->question) {
							$csv[$d->result_id][$d->question_title?$d->question_title:$d->question_type][$d->id] .= "::".$d->question;
						}
        }
          
     }
     return $csv;

  }
  public function getDataFields() {
	$query = $this->query();


	$query = $this->setFilters($query);
	$query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');
	
	$data = $query->get();
	$fileds = [];

	$questions = [];
	foreach($data as $d) {
	   if(!in_array($d->question_id,array_keys($questions))) {
		   if(!$d->question_id) continue;
		   $question = \Taket\Structure\Models\Question::find($d->question_id);
		   if(isset($question->title))
			   $questions[$d->question_id] = $question->title?$question->title:$question->name;
	   }
	   if(isset($questions[$d->question_id]))
		   $fileds[$questions[$d->question_id]] = $questions[$d->question_id];
				   
	}

   return $fileds;

  }
	public function calcPercent()
    {
        $this->completed = 100;
        if ($this->quiz->slides()->count()) {
            $this->completed = $this->answers()->groupBy('slide_id')->count() * 100 / $this->quiz->slides()->count();
        }

        return $this->save();
    }
    public function getSatisfaccion() {

	    $answerNps = $this->answers()->where('question_type',"=", "nps")->first();
	    if(isset($answerNps))
	    switch($answerNps->value_type) {
		    case '1':
		    	return 'detractores';
		    break;
		    case '2':
		    	return 'pasivos';
		    break;
		    case '3':
		    	return 'promotores';
		    break;
	    }
	    return 0;
    }
    static function getMetricas() {

	    $user = BackendAuth::getUser();
	    $query  = DB::table("tresfera_taketsystem_answers")->where("question_type","=","specific")->groupBy("question_title")->groupBy("question");

	    if ($user->client_id) {
		    $query->where("client_id","=",$user->client_id);
		    $query->join('tresfera_taketsystem_results', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');
			}

	    $query->addSelect(DB::raw("question_title as id"));
	    $query->addSelect(DB::raw("question_title as name"));

	    $generales = $query->get();
	    $data[] = [
		    'id' => 'nps',
		    'name' => 'NPS'
	    ];

	    if(count($generales)) {
		    foreach($generales as $general) {
			   $data[] = [
				    'id' => $general->id,
				    'name' => $general->name
			    ];
		    }
	    }

	    return $data;
    }
    static function getSondeosFilter() {

	    $user = BackendAuth::getUser();
	    $query  = DB::table("tresfera_taketsystem_answers")->where("answer_type","=","sondeo")->groupBy("value")->groupBy("question_title");

	    if ($user->client_id) {
		    $query->where("client_id","=",$user->client_id);
		    $query->join('tresfera_taketsystem_results', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');
		    $userShops = \Tresfera\Taketsystem\Models\UserShop::where("user_id","=",$user->id)->get();
	        if(isset($userShops)) {
		        $query->where(function ($query) use ($userShops) {
					foreach($userShops as $userShop)
						$query->orWhere("tresfera_taketsystem_results.shop_id", '=', $userShop->shop_id);
				});
	        }
		}


	    return $query;
    }
    static function getGeo() {
	    $user = BackendAuth::getUser();
	    if ($user->client_id) {
		    $query = \Tresfera\Statistics\Models\Result::where("client_id","=",$user->client_id)->groupBy('citycp_name');
		    $userShops = \Tresfera\Taketsystem\Models\UserShop::where("user_id","=",$user->id)->get();
	        if(isset($userShops)) {
		        $query->where(function ($query) use ($userShops) {
					foreach($userShops as $userShop)
						$query->orWhere("tresfera_taketsystem_results.shop_id", '=', $userShop->shop_id);
				});
	        }
			return $query->get();
		}
		return [];
    }
    static function getTiendas($cuestionario=null) {
	    $user = BackendAuth::getUser();
	    if ($user->client_id) {
			return \Tresfera\Taketsystem\Models\Shop::where("client_id","=",$user->client_id)->get();
		}
		else
	    	return \Tresfera\Taketsystem\Models\Shop::all();
    }

    static function getCuestionarios() {
	    $user = BackendAuth::getUser();
	    if ($user->client_id) {
		    $query = \Tresfera\Taketsystem\Models\Quiz::where("client_id","=",$user->client_id);
		    //filter by shop user
	        /*$userShops = \Tresfera\Taketsystem\Models\UserShop::where("user_id","=",$user->id)->get();
	        if(isset($userShops)) {
		        $query->where(function ($query) use ($userShops) {
					foreach($userShops as $userShop)
						$query->orWhere("tresfera_taketsystem_results.shop_id", '=', $userShop->shop_id);
				});
	        }*/
        return $query->get();
      }
			else
	    	return \Tresfera\Taketsystem\Models\Quiz::all();
    }
    
    public function getSondeos($filter=null,$filterId=null,$dateRange=null,$cuestionario=null) {
	    $query = $this->query();
	    $query->addSelect(DB::raw('COUNT(*) AS count'))
			    ->addSelect(DB::raw('question_title'))
          ->addSelect(DB::raw('slide_id'))
          ->addSelect(DB::raw('result_id'))
          ->addSelect(DB::raw('question_type'))
			    ->addSelect(DB::raw('value'));


        if($filter!=null) {
	        if(is_array($filter)) {
		        foreach($filter as $f)
		        	$query->where($f, '=', $filterId[$f]);
          } else {
            $query->where($filter, '=', $filterId);
          }
        }

        /*if($cuestionario!=null)
        	$query->where("quiz_id", '=', $cuestionario);*/

       	$query->where("answer_type", '=', "sondeo");

        $query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

        $query->groupBy("value");
        $query->orderBy("quiz_id","ASC");
        $query->orderBy("question_title","ASC");
        $query = $this->setFilters($query, $dateRange);

        $result = $query->get();
        return $result;
		}
		public function getSondeosSpecific($filter=null,$filterId=null,$dateRange=null,$cuestionario=null) {
	    $query = $this->query();
	    $query->addSelect(DB::raw('COUNT(*) AS count'))
			    ->addSelect(DB::raw('question_title'))
          ->addSelect(DB::raw('slide_id'))
          ->addSelect(DB::raw('result_id'))
          ->addSelect(DB::raw('question_type'))
			    ->addSelect(DB::raw('value'));


        if($filter!=null) {
	        if(is_array($filter)) {
		        foreach($filter as $f)
		        	$query->where($f, '=', $filterId[$f]);
          } else {
            $query->where($filter, '=', $filterId);
          }
        }

        /*if($cuestionario!=null)
        	$query->where("quiz_id", '=', $cuestionario);*/

       	$query->where("question_type", '=', "sondeo");

        $query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

        $query->groupBy("value");
        $query->orderBy("quiz_id","ASC");
        $query->orderBy("question_title","ASC");
        $query = $this->setFilters($query, $dateRange);

        $result = $query->get();
        return $result;
    }
    public function getTotalsSegmentacion($type=1,$filter=null,$filterId=null,$dateRange=null,$cuestionario=null) {
        $query = $this->query();
        $query->addSelect(DB::raw('COUNT(*) AS count'))
            	->addSelect(DB::raw('question_id'))
            	->addSelect(DB::raw('slide_id'))
            	->addSelect(DB::raw('result_id'))
            	->addSelect(DB::raw('question_type'))
            	->addSelect(DB::raw('value'));

        if($filter!=null) {
          if(is_array($filter)) {
            foreach($filter as $f)
              $query->where($f, '=', $filterId[$f]);
          } else {
            $query->where($filter, '=', $filterId);
          }
        }

        /*if($cuestionario!=null)
        	$query->where("quiz_id", '=', $cuestionario);*/

       	$query->where("question_id", '=', $type);

        $query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

        $query->groupBy("value");
        $query->orderBy("count","DESC");
		$query = $this->setFilters($query, $dateRange);
		
        $result = $query->get();
        return $result;
    }
  	public function getSpecificsLogico($type=1,$filter=null,$filterId=null,$dateRange=null,$cuestionario=null) {
	     $query = $this->query();
        $query->addSelect(DB::raw('COUNT(*) AS count'))
            ->addSelect(DB::raw('question_title'))
            ->addSelect(DB::raw('slide_id'))
            ->addSelect(DB::raw('result_id'))
            ->addSelect(DB::raw('question_type'))
            ->addSelect(DB::raw('value'));


        if($filter!=null) {
          if(is_array($filter)) {
            foreach($filter as $f)
              $query->where($f, '=', $filterId[$f]);
          } else {
            $query->where($filter, '=', $filterId);
          }
        }

        /*if($cuestionario!=null)
        	$query->where("quiz_id", '=', $cuestionario);*/

       	$query->where("answer_type", '=', "specific_answer_".$type);

        $query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

        $query->groupBy("value");
        $query->orderBy("count","DESC");
        $query->orderBy("question_title","ASC");
        $query = $this->setFilters($query, $dateRange);

        $result = $query->get();
        return $result;
    }
    public function getTotalsNPSLogico($type=1,$filter=null,$filterId=null,$dateRange=null,$cuestionario=null) {
        $query = $this->query();
        $query->addSelect(DB::raw('COUNT(*) AS count'))
            ->addSelect(DB::raw('question_title'))
            ->addSelect(DB::raw('slide_id'))
            ->addSelect(DB::raw('result_id'))
            ->addSelect(DB::raw('question_type'))
            ->addSelect(DB::raw('value'));


        if($filter!=null) {
          if(is_array($filter)) {
            foreach($filter as $f)
              $query->where($f, '=', $filterId[$f]);
          } else {
            $query->where($filter, '=', $filterId);
          }
        }

        /*if($cuestionario!=null)
        	$query->where("quiz_id", '=', $cuestionario);*/

       	$query->where("answer_type", '=', "nps_answer_".$type);

        $query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

        $query->groupBy("value");
        $query->orderBy("count","DESC");
        $query = $this->setFilters($query, $dateRange);
        $result = $query->get();
        return $result;
    }
    public function getTotalsGeneralNumericos($filter=null,$filterId=null,$dateRange=null,$cuestionario=null, $total=null) {
	    $query = $this->query();
	    $query->addSelect(DB::raw('COUNT(*) AS count'))
					->addSelect(DB::raw('question_title'))
					->addSelect("slide_id")
			    ->addSelect(DB::raw('question'))
					->addSelect(DB::raw('value'))  
					->addSelect(DB::raw('count(distinct result_id) as numQuizz'))
          ->addSelect(DB::raw('CONCAT(FORMAT(SUM(value_type)/(COUNT(*)),1)) as media'));

			  

        if($filter!=null) {
	        if(is_array($filter)) {
		        foreach($filter as $f)
		        	$query->whereRaw(DB::raw($f . '=' . "'" . $filterId[$f] . "'"));
          } else {
            $query->where(DB::raw($f . '=' . "'" . $filterId . "'"));
          }
        }

        /*if($cuestionario!=null)
        	$query->where("quiz_id", '=', $cuestionario);*/

       	$query->whereRaw(DB::raw("answer_type" . '=' . "'numericas'"));


        $query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

				if($total) {
					$query->groupBy("question");
					$query->orderBy( "question_title");
				} else {
					$query->groupBy("slide_id","question");
					$query->orderBy( "slide_id");
				}
        
        $query = $this->setFilters($query, $dateRange);

        $result = $query->get();

    //  dd($query->toSql());

        if($result->count() == 0) {
          return $this->getTotalsGeneralLineal($filter,$filterId,$dateRange,$cuestionario);
        }

        return $result;
		}
		function clean($string) {
			$string = str_replace(' ', ' ', $string); // Replaces all spaces with hyphens.
		
			return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
		}
    public function getTotalsGeneral($filter=null,$filterId=null,$dateRange=null,$cuestionario=null) {
		$query = $this->query();
		$query->addSelect(DB::raw('COUNT(*) AS count'))
					->addSelect(DB::raw('COUNT(*)/count(distinct result_id) as percent'))
					->addSelect(DB::raw('value as question_title'))
					->addSelect(DB::raw('slide_id'))
					->addSelect(DB::raw('question'))
					->addSelect(DB::raw('question_id'))
					->addSelect(DB::raw('question_title as title'))
					->addSelect(DB::raw('value'))
					->addSelect(DB::raw('count(distinct result_id) as numQuizz'));


        if($filter!=null) {
	        if(is_array($filter)) {
		        foreach($filter as $f)
		        	$query->whereRaw(DB::raw($f . '=' . "'" . $filterId[$f] . "'"));
			} else {
				$query->whereRaw(DB::raw($filter . '=' . "'" . $filterId . "'"));
			}
		}

        /*if($cuestionario!=null)
			$query->where("quiz_id", '=', $cuestionario);*/
		if(is_array($filter)) {
		
		} else {
			if($filter == 'requestion_id') {
				$query->whereRaw(DB::raw("type" . '=' . "'specific'"));
	
			} else {
				$query->whereRaw(DB::raw("type" . '=' . "'general'"));
			}
		}
		

        $query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

		$query->groupBy("value");
				
        $query = $this->setFilters($query, $dateRange);
        $query->orderBy("count");
				
		// dd($query->toSql());

        $result = $query->get();

    	//dd($query->toSql());

        if($result->count() == 0) {
          return $this->getTotalsGeneralLineal($filter,$filterId,$dateRange,$cuestionario);
        }

        return $result;
    }
    public function getTotalsGeneralLineal($filter=null,$filterId=null,$dateRange=null,$cuestionario=null) {
	    $query = $this->query();
	    $query->addSelect(DB::raw('COUNT(*) AS count'))
					->addSelect(DB::raw('COUNT(*)/count(distinct result_id) as percent'))
			    ->addSelect(DB::raw('question as question_title'))
			    ->addSelect(DB::raw('question_title as title'))
			    ->addSelect(DB::raw('value'))
			    ->addSelect(DB::raw('value'))
			    ->addSelect(DB::raw('count(distinct result_id) as numQuizz'));


        if($filter!=null) {
	        if(is_array($filter)) {
		        foreach($filter as $f)
		        	$query->where($f, '=', $filterId[$f]);
					} else {
						$query->where($filter, '=', $filterId);
					}
        }

        /*if($cuestionario!=null)
        	$query->where("quiz_id", '=', $cuestionario);*/

       	$query->where("question_type", '=', "specific");


        $query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

        $query->groupBy("value");
         $query = $this->setFilters($query, $dateRange);

        $result = $query->get();


        return $result;
    }
    public function getTotalsNPS2($filter=null,$filterId=null,$dateRange=null,$cuestionario=null) {
	    $query = $this->query();
	    $query->addSelect(DB::raw('COUNT(*) AS count'))
			    ->addSelect(DB::raw('question_title'))
			    ->addSelect(DB::raw('value'))
			    ->addSelect(DB::raw('value'))
			    ->addSelect(DB::raw('count(distinct result_id) as numQuizz'))
                ->addSelect(DB::raw('SUM(if(value_type = 3, 1, 0)) as numOk'))
                ->addSelect(DB::raw('SUM(if(value_type = 1, 1, 0)) as numKo'))
                ->addSelect(DB::raw('CONCAT(FORMAT(SUM(if(value_type = 1, 1, 0))/(COUNT(*))*100,1),\'%\') as percentKo'))
                ->addSelect(DB::raw('CONCAT(FORMAT(SUM(if(value_type = 3, 1, 0))/(COUNT(*))*100,1),\'%\') as percentOk'))
                ->addSelect(DB::raw('CONCAT(FORMAT(SUM(if(value_type = 2, 1, 0))/(COUNT(*))*100,1),\'%\') as percentMix'))
                ->addSelect(DB::raw('SUM(if(value_type = 2, 1, 0)) as numMix'));

        $query->addSelect(DB::raw("
			    			FORMAT(
				    				(
					    				SUM(if(value_type = 3, 1, 0))
					    				/
					    				COUNT(*)
				    				)
				    				-
				    				(
					    				SUM(if(value_type = 1, 1, 0))
					    				/
					    				COUNT(*)
				    				)
			    				,2) as global"));
        if($filter!=null) {
	        if(is_array($filter)) {

		        if(in_array("question", $filter)) {
			        $filterId['question_title'] = $filterId['question'];
			        $filter[] = 'question_title';
			        unset($filterId['question']);
		        }

		        foreach($filter as $f) {
			        if(isset($filterId[$f]))
				        $query->where($f, '=', $filterId[$f]);
		        }

			} else {
				$query->where('question_title', '=', $filterId);
			}
        }

		/*if($cuestionario!=null)
        	$query->where("quiz_id", '=', $cuestionario);*/

        $query->where("question_type", '=', "general");

        $query = $this->setFilters($query, $dateRange);
        $query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

        $query->groupBy("question_title");

        //dd($query->toSql());

        $result = $query->get();

        return $result;
		}
		public function getTotalsNPS22($filter=null,$filterId=null,$dateRange=null,$cuestionario=null) {
	    $query = $this->query();
	    $query->addSelect(DB::raw('COUNT(*) AS count'))
			    ->addSelect(DB::raw('question_title'))
			    ->addSelect(DB::raw('value'))
			    ->addSelect(DB::raw('value'))
			    ->addSelect(DB::raw('count(distinct result_id) as numQuizz'))
                ->addSelect(DB::raw('SUM(if(value_type = 3, 1, 0)) as numOk'))
                ->addSelect(DB::raw('SUM(if(value_type = 1, 1, 0)) as numKo'))
                ->addSelect(DB::raw('CONCAT(FORMAT(SUM(if(value_type = 1, 1, 0))/(COUNT(*))*100,1),\'%\') as percentKo'))
                ->addSelect(DB::raw('CONCAT(FORMAT(SUM(if(value_type = 3, 1, 0))/(COUNT(*))*100,1),\'%\') as percentOk'))
                ->addSelect(DB::raw('CONCAT(FORMAT(SUM(if(value_type = 2, 1, 0))/(COUNT(*))*100,1),\'%\') as percentMix'))
                ->addSelect(DB::raw('SUM(if(value_type = 2, 1, 0)) as numMix'));

        $query->addSelect(DB::raw("
			    			FORMAT(
				    				(
					    				SUM(if(value_type = 3, 1, 0))
					    				/
					    				COUNT(*)
				    				)
				    				-
				    				(
					    				SUM(if(value_type = 1, 1, 0))
					    				/
					    				COUNT(*)
				    				)
			    				,2) as global"));
        if($filter!=null) {
	        if(is_array($filter)) {

		        if(in_array("question", $filter)) {
			        $filterId['question'] = $filterId['question'];
			        $filter[] = 'question_title';
			        unset($filterId['question']);
		        }

		        foreach($filter as $f) {
			        if(isset($filterId[$f]))
				        $query->where($f, '=', $filterId[$f]);
		        }

					} else {
						$query->where('question', '=', $filterId);
					}
				}

		/*if($cuestionario!=null)
        	$query->where("quiz_id", '=', $cuestionario);*/

        $query->where("question_type", '=', "general2");

        $query = $this->setFilters($query, $dateRange);
        $query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

        $query->groupBy("question_title");

        //dd($query->toSql());

        $result = $query->get();

        return $result;
    }
    public function getTotalsNPS($filter=null,$filterId=null,$dateRange=null,$cuestionario=null) {
	    $query = $this->query();
	    $query->addSelect(DB::raw('COUNT(*) AS count'))
			    ->addSelect(DB::raw('question_title'))
			    ->addSelect(DB::raw('value'))
			    ->addSelect(DB::raw('value'))
			    ->addSelect(DB::raw('count(distinct result_id) as numQuizz'))
                ->addSelect(DB::raw('SUM(if(value_type = 3, 1, 0)) as numOk'))
                ->addSelect(DB::raw('SUM(if(value_type = 1, 1, 0)) as numKo'))
                ->addSelect(DB::raw('CONCAT(FORMAT(SUM(if(value_type = 1, 1, 0))/(COUNT(*))*100,1),\'%\') as percentKo'))
                ->addSelect(DB::raw('CONCAT(FORMAT(SUM(if(value_type = 3, 1, 0))/(COUNT(*))*100,1),\'%\') as percentOk'))
                ->addSelect(DB::raw('CONCAT(FORMAT(SUM(if(value_type = 2, 1, 0))/(COUNT(*))*100,1),\'%\') as percentMix'))
                ->addSelect(DB::raw('SUM(if(value_type = 2, 1, 0)) as numMix'));

        $query->addSelect(DB::raw("
			    			FORMAT(
				    				(
					    				SUM(if(value_type = 3, 1, 0))
					    				/
					    				COUNT(*)
				    				)
				    				-
				    				(
					    				SUM(if(value_type = 1, 1, 0))
					    				/
					    				COUNT(*)
				    				)
			    				,2) as global"));

        if($filter!=null) {
	        if(is_array($filter)) {
		        foreach($filter as $f) {
			        $query->where($f, '=', $filterId[$f]);
		        }

			} else {
				$query->where($filter, '=', $filterId);
			}
        }

		/*if($cuestionario!=null)
        	$query->where("quiz_id", '=', $cuestionario);*/

        $query->where("question_type", '=', "nps");

        $query = $this->setFilters($query, $dateRange);
        $query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

        $query->groupBy("question_type");

        $result = $query->get();

        return $result;
    }
	public function getRankingData($tiendas=null,$metrica=null,$dateRange=null,$cuestionario=null) {
	    $query = $this->query();


        $query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

		$query->addSelect(DB::raw("CAST(( ( Sum(IF(value_type = 3, 1, 0)) / Count(*) ) - ( Sum(IF(value_type = 1, 1, 0)) / Count(*) ) ) AS DECIMAL(10,2)) as shop"));

	    $query->addSelect("shop_id");

        $orderLimit = explode("|", $tiendas);


        if($metrica == 'nps')
	        $query->where("question_type", "=", "nps");
        else
        	$query->where("question_title", "=", $metrica);

        /*if($cuestionario!=null)
        	$query->where("quiz_id", '=', $cuestionario);*/

        $query = $this->setFilters($query, $dateRange);

		$query->take($orderLimit[0]);
		$query->orderBy(DB::RAW("shop"), $orderLimit[1]);

        $query->groupBy("shop_id");

        $result = $query->get();



        return $result;

    }

    public function getComparativaData($tiendas=null,$metrica=null,$dateRange=null,$cuestionario=null) {
	    $query = $this->query();

        $query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

	    if(is_array($tiendas)) {
		    foreach($tiendas as $tienda) {
			    $query->addSelect(DB::raw("
			    			FORMAT(
				    				(
					    				SUM(if(shop_id = ".$tienda." AND value_type = 3, 1, 0))
					    				/
					    				SUM(if(shop_id = ".$tienda.", 1, 0))
				    				)
				    				-
				    				(
					    				SUM(if(shop_id = ".$tienda." AND value_type = 1, 1, 0))
					    				/
					    				SUM(if(shop_id = ".$tienda.", 1, 0))
				    				)
			    				,2) as shop_".$tienda));
			    $query->addSelect(DB::raw("
			    			FORMAT(
				    				(
					    				SUM(if(value_type = 3, 1, 0))
					    				/
					    				COUNT(*)
				    				)
				    				-
				    				(
					    				SUM(if(value_type = 1, 1, 0))
					    				/
					    				COUNT(*)
				    				)
			    				,2) as global"));
		    }
	    }

        $query->addSelect(DB::raw("DATE(tresfera_taketsystem_answers.created_at) as date"));

        if($metrica == 'nps')
	        $query->where("question_type", "=", "nps");
        else
        	$query->where("question_title", "=", $metrica);

        /*if($cuestionario!=null)
        	$query->where("quiz_id", '=', $cuestionario);*/

        $query = $this->setFilters($query, $dateRange);

		//dias transcurridos en el rango
		$start = strtotime($dateRange['start']);
		$end = strtotime($dateRange['end']);

		$days_between = ceil(abs($end - $start) / 86400);

        $groupTime = "DATE";
        if($days_between > 60) {
	        $groupTime = "WEEK";
        }
        if($days_between > 300) {
	        $groupTime = "MONTH";
        }

        $query->groupBy(DB::raw($groupTime."(tresfera_taketsystem_answers.created_at)"));
        $query->orderBy("date");
        $result = $query->get();

        return $result;
    }
    public function getDataStats($filter=null,$filterId=null,$dateRange=null,$cuestionario=null)
    {
	    $query = $this->getQueryTotals($filter,$filterId,$dateRange,$cuestionario);
        $query->addSelect(DB::raw("DATE(tresfera_taketsystem_answers.created_at) as date"));



        $query->groupBy(DB::raw("DATE(tresfera_taketsystem_answers.created_at)"));
        $result = $query->get();
        //dd($result);

        return $result;
    }
    public function getSpecifics($filter=null,$filterId=null,$dateRange=null,$cuestionario=null)
    {
	    
						
		$query = $this->getQueryTotals($filter,$filterId,$dateRange,$cuestionario);
	    $query->addSelect(DB::raw('value_type'));
	    $query->addSelect(DB::raw('value as question_value'));
	    $query->addSelect(DB::raw('question_id'));
	    $query->addSelect(DB::raw('question_title'));

	    $query->where("question_type", '=', "specific");
	    $query->orderBy("value_type", 'desc');
			
			
			
      if($filter!=null) {
	        if(is_array($filter)) {
		        foreach($filter as $f)
		        	$query->where($f, '=', $filterId[$f]);
			} else {
				$query->where($filter, '=', $filterId);
			}
        }

        $query->groupBy(DB::raw("value"));
	
		/*if($cuestionario!=null)
        	$query->where("quiz_id", '=', $cuestionario);*/
		//dd($query->toSql());
        $result = $query->get();
        //
			
        return $result;
    }
    public function getComments($filter=null,$filterId=null,$dateRange=null,$cuestionario=null) {
	    $query = $this->query();
	    $selectTotalA = null;
	    $selectTotal = "1=1";
	    if($filter!=null) {
	        if(is_array($filter)) {
		        foreach($filter as $f)
		        	$query->where($f, '=', $filterId[$f]);
		        	//$selectTotalA[] = $f. '='.$filterId[$f];

			} else {
				$query->where($filter, '=', $filterId);
				//$selectTotal = $filter . '=' . $filterId;
			}
        }
       /* if(is_array($selectTotalA)) {
	        $selectTotal = implode(" AND ", $selectTotal);
	    }*/
	    /*$query->addSelect(DB::raw("CASE
							        WHEN age BETWEEN 1 and 19 THEN 'Menos de 20'
							        WHEN age BETWEEN 20 and 29 THEN '20 - 29'
							        WHEN age BETWEEN 30 and 39 THEN '30 - 39'
							        WHEN age BETWEEN 40 and 49 THEN '40 - 49'
							        WHEN age BETWEEN 50 and 59 THEN '50 - 59'
							        WHEN age BETWEEN 60 and 69 THEN '60 - 69'
							        WHEN age BETWEEN 70 and 79 THEN '70 - 79'
							        WHEN age >= 80 THEN 'Más de 80'
							        WHEN age IS NULL OR age <= 0 THEN 'No especificado'
							    END as age_range"))
                ->addSelect(DB::raw('COUNT(distinct result_id) AS count'));
                //->addSelect(DB::raw("COUNT(distinct result_id)/(select count(*) from `tresfera_taketsystem_results` where ".$selectTotal." and DATE(tresfera_taketsystem_answers.created_at) >= DATE('".$dateRange['start']."') AND DATE(tresfera_taketsystem_answers.created_at) <= DATE('".$dateRange['end']."'))*100 as percent"));
        */


       	//$query->where("question_type", '=', "age");

	   /*	if($cuestionario!=null)
        	$query->where("quiz_id", '=', $cuestionario);*/

        $query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');
        $query = $this->setFilters($query, $dateRange);
        $query->where("answer_type", '=', "free");
        $query->orderBy("tresfera_taketsystem_results.created_at", 'DESC');
        $query->groupBy("value");

		$results = $query->get();
        //dd($query->toSql());
        $data = [];
        foreach($results as $result) {
	       /* $shop = \Tresfera\Devices\Models\Shop::find($result->shop_id);
					if(isset($shop->name))
	        	$data[$result->id]['shop'] 		= $shop->name;
					else
						$data[$result->id]['shop'] 		= "";*/
	        $data[$result->id]['comment'] 	= $result->value;
	        $data[$result->id]['room'] 		= $result->room;
	        $data[$result->id]['email'] 	= $result->email;
	        $data[$result->id]['fecha'] 	= $result->created_at;

        }
        return $data;
    }
    public function getTotalsAge($filter=null,$filterId=null,$dateRange=null,$cuestionario=null) {
	    $query = $this->query();
	    $selectTotalA = null;
	    $selectTotal = "1=1";
	    if($filter!=null) {
	        if(is_array($filter)) {
		        foreach($filter as $f)
		        	$query->where($f, '=', $filterId[$f]);
		        	//$selectTotalA[] = $f. '='.$filterId[$f];

			} else {
				$query->where($filter, '=', $filterId);
				//$selectTotal = $filter . '=' . $filterId;
			}
        }
       /* if(is_array($selectTotalA)) {
	        $selectTotal = implode(" AND ", $selectTotal);
	    }*/
	    $query->addSelect(DB::raw("CASE
							        WHEN age BETWEEN 1 and 19 THEN 'Menos de 20'
							        WHEN age BETWEEN 20 and 29 THEN '20 - 29'
							        WHEN age BETWEEN 30 and 39 THEN '30 - 39'
							        WHEN age BETWEEN 40 and 49 THEN '40 - 49'
							        WHEN age BETWEEN 50 and 59 THEN '50 - 59'
							        WHEN age BETWEEN 60 and 69 THEN '60 - 69'
							        WHEN age BETWEEN 70 and 79 THEN '70 - 79'
							        WHEN age >= 80 THEN 'Más de 80'
							        WHEN age IS NULL OR age <= 0 THEN 'No especificado'
							    END as age_range"))
                ->addSelect(DB::raw('COUNT(distinct result_id) AS count'));
                //->addSelect(DB::raw("COUNT(distinct result_id)/(select count(*) from `tresfera_taketsystem_results` where ".$selectTotal." and DATE(tresfera_taketsystem_answers.created_at) >= DATE('".$dateRange['start']."') AND DATE(tresfera_taketsystem_answers.created_at) <= DATE('".$dateRange['end']."'))*100 as percent"));



       	//$query->where("question_type", '=', "age");

	   /*	if($cuestionario!=null)
        	$query->where("quiz_id", '=', $cuestionario);*/

        $query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');
        $query = $this->setFilters($query, $dateRange);
        $query->groupBy("age_range");

        $result = $query->get();
        //dd($query->toSql());
        return $result;
    }

    public function getTotalsCities($filter=null,$filterId=null,$dateRange=null,$cuestionario=null) {
	    $query = $this->query();
	    $query->addSelect(DB::raw('COUNT(distinct result_id) AS count'))
	    		->addSelect(DB::raw('(SELECT name FROM tresfera_taketsystem_cities_cp as c WHERE c.id = citycp_id) as city'))
	    		->addSelect("citycp_id")
	    		->addSelect(DB::raw('COUNT(*) AS total'));

        if($filter!=null) {
	        if(is_array($filter)) {
		        foreach($filter as $f)
		        	$query->where($f, '=', $filterId[$f]);
			} else {
				$query->where($filter, '=', $filterId);
			}
        }


       	//$query->where("question_type", '=', "age");

       	$query = $this->setFilters($query, $dateRange);

        $query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

        $query->groupBy("citycp_name");

        /*if($cuestionario!=null)
        	$query->where("quiz_id", '=', $cuestionario);*/


        $query->orderBy("count", "DESC");

        //$query->take(10);

        $result = $query->get();

        return $result;

    }
  
   public function getTotalsRegion($filter=null,$filterId=null,$dateRange=null,$cuestionario=null) {
	    $query = $this->query();
	    $query->addSelect(DB::raw('COUNT(distinct result_id) AS count'))
	    		->addSelect(DB::raw('(SELECT name FROM tresfera_taketsystem_regions_cp as c WHERE c.id = regioncp_id) as city'))
	    		->addSelect("regioncp_id")
	    		->addSelect(DB::raw('COUNT(*) AS total'));

        if($filter!=null) {
	        if(is_array($filter)) {
		        foreach($filter as $f)
		        	$query->where($f, '=', $filterId[$f]);
			} else {
				$query->where($filter, '=', $filterId);
			}
        }


       	//$query->where("question_type", '=', "age");

       	$query = $this->setFilters($query, $dateRange);

        $query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

        $query->groupBy("regioncp_id");

        /*if($cuestionario!=null)
        	$query->where("quiz_id", '=', $cuestionario);*/


        $query->orderBy("count", "DESC");

        //$query->take(10);

        $result = $query->get();

        return $result;

    }

    public function getTotalsSex($filter=null,$filterId=null,$dateRange=null,$cuestionario=null) {
	    $query = $this->query();
	    //$query  = DB::table("tresfera_taketsystem_results");

	    $query->addSelect(DB::raw('COUNT(distinct tresfera_taketsystem_results.id) AS count'))
	    		->addSelect(DB::raw('SUM(if(tresfera_taketsystem_results.sex = 2, 1, 0)) as numWomen'))
	    		->addSelect(DB::raw('SUM(if(tresfera_taketsystem_results.sex = 1, 1, 0)) as numMen'))
	    		->addSelect(DB::raw('SUM(if(tresfera_taketsystem_results.sex = 0, 1, 0)) as No'))
				->addSelect(DB::raw("CONCAT(FORMAT(SUM(if(tresfera_taketsystem_results.sex = 2, 1, 0))/(COUNT( tresfera_taketsystem_results.id))*100,1),'%') as percentWomen"))
	    		->addSelect(DB::raw("CONCAT(FORMAT(SUM(if(tresfera_taketsystem_results.sex = 1, 1, 0))/(COUNT( tresfera_taketsystem_results.id))*100,1),'%') as percentMen"))
	    		->addSelect(DB::raw("CONCAT(FORMAT(SUM(if(tresfera_taketsystem_results.sex = 0, 1, 0))/(COUNT( tresfera_taketsystem_results.id))*100,1),'%') as percentNo"));

        if($filter!=null) {
	        if(is_array($filter)) {
		        foreach($filter as $f)
		        	$query->where($f, '=', $filterId[$f]);
			} else {
				$query->where($filter, '=', $filterId);
			}
        }else {
	        $query->where("question_type", '=', "sex");
        }



       	//$query->where("question_type", '=', "age");
 		$query = $this->setFilters($query, $dateRange);

        $query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

        /*if($cuestionario!=null)
        	$query->where("quiz_id", '=', $cuestionario);*/

        //$query->groupBy("tresfera_taketsystem_results.id");
		//dd($query->toSql());
        $result = $query->get();
        return $result;

    }

    public function getTotalsAnswers($filter=null,$filterId=null,$dateRange=null,$cuestionario=null) {
	    $query = $this->query();
	    $query->addSelect(DB::raw('COUNT(*) AS count'))
			    ->addSelect(DB::raw('question_title'))
			    ->addSelect(DB::raw('value'))
			    ->addSelect(DB::raw('count(distinct result_id) as numQuizz'))
                ->addSelect(DB::raw('SUM(if(value_type = 3, 1, 0)) as numOk'))
                ->addSelect(DB::raw('SUM(if(value_type = 1, 1, 0)) as numKo'))
                ->addSelect(DB::raw('CONCAT(FORMAT(SUM(if(value_type = 1, 1, 0))/(COUNT(*))*100,1),\'%\') as percentKo'))
                ->addSelect(DB::raw('CONCAT(FORMAT(SUM(if(value_type = 3, 1, 0))/(COUNT(*))*100,1),\'%\') as percentOk'))
                ->addSelect(DB::raw('CONCAT(FORMAT(SUM(if(value_type = 2, 1, 0))/(COUNT(*))*100,1),\'%\') as percentMix'))
                ->addSelect(DB::raw('SUM(if(value_type = 2, 1 AND question_type = \'smiles\', 0)) as numMix'));


        if($filter!=null) {
	        if(is_array($filter)) {
		        foreach($filter as $f)
		        	$query->where($f, '=', $filterId[$f]);
					} else {
						$query->where($filter, '=', $filterId);
					}
        }

       	$query->where("question_type", '=', "smile");

	   	/*if($cuestionario!=null)
        	$query->where("quiz_id", '=', $cuestionario);*/

        $query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

        $query = $this->setFilters($query, $dateRange);

        $query->groupBy("question_title");

        $result = $query->get();

        return $result;

	}
		
    public function setFiltersOut($filters) {
			$this->filters = $filters;

	}
	private function getFilters() {
		if(isset($this->filters)) {
			return $this->filters;
		}
		$numSession = "Taket.statistics.filters";
		return Session::get($numSession);
	}
    private function setFilters($query, $dateRange=null, $session=null) {
	    // Permisions
	    $user = BackendAuth::getUser();
			$numSession = "Taket.statistics.filters";
			if(!$session)
				$session = $this->getFilters();
	    /*if(isset($user->id)) {
			if ($user->client_id) {
				$query->whereRaw(DB::raw('tresfera_taketsystem_results.client_id' . '=' .  $user->client_id));
			}
			//filter by shop user
			$userShops = \Tresfera\Taketsystem\Models\UserShop::whereRaw(DB::raw("user_id" . '=' . $user->id))->get();
			if(isset($userShops)) {
				$query->where(function ($query) use ($userShops) {
						foreach($userShops as $userShop)
							$query->orwhereRaw(DB::raw("tresfera_taketsystem_results.shop_id" . '=' . $userShop->shop_id));
						});
			}
			
			$userQuizs = \Tresfera\Taketsystem\Models\UserQuiz::where("user_id","=",$user->id)->get();
			if(isset($userQuizs)) {
				$query->where(function ($query) use ($userQuizs) {
					foreach($userQuizs as $userQuiz) {
						
						$query->orWhere("tresfera_taketsystem_results.quiz_id", '=', $userQuiz->quiz_id);
					}
				});
			}
		}*/
		if(is_array($dateRange)) {
			$query->whereRaw("DATE(tresfera_taketsystem_answers.created_at) >= DATE('".$dateRange['start']."') AND DATE(tresfera_taketsystem_answers.created_at) <= DATE('".$dateRange['end']."')");
		}

			if(is_array($session))
			foreach($session as $filter => $data) {
				switch($filter) {
					case 'quizzes':
						$query->where(function ($query) use ($data) {
							foreach($data as $quiz)
								$query->orwhereRaw(DB::raw("quiz_id" . '=' . $quiz['id']));
						});
					break;
					case 'quizzes_status':
						$query->join('tresfera_envios_datos', 'tresfera_taketsystem_results.user_id', '=', 'tresfera_envios_datos.id');
						$query->where(function ($query) use ($data) {
							foreach($data as $quiz) {
								if($quiz['id'] == 'open')
									$query->orwhereRaw(\DB::raw("UNIX_TIMESTAMP(apertura_at)"))->whereRaw(\DB::raw("UNIX_TIMESTAMP(completado) = 0"));
								if($quiz['id'] == 'completed')
									$query->orwhereRaw(\DB::raw("UNIX_TIMESTAMP(completado)"));
							}
						});
					break;
					case 'sex':
						$query->where(function ($query) use ($data) {
							foreach($data as $sex)
								$query->orwhereRaw(DB::raw("sex" . '=' . $sex['id']));
						});
					break;
					case 'age':
						$query->where(function ($query) use ($data) {
							foreach($data as $key => $age) {
								$ini = (int)($age['id']/10)*10;
								$fin = $ini+9;

								$query->orWhere(function ($query) use ($ini, $fin) {
										$query->whereRaw(DB::raw("age" . '>=' . $ini))
														->whereRaw(DB::raw("age" . '<=' . $fin));
										});
							}
						});
					break;
					case 'sondeo':
						if(count($data)>0) {
              
              $sondeos = [];
              foreach($data as $value) {
                $explode = explode("::",$value['name']);
                $sondeos[$explode[0]][] = $value['id'];
              }

              foreach($sondeos as $title=>$values) {
								$a = explode(" - ", $title);
								if(count($a)>1) {
									unset($a[0]);
									$title = implode(" - ", $a);
								}
                $subSql = "SELECT a1.result_id FROM tresfera_taketsystem_answers as a1 WHERE a1.question_type = 'sondeo' AND a1.question_title = '".$title."' AND ";
                $i = 0;

                foreach($values as $key => $value) {
                  if($i > 0) $subSql.= ' OR ';
                  $subSql.= " a1.value = '".$value."'";
                  $i++;
                }
                $query->whereRaw("result_id IN (".$subSql.")");
              }
							
			}

					break;
					case 'shop':
						$query->where(function ($query) use ($data) {
							foreach($data as $shop)
								$query->orwhereRaw(DB::raw("shop_id" . '=' . $shop['id']));
						});
					break;
					case 'geo':
						$query->where(function ($query) use ($data) {
							foreach($data as $geo)
								$query->orwhereRaw(DB::raw("citycp_id" . '=' . $geo['id']));
						});
					break;
					case 'hour':
						$query->where(function ($query) use ($data) {
							foreach($data as $hour)
								$query->orWhereRaw(DB::raw("HOUR(tresfera_taketsystem_results.created_at) = ".$hour['id']));
						});
					break;
          case 'date_range':
            
            break;
          //cualquier otro filtro será una segmentacion custom
			default:
				if(count($data)>0) {
					$subSql = "SELECT a1.result_id FROM tresfera_taketsystem_answers as a1 WHERE a1.question_id = '".$filter."'  ";
					foreach($data as $key => $value) {
						if(isset($value['id']))
							if($key == 0)
								$subSql.= " AND a1.answer_id = '".$value['id']."'";
							else
								$subSql.= " OR a1.answer_id = '".$value['id']."'";
						}
					$query->whereRaw("result_id IN (".$subSql.")");
				}

			break;
			}

		}

		return $query;
    }


	public function getTotalsDatos($filter=null,$filterId=null,$dateRange=null,$cuestionario=null)
    {
		$query = $this->query();
				$query->addSelect(DB::raw('count(distinct result_id) as numQuizz'))
							->addSelect(DB::raw('sum(!ISNULL(enviado_at)) as enviados'))
							->addSelect(DB::raw('sum(!ISNULL(apertura_at)) as abiertos'))
							->addSelect(DB::raw('sum(!ISNULL(completado)) as completados'));

        if($filter!=null) {
	        if(is_array($filter)) {
                foreach($filter as $f)
                  $query->where($f, '=', $filterId[$f]);
          } else {
            $query->where($filter, '=', $filterId);
          }
      	}

        if(is_array($dateRange)) {
			$query->whereRaw("DATE(tresfera_taketsystem_answers.created_at) >= DATE('".$dateRange['start']."') AND DATE(tresfera_taketsystem_answers.created_at) <= DATE('".$dateRange['end']."')");
		}

		$query = $this->setFilters($query, $dateRange);

        $query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');
		$query->groupBy("tresfera_envios_datos.id");
		return $query->get();
    }
    public function getTotals($filter=null,$filterId=null,$dateRange=null,$cuestionario=null)
    {

        $query = $this->getQueryTotals($filter,$filterId,$dateRange,$cuestionario);

        $result = $query->get();
        //dd($query->toSql());
        //dd($result);

		return $result;
    }
	public function getQueryCustom($filter=null,$filterId=null,$dateRange=null,$cuestionario=null) {
		$query = $this->query();
		
		/* if($cuestionario!=null)
			$query->where("quiz_id", '=', $cuestionario);*/

		if(is_array($dateRange)) {
			$query->whereRaw("DATE(tresfera_taketsystem_answers.created_at) >= DATE('".$dateRange['start']."') AND DATE(tresfera_taketsystem_answers.created_at) <= DATE('".$dateRange['end']."')");
		}

		$query = $this->setFilters($query, $dateRange, $filter);
		$query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

		// dd($query->toSql());
		return $query;
	}
    public function getQueryTotals($filter=null,$filterId=null,$dateRange=null,$cuestionario=null) {
		$query = $this->query();
		$query->addSelect(DB::raw('count(distinct result_id) as numQuizz'))
					//->addSelect(DB::raw('sum(if(enviado_at IS NOT NULL, 1, 0)) as enviados'))
				//	->addSelect(DB::raw('sum(if(apertura_at IS NOT NULL, 1, 0)) as abiertos'))
				//	->addSelect(DB::raw('sum(if(completado IS NOT NULL, 1, 0)) as completados'))
					->addSelect(DB::raw('SUM(if(value_type = 3 AND answer_type = \'smiles\', 1, 0)) as numOk'))
					->addSelect(DB::raw('SUM(if(value_type = 1 AND answer_type = \'smiles\', 1, 0)) as numKo'))
					->addSelect(DB::raw('SUM(if(answer_type = \'smiles\', 1, 0)) as numQuestions'))
					->addSelect(DB::raw('CONCAT(FORMAT(SUM(if(value_type = 1 AND answer_type = \'smiles\', 1, 0))/SUM(if(answer_type = \'smiles\', 1, 0))*100,1),\'%\') as percentKo'))
					->addSelect(DB::raw('CONCAT(FORMAT(SUM(if(value_type = 3 AND answer_type = \'smiles\', 1, 0))/SUM(if(answer_type = \'smiles\', 1, 0))*100,1),\'%\') as percentOk'))
					->addSelect(DB::raw('CONCAT(FORMAT(SUM(if(value_type = 2 AND answer_type = \'smiles\', 1, 0))/SUM(if(answer_type = \'smiles\', 1, 0))*100,1),\'%\') as percentMix'))
					->addSelect(DB::raw("SUM(if(question_type = 'email' and value <> '', 1, 0)) as numEmail"))
					->addSelect(DB::raw('SUM(if(value_type = 2, 1 AND answer_type = \'smiles\', 0)) as numMix'));


        if($filter!=null) {
	        if(is_array($filter)) {

                foreach($filter as $f)
                  $query->where($f, '=', $filterId[$f]);
          } else {
            $query->where($filter, '=', $filterId);
          }
      	}
       /* if($cuestionario!=null)
        	$query->where("quiz_id", '=', $cuestionario);*/

        if(is_array($dateRange)) {
					$query->whereRaw("DATE(tresfera_taketsystem_answers.created_at) >= DATE('".$dateRange['start']."') AND DATE(tresfera_taketsystem_answers.created_at) <= DATE('".$dateRange['end']."')");
				}

				$query = $this->setFilters($query, $dateRange);

        $query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');
        // dd($query->toSql());
         return $query;
    }
}
