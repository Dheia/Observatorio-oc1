<?php

namespace Tresfera\Statistics\Models;

use Model;
use System\Models\MailTemplate;
use Backend\Models\User;
use Mail;
use Tresfera\Clients\Models\Client;
/**
 * Client Model.
 */
class Rapport extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_statistics_rapports';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['name', 'max_devices'];
	protected $jsonable = ['data','cuestionario','filters'];
		//protected $dates = ['date_start', 'date_end'];
    /**
     * @var array Rules
     */
    public $rules = [
        'name' => 'required',
    ];

    /**
     * Has Many relations.
     *
     * @var array
     */

    public $belongsTo = [
        'client'     					=> ['Tresfera\Clients\Models\Client'],
        'shop'    	 					=> ['Tresfera\Devices\Models\Shop'],
        'rapportperiod'    	 			=> ['Tresfera\Devices\Statistics\RapportPeriod'],
    ];

    public function beforeSave() {
	    $this->data = $this->generatePdf();
      $this->md5 = md5( json_encode($this->data).$this->client_id.$this->data_start.$this->data_end );
      $client = Client::find($this->client_id);
			if(isset($client->id)) {
				$this->email = $client->email;
				$this->name  = $client->name;
			}

    }

	public function afterCreate() {

	}

    public function sendEmail($informe,$emails) {
	    $data = [
				"informe" => $informe,
				"url" => url("informes/".$this->md5),

			];
			/*if(isset($this->shop->name)) {
				$data["shop"] =  $this->shop->name;
			}*/
			Mail::send("informe_weekly", $data, function($message) use ($emails, $informe)
			{
					//$email['email'] = "fgomezserna@gmail.com";
					foreach($emails as $email) {
            if(!isset($email['email'])) continue;
						//$message->to("fgomezserna@gmail.com", "");
						$message->subject('Informe: '.$informe);
						$message->to($email['email'], "");
					}

			});
    }

  public function generatePdf($cuestionario = null) {
    $model 					= new \Tresfera\Statistics\Models\Result();

	//get Last Monday
    $date['start'] 		= isset($this->date_start->date)?$this->date_start->format('Y-m-d'):$this->date_start;
    //get Last Sunday
    $date['end'] 		= isset($this->date_end->date)?$this->date_end->format('Y-m-d'):$this->date_end;

	$date_last['start'] = isset($this->datelast_start->date)?$this->datelast_start->format('Y-m-d'):$this->datelast_start;
    //get Last Sunday
    $date_last['end'] 	= isset($this->datelast_end->date)?$this->datelast_end->format('Y-m-d'):$this->datelast_end;
	$specifics = [];


	
	$filter = [];
	$filter_id = "";
	if($this->filters) {
		$model->setFiltersOut($this->filters);
	}
		$actividad 				= [];
		
		$datos = new \Tresfera\Envios\Models\Dato();

		$actividad['envios'] 	= 	count($datos->isSendFilters($this->filters)->whereRaw("DATE(tresfera_envios_datos.created_at) >= DATE('".$date['start']."') AND DATE(tresfera_envios_datos.created_at) <= DATE('".$date['end']."')")->get());
		$actividad['abiertos'] 	= 	count($datos->isOpenFilters($this->filters)->whereRaw("DATE(tresfera_envios_datos.created_at) >= DATE('".$date['start']."') AND DATE(tresfera_envios_datos.created_at) <= DATE('".$date['end']."')")->get());
		$actividad['completados'] = 	count($datos->isCompletedFilters($this->filters)->whereRaw("DATE(tresfera_envios_datos.created_at) >= DATE('".$date['start']."') AND DATE(tresfera_envios_datos.created_at) <= DATE('".$date['end']."')")->get());


		$actividad_last 		= [];
		$actividad_last['envios'] 		= 	count($datos->isSendFilters($this->filters)->whereRaw("DATE(tresfera_envios_datos.created_at) >= DATE('".$date_last['start']."') AND DATE(tresfera_envios_datos.created_at) <= DATE('".$date_last['end']."')")->get());
		$actividad_last['abiertos'] 	= 	count($datos->isOpenFilters($this->filters)->whereRaw("DATE(tresfera_envios_datos.created_at) >= DATE('".$date_last['start']."') AND DATE(tresfera_envios_datos.created_at) <= DATE('".$date_last['end']."')")->get());
		$actividad_last['completados'] 	= 	count($datos->isCompletedFilters($this->filters)->whereRaw("DATE(tresfera_envios_datos.created_at) >= DATE('".$date_last['start']."') AND DATE(tresfera_envios_datos.created_at) <= DATE('".$date_last['end']."')")->get());


		$nps 					= $model->getTotalsNPS($filter,$filter_id,$date,$this->cuestionario);
		$nps_last 				= $model->getTotalsNPS($filter,$filter_id,$date_last,$this->cuestionario);

		$generales_client 		= $model->getTotalsGeneral($filter,$filter_id,$date,$this->cuestionario);

		$filtros = [
			'quizzes' => 'Enquestes'
		];

		$generales = [];
		$areas = [];
		if(count($generales_client)) {
			$count_total = 0;
			foreach($generales_client as $general) {
					$count_total += $general->count;
			}
			foreach($generales_client as $total) {            
				$type = $total->question_title;
				$generales[$type]['type'] 			    = "ok";

				$generales[$type]['question_title'] 	= $total->question_title;

				$generales[$type]['percent'] 			= ($total->count/$count_total*100);
				$generales[$type]['percent_disp'] 		= number_format(($total->count/$count_total*100),2);
				$generales[$type]['count'] 				= $total->count;

				//cargamos areas
				$areas_client = $model->getTotalsGeneral("question",$type,$date,$this->cuestionario);
				$areas[$type] = [];
				$count_total_area = 0;
				foreach($areas_client as $general) {
					$count_total_area += $general->count;
				}
				foreach($areas_client as $total) {            
					$type_area = $total->value;
					$areas[$type][$type_area]['type'] 			    = "ok";
	
					$areas[$type][$type_area]['question_title'] 	= $total->value;
					$areas[$type][$type_area]['percent'] 			= ($total->count/$count_total_area*100);
					$areas[$type][$type_area]['percent_disp'] 		= number_format(($total->count/$count_total_area*100),2);
					$areas[$type][$type_area]['count'] 				= $total->count;
				}
			}
		}
		//$genero 				= $model->getTotalsSex($filter,$filter_id,$date,$this->cuestionario);
		//$age	 				= $model->getTotalsAge($filter,$filter_id,$date,$this->cuestionario);
		//$geo	 				= $model->getTotalsCities($filter,$filter_id,$date,$this->cuestionario);
		$comments	 			= $model->getComments($filter,$filter_id,$date,array());
		$segmentaciones = array();

		$segmentaciones_client = \Tresfera\Taketsystem\Models\Segmentacion::with("values")->orderBy("order")->get();
		if(count($segmentaciones_client)) {
			foreach($segmentaciones_client as $segmentacion) {
				$filtros[$segmentacion->slug] = $segmentacion->name;

				$totals = $model->getTotalsSegmentacion(str_slug($segmentacion->name),$filter,$filter_id,$date,$this->cuestionario);
				$type = $segmentacion->name;
				
				$count_total = 0;
				foreach($totals as $total) {
					$count_total += $total->count;
				}
				foreach($totals as $total) {            
					$segmentaciones[$type][$total->value]['type'] 			    = "ok";

					$segmentaciones[$type][$total->value]['name'] 		        = $total->value;

					$segmentaciones[$type][$total->value]['percent'] 			= ($total->count/$count_total*100);
					$segmentaciones[$type][$total->value]['percent_disp'] 		= number_format(($total->count/$count_total*100),2);
					$segmentaciones[$type][$total->value]['count'] 			    = $total->count;
				}
			}
		}
		$nps_logico = [];
	
		/* Get Specifics */

		// Sondeos
		$sondeosa = $model->getSondeos($filter, $filter_id, $date, $cuestionario);
		$sondeos = [];
		$slide_id = null;
		foreach($sondeosa as $sondeo) {
			$slide = \Tresfera\Taketsystem\Models\Slide::find($sondeo->slide_id);
			$image = \System\Models\File::find($sondeo->value);

			if($slide_id != $sondeo->id) {
				$slide_id = $sondeo->id;
			}
			$stats[$slide_id]['slide'] = $slide;
			if( !isset($stats[$slide_id]['total']) ) $stats[$slide_id]['total'] = 0;
			$stats[$slide_id]['total'] += $sondeo->count;
			if( !isset($stats[$slide_id]['max']) ) $stats[$slide_id]['max'] = 0;
			if( !isset($stats[$slide_id]['min']) ) $stats[$slide_id]['min'] = 999999999;
			$stats[$slide_id][$sondeo->value]['class'] = 'mix';
			if( $stats[$slide_id]['min'] >= $sondeo->count ) {
				$stats[$slide_id]['min'] = $sondeo->count;
			}
			if( $stats[$slide_id]['max'] <= $sondeo->count ) {
				$stats[$slide_id]['max'] = $sondeo->count;
			}
		}

		$slide_id = null;
		foreach($sondeosa as $key=>$sondeo) {
			$title = "";
			$cierre = false;
			$slide = \Tresfera\Taketsystem\Models\Slide::find($sondeo->slide_id);
		    //$image = \System\Models\File::find($sondeo->value);
		   // if(!isset($image)) {

			$sondeo_answer = \Tresfera\Taketsystem\Models\QuizMulti::find($sondeo->value);
			if(!isset($sondeo_answer->title)) {
				$title = $sondeo->value;
			} else {
        	$title = $sondeo_answer->title;
      	}
		   // }
		$cuestionario = $sondeo->question_title;

		if($slide_id != $sondeo->id) {
			$slide_id = $sondeo->id;
			$cierre = true;

			$cuestionario = $sondeo->question_title;
		}
     	 if($sondeo->count >= $stats[$slide_id]['max']) {
				$stats[$slide_id][$sondeo->value]['class'] = 'ok';
			} elseif($sondeo->count <= $stats[$slide_id]['min']) {
				$stats[$slide_id][$sondeo->value]['class'] = 'ko';
			}
			$sondeos[$cuestionario][$sondeo->value]['type'] 			= $stats[$slide_id][$sondeo->value]['class'];

			/*if(isset($image))
				$sondeos[$cuestionario][$sondeo->value]['url'] 			= url($image->getPath());
			else*/
			$sondeos[$cuestionario][$sondeo->value]['name'] 		    = $title;
			$sondeos[$cuestionario][$sondeo->value]['percent'] 			= ($sondeo->count/$stats[$slide_id]['max']*100);
			$sondeos[$cuestionario][$sondeo->value]['percent_disp'] = number_format(($sondeo->count/$stats[$slide_id]['total']*100),2);
			$sondeos[$cuestionario][$sondeo->value]['count'] 			  = $sondeo->count;
		}
		$filter[] = "tresfera_taketsystem_answers.question";
		$filter_id["tresfera_taketsystem_answers.question"] = "";

		/*foreach($areas as $area) {
			//echo $area->question_title;
			$filter_id["tresfera_taketsystem_answers.question"] =  $area->question_title;
			$results = $model->getSpecifics($filter, $filter_id, $date, $this->cuestionario);
			$max = 0;
			$total = 0;
			foreach($results as $result) {
				if($max < $result->numQuizz) $max = $result->numQuizz;
				$total += $result->numQuizz;
			}
			foreach($results as $result) {
				if($result->value_type.$result->question_value == 0) continue;
				switch($result->value_type) {
					case 3: $type = "ok"; break;
					case 2: $type = "mix"; break;
					case 1: $type = "ko"; break;
				}
				$specifics[$result->question_title][$result->question_id.$result->question_value] = [
					"result_answer" 	=> number_format( (($result->numQuizz/$total)*100) , 2 ),
					"result_section" 	=> (int)$area->percentKo,
					"question_value" 	=> $result->question_value,
					"question_id" 		=> $result->question_id,
					"numQuizzs" 		=> $result->numQuizz,
					"type" 				=> $type,
					"value_type" 		=> $result->value_type,
					"disp_percent" 		=> (($result->numQuizz/$max)*100)."%",
				];
			}
		}*/
		//dd("");
		foreach($generales as $key=>$general) {
			//$slide = \Tresfera\Taketsystem\Models\Slide::find($general->slide_id);
			//$general->slide_name = $slide->name;
			$generales[$key] = $general;
		}
		$header = "global";
		foreach($this->filters as $f=>$values) {
			if($f == "date_range") continue;
			if(count($values)) $header = "";
		}
		$style = "";
		$config = \Tresfera\Statistics\Models\Config::find(1);
		if(isset($config->config) and isset($config->config['stats'])) {
			if(isset($config->config['stats']['ok']) and $config->config['stats']['ok']) {
				$style .= "
				.ok, .indicator i.ok {
					color: ".$config->config['stats']['ok']." !important;
				}
				.indicator i.ok,
				.bar-line-ok,
				.value_type_1 .bar-line {
					background: ".$config->config['stats']['ok']." !important;
				}
				";
			}
			if(isset($config->config['stats']['mix']) and $config->config['stats']['mix']) {
				$style .= "
				.mix, .indicator i.mix {
					color: ".$config->config['stats']['mix']." !important;
				}
				.indicator i.mix,
				.bar-line-mix,
				.value_type_2 .bar-line {
					background: ".$config->config['stats']['mix']." !important;
				}
				";
			}
			if(isset($config->config['stats']['ko']) and $config->config['stats']['ko']) {
				$style .= "
				.ko, .indicator i.ok {
					color: ".$config->config['stats']['ko']." !important;
				}
				.indicator i.ko,
				.bar-line-ko,
				.value_type_1 .bar-line {
					background: ".$config->config['stats']['ko']." !important;
				}
				";
			}
		}
		//asignamos 
		$data = [
			"date" 				=> $date,
			"actividad" 		=> $actividad,
			"actividad_last" 	=> $actividad_last,
			"nps" 				=> $nps,
			"generales" 		=> $generales,
			"header" 			=> $header,
			"areas" 			=> $areas,
			"comments" 			=> $comments,
			"filtros"         	=> $filtros,
			"filters"         	=> $this->filters,
			"nps_logico"      	=> $nps_logico,
			"segmentaciones"  	=> $segmentaciones,
			"styles"			=> $style
		];
		if($nps_last->count()) {
			$data["nps_last"] =  $nps_last[0];
		}

		return $data;
	}

}
