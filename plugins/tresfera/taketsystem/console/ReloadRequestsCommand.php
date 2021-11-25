<?php
namespace Tresfera\Taketsystem\Console;

use Illuminate\Console\Command;
use Tresfera\Devices\Models\DeviceLog;
use Tresfera\Taketsystem\Models\Result;
use Tresfera\Taketsystem\Models\Quiz;
use Tresfera\Taketsystem\Models\Answer;
use Tresfera\Taketsystem\Models\Slide;
use Tresfera\Taketsystem\Models\Progreso;
use Tresfera\Devices\Models\Citycp;
use Tresfera\Devices\Models\Recioncp;
use Tresfera\Campaign\Models\Subscriber;
use Tresfera\Campaign\Models\SubscriberList;
use DB;
use RainLab\User\Models\User as UserBase;
use  Auth;

class ReloadRequestsCommand extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'taket:reloadrequests';

    /**
     * @var string The console command description.
     */
    protected $description = 'Recarga las estadísticas a través de los logs de conexiones';

    /**
     * Create a new command instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
	
	public function simSave($json_results,$request) {
		$results = json_decode($json_results, true)['results'];
		//Developpers tablets

            // Results
            foreach ($results as $result_data) {
	            //echo "<pre>"; print_r($result_data); echo "</pre>";
				if(!isset($result_data['quizz_id'])) continue;
                // Create result
                $result = new \Tresfera\Taketsystem\Models\Result();
                $result->quiz()->associate(Quiz::findOrFail($result_data['quizz_id']));
                //$result->client_id = $this->device->client_id;

               

                $result->save();

				$dataAnswered = [
					/*'sex' => 0,
					'age' => 0*/
				];
				$lang = 'ES';
                // Answers
                foreach ($result_data['answers'] as $answer_data) {

                    // Create answer
                    $answer = new Answer();
                    $slide = Slide::find($answer_data['slide_id']);
                    if(isset($slide))
                    	$answer->slide()->associate(Slide::find($answer_data['slide_id']));
                    $answer->result()->associate($result);

                    if(isset($answer_data['value']))
                    	$answer->value           = $answer_data['value'];
                    if(isset($answer_data['question_number']))
                    	$answer->question_number = $answer_data['question_number'];
                    if(isset($answer_data['question_title']))
                    	$answer->question_title  = $answer_data['question_title'];
					if(isset($answer_data['question_type']))
                    	$answer->question_type   = $answer_data['question_type'];
					if(isset($answer_data['question_dimension']))
						$answer->question_dimension   = $answer_data['question_dimension'];
					if(isset($answer_data['question_competencia']))
						$answer->question_competencia   = $answer_data['question_competencia'];
					if(isset($answer_data['question_categoria']))
						$answer->question_categoria   = $answer_data['question_categoria'];
					if(isset($answer_data['no_analizable']))
						$answer->no_analizable   = $answer_data['no_analizable'];
                    if(isset($answer_data['value_type']))
                    	$answer->value_type      = $answer_data['value_type'];
                    if(isset($answer_data['answer_type']))
                    	$answer->answer_type     = $answer_data['answer_type'];
                    if(isset($answer_data['question']))
                    	$answer->question     	= $answer_data['question'];
                    if(isset($answer_data['lang'])) {
	                    $lang 				= $answer_data['lang'];
	                    $answer->lang     	= $answer_data['lang'];
                    }

                    if(isset($answer_data['question_id']))
                    	$answer->question_id     	= $answer_data['question_id'];
                    $answer->created_at      = date('Y-m-d H:i:s', strtotime($answer_data['create_at']));

                    try {
						$answer->save();
						//buscamos si está duplicado
						//si lo está, marcamos el resto como duplicados 
						//para que no se tengan en cuenta al analizar los datos
						$query = Answer::where("result_id",$result->id)->where("id","<>",$answer->id);
						if($answer->answer_type)
							$query->where("answer_type",$answer->answer_type);
						if($answer->question)
							$query->where("question",$answer->question);
						if($answer->value_type)
							$query->where("value_type",$answer->value_type);
						if($answer->no_analizable)
							$query->where("no_analizable",$answer->no_analizable);
						if($answer->question_categoria)
							$query->where("question_categoria",$answer->question_categoria);
						if($answer->question_competencia)
							$query->where("question_competencia",$answer->question_competencia);
						if($answer->question_dimension)
							$query->where("question_dimension",$answer->question_dimension);
						if($answer->question_type)
							$query->where("question_type",$answer->question_type);
						if($answer->question_title)
							$query->where("question_title",$answer->question_title);
						if($answer->question_number)
							$query->where("question_number",$answer->question_number);

						$query->update(["duplicated"=>$answer->id]);
						/*if(count($query->get()))
							dd($answer);*/

                    } catch (\Illuminate\Database\QueryException $e) {
						trace_log($e->getMessage()." -- ".$e->getFile()." -- ".$e->getLine());
					}

					switch($answer->question_type) {
						case 'sex':
							$result->sex = $answer->value;
							$dataAnswered[$answer->question_type] = 1;
						break;
						case 'age':
							$result->age = $answer->value;
							$dataAnswered[$answer->question_type] = 1;
						break;
						case 'email':
							$result->email = $answer->value;
						break;
						case 'free':
							$result->free = $answer->value;
						break;
						case 'cp':
							$result->cp 				= $answer->value;
							$citycp = Citycp::where("cod_postal","=",$answer->value)->first();
							if(isset($citycp)) {
								$result->citycp_id 		= $citycp->id;
								$result->regioncp_id 	= $citycp->region_id;
								$result->citycp_name	= $citycp->name;
							}

						break;
					}

					switch($answer->question_title) {
						case 'Sexo':
						case 'Sex':
							$result->genero = $answer->value;
						break;
						case 'Edad':
						case 'Age':
							$result->edad = $answer->value;
						break;
						case 'Sector que mejor se ajusta a su actual/última organización':
						case 'Indicate which industry best fits your current/latest organization':
							$result->sector = $answer->value;
						break;
						case 'Área actual en la que trabaja':
						case 'Current area of work':
							$result->area = $answer->value;
						break;
						case 'Nivel de responsabilidad actual/último':
						case 'Current/latest level of responsibility':
							$result->funcion = $answer->value;
						break;
						
					}

                }
          //Introducimos las variables de url como segmentacion
          $no_segmentacion = [
            "id", "lang", "token", 'results', 'version'
		  ];
		  $post = $request;
		  if($post['talentapp']) {
			$evaluacion_id = $post['ev'];
			if(isset($post['a']))
				$auto = $post['a'];
			if(isset($post['e']))
				$eva = $post['e'];
			if(isset($post['t']))
				$type = $post['t'];
			
			if(!isset($type)) {
				$type = "autoevaluado";
			}
			
			$evaluacion = \Tresfera\TalentApp\Models\Evaluacion::find($evaluacion_id);

			if(isset($evaluacion->id)) {
				if(!isset($eva)) {
					$result->is_autoevaluacion	= 1;
					$result->email = $auto;
				}
				else {
					$result->is_evaluacion	= 1;
					$result->email = $eva;
				}

				$result->evaluacion_id = $evaluacion->id;
				$result->save();

				//comprobamos si ya ha contestado esta evaluacion
				//si es asi, las otras las marcamos como eliminadas
				Result::where("evaluacion_id",$evaluacion->id)
						->where("id","<>",$result->id)
						->where("email",$result->email)
						->update(["duplicated"=>$result->id]);

				//Marcar la evaluacion que toca como completada
				//try {
					$stats = $evaluacion->stats;
					$lastCompleted = $stats[$type][$result->email]['completed'];
					if($result->is_autoevaluacion) {
						$stats['autoevaluado'][$result->email]['completed'] = 1;
						$stats['autoevaluado'][$result->email]['completed_at'] = \Carbon\Carbon::now();
					} else {
						$stats[$type][$result->email]['completed'] = 1;
						$stats[$type][$result->email]['completed_at'] = \Carbon\Carbon::now();
					}
					$stats["numAnswered"]++;
					$evaluacion->stats = $stats;
					//if(!$lastCompleted)
						$evaluacion->save();
			/*	} catch(\Exception $ex) {

				}*/
				
			}
			//buscamos 
		  } 
                //rellenamos respuestas obligatorias para los stats si no se ha hecho antes
            foreach($dataAnswered as $question_type => $value) {
              if($value==0) {
                $answer = new Answer();
                $answer->value = 0;
                $answer->value_type = 0;
                $answer->question_type = $question_type;
                $answer->result_id = $result->id;
                $answer->answer_type = $question_type;
                $answer->lang = $lang;
                $answer->save();
              }
            }
                $result->save();
			}
			dd($results);
            $quiz = Quiz::find($results['quizz_id']);


        
     
		
        return $results;
	}

    public function test() {
		
		$test = '{"token":"hd79S1PFMISQAiSV6bAQmbgBCwwA8Oy1","results":[{"answers":[{"answer_type":"smiles","value":2,"question_title":"You analyze the factors that affect business competition","question_type":"pregunta","question_dimension":"ESTRATÉGICA","question_competencia":"Visión Estratégica","lang":"ES","slide_id":7,"create_at":"2019-02-04T12:33:34.512Z","quizzNum":68,"activeStep":7},{"answer_type":"smiles","value":3,"question_title":"You know your company\'s strong and critical points when facing the competition","question_type":"pregunta","question_dimension":"ESTRATÉGICA","question_competencia":"Visión Estratégica","lang":"ES","slide_id":8,"create_at":"2019-02-04T12:33:36.088Z","quizzNum":68,"activeStep":8},{"answer_type":"smiles","value":5,"question_title":"You anticipate the evolution of events in the world of business","question_type":"pregunta","question_dimension":"ESTRATÉGICA","question_competencia":"Visión Estratégica","lang":"ES","slide_id":9,"create_at":"2019-02-04T12:33:37.370Z","quizzNum":68,"activeStep":9},{"answer_type":"icons","value":1,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I gain status and influence","question_type":"motivo","question_categoria":"EXT - Estratega","no_analizable":0,"lang":"ES","slide_id":10,"create_at":"2019-02-04T12:33:39.278Z","quizzNum":68,"activeStep":10},{"answer_type":"icons","value":2,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I enjoy overcoming challenges","question_type":"motivo","question_categoria":"INT - Ejecutivo","no_analizable":0,"lang":"ES","slide_id":10,"create_at":"2019-02-04T12:33:39.745Z","quizzNum":68,"activeStep":10},{"answer_type":"icons","value":2,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I help solve other people’s needs","question_type":"motivo","question_categoria":"PRO","no_analizable":1,"lang":"ES","slide_id":10,"create_at":"2019-02-04T12:33:40.258Z","quizzNum":68,"activeStep":10},{"answer_type":"icons","value":3,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I anticipate the impact on others and try not to harm them, regardless of my best interest","question_type":"motivo","question_categoria":"TRA - Integrador","no_analizable":0,"lang":"ES","slide_id":10,"create_at":"2019-02-04T12:33:40.692Z","quizzNum":68,"activeStep":10},{"answer_type":"icons","value":1,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I anticipate the impact on others and try not to harm them, regardless of my best interest","question_type":"motivo","question_categoria":"TRA - Integrador","no_analizable":0,"lang":"ES","slide_id":10,"create_at":"2019-02-04T12:34:10.981Z","quizzNum":68,"activeStep":10},{"answer_type":"smiles","value":3,"question_title":"You know the work, operation and needs of other areas","question_type":"pregunta","question_dimension":"ESTRATÉGICA","question_competencia":"Visión de la Organización","lang":"ES","slide_id":11,"create_at":"2019-02-04T12:34:12.339Z","quizzNum":68,"activeStep":11},{"answer_type":"smiles","value":4,"question_title":"You are aware that your decisions can affect other areas","question_type":"pregunta","question_dimension":"ESTRATÉGICA","question_competencia":"Visión de la Organización","lang":"ES","slide_id":12,"create_at":"2019-02-04T12:34:13.574Z","quizzNum":68,"activeStep":12},{"answer_type":"smiles","value":4,"question_title":"You collaborate with other departments when necessary","question_type":"pregunta","question_dimension":"ESTRATÉGICA","question_competencia":"Visión de la Organización","lang":"ES","slide_id":13,"create_at":"2019-02-04T12:34:14.704Z","quizzNum":68,"activeStep":13},{"answer_type":"icons","value":2,"question":" IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I learn from other areas","question_type":"motivo","question_categoria":"INT - Ejecutivo","no_analizable":0,"lang":"ES","slide_id":14,"create_at":"2019-02-04T12:34:16.768Z","quizzNum":68,"activeStep":14},{"answer_type":"icons","value":3,"question":" IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I obtain a better reputation","question_type":"motivo","question_categoria":"EXT - Estratega","no_analizable":0,"lang":"ES","slide_id":14,"create_at":"2019-02-04T12:34:17.171Z","quizzNum":68,"activeStep":14},{"answer_type":"icons","value":3,"question":" IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I anticipate the impact of my choices on others and try not to harm them, regardless of my best interest","question_type":"motivo","question_categoria":"TRA - Integrador","no_analizable":0,"lang":"ES","slide_id":14,"create_at":"2019-02-04T12:34:17.470Z","quizzNum":68,"activeStep":14},{"answer_type":"icons","value":4,"question":" IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I serve others and improve the work atmosphere","question_type":"motivo","question_categoria":"PRO","no_analizable":1,"lang":"ES","slide_id":14,"create_at":"2019-02-04T12:34:17.775Z","quizzNum":68,"activeStep":14},{"answer_type":"smiles","value":3,"question_title":"You quickly respond to client demands","question_type":"pregunta","question_dimension":"ESTRATÉGICA","question_competencia":"Orientación al Cliente","lang":"ES","slide_id":15,"create_at":"2019-02-04T12:34:19.014Z","quizzNum":68,"activeStep":15},{"answer_type":"smiles","value":4,"question_title":"You know how to find out client needs and expectations","question_type":"pregunta","question_dimension":"ESTRATÉGICA","question_competencia":"Orientación al Cliente","lang":"ES","slide_id":16,"create_at":"2019-02-04T12:34:20.189Z","quizzNum":68,"activeStep":16},{"answer_type":"smiles","value":4,"question_title":"You create offers that generate added value for clients","question_type":"pregunta","question_dimension":"ESTRATÉGICA","question_competencia":"Orientación al Cliente","lang":"ES","slide_id":17,"create_at":"2019-02-04T12:34:21.584Z","quizzNum":68,"activeStep":17},{"answer_type":"icons","value":1,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I attend to the needs of others","question_type":"motivo","question_categoria":"PRO","no_analizable":1,"lang":"ES","slide_id":18,"create_at":"2019-02-04T12:34:22.987Z","quizzNum":68,"activeStep":18},{"answer_type":"icons","value":2,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I like challenges","question_type":"motivo","question_categoria":"INT - Ejecutivo","no_analizable":0,"lang":"ES","slide_id":18,"create_at":"2019-02-04T12:34:23.362Z","quizzNum":68,"activeStep":18},{"answer_type":"icons","value":3,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I take interest in other people’s opinion with an open mind, not trying to impose my judgment","question_type":"motivo","question_categoria":"TRA - Integrador","no_analizable":0,"lang":"ES","slide_id":18,"create_at":"2019-02-04T12:34:23.696Z","quizzNum":68,"activeStep":18},{"answer_type":"icons","value":4,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I gain prestige","question_type":"motivo","question_categoria":"EXT - Estratega","no_analizable":0,"lang":"ES","slide_id":18,"create_at":"2019-02-04T12:34:24.112Z","quizzNum":68,"activeStep":18},{"answer_type":"smiles","value":3,"question_title":"You have a circle of influential friends with whom you share information and contacts","question_type":"pregunta","question_dimension":"ESTRATÉGICA","question_competencia":"Networking","lang":"ES","slide_id":19,"create_at":"2019-02-04T12:34:25.212Z","quizzNum":68,"activeStep":19},{"answer_type":"smiles","value":4,"question_title":"You seek informal ways of connecting with key people in the business environment","question_type":"pregunta","question_dimension":"ESTRATÉGICA","question_competencia":"Networking","lang":"ES","slide_id":20,"create_at":"2019-02-04T12:34:26.351Z","quizzNum":68,"activeStep":20},{"answer_type":"smiles","value":3,"question_title":"You know how to gain supports among your contacts","question_type":"pregunta","question_dimension":"ESTRATÉGICA","question_competencia":"Networking","lang":"ES","slide_id":21,"create_at":"2019-02-04T12:34:27.418Z","quizzNum":68,"activeStep":21},{"answer_type":"icons","value":1,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I feel more confident and satisfied","question_type":"motivo","question_categoria":"INT - Ejecutivo","no_analizable":0,"lang":"ES","slide_id":22,"create_at":"2019-02-04T12:34:28.835Z","quizzNum":68,"activeStep":22},{"answer_type":"icons","value":2,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I take interest in others with an open mind, regardless of my best interest","question_type":"motivo","question_categoria":"TRA - Integrador","no_analizable":0,"lang":"ES","slide_id":22,"create_at":"2019-02-04T12:34:29.190Z","quizzNum":68,"activeStep":22},{"answer_type":"icons","value":3,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I gain status and influence","question_type":"motivo","question_categoria":"EXT - Estratega","no_analizable":0,"lang":"ES","slide_id":22,"create_at":"2019-02-04T12:34:29.545Z","quizzNum":68,"activeStep":22},{"answer_type":"icons","value":2,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I attend to the needs of others","question_type":"motivo","question_categoria":"PRO","no_analizable":1,"lang":"ES","slide_id":22,"create_at":"2019-02-04T12:34:29.914Z","quizzNum":68,"activeStep":22},{"answer_type":"smiles","value":3,"question_title":"You approach conversations in a clear, honest, effective manner","question_type":"pregunta","question_dimension":"INTERPERSONAL","question_competencia":"Comunicación","lang":"ES","slide_id":23,"create_at":"2019-02-04T12:34:31.345Z","quizzNum":68,"activeStep":23},
		{"answer_type":"smiles","value":4,"question_title":"You adapt your language and style according to the persons in front of you","question_type":"pregunta","question_dimension":"INTERPERSONAL","question_competencia":"Comunicación","lang":"ES","slide_id":24,"create_at":"2019-02-04T12:34:32.443Z","quizzNum":68,"activeStep":24},{"answer_type":"smiles","value":5,"question_title":"You can listen and you make sure you have been understood","question_type":"pregunta","question_dimension":"INTERPERSONAL","question_competencia":"Comunicación","lang":"ES","slide_id":25,"create_at":"2019-02-04T12:34:33.565Z","quizzNum":68,"activeStep":25},{"answer_type":"icons","value":1,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I acquire new prestige","question_type":"motivo","question_categoria":"EXT - Estratega","no_analizable":0,"lang":"ES","slide_id":26,"create_at":"2019-02-04T12:34:34.990Z","quizzNum":68,"activeStep":26},{"answer_type":"icons","value":1,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I feel more satisfied","question_type":"motivo","question_categoria":"INT - Ejecutivo","no_analizable":0,"lang":"ES","slide_id":26,"create_at":"2019-02-04T12:34:35.316Z","quizzNum":68,"activeStep":26},{"answer_type":"icons","value":1,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I make other people’s work easier\t","question_type":"motivo","question_categoria":"PRO","no_analizable":1,"lang":"ES","slide_id":26,"create_at":"2019-02-04T12:34:35.673Z","quizzNum":68,"activeStep":26},{"answer_type":"icons","value":2,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I take interest in other people’s opinions with an open mind, not trying to impose my judgement","question_type":"motivo","question_categoria":"TRA - Integrador","no_analizable":0,"lang":"ES","slide_id":26,"create_at":"2019-02-04T12:34:35.970Z","quizzNum":68,"activeStep":26},{"answer_type":"smiles","value":3,"question_title":"You know what to delegate to each person","question_type":"pregunta","question_dimension":"INTERPERSONAL","question_competencia":"Delegación","lang":"ES","slide_id":27,"create_at":"2019-02-04T12:34:37.403Z","quizzNum":68,"activeStep":27},{"answer_type":"smiles","value":4,"question_title":"You supervise tasks and projects without interfering in the details","question_type":"pregunta","question_dimension":"INTERPERSONAL","question_competencia":"Delegación","lang":"ES","slide_id":28,"create_at":"2019-02-04T12:34:38.630Z","quizzNum":68,"activeStep":28},{"answer_type":"smiles","value":4,"question_title":"You encourage your collaborators’ responsibility","question_type":"pregunta","question_dimension":"INTERPERSONAL","question_competencia":"Delegación","lang":"ES","slide_id":29,"create_at":"2019-02-04T12:34:39.813Z","quizzNum":68,"activeStep":29},{"answer_type":"icons","value":1,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I feel better about myself","question_type":"motivo","question_categoria":"INT - Ejecutivo","no_analizable":0,"lang":"ES","slide_id":30,"create_at":"2019-02-04T12:34:41.258Z","quizzNum":68,"activeStep":30},{"answer_type":"icons","value":1,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I increase my prestige","question_type":"motivo","question_categoria":"EXT - Estratega","no_analizable":0,"lang":"ES","slide_id":30,"create_at":"2019-02-04T12:34:41.621Z","quizzNum":68,"activeStep":30},{"answer_type":"icons","value":2,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I anticipate the impact of my decisions and try not to harm others, regardless of my best interest","question_type":"motivo","question_categoria":"TRA - Integrador","no_analizable":0,"lang":"ES","slide_id":30,"create_at":"2019-02-04T12:34:42.000Z","quizzNum":68,"activeStep":30},{"answer_type":"icons","value":3,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I serve others and improve the work atmosphere","question_type":"motivo","question_categoria":"PRO","no_analizable":1,"lang":"ES","slide_id":30,"create_at":"2019-02-04T12:34:42.555Z","quizzNum":68,"activeStep":30},{"answer_type":"smiles","value":2,"question_title":"You pay attention to your collaborators’ needs and interests","question_type":"pregunta","question_dimension":"INTERPERSONAL","question_competencia":"Coaching","lang":"ES","slide_id":31,"create_at":"2019-02-04T12:34:44.100Z","quizzNum":68,"activeStep":31},{"answer_type":"smiles","value":4,"question_title":"You pay attention to your collaborators’ needs and interests","question_type":"pregunta","question_dimension":"INTERPERSONAL","question_competencia":"Coaching","lang":"ES","slide_id":31,"create_at":"2019-02-04T12:34:44.629Z","quizzNum":68,"activeStep":31},{"answer_type":"smiles","value":3,"question_title":"You pay attention to your collaborators’ needs and interests","question_type":"pregunta","question_dimension":"INTERPERSONAL","question_competencia":"Coaching","lang":"ES","slide_id":31,"create_at":"2019-02-04T12:34:45.095Z","quizzNum":68,"activeStep":31},{"answer_type":"smiles","value":3,"question_title":"You advise, encourage and demand when necessary","question_type":"pregunta","question_dimension":"INTERPERSONAL","question_competencia":"Coaching","lang":"ES","slide_id":32,"create_at":"2019-02-04T12:34:46.402Z","quizzNum":68,"activeStep":32},{"answer_type":"smiles","value":4,"question_title":"You advise, encourage and demand when necessary","question_type":"pregunta","question_dimension":"INTERPERSONAL","question_competencia":"Coaching","lang":"ES","slide_id":32,"create_at":"2019-02-04T12:34:46.937Z","quizzNum":68,"activeStep":32},{"answer_type":"smiles","value":3,"question_title":"You advise, encourage and demand when necessary","question_type":"pregunta","question_dimension":"INTERPERSONAL","question_competencia":"Coaching","lang":"ES","slide_id":32,"create_at":"2019-02-04T12:34:47.386Z","quizzNum":68,"activeStep":32},{"answer_type":"smiles","value":3,"question_title":"You care about the development of your collaborators","question_type":"pregunta","question_dimension":"INTERPERSONAL","question_competencia":"Coaching","lang":"ES","slide_id":33,"create_at":"2019-02-04T12:34:48.658Z","quizzNum":68,"activeStep":33},{"answer_type":"icons","value":1,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I attend to the needs of others","question_type":"motivo","question_categoria":"PRO","no_analizable":1,"lang":"ES","slide_id":34,"create_at":"2019-02-04T12:34:50.472Z","quizzNum":68,"activeStep":34},{"answer_type":"icons","value":2,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I like challenges","question_type":"motivo","question_categoria":"INT - Ejecutivo","no_analizable":0,"lang":"ES","slide_id":34,"create_at":"2019-02-04T12:34:50.872Z","quizzNum":68,"activeStep":34},{"answer_type":"icons","value":2,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I take interest in the opinions of others with an open mind, not trying to impose my judgment","question_type":"motivo","question_categoria":"TRA - Integrador","no_analizable":0,"lang":"ES","slide_id":34,"create_at":"2019-02-04T12:34:51.396Z","quizzNum":68,"activeStep":34},{"answer_type":"icons","value":3,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I am better acknowledged","question_type":"motivo","question_categoria":"EXT - Estratega","no_analizable":0,"lang":"ES","slide_id":34,"create_at":"2019-02-04T12:34:51.746Z","quizzNum":68,"activeStep":34},{"answer_type":"icons","value":2,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I am better acknowledged","question_type":"motivo","question_categoria":"EXT - Estratega","no_analizable":0,"lang":"ES","slide_id":34,"create_at":"2019-02-04T12:34:54.159Z","quizzNum":68,"activeStep":34},{"answer_type":"smiles","value":3,"question_title":"You responsibly comply with the team’s norms and agreements","question_type":"pregunta","question_dimension":"INTERPERSONAL","question_competencia":"Trabajo en Equipo","lang":"ES","slide_id":35,"create_at":"2019-02-04T12:34:55.347Z","quizzNum":68,"activeStep":35},{"answer_type":"smiles","value":2,"question_title":"You responsibly comply with the team’s norms and agreements","question_type":"pregunta","question_dimension":"INTERPERSONAL","question_competencia":"Trabajo en Equipo","lang":"ES","slide_id":35,"create_at":"2019-02-04T12:34:58.248Z","quizzNum":68,"activeStep":35},{"answer_type":"smiles","value":4,"question_title":"You foster morale and enthusiasm among your team members ","question_type":"pregunta","question_dimension":"INTERPERSONAL","question_competencia":"Trabajo en Equipo","lang":"ES","slide_id":36,"create_at":"2019-02-04T12:34:59.563Z","quizzNum":68,"activeStep":36},{"answer_type":"smiles","value":4,"question_title":"You collaborate with others regarding team needs","question_type":"pregunta","question_dimension":"INTERPERSONAL","question_competencia":"Trabajo en Equipo","lang":"ES","slide_id":37,"create_at":"2019-02-04T12:35:00.622Z","quizzNum":68,"activeStep":37},{"answer_type":"icons","value":1,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I learn new skills","question_type":"motivo","question_categoria":"INT - Ejecutivo","no_analizable":0,"lang":"ES","slide_id":38,"create_at":"2019-02-04T12:35:02.008Z","quizzNum":68,"activeStep":38},{"answer_type":"icons","value":2,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I take an interest in others with an open mind, regardless of my best interest","question_type":"motivo","question_categoria":"TRA - Integrador","no_analizable":0,"lang":"ES","slide_id":38,"create_at":"2019-02-04T12:35:02.496Z","quizzNum":68,"activeStep":38},{"answer_type":"icons",
			"value":3,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I obtain a better reputation","question_type":"motivo","question_categoria":"EXT - Estratega","no_analizable":0,"lang":"ES","slide_id":38,"create_at":"2019-02-04T12:35:02.853Z","quizzNum":68,"activeStep":38},{"answer_type":"icons","value":4,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I serve others and improve the work atmosphere","question_type":"motivo","question_categoria":"PRO","no_analizable":1,"lang":"ES","slide_id":38,"create_at":"2019-02-04T12:35:03.225Z","quizzNum":68,"activeStep":38},{"answer_type":"smiles","value":3,"question_title":"You allocate the appropriate time for each task","question_type":"pregunta","question_dimension":"AUTOGESTIÓN","question_competencia":"Gestión del Tiempo","lang":"ES","slide_id":39,"create_at":"2019-02-04T12:35:04.316Z","quizzNum":68,"activeStep":39},{"answer_type":"smiles","value":4,"question_title":"You use a calendar to schedule your activities","question_type":"pregunta","question_dimension":"AUTOGESTIÓN","question_competencia":"Gestión del Tiempo","lang":"ES","slide_id":40,"create_at":"2019-02-04T12:35:05.733Z","quizzNum":68,"activeStep":40},{"answer_type":"smiles","value":2,"question_title":"Your priorities are clear and you allocate the time for each one accordingly","question_type":"pregunta","question_dimension":"AUTOGESTIÓN","question_competencia":"Gestión del Tiempo","lang":"ES","slide_id":41,"create_at":"2019-02-04T12:35:06.927Z","quizzNum":68,"activeStep":41},{"answer_type":"icons","value":2,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I gain prestige","question_type":"motivo","question_categoria":"EXT - Estratega","no_analizable":0,"lang":"ES","slide_id":42,"create_at":"2019-02-04T12:35:08.287Z","quizzNum":68,"activeStep":42},{"answer_type":"icons","value":3,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I enjoy overcoming challenges","question_type":"motivo","question_categoria":"INT - Ejecutivo","no_analizable":0,"lang":"ES","slide_id":42,"create_at":"2019-02-04T12:35:08.678Z","quizzNum":68,"activeStep":42},{"answer_type":"icons","value":3,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I make other people’s work easier","question_type":"motivo","question_categoria":"PRO","no_analizable":1,"lang":"ES","slide_id":42,"create_at":"2019-02-04T12:35:08.972Z","quizzNum":68,"activeStep":42},{"answer_type":"icons","value":4,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I anticipate the impact of my decisions and try not to harm others, regardless of my best interest","question_type":"motivo","question_categoria":"TRA - Integrador","no_analizable":0,"lang":"ES","slide_id":42,"create_at":"2019-02-04T12:35:09.307Z","quizzNum":68,"activeStep":42},{"answer_type":"smiles","value":3,"question_title":"You can detect stress symptoms and take measures to mitigate it","question_type":"pregunta","question_dimension":"AUTOGESTIÓN","question_competencia":"Gestión del Estrés","lang":"ES","slide_id":43,"create_at":"2019-02-04T12:35:10.462Z","quizzNum":68,"activeStep":43},{"answer_type":"smiles","value":3,"question_title":"You rest the right/proper amount of time","question_type":"pregunta","question_dimension":"AUTOGESTIÓN","question_competencia":"Gestión del Estrés","lang":"ES","slide_id":44,"create_at":"2019-02-04T12:35:11.544Z","quizzNum":68,"activeStep":44},{"answer_type":"smiles","value":4,"question_title":"You maintain a balance between your personal and professional life","question_type":"pregunta","question_dimension":"AUTOGESTIÓN","question_competencia":"Gestión del Estrés","lang":"ES","slide_id":45,"create_at":"2019-02-04T12:35:12.767Z","quizzNum":68,"activeStep":45},{"answer_type":"icons","value":1,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I feel more confident and satisfied","question_type":"motivo","question_categoria":"INT - Ejecutivo","no_analizable":0,"lang":"ES","slide_id":46,"create_at":"2019-02-04T12:35:14.309Z","quizzNum":68,"activeStep":46},{"answer_type":"icons","value":5,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I am better acknowledged","question_type":"motivo","question_categoria":"EXT - Estratega","no_analizable":0,"lang":"ES","slide_id":46,"create_at":"2019-02-04T12:35:15.228Z","quizzNum":68,"activeStep":46},{"answer_type":"icons","value":5,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I anticipate the impact of my actions and try not to harm others, regardless of my best interest","question_type":"motivo","question_categoria":"TRA - Integrador","no_analizable":0,"lang":"ES","slide_id":46,"create_at":"2019-02-04T12:35:15.558Z","quizzNum":68,"activeStep":46},{"answer_type":"icons","value":5,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I serve others and improve the work atmosphere","question_type":"motivo","question_categoria":"PRO","no_analizable":1,"lang":"ES","slide_id":46,"create_at":"2019-02-04T12:35:15.904Z","quizzNum":68,"activeStep":46},{"answer_type":"smiles","value":3,"question_title":"You feel enthusiastic about everything you do","question_type":"pregunta","question_dimension":"AUTOGESTIÓN","question_competencia":"Optimismo","lang":"ES","slide_id":47,"create_at":"2019-02-04T12:35:17.537Z","quizzNum":68,"activeStep":47},{"answer_type":"smiles","value":4,"question_title":"You recover with sportsmanship from professional and personal setbacks","question_type":"pregunta","question_dimension":"AUTOGESTIÓN","question_competencia":"Optimismo","lang":"ES","slide_id":48,"create_at":"2019-02-04T12:35:25.783Z","quizzNum":68,"activeStep":48},{"answer_type":"smiles","value":3,"question_title":"You don’t feel discouraged by difficulties","question_type":"pregunta","question_dimension":"AUTOGESTIÓN","question_competencia":"Optimismo","lang":"ES","slide_id":49,"create_at":"2019-02-04T12:35:26.939Z","quizzNum":68,"activeStep":49},{"answer_type":"icons","value":1,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I make other people’s work easier","question_type":"motivo","question_categoria":"PRO","no_analizable":1,"lang":"ES","slide_id":50,"create_at":"2019-02-04T12:35:28.533Z","quizzNum":68,"activeStep":50},{"answer_type":"icons","value":2,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I enjoy overcoming challenges","question_type":"motivo","question_categoria":"INT - Ejecutivo","no_analizable":0,"lang":"ES","slide_id":50,"create_at":"2019-02-04T12:35:28.995Z","quizzNum":68,"activeStep":50},{"answer_type":"icons","value":2,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I anticipate the impact of my reactions on others and try not to harm others","question_type":"motivo","question_categoria":"TRA - Integrador","no_analizable":0,"lang":"ES","slide_id":50,"create_at":"2019-02-04T12:35:29.429Z","quizzNum":68,"activeStep":50},{"answer_type":"icons","value":3,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I gain a better reputation","question_type":"motivo","question_categoria":"EXT - Estratega","no_analizable":0,"lang":"ES","slide_id":50,"create_at":"2019-02-04T12:35:29.865Z","quizzNum":68,"activeStep":50},{"answer_type":"smiles","value":4,"question_title":"You foster improvements in your department","question_type":"pregunta","question_dimension":"AUTOGESTIÓN","question_competencia":"Iniciativa","lang":"ES","slide_id":51,"create_at":"2019-02-04T12:35:31.108Z","quizzNum":68,"activeStep":51},{"answer_type":"smiles","value":4,"question_title":"You actively participate in brainstorming at work","question_type":"pregunta","question_dimension":"AUTOGESTIÓN","question_competencia":"Iniciativa","lang":"ES","slide_id":52,"create_at":"2019-02-04T12:35:32.383Z","quizzNum":68,"activeStep":52},{"answer_type":"smiles","value":4,"question_title":"You analyze problems from new points of view","question_type":"pregunta","question_dimension":"AUTOGESTIÓN","question_competencia":"Iniciativa","lang":"ES","slide_id":53,"create_at":"2019-02-04T12:35:33.721Z","quizzNum":68,"activeStep":53},{"answer_type":"icons","value":1,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I learn new things","question_type":"motivo","question_categoria":"INT - Ejecutivo","no_analizable":0,"lang":"ES","slide_id":54,"create_at":"2019-02-04T12:35:35.758Z","quizzNum":68,"activeStep":54},{"answer_type":"icons","value":2,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I appreciate the opinions and help of others without feeling annoyed","question_type":"motivo","question_categoria":"TRA - Integrador","no_analizable":0,"lang":"ES","slide_id":54,"create_at":"2019-02-04T12:35:36.186Z","quizzNum":68,"activeStep":54},{"answer_type":"icons","value":3,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I gain status and influence","question_type":"motivo","question_categoria":"EXT - Estratega","no_analizable":0,"lang":"ES","slide_id":54,"create_at":"2019-02-04T12:35:36.554Z","quizzNum":68,"activeStep":54},{"answer_type":"icons","value":4,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I help solve other people’s needs","question_type":"motivo","question_categoria":"PRO","no_analizable":1,"lang":"ES","slide_id":54,"create_at":"2019-02-04T12:35:36.938Z","quizzNum":68,"activeStep":54},{"answer_type":"smiles","value":4,"question_title":"You take time for personal and professional training","question_type":"pregunta","question_dimension":"AUTODESARROLLO","question_competencia":"Aprendizaje","lang":"ES","slide_id":55,"create_at":"2019-02-04T12:35:38.139Z","quizzNum":68,"activeStep":55},
			{"answer_type":"smiles","value":3,"question_title":"You commit to continuous improvement by setting concrete goals","question_type":"pregunta","question_dimension":"AUTODESARROLLO","question_competencia":"Aprendizaje","lang":"ES","slide_id":56,"create_at":"2019-02-04T12:35:39.214Z","quizzNum":68,"activeStep":56},{"answer_type":"smiles","value":4,"question_title":"You easily adapt to changes at work","question_type":"pregunta","question_dimension":"AUTODESARROLLO","question_competencia":"Aprendizaje","lang":"ES","slide_id":57,"create_at":"2019-02-04T12:35:40.360Z","quizzNum":68,"activeStep":57},{"answer_type":"icons","value":1,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I obtain a better reputation","question_type":"motivo","question_categoria":"EXT - Estratega","no_analizable":0,"lang":"ES","slide_id":58,"create_at":"2019-02-04T12:35:41.887Z","quizzNum":68,"activeStep":58},{"answer_type":"icons","value":1,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I learn new things","question_type":"motivo","question_categoria":"INT - Ejecutivo","no_analizable":0,"lang":"ES","slide_id":58,"create_at":"2019-02-04T12:35:42.214Z","quizzNum":68,"activeStep":58},{"answer_type":"icons","value":2,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I make other people’s work easier","question_type":"motivo","question_categoria":"PRO","no_analizable":1,"lang":"ES","slide_id":58,"create_at":"2019-02-04T12:35:42.545Z","quizzNum":68,"activeStep":58},{"answer_type":"icons","value":3,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I appreciate the opinion and help of others and don’t become annoyed","question_type":"motivo","question_categoria":"TRA - Integrador","no_analizable":0,"lang":"ES","slide_id":58,"create_at":"2019-02-04T12:35:42.887Z","quizzNum":68,"activeStep":58},{"answer_type":"smiles","value":4,"question_title":"You frequently examine your own behavior","question_type":"pregunta","question_dimension":"AUTODESARROLLO","question_competencia":"Autoconocimiento","lang":"ES","slide_id":59,"create_at":"2019-02-04T12:35:44.122Z","quizzNum":68,"activeStep":59},{"answer_type":"smiles","value":2,"question_title":"You ask for feedback to improve your behavior and to learn","question_type":"pregunta","question_dimension":"AUTODESARROLLO","question_competencia":"Autoconocimiento","lang":"ES","slide_id":60,"create_at":"2019-02-04T12:35:45.358Z","quizzNum":68,"activeStep":60},{"answer_type":"smiles","value":5,"question_title":"You analyze your feelings and how they affect your productivity and relationships with other people","question_type":"pregunta","question_dimension":"AUTODESARROLLO","question_competencia":"Autoconocimiento","lang":"ES","slide_id":61,"create_at":"2019-02-04T12:35:46.951Z","quizzNum":68,"activeStep":61},{"answer_type":"icons","value":1,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I feel more satisfied","question_type":"motivo","question_categoria":"INT - Ejecutivo","no_analizable":0,"lang":"ES","slide_id":62,"create_at":"2019-02-04T12:35:48.339Z","quizzNum":68,"activeStep":62},{"answer_type":"icons","value":2,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I gain prestige","question_type":"motivo","question_categoria":"EXT - Estratega","no_analizable":0,"lang":"ES","slide_id":62,"create_at":"2019-02-04T12:35:48.757Z","quizzNum":68,"activeStep":62},{"answer_type":"icons","value":3,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I appreciate the opinion and help of others and don’t feel annoyed","question_type":"motivo","question_categoria":"TRA - Integrador","no_analizable":0,"lang":"ES","slide_id":62,"create_at":"2019-02-04T12:35:49.159Z","quizzNum":68,"activeStep":62},{"answer_type":"icons","value":4,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I serve others and improve the work atmosphere","question_type":"motivo","question_categoria":"PRO","no_analizable":1,"lang":"ES","slide_id":62,"create_at":"2019-02-04T12:35:49.533Z","quizzNum":68,"activeStep":62},{"answer_type":"smiles","value":5,"question_title":"You recognize your limitations without excuses","question_type":"pregunta","question_dimension":"AUTODESARROLLO","question_competencia":"Autocrítica","lang":"ES","slide_id":63,"create_at":"2019-02-04T12:35:50.760Z","quizzNum":68,"activeStep":63},{"answer_type":"smiles","value":5,"question_title":"You take feedback with an open mind and the desire to improve","question_type":"pregunta","question_dimension":"AUTODESARROLLO","question_competencia":"Autocrítica","lang":"ES","slide_id":64,"create_at":"2019-02-04T12:35:52.071Z","quizzNum":68,"activeStep":64},{"answer_type":"smiles","value":4,"question_title":"You accept mistakes with a constructive attitude and try to learn from them","question_type":"pregunta","question_dimension":"AUTODESARROLLO","question_competencia":"Autocrítica","lang":"ES","slide_id":65,"create_at":"2019-02-04T12:35:53.392Z","quizzNum":68,"activeStep":65},{"answer_type":"icons","value":5,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I serve others and improve the work atmosphere","question_type":"motivo","question_categoria":"PRO","no_analizable":1,"lang":"ES","slide_id":66,"create_at":"2019-02-04T12:35:55.429Z","quizzNum":68,"activeStep":66},{"answer_type":"icons","value":4,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I feel better about myself","question_type":"motivo","question_categoria":"INT - Ejecutivo","no_analizable":0,"lang":"ES","slide_id":66,"create_at":"2019-02-04T12:35:56.003Z","quizzNum":68,"activeStep":66},{"answer_type":"icons","value":3,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I appreciate the opinion and help of others and don’t feel annoyed","question_type":"motivo","question_categoria":"TRA - Integrador","no_analizable":0,"lang":"ES","slide_id":66,"create_at":"2019-02-04T12:35:56.395Z","quizzNum":68,"activeStep":66},{"answer_type":"icons","value":2,"question":"IN REGARDS TO THE 3 PRIOR QUESTIONS, WHY DO I DO IT?","question_title":"I am better acknowledged","question_type":"motivo","question_categoria":"EXT - Estratega","no_analizable":0,"lang":"ES","slide_id":66,"create_at":"2019-02-04T12:35:56.781Z","quizzNum":68,"activeStep":66},{"answer_type":"smiles","value":4,"question_title":"You commit to difficult objectives when necessary","question_type":"pregunta","question_dimension":"AUTODESARROLLO","question_competencia":"Ambición","lang":"ES","slide_id":67,"create_at":"2019-02-04T12:35:58.160Z","quizzNum":68,"activeStep":67},{"answer_type":"smiles","value":3,"question_title":"You pursue your goals with resolution, not giving up until you reach them","question_type":"pregunta","question_dimension":"AUTODESARROLLO","question_competencia":"Ambición","lang":"ES","slide_id":68,"create_at":"2019-02-04T12:35:59.332Z","quizzNum":68,"activeStep":68},{"answer_type":"smiles","value":4,"question_title":"You seek excellence in everything you do","question_type":"pregunta","question_dimension":"AUTODESARROLLO","question_competencia":"Ambición","lang":"ES","slide_id":69,"create_at":"2019-02-04T12:36:00.584Z","quizzNum":68,"activeStep":69},{"answer_type":"icons","value":1,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I like challenges","question_type":"motivo","question_categoria":"INT - Ejecutivo","no_analizable":0,"lang":"ES","slide_id":70,"create_at":"2019-02-04T12:36:02.140Z","quizzNum":68,"activeStep":70},{"answer_type":"icons","value":2,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I anticipate the impact on others, thus keeping them from harm and not seeking my best interest","question_type":"motivo","question_categoria":"TRA - Integrador","no_analizable":0,"lang":"ES","slide_id":70,"create_at":"2019-02-04T12:36:02.548Z","quizzNum":68,"activeStep":70},{"answer_type":"icons","value":3,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I gain status and influence","question_type":"motivo","question_categoria":"EXT - Estratega","no_analizable":0,"lang":"ES","slide_id":70,"create_at":"2019-02-04T12:36:02.911Z","quizzNum":68,"activeStep":70},{"answer_type":"icons","value":4,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I help solve the needs of others","question_type":"motivo","question_categoria":"PRO","no_analizable":1,"lang":"ES","slide_id":70,"create_at":"2019-02-04T12:36:03.275Z","quizzNum":68,"activeStep":70},{"answer_type":"smiles","value":5,"question_title":"You deeply analyze the causes of a problem, you don’t stop at the obvious","question_type":"pregunta","question_dimension":"AUTOGOBIERNO","question_competencia":"Toma de Decisiones","lang":"ES","slide_id":71,"create_at":"2019-02-04T12:36:04.593Z","quizzNum":68,"activeStep":71},{"answer_type":"smiles","value":5,"question_title":"You systematically explore various alternatives, analyzing their possible consequences","question_type":"pregunta","question_dimension":"AUTOGOBIERNO","question_competencia":"Toma de Decisiones","lang":"ES","slide_id":72,"create_at":"2019-02-04T12:36:05.971Z","quizzNum":68,"activeStep":72},{"answer_type":"smiles","value":2,"question_title":"You define and consider the criteria to keep in mind when choosing an alternative","question_type":"pregunta","question_dimension":"AUTOGOBIERNO","question_competencia":"Toma de Decisiones","lang":"ES","slide_id":73,"create_at":"2019-02-04T12:36:07.762Z","quizzNum":68,"activeStep":73},{"answer_type":"icons","value":5,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I earn status and influence","question_type":"motivo","question_categoria":"EXT - Estratega","no_analizable":0,
			"lang":"ES","slide_id":74,"create_at":"2019-02-04T12:36:09.720Z","quizzNum":68,"activeStep":74},{"answer_type":"icons","value":4,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I learn new things","question_type":"motivo","question_categoria":"INT - Ejecutivo","no_analizable":0,"lang":"ES","slide_id":74,"create_at":"2019-02-04T12:36:10.140Z","quizzNum":68,"activeStep":74},{"answer_type":"icons","value":3,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I help solve the needs of others","question_type":"motivo","question_categoria":"PRO","no_analizable":1,"lang":"ES","slide_id":74,"create_at":"2019-02-04T12:36:10.463Z","quizzNum":68,"activeStep":74},{"answer_type":"icons","value":3,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I anticipate the impact on others and try not to harm others, regardless of my best interest","question_type":"motivo","question_categoria":"TRA - Integrador","no_analizable":0,"lang":"ES","slide_id":74,"create_at":"2019-02-04T12:36:10.816Z","quizzNum":68,"activeStep":74},{"answer_type":"smiles","value":3,"question_title":"Your opinions and actions reflect what you think: you are sincere and transparent","question_type":"pregunta","question_dimension":"AUTOGOBIERNO","question_competencia":"Integridad","lang":"ES","slide_id":75,"create_at":"2019-02-04T12:36:12.634Z","quizzNum":68,"activeStep":75},{"answer_type":"smiles","value":4,"question_title":"Your behavior is consistent with your principles","question_type":"pregunta","question_dimension":"AUTOGOBIERNO","question_competencia":"Integridad","lang":"ES","slide_id":76,"create_at":"2019-02-04T12:36:13.796Z","quizzNum":68,"activeStep":76},{"answer_type":"smiles","value":5,"question_title":"You are fair when recognizing, defending and demanding accordingly to each person","question_type":"pregunta","question_dimension":"AUTOGOBIERNO","question_competencia":"Integridad","lang":"ES","slide_id":77,"create_at":"2019-02-04T12:36:15.459Z","quizzNum":68,"activeStep":77},{"answer_type":"icons","value":1,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I feel better about myself","question_type":"motivo","question_categoria":"INT - Ejecutivo","no_analizable":0,"lang":"ES","slide_id":78,"create_at":"2019-02-04T12:36:17.224Z","quizzNum":68,"activeStep":78},{"answer_type":"icons","value":1,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I am better acknowledged","question_type":"motivo","question_categoria":"EXT - Estratega","no_analizable":0,"lang":"ES","slide_id":78,"create_at":"2019-02-04T12:36:17.587Z","quizzNum":68,"activeStep":78},{"answer_type":"icons","value":2,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I take an interest in the opinions of others with an open mind, not trying to impose my judgment","question_type":"motivo","question_categoria":"TRA - Integrador","no_analizable":0,"lang":"ES","slide_id":78,"create_at":"2019-02-04T12:36:17.992Z","quizzNum":68,"activeStep":78},{"answer_type":"icons","value":2,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I serve others and improve the work atmosphere","question_type":"motivo","question_categoria":"PRO","no_analizable":1,"lang":"ES","slide_id":78,"create_at":"2019-02-04T12:36:18.355Z","quizzNum":68,"activeStep":78},{"answer_type":"smiles","value":3,"question_title":"You are persistent and organized in your work","question_type":"pregunta","question_dimension":"AUTOGOBIERNO","question_competencia":"Autocontrol","lang":"ES","slide_id":79,"create_at":"2019-02-04T12:36:19.644Z","quizzNum":68,"activeStep":79},{"answer_type":"smiles","value":4,"question_title":"You finish the tasks you start even if difficulties come up","question_type":"pregunta","question_dimension":"AUTOGOBIERNO","question_competencia":"Autocontrol","lang":"ES","slide_id":80,"create_at":"2019-02-04T12:36:20.874Z","quizzNum":68,"activeStep":80},{"answer_type":"smiles","value":4,"question_title":"You do what is necessary in each moment and don’t take any shortcuts","question_type":"pregunta","question_dimension":"AUTOGOBIERNO","question_competencia":"Autocontrol","lang":"ES","slide_id":81,"create_at":"2019-02-04T12:36:22.023Z","quizzNum":68,"activeStep":81},{"answer_type":"icons","value":2,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I make other people’s work easier","question_type":"motivo","question_categoria":"PRO","no_analizable":1,"lang":"ES","slide_id":82,"create_at":"2019-02-04T12:36:23.456Z","quizzNum":68,"activeStep":82},{"answer_type":"icons","value":3,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I feel more satisfied","question_type":"motivo","question_categoria":"INT - Ejecutivo","no_analizable":0,"lang":"ES","slide_id":82,"create_at":"2019-02-04T12:36:23.942Z","quizzNum":68,"activeStep":82},{"answer_type":"icons","value":3,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I appreciate the opinion of others and don’t feel annoyed","question_type":"motivo","question_categoria":"TRA - Integrador","no_analizable":0,"lang":"ES","slide_id":82,"create_at":"2019-02-04T12:36:24.259Z","quizzNum":68,"activeStep":82},{"answer_type":"icons","value":4,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I am better acknowledged","question_type":"motivo","question_categoria":"EXT - Estratega","no_analizable":0,"lang":"ES","slide_id":82,"create_at":"2019-02-04T12:36:24.588Z","quizzNum":68,"activeStep":82},{"answer_type":"smiles","value":4,"question_title":"You react in a balanced way in conflictive situations","question_type":"pregunta","question_dimension":"AUTOGOBIERNO","question_competencia":"Equilibrio Emocional","lang":"ES","slide_id":83,"create_at":"2019-02-04T12:36:25.730Z","quizzNum":68,"activeStep":83},{"answer_type":"smiles","value":2,"question_title":"You use a respectful tone when correcting other people’s mistakes","question_type":"pregunta","question_dimension":"AUTOGOBIERNO","question_competencia":"Equilibrio Emocional","lang":"ES","slide_id":84,"create_at":"2019-02-04T12:36:27.073Z","quizzNum":68,"activeStep":84},{"answer_type":"smiles","value":3,"question_title":"You use a respectful tone when correcting other people’s mistakes","question_type":"pregunta","question_dimension":"AUTOGOBIERNO","question_competencia":"Equilibrio Emocional","lang":"ES","slide_id":84,"create_at":"2019-02-04T12:36:27.615Z","quizzNum":68,"activeStep":84},{"answer_type":"smiles","value":4,"question_title":"You maintain a steady mood without sudden fluctuations when circumstances change","question_type":"pregunta","question_dimension":"AUTOGOBIERNO","question_competencia":"Equilibrio Emocional","lang":"ES","slide_id":85,"create_at":"2019-02-04T12:36:28.885Z","quizzNum":68,"activeStep":85},{"answer_type":"icons","value":2,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I feel more confident and satisfied","question_type":"motivo","question_categoria":"INT - Ejecutivo","no_analizable":0,"lang":"ES","slide_id":86,"create_at":"2019-02-04T12:36:30.353Z","quizzNum":68,"activeStep":86},{"answer_type":"icons","value":3,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I anticipate the impact of my reactions on others and try not to harm them","question_type":"motivo","question_categoria":"TRA - Integrador","no_analizable":0,"lang":"ES","slide_id":86,"create_at":"2019-02-04T12:36:30.786Z","quizzNum":68,"activeStep":86},{"answer_type":"icons","value":4,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I obtain a better reputation","question_type":"motivo","question_categoria":"EXT - Estratega","no_analizable":0,"lang":"ES","slide_id":86,"create_at":"2019-02-04T12:36:31.159Z","quizzNum":68,"activeStep":86},{"answer_type":"icons","value":5,"question":"IN REGARDS TO THE PRIOR 3 QUESTIONS, WHY DO I DO IT?","question_title":"I serve others and improve the work atmosphere","question_type":"motivo","question_categoria":"PRO","no_analizable":1,"lang":"ES","slide_id":86,"create_at":"2019-02-04T12:36:31.622Z","quizzNum":68,"activeStep":86},{"answer_type":"sondeo","question":"Sex","question_title":"Sex","question_type":"select","value_type":"select","require":1,"lang":"ES","value":"Female","slide_id":87,"create_at":"2019-02-04T12:36:43.562Z","quizzNum":68,"activeStep":87},{"answer_type":"sondeo","question":"Age","question_title":"Age","question_type":"select","value_type":"select","require":1,"lang":"ES","value":"20-24 year old","slide_id":87,"create_at":"2019-02-04T12:36:43.565Z","quizzNum":68,"activeStep":87},{"answer_type":"sondeo","question":"Country","question_title":"Country","question_type":"select","value_type":"select","require":1,"lang":"ES","value":"Spain","slide_id":87,"create_at":"2019-02-04T12:36:43.572Z","quizzNum":68,"activeStep":87},{"answer_type":"sondeo","question":"Highest level of studies finished","question_title":"Highest level of studies finished","question_type":"select","value_type":"select","require":1,"lang":"ES","value":"Secondary education","slide_id":87,"create_at":"2019-02-04T12:36:43.574Z","quizzNum":68,"activeStep":87},{"answer_type":"sondeo","question":"Total number of years you have worked until today","question_title":"Total number of years you have worked until today","question_type":"select","value_type":"select","require":1,"lang":"ES","value":"2 or less ","slide_id":87,"create_at":"2019-02-04T12:36:43.578Z","quizzNum":68,"activeStep":87},{"answer_type":"sondeo","question":"Total number of companies you have worked for until today","question_title":"Total number of companies you have worked for until today","question_type":"select","value_type":"select","require":1,"lang":"ES","value":"1 ","slide_id":87,
			"create_at":"2019-02-04T12:36:43.581Z","quizzNum":68,"activeStep":87},{"answer_type":"sondeo","question":"Total number of years you have worked abroad","question_title":"Total number of years you have worked abroad","question_type":"select","value_type":"select","require":1,"lang":"ES","value":"0","slide_id":88,"create_at":"2019-02-04T12:37:11.075Z","quizzNum":68,"activeStep":88},{"answer_type":"sondeo","question":"Current/latest level of responsibility","question_title":"Current/latest level of responsibility","question_type":"select","value_type":"select","require":1,"lang":"ES","value":"Board of Directors","slide_id":88,"create_at":"2019-02-04T12:37:11.078Z","quizzNum":68,"activeStep":88},{"answer_type":"sondeo","question":"Current area of work ","question_title":"Current area of work ","question_type":"select","value_type":"select","require":1,"lang":"ES","value":"Business, Marketing, Sales, Exports","slide_id":88,"create_at":"2019-02-04T12:37:11.079Z","quizzNum":68,"activeStep":88},{"answer_type":"sondeo","question":"Total number of different areas you have worked in until today","question_title":"Total number of different areas you have worked in until today","question_type":"select","value_type":"select","require":1,"lang":"ES","value":"1","slide_id":88,"create_at":"2019-02-04T12:37:11.081Z","quizzNum":68,"activeStep":88},{"answer_type":"sondeo","question":"Indicate which industry best fits your current/latest organization ","question_title":"Indicate which industry best fits your current/latest organization ","question_type":"select","value_type":"select","require":1,"lang":"ES","value":"Central and local administration","slide_id":89,"create_at":"2019-02-04T12:37:38.650Z","quizzNum":68,"activeStep":89},{"answer_type":"sondeo","question":"Total number of different industries you have worked in until today ","question_title":"Total number of different industries you have worked in until today ","question_type":"select","value_type":"select","require":1,"lang":"ES","value":"3","slide_id":89,"create_at":"2019-02-04T12:37:38.652Z","quizzNum":68,"activeStep":89},{"answer_type":"sondeo","question":"Number of people working in your current company","question_title":"Number of people working in your current company","question_type":"select","value_type":"select","require":1,"lang":"ES","value":"Between 50 and 200","slide_id":89,"create_at":"2019-02-04T12:37:38.657Z","quizzNum":68,"activeStep":89},{"answer_type":"sondeo","question":"Do you have people under your responsibility? ","question_title":"Do you have people under your responsibility? ","question_type":"select","value_type":"select","require":1,"lang":"ES","value":"No","slide_id":89,"create_at":"2019-02-04T12:37:38.660Z","quizzNum":68,"activeStep":89},{"answer_type":"sondeo","question":"How many people work under your responsibility? ","question_title":"How many people work under your responsibility? ","question_type":"select","value_type":"select","require":1,"lang":"ES","value":"Under 10","slide_id":89,"create_at":"2019-02-04T12:37:38.662Z","quizzNum":68,"activeStep":89},{"answer_type":"sondeo","question":"Marital status ","question_title":"Marital status ","question_type":"select","value_type":"select","require":1,"lang":"ES","value":"Separated-Divorced ","slide_id":90,"create_at":"2019-02-04T12:37:44.049Z","quizzNum":68,"activeStep":90},{"answer_type":"sondeo","question":"Number of children","question_title":"Number of children","question_type":"select","value_type":"select","require":1,"lang":"ES","value":"2","slide_id":90,"create_at":"2019-02-04T12:37:44.050Z","quizzNum":68,"activeStep":90},{"answer_type":"sondeo","question":"Total number of daily hours dedicated to taking care of your family (home, partner, children, parents…)","question_title":"Total number of daily hours dedicated to taking care of your family (home, partner, children, parents…)","question_type":"select","value_type":"select","require":1,"lang":"ES","value":"2","slide_id":90,"create_at":"2019-02-04T12:37:44.053Z","quizzNum":68,"activeStep":90},{"answer_type":"sondeo","question":"Total number of daily hours dedicated to your personal care","question_title":"Total number of daily hours dedicated to your personal care","question_type":"select","value_type":"select","require":1,"lang":"ES","value":"1","slide_id":90,"create_at":"2019-02-04T12:37:44.055Z","quizzNum":68,"activeStep":90},{"answer_type":"sondeo","question":"Total number of anual hours dedicated to training","question_title":"Total number of anual hours dedicated to training","question_type":"select","value_type":"select","require":1,"lang":"ES","value":"Between 11 and 30 ","slide_id":90,"create_at":"2019-02-04T12:37:44.060Z","quizzNum":68,"activeStep":90}],"quizz_id":16}],"id":"iese-autoevaluado-en","talentapp":"1","ev":"47","a":"fran@3fera.com"}';
		//talentapp=1&ev=47&a=fran@3fera.com

		$request = [
			"talentapp" => 1,
			"ev" => 47,
			"a" => "fran@3fera.com"
		];
		$this->simSave($test,$request);

			exit;
	    
	    $results = Answer::where("question_type","=","email")->get();
	    foreach($results as $answer) {
		    $this->info($answer->value);
			$answer->setEmail();
		}
		exit;    
	    $strings = [
		    "promotores" => [
			    				"name" => 'PROMOTORES',
			    				"desc" => 'Clientes más que satisfechos.  Son fieles, hablan bien y recomiendan nuestra empresa.'
		    				],	
		    "pasivos" => [
			    				"name" => 'PASIVOS',
			    				"desc" => 'Clientes que pueden irse a la competencia.   Ni satisfechos ni insatisfechos.'
		    				],	
		    "detractores" => [
			    				"name" => 'DETRACTORES',
			    				"desc" => 'Clientes insatisfechos.  No volverán y en cuanto tengan ocasión, hablarán mal de nosotros.'
		    				],	
	    ];
	    
	    
	    foreach($results as $result) {
		    $client_id = $result->client_id;
		    
		    if(!$client_id) continue;
		    
		    if(!filter_var($result->email, FILTER_VALIDATE_EMAIL)) continue;
		    //check if exists
		    $subscriber = Subscriber::where("email","=",$result->email)->where("client_id","=",$client_id)->first();
		    $this->info($result->email);
		    if(isset($subscriber)) continue;
		    
		    $this->info($result->email);
		    
		    $subscriber = new Subscriber();
		    $subscriber->client_id 	= $client_id;
		    $subscriber->email 		= $result->email;
		    $subscriber->result_id 	= $result->id;
		    
			$subscriber->save();
			
			
			
			//Asign in list
			$typeSatisfaccion = $result->getSatisfaccion();
			if($typeSatisfaccion) {
				$this->info($typeSatisfaccion);
				$list = SubscriberList::where("code","=",$typeSatisfaccion)->where("client_id","=",$client_id)->first();
				//Comprobamos que la lista exista, sino la creamos
				if(!isset($list)) {
					$list = new SubscriberList();
					$list->code 		= $typeSatisfaccion;
					$list->name 		= $typeSatisfaccion;
					$list->client_id 	= $client_id;
					$list->name 		= $strings[$typeSatisfaccion]['name'];
					$list->description 	= $strings[$typeSatisfaccion]['desc'];
					$list->save();
				}
				$list->subscribers()->add($subscriber);
			}	
			 
	    }
	    return;
 
	    
	    $answer = new Answer();
	    $answer->result_id = 447;
	    $answer->slide_id = 180;
	    $answer->lang = 'CA';
	    $answer->question_number = 1;
	    $answer->question_title = '¿Recomendaría nuestra tienda a un amigo o familiar?';
	    $answer->question_type = 'email';
	    $answer->answer_type = 'email';
	    $answer->value_type = 0;
	    $answer->value = 'tjane@addvaloraglobal.com';
	    $answer->save();
	    $answer->delete();
	    
	    return;
	    
	}
	function randomPassword() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}
    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {	
		$users = UserBase::all();
		foreach($users as $user) {
				echo $user->id."\n";
				$data = [
					"name" => $user->name,
					"email" => $user->email,
				];
				\Mail::send("cofidis.welcome", $data, function($message) use ($data)
				{
					$message->to($data['email'], $data['name']);
					//$message->to("fgomezserna@gmail.com", "soy el mejor");
					$message->from("talentup@taket.es");
				});
		}
		exit;
		exit;
		$fila=0;
		$handle = fopen("Fichero 7 febrero Taket para Cookie (4 incorporaciones).csv",'r');
		ini_set('auto_detect_line_endings',TRUE);
		while ( ($data = fgetcsv($handle,0,";") ) !== FALSE ) {
			$data = array_map("utf8_encode", $data); 
			//process
			if($fila == 0) { $fila++;continue; }
			$password = $this->randomPassword();
			
			$user = Auth::register([
				'name' => $data[1],
				'email' => $data[3],
				'password' => $password,
				'password_confirmation' => $password,
				'company' => $data[24],
				'mobile' => $data[0],
				'phone' => $data[4],
			], true);
	
			$data = [
				"name" => $user->name,
				"user" => $user->email,
				"email" => $user->email,
				"password" => $password
			];
			
			\Mail::send("cofidis.welcome", $data, function($message) use ($data)
			{
				$message->to($data['email'], $data['name']);
				//$message->to("fgomezserna@gmail.com", "soy el mejor");
				$message->from("talentup@taket.es");
			});
			print_r($data);
			//break;
			$fila++;
		}
		ini_set('auto_detect_line_endings',FALSE);
		exit;
		$usersCompleted = UserBase::leftjoin("tresfera_taketsystem_progresos","user_id","=","users.id")
							->where("quiz","cofidis-competencia2")
							->where("pag","27")->get()->lists("email","user_id");
		$users = UserBase::all();
		$i = 0;
		foreach($users as $user) {
			if(!in_array($user->email,$usersCompleted)) {
				echo $user->id."\n";
				$data = [
					"name" => $user->name,
					"email" => $user->email,
				];
				\Mail::send("cofidis:recordatorio", $data, function($message) use ($data)
				{
					$message->to($data['email'], $data['name']);
					//$message->to("fgomezserna@gmail.com", "soy el mejor");
					$message->from("talentup@taket.es");
				});
				//break;
				$i++;
			} 
		}
		echo "num: ".$i."\n";
		exit;
		//añadir nuevo campo a usuarios
	
		$users = UserBase::all();
		foreach($users as $user) {
				echo $user->id."\n";
				$data = [
					"name" => $user->name,
					"email" => $user->email,
				];
				\Mail::send("cofidis.welcome", $data, function($message) use ($data)
				{
					$message->to($data['email'], $data['name']);
					//$message->to("fgomezserna@gmail.com", "soy el mejor");
					$message->from("talentup@taket.es");
				});
		}
		exit;
		$data = [];
		$data[1] = 'CAMACHO GOMES, CRISTINA';
		$data[3] = 'cristina.camachogomes@cofidis.es';
		$data[24] = 'ATREVIMIENTO';
		$data[0] = '81006163';
		$data[4] = '';
		$password = $this->randomPassword();
		print_r($data);
		$user = Auth::register([
			'name' => $data[1],
			'email' => $data[3],
			'password' => $password,
			'password_confirmation' => $password,
			'company' => $data[24],
			'mobile' => $data[0],
			'phone' => $data[4],
		], true);

		$data = [
			"name" => $user->name,
			"user" => $user->email,
			"email" => $user->email,
			"password" => $password
		];
		
		\Mail::send("cofidis.welcome", $data, function($message) use ($data)
		{
			$message->to($data['email'], $data['name']);
			//$message->to("fgomezserna@gmail.com", "soy el mejor");
			$message->from("talentup@taket.es");
		});
		exit;
		
		
		exit;
		
		$fila=0;
		$handle = fopen("Fichero Definitivo Equipos Talent UP Tacket 24 enero 2020.csv",'r');
		ini_set('auto_detect_line_endings',TRUE);
		while ( ($data = fgetcsv($handle,0,";") ) !== FALSE ) {
			$data = array_map("utf8_encode", $data); 
			//process
			if($fila == 0) { $fila++;continue; }
			/*$password = $this->randomPassword();
			$data1 = [
				'name' => $data[1],
				'email' => $data[3],
				'password' => $password,
				'password_confirmation' => $password,
				'company' => $data[23],
				'mobile' => $data[0],
				'phone' => $data[4],
			];
			print_r($data1);
			continue;*/
			$password = $this->randomPassword();
			print_r($data);
			$user = Auth::register([
				'name' => $data[1],
				'email' => $data[3],
				'password' => $password,
				'password_confirmation' => $password,
				'company' => $data[24],
				'mobile' => $data[0],
				'phone' => $data[4],
			], true);

			$data = [
                "name" => $user->name,
                "user" => $user->email,
                "email" => $user->email,
                "password" => $password
            ];
			
            \Mail::send("cofidis.welcome", $data, function($message) use ($data)
            {
				$message->to($data['email'], $data['name']);
				//$message->to("fgomezserna@gmail.com", "soy el mejor");
                $message->from("talentup@taket.es");
			});
			//break;
			$fila++;
		}
		ini_set('auto_detect_line_endings',FALSE);
		exit;
		$users = [
			"Carlos Andreu"=>"carlos.andreu@cookiebox.es",
			"Román Zabal"=>"roman.zabal@cookiebox.es",
			"Oscar García"=>"oscar.garciap@cookiebox.es",
			"Marta Sala"=>"marta.sala@cookiebox.es",
			"Cristina Bieto"=>"cristina.bieto@cookiebox.es",
			"Sonia Martínez"=>"sonia.martinez@cookiebox.es",
			"Helena Navarro"=>"navarro@cookiebox.es",
			"Ana Perez"=>"ana.perez@cookiebox.es",
			"Mónica Espada"=>"monica.espada@cookiebox.es",
			"Adrián Gallardo"=>"adrian.gallardo@cookiebox.es",
			"Rocío Ortiz"=>"rocio.ortiz@cookiebox.es",
			"Alexandra Estruch"=>"alexandra.estruch@cookiebox.es",
			"Alba González"=>"alba.gonzalez@cookiebox.es",
			"Carla Urenda"=>"carla.urenda@cookiebox.es",
			"Javier Vicente"=>"javier.vicente@cookiebox.es",
			"Fran Gómez"=>"fran.gomez@cookiebox.es",
			"Miriam Andreu"=>"miriam.andreu@cookiebox.es",
			"Bart Slot"=>"bart.slot@cookiebox.es",
			"Fernando Pajares"=>"fernando.pajares@cookiebox.es",
			"Marina Parra"=>"marina.parra@cookiebox.es",
			"Fran Gómez"=>"fran.gomez@cookiebox.es",
			"Alexandra Estruch"=>"alexandra.estruch@cookiebox.es",
		];
		foreach($users as $name=>$email) {
			$user = Auth::register([
				'name' => $name,
				'email' => $email,
				'password' => 'cookie2020',
				'password_confirmation' => 'cookie2020',
			], true);
			echo $email."\n";
			$data = [
                "name" => $name,
                "user" => $email,
                "email" => $email,
                "password" => 'cookie2020'
            ];
    
            \Mail::send("cofidis.welcome", $data, function($message) use ($data)
            {
                $message->to($data['email'], $data['name']);
                $message->from("talentup@taket.es");
            });
		}
		exit;
		
		
		//english
		$slideSource = Slide::find(578);
		$syntax_data = $slideSource->syntax_data;
		$countries = [];
		foreach($syntax_data['selects'] as $data) {
			if(isset($data["segmentacion"]))
			if($data["segmentacion"] == "Country") 
				$countries[] = ["title"=>$data["option"],"code"=>$data["option"]];
		}
		print_r(json_encode($countries));
		exit;
		exit;
		//spanish
		$slideSource = Slide::find(289);
		$slideDest = Slide::find(776);
		//dd($slideDest->campos);
		$countries = [];
		$syntax_data = $slideSource->syntax_data;
	/*	foreach($syntax_data['selects'] as $data) {
			if(isset($data["segmentacion"]))
			if($data["segmentacion"] == "País") 
			//$slideDest->campos[5]
			$countries[] = ["title"=>$data["option"],"code"=>$data["option"]];
		}*/
		$campos = $slideDest->campos;
		$campos[5]['segmentacion'] = $countries;
		$campos[6]['segmentacion'] = $countries;
		$slideDest->campos = $campos;
		$slideDest->save();
		exit;
		$sql = "SELECT a.created_at , result_id, r.evaluacion_id, r.duplicated FROM tresfera_taketsystem_results as r JOIN tresfera_taketsystem_answers as a ON a.result_id = r.id
		WHERE email = 'aestenos@ucsp.edu.pe' and quiz_id = 11 GROUP BY result_id ORDER BY a.created_at";
		$results = DB::select($sql);
		$results2 = array();
		$results3 = array();
		foreach($results as $result) {
				$results2[$result->created_at][$result->duplicated] = $result->result_id;
		}
		print_r($results2);
		//dd($result);
		exit;
		$dimensiones = [
			"C1" => "Iniciativa y Proactividad / Organización",
			"C2" => "Orientación a resultados / Visión estratégica",
			"C3" => "Adaptación al cambio / Agilidad",
			"C4" => "Gestión del estrés / Tolerancia a la frustración /  Auto-motivación",
			"C5" => "Trabajo en equipo / Cooperación",
			"C6" => "Comunicación  / Aprendizaje colaborativo"
		  ];
		  $competencias = [
			  "A", "B"
		  ];
		  $results = \Tresfera\Skillyouup\Models\Result::
							  whereRaw(\DB::raw("DATE(created_at) = '2019-06-06'"))
							  ->get();
							  
		  foreach($results as $result) {
			  echo $result->email."\n";
			foreach($dimensiones as $code=>$dimension) {
				foreach($competencias as $competencia) {
						$question_id = $code.$competencia;
						echo $question_id;
						$answer = new \Tresfera\Skillyouup\Models\Answer();
						$answer->result_id = $result->id;
						$answer->slide_id = 6;
						$answer->question_id = $question_id;
						$answer->value = rand(2,4);
						$answer->value_type = 'segmentacion';
						$answer->answer_type = 'range';
						$answer->lang = 'ES';
						echo " ".$answer->value."\n";

						$answer->save();
					}
				}
			}
		  
		exit;
	   $this->test();
	   exit;
	    $this->info('Leyendo logs...');
	    
	    $logs = DeviceLog::where("device_id","=","74")->where("action","=","Tresfera\Taketsystem\Classes\Http\Controllers\API\Quizzes@save")->get();
	   
	    foreach($logs as $log) {
		    $data = explode("\n", $log->request);
		   /* echo "\n";
		    print_r($data[5]);
		    echo "\n"; */
		    $request = json_decode($data[5]);
		    		    
		    $this->save($request,$log);
	    }  
        $this->output->writeln('Fin');
	
		 exit;
		 
	   
		$debug = true;
		$username = '34666554433';   // Telephone number including the country code without '+' or '00'.
		
		// Create an instance of Registration.
		$w = new Registration($username, $debug);
		$w->codeRequest('sms');
		dd($w);
		exit;
	   
	    
	   $quiz = Quiz::with('results')->find(63); 
	   dd($quiz->results);
	   $new_quiz = $quiz->replicate();
	   $new_quiz->client_id = 20;
	   $new_quiz->save();
	   
	   foreach($quiz->results as $result) {
		   $result->client_id = 20;
		   $result->quiz_id = $new_quiz->id;
		   $result->save();
		   
		   dd($result);
	   }
	   
	   
	   exit;
    
    }
	
	public function save($results,$log) {
		if (is_array($results) && !empty($results)) {

            // Results
            foreach ($results as $result_data) {
	            $this->info('New Result...');
				if(!isset($result_data->quizz_id)) continue;
                // Create result
                $result = new Result();
                $result->quiz()->associate(Quiz::findOrFail($result_data->quizz_id));
                $result->device_id = 74;
                $result->save();
                $result->client_id = $result->device->client_id;
                
                $result->save();
				
				$dataAnswered = [
					'sex' => 0,
					'age' => 0
				];
				$lang = 'ES';
                // Answers
                foreach ($result_data->answers as $answer_data) {
					
                    // Create answer
                    $answer = new Answer();
                    $slide = Slide::find($answer_data->slide_id);
                    if(isset($slide))
                    	$answer->slide()->associate(Slide::find($answer_data->slide_id));
                    $answer->result()->associate($result);
                    
                    if(isset($answer_data->value))
                    	$answer->value           = $answer_data->value;
                    if(isset($answer_data->question_number))
                    	$answer->question_number = $answer_data->question_number;
                    if(isset($answer_data->question_title))
                    	$answer->question_title  = $answer_data->question_title;
                    if(isset($answer_data->question_type))
                    	$answer->question_type   = $answer_data->question_type;
                    if(isset($answer_data->value_type))
                    	$answer->value_type      = $answer_data->value_type;
                    if(isset($answer_data->answer_type))
                    	$answer->answer_type     = $answer_data->answer_type;
                    if(isset($answer_data->question))
                    	$answer->question     	= $answer_data->question;
                    if(isset($answer_data->lang)) {
	                    $lang 				= $answer_data->lang;
	                    $answer->lang     	= $answer_data->lang; 
                    }
                    	 
                    if(isset($answer_data->question_id))
                    	$answer->question_id     	= $answer_data->question_id;                    	
                    $answer->created_at      = date('Y-m-d H:i:s', strtotime($answer_data->create_at));
                    
                    
                    try {
	                    $answer->save();
                    }catch (\Illuminate\Database\QueryException $e) {

					}
					
					switch($answer->question_type) {
						case 'sex':
							$result->sex = $answer->value;
							$this->info('sex: '.$answer->value);
							$dataAnswered[$answer->question_type] = 1;
						break;
						case 'age':
							$result->age = $answer->value;
							$this->info('age: '.$answer->value);
							$dataAnswered[$answer->question_type] = 1;
						break;
						case 'email':
							$result->email = $answer->value;
							$this->info('email: '.$answer->value);
						break;
						case 'cp':
							$result->cp 			= $answer->value;
							$this->info('cp: '.$answer->value);
							$citycp = Citycp::where("cod_postal","=",$answer->value)->first();
							if(isset($citycp)) {
								$result->citycp_id 		= $citycp->id;
								$result->regioncp_id 	= $citycp->region_id;	
								$result->citycp_name	= $citycp->name;
							}
							
						break;
					}
					
                }
                //rellenamos respuestas obligatorias para los stats si no se ha hecho antes
				foreach($dataAnswered as $question_type => $value) { 
					if($value==0) {
						$this->info('override: '.$question_type);
						$answer = new Answer();
						$answer->value = 0;
						$answer->value_type = 0;
						$answer->question_type = $question_type;
						$answer->result_id = $result->id;
						$answer->answer_type = $question_type;
						$answer->lang = $lang;
						$answer->save();
					}
				}
				$result->created_at      = date('Y-m-d H:i:s', strtotime($answer_data->create_at));
                $result->save();
            }
        }
	}
   
}
?>