<?php

namespace Tresfera\Taketsystem\Classes\Http\Controllers\API;

use Tresfera\Taketsystem\Classes\Http\Controllers\API;
use Request;
use Tresfera\Taketsystem\Models\Quiz;
use Tresfera\Taketsystem\Models\Answer;
use Tresfera\Taketsystem\Models\Result;
use Tresfera\Taketsystem\Models\Slide;
use Tresfera\Taketsystem\Models\Invitacion;
use Tresfera\Taketsystem\Models\QuizMulti;
use Tresfera\Devices\Models\Citycp;
use Tresfera\Devices\Models\Device;

class Quizzes extends API
{
    /**
     * Instantiate a new API instance.
     */
    public function __construct()
    {
		// Auth
        $this->middleware('Tresfera\Taketsystem\Classes\Http\Middleware\API\Auth');
    }

    /**
     * List quizzes.
     *
     * @return Response
     */
    public function index()
    {
        // Auth
        $this->tokenAuth();

       /* if( in_array($this->device->id,[157]))
          \App::abort(403, 'MAC is not present.');*/

        // Get active quizzes
        $quizzes = $this->device->quizzes()->with('slides')->orderBy("id","DESC")->get();

        //FIX MULTIQUIZ
	    //1. Comprobamos que la encuesta sea multiple
			$is_multiquiz = $quizzes[0]->slides()->where("page","=","slides/multiquiz")->count();
    	if($is_multiquiz > 0) {
		    //2. Buscamos el ultimo resultado
				//TODO: Falta filtrar por dispositivo
				$this->getDevice($quizzes[0]->id);

				$date = new \DateTime;
				$date->modify('-10 seconds');
				$formatted_date = $date->format('Y-m-d H:i:s');

	    	$lastResult = Result::where("device_id","=",$this->device->id)->where('created_at','>=',$formatted_date)->orderBy("id","DESC")->first();

	    	if(isset($lastResult)) {

			    //3. Buscamos que ha seleccionado para poder cargar el cuestionario correcto
		    	$answerMultiQuiz = $lastResult->answers()->where("question_type", "=", "multiquiz")->first();

		    	if(isset($answerMultiQuiz)) {

            $multiquiz = \Tresfera\Taketsystem\Models\QuizMulti::find($answerMultiQuiz->value);
  					$quizzes = Quiz::where("id","=",$multiquiz->quiz_id)->with('slidesMulti')->get();
  					$lang = $answerMultiQuiz->lang;

  					//quitamos idiomas son seleccionados
  					foreach($quizzes[0]->slidesMulti as $key => $slide) {
  						$views = $slide->view;
  						$viewsGood = [];
  						foreach($views as $l => $view) {
  							//echo $slide->name." ".$l."<br>\n";
  							//print_r($view);

  							if($l=="views") {

  								foreach($view[0] as $l1 => $view1) {

  									if($lang==$l1) {
  										$viewsGood[$l] = ["views" => ['ES'=> str_replace("'","&#8216;",$view1)]];
  										$viewsGood[$l] = ["views" => ['ES'=> $view1]];
  									}
  								}
  								//$viewsGood[$l] = $view;
  							} else {
  								if($lang!=$l)
  									unset($views[$l]);
  								else {
  									unset($views[$l]);
  									$viewsGood['ES'] = str_replace("'","&#8216;",$view);
  									$viewsGood['ES'] = $view;

  								}
  							}

  						}
  						//$views['ES'] = str_replace("'","&#8216;",$viewGood);
  						$quizzes[0]->slidesMulti[$key]->view = $viewsGood;
					 }
				  }
			  }

	    }

        // Response
        return $this->response(['quizzes' => $quizzes]);
    }

	/**
     * List quizzes.
     *
     * @return Response
     */
    public function get()
    {
			$this->tokenAuth();

		/*if($this->device->devel != 1 && Request::get('token') != 'hd79S1PFMISQAiSV6bAQmbgBCwwA8Oy1') {
			return $this->index();
		}*/
			//FIX cambiar datos de una pantalla en funcion del equipo
			if(Request::get('quiz_md5') == 'skillyouup' and post('ev')) {
				//$quiz = Quiz::where("md5","skillyouup")->first();
				$slide = Slide::find(558);
				$campos = $slide->campos;
				$segmentacion = [];
				$segmentacion_original = $campos[0]['segmentacion'];
				$equipo = \Tresfera\Skillyouup\Models\Equipo::find(post('ev'));
				foreach($equipo->players as $player) {
					$segmentacion[] = [
						"title" => $player['name'],
						"code" => $player['name']
					];
				}
				$campos[0]['segmentacion'] = $segmentacion;
				$slide->campos = $campos; 
				$slide->save();
				$slide = Slide::find(559);
				$campos = $slide->campos;
				$campos[0]['segmentacion'] = $segmentacion;
				$slide->campos = $campos; 
				$slide->save();

			}
			if(Request::get('quiz_md5') == 'skillyouup-en' and post('ev')) {
				//$quiz = Quiz::where("md5","skillyouup")->first();
				$slide = Slide::find(1167);
				$campos = $slide->campos;
				$segmentacion = [];
				$segmentacion_original = $campos[0]['segmentacion'];
				$equipo = \Tresfera\Skillyouup\Models\Equipo::find(post('ev'));
				foreach($equipo->players as $player) {
					$segmentacion[] = [
						"title" => $player['name'],
						"code" => $player['name']
					];
				}
				$campos[0]['segmentacion'] = $segmentacion;
				$slide->campos = $campos; 
				$slide->save();
				$slide = Slide::find(1168);
				$campos = $slide->campos;
				$campos[0]['segmentacion'] = $segmentacion;
				$slide->campos = $campos; 
				$slide->save();

			}
			if(Request::get('quiz_md5') == 'buildyouup' and post('ev')) {
				//$quiz = Quiz::where("md5","skillyouup")->first();
				$slide = Slide::find(963);
				$campos = $slide->campos;
				$segmentacion = [];
				$segmentacion_original = $campos[0]['segmentacion'];
				$equipo = \Tresfera\Buildyouup\Models\Equipo::find(post('ev'));
				foreach($equipo->players as $player) {
					$segmentacion[] = [
						"title" => $player['name'],
						"code" => $player['name']
					];
				}
				$campos[0]['segmentacion'] = $segmentacion;
				$slide->campos = $campos; 
				$slide->save();
				$slide = Slide::find(963);
				$campos = $slide->campos;
				$campos[0]['segmentacion'] = $segmentacion;
				$slide->campos = $campos; 
				$slide->save();

			}
        // Get active quizzes
        if(!Request::get('quiz_id')) {
        	if(Request::get('token') == 'hd79S1PFMISQAiSV6bAQmbgBCwwA8Oy1')
		        $quizzes = Quiz::where("md5", "=", Request::get('quiz_md5'))->with('slidesQuiz')->get();
		    	else
        		$quizzes = Quiz::where("md5", "=", Request::get('quiz_md5'))->with('slidesQuiz')->get();
        }
        else {
					$quizzes = Quiz::where("id", "=", Request::get('quiz_id'))->with('slidesQuiz')->get();
				}
			//FIX cambiar datos de una pantalla en funcion del equipo
			if(Request::get('quiz_md5') == 'skillyouup' and post('ev')) {
				//$quiz = Quiz::where("md5","skillyouup")->first();
				//$slide = 
				$slide = Slide::find(558);
				$campos = $slide->campos;
				$campos[0]['segmentacion'] = $segmentacion;
				$slide->campos = $campos; 
				$slide->save();
				$slide = Slide::find(559);
				$campos = $slide->campos;
				$campos[0]['segmentacion'] = $segmentacion;
				$slide->campos = $campos; 
				$slide->save();
				$quizzes = Quiz::where("md5", "=", Request::get('quiz_md5'))->with('slidesQuiz')->get();
			}
			if(Request::get('quiz_md5') == 'skillyouup-en' and post('ev')) {
				//$quiz = Quiz::where("md5","skillyouup")->first();
				//$slide = 
				$slide = Slide::find(1167);
				$campos = $slide->campos;
				$campos[0]['segmentacion'] = $segmentacion;
				$slide->campos = $campos; 
				$slide->save();
				$slide = Slide::find(1168);
				$campos = $slide->campos;
				$campos[0]['segmentacion'] = $segmentacion;
				$slide->campos = $campos; 
				$slide->save();
				$quizzes = Quiz::where("md5", "=", Request::get('quiz_md5'))->with('slidesQuiz')->get();
			}
			if(Request::get('quiz_md5') == 'buildyouup' and post('ev')) {
				//$quiz = Quiz::where("md5","skillyouup")->first();
				//$slide = 
				$slide = Slide::find(964);
				$campos = $slide->campos;
				$campos[0]['segmentacion'] = $segmentacion;
				$slide->campos = $campos; 
				$slide->save();
				$campos = $slide->campos;
				$campos[0]['segmentacion'] = $segmentacion;
				$slide->campos = $campos; 
				$slide->save();
			}
			//FIX MULTIQUIZ
	    //1. Comprobamos que la encuesta sea multiple
			$is_multiquiz = $quizzes[0]->slides()->where("page","=","slides/multiquiz")->count();
    	if($is_multiquiz > 0) {
		    //2. Buscamos el ultimo resultado
			//TODO: Falta filtrar por dispositivo
			$this->getDevice($quizzes[0]->id);

			$date = new \DateTime;
			$date->modify('-10 seconds');
			$formatted_date = $date->format('Y-m-d H:i:s');

	    	$lastResult = Result::where("device_id","=",$this->device->id)->where('created_at','>=',$formatted_date)->orderBy("id","DESC")->first();

	    	if(isset($lastResult)) {

			    //3. Buscamos que ha seleccionado para poder cargar el cuestionario correcto
		    	$answerMultiQuiz = $lastResult->answers()->where("question_type", "=", "multiquiz")->first();

          if(isset($answerMultiQuiz)) {

            $multiquiz = \Tresfera\Taketsystem\Models\QuizMulti::find($answerMultiQuiz->value);
            $quizzes = Quiz::where("id","=",$multiquiz->quiz_id)->with('slidesMulti')->get();

					$lang = $answerMultiQuiz->lang;

					//quitamos idiomas son seleccionados
					/*foreach($quizzes[0]->slidesMulti as $key => $slide) {
						$views = $slide->view;
						$viewsGood = [];
						foreach($views as $l => $view) {
							//echo $slide->name." ".$l."<br>\n";
							//print_r($view);
							if($l=="views") {
								foreach($view[0] as $l1 => $view1) {
									if($lang==$l1) {
										$viewsGood[$l] = ["views" => ['ES'=> str_replace("'","&#8216;",$view1)]];
									}
								}
								//$viewsGood[$l] = $view;
							} else {
								if($lang!=$l)
									unset($views[$l]);
								else {
									unset($views[$l]);
									$viewsGood['ES'] = str_replace("'","&#8216;",$view);

								}
							}

						}

						//$views['ES'] = str_replace("'","&#8216;",$viewGood);
						$quizzes[0]->slidesMulti[$key]->view = $viewsGood;


					}*/
				}
			}
	    } else {

        if(post('lang') != "") {
          $lang = post('lang');
          foreach($quizzes as $quiz) {
            foreach($quiz->slidesMulti  as $key => $slide) {
  						$views = $slide->view;
  						$viewsGood = [];
  						foreach($views as $l => $view) {
  							//echo $slide->name." ".$l."<br>\n";
  							//print_r($view);

  							if($l=="views") {
  								foreach($view[0] as $l1 => $view1) {
  									if($lang==$l1) {
  										$viewsGood[$l] = ["views" => ['ES'=> str_replace("'","&#8216;",$view1)]];
  										$viewsGood[$l] = ["views" => ['ES'=> $view1]];
  									}
  								}
  								//$viewsGood[$l] = $view;
  							} else {
  								if($lang!=$l)
  									unset($views[$l]);
  								else {
  									unset($views[$l]);
  									$viewsGood['ES'] = str_replace("'","&#8216;",$view);
  									$viewsGood['ES'] = $view;

  								}
  							}

  						}
  						//$views['ES'] = str_replace("'","&#8216;",$viewGood);
  						$quiz->slidesMulti[$key]->view = $viewsGood;
            }
          }
        }
      }

      // Response
      return $this->response(['quizzes' => $quizzes]);
    }

	/**
     * List quizzes.
     *
     * @return Response
     */
    public function all()
    {
        // Auth
        $this->tokenAuth();

        // Get active quizzes
        $quizzes = Quiz::AllClient()->get();

        // Response
        return $this->response(['quizzes' => $quizzes]);
    }

    /**
     * Save quizzes results.
     *
     * @return Response
     */
    public function save()
    {
				
        // Auth
        $this->tokenAuth();
				$post = Request::all();

				// Results
        $results = Request::get('results');
				//Developpers tablets
				if(isset($this->device->id))
				if($this->device->devel == 1) {
					// return $this->response(array(),$results);
				}
				//Fix to web device
				if(isset($results[0]['quizz_id']))
					$this->getDevice($results[0]['quizz_id']);
				elseif(isset($results[1]['quizz_id']))
					$this->getDevice($results[1]['quizz_id']);
				else
					if(isset($results['NaN']))
						$this->getDevice($results['NaN']['quizz_id']);
						elseif(isset($results['undefined']))
						$this->getDevice($results['undefined']['quizz_id']);

        if (is_array($results) && !empty($results)) {

            // Results
            foreach ($results as $id_eva => $result_data) {
							$date1 = time();
						//	trace_log("Empezamos a guardar el cuestionario");
	            //echo "<pre>"; print_r($result_data); echo "</pre>";
							if(!isset($result_data['quizz_id'])) continue;
							// Create result
			
							if(isset($post['talent'])) {
								$result = new \Tresfera\Talent\Models\Result();
							} elseif(isset($post['skillyouup'])) {
								$result = new \Tresfera\Skillyouup\Models\Result();
							} elseif(isset($post['buildyouup'])) {
								$result = new \Tresfera\Buildyouup\Models\Result();
							} else {
								$result = new Result();
							}
							$result->quiz()->associate(Quiz::findOrFail($result_data['quizz_id']));
							$result->device()->associate($this->device);
							//$result->client_id = $this->device->client_id;

							/* Invitacion id */
							$invitacion_md5 = Request::get('invitacion');

							if($invitacion_md5) {
								$invitacion = Invitacion::where("md5","=",$invitacion_md5)->first();

								if(isset($invitacion))
									$result->invitacion_id = $invitacion->id;
							}

							$result->save();

							$dataAnswered = [
								/*'sex' => 0,
								'age' => 0*/
							];
							$lang = 'ES';

							//procesamos info
							$no_segmentacion = [
								"id", "lang", "token", 'results', 'version'
							];
							$post = Request::all();
							if(isset($post['skillyouup'])) {
								$evaluacion_id = $post['ev'];
								$equipo = \Tresfera\Skillyouup\Models\Equipo::find($id_eva);
								if(isset($equipo->id)) {
									$result->evaluacion_id = $equipo->id;
									$result->save();
								}
							} elseif(isset($post['buildyouup'])) {
								$evaluacion_id = $post['ev'];
								$equipo = \Tresfera\Buildyouup\Models\Equipo::find($id_eva);
								if(isset($equipo->id)) {
									$result->evaluacion_id = $equipo->id;
									$result->save();
								}
							} elseif(isset($post['talentapp']) || isset($post['talent'])) {
								$evaluacion_id = $id_eva;
								if(isset($post['a']))
									$auto = $post['a'];
								if(isset($post['e']))
									$eva = $post['e'];
								if(isset($post['t']))
									$type = $post['t'];
								
								if(!isset($type)) {
									$type = "autoevaluado";
								}
								if(isset($post['talent'])) {
									$evaluacion = \Tresfera\Talent\Models\Evaluacion::find($evaluacion_id);
								} else {
									$evaluacion = \Tresfera\TalentApp\Models\Evaluacion::find($evaluacion_id);
								}
		
								if(isset($evaluacion->id)) {
									if(isset($post['talentapp'])) {
										if(isset($eva)) {
											$result->is_evaluacion	= 1;
											$result->email = $eva;
											$result->rol = $type;
										}
										elseif(isset($auto)) {
											$result->is_autoevaluacion	= 1;
											$result->email = $auto;
											$result->rol = $type;
										}
									} else {
										$result->email = $eva;
									}
		
									$result->evaluacion_id = $evaluacion->id;
									$result->save();
		
									//comprobamos si ya ha contestado esta evaluacion
									//si es asi, las otras las marcamos como eliminadas
									
		
									if(isset($post['talent'])) {
										\Tresfera\Talent\Models\Result::where("evaluacion_id",$evaluacion->id)
											->where("id","<>",$result->id)
											->where("email",$result->email)
											->update(["duplicated"=>$result->id]);
									} else {
										Result::where("evaluacion_id",$evaluacion->id)
										->where("id","<>",$result->id)
										->where("email",$result->email)
										->update(["duplicated"=>$result->id]);
									
										//Marcar la evaluacion que toca como completada
		
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
		
										$evaluacion->save();
									}
								}
								//buscamos 
							} else
									foreach(Request::all() as $name => $value) {
										if(in_array($name,$no_segmentacion)) continue;
										$values = explode(",",$value);
										foreach($values as $val) {
											if(isset($post['talent'])) {
												$answer = new \Tresfera\Talent\Models\Answer();
											} else {
												$answer = new Answer();
											}
											
											$answer->value = $val;
											$answer->value_type = 0;
											$answer->question_type = "segmentacion";

											//buscamos el question title
										/*	$segmentacion = \Tresfera\Taketsystem\Models\Segmentacion::where("client_id",$result->client_id)->where("slug",$name)->first();
											if(isset($segmentacion->slug)) {
												$answer->question_title = $segmentacion->name;
											}*/
											$answer->result_id = $result->id;
											$answer->answer_type = $name;
											$answer->lang = $lang;
											$answer->save();
										}
									}
                // Answers
            foreach ($result_data['answers'] as $answer_data) {
							$date_2_1 = time();
							//trace_log("Empezamos a guardar el answer");
							// Create answer
							if(isset($post['talent'])) {
								$answer = new \Tresfera\Talent\Models\Answer();
							} elseif(isset($post['skillyouup'])) {
								$answer = new \Tresfera\Skillyouup\Models\Answer();
							} elseif(isset($post['buildyouup'])) {
								$answer = new \Tresfera\Buildyouup\Models\Answer();
							} else {
                    	$answer = new Answer();
							}
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

							if(isset($answer_data['question_id'])) {
								
								$answer->question_id     	= $answer_data['question_id'];
							}
							$answer->created_at      = date('Y-m-d H:i:s', strtotime($answer_data['create_at']));
							
							try {

								$answer->save();
								//buscamos si está duplicado buildyouup
								//si lo está, marcamos el resto como duplicados 
								//para que no se tengan en cuenta al analizar los datos
								if(isset($post['talent'])) {
									$query = \Tresfera\Talent\Models\Answer::where("result_id",$result->id)->where("id","<>",$answer->id);
								} elseif(isset($post['skillyouup'])) {
									$query = \Tresfera\Skillyouup\Models\Answer::where("result_id",$result->id)->where("id","<>",$answer->id);
								} elseif(isset($post['buildyouup'])) {
									$query = \Tresfera\Buildyouup\Models\Answer::where("result_id",$result->id)->where("id","<>",$answer->id);
								} else {
									$query = Answer::where("result_id",$result->id)->where("id","<>",$answer->id);
								}
								
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
							
								if($answer->question_id)
									$query->where("question_id",$answer->question_id);

								$query->update(["duplicated"=>$answer->id]);


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
								case '¿A qué jugador observas?':
								case 'Who are you observing?':
									$result->email = $answer->value;
								break;
								
							}
							$t = (int)($date_2_1);
							//trace_log("fin: ". $t);
						}
							//Introducimos las variables de url como segmentacion
					}
						
										//rellenamos respuestas obligatorias para los stats si no se ha hecho antes
								foreach($dataAnswered as $question_type => $value) {
										if($value==0) {
										if($post['talent']) {
											$answer = new \Tresfera\Talent\Models\Answer();
										} else {
											$answer = new Answer();
										}
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
								//trace_log("fin: ".time()-$date1);
            
            $quiz = Quiz::find($result_data['quizz_id']);


        }
        // Response
        if(isset($quiz)) {
	        $is_multiquiz = $quiz->slides()->where("page","=","slides/multiquiz")->count();
	    	if($is_multiquiz > 0)
	    		return $this->response(array("reload" => 1), $results);
        }
        return $this->response(array(),$results);
    }
    public function getDevice($quiz_id) {
		if(isset($this->device->id))
	    if($this->device->token == 'hd79S1PFMISQAiSV6bAQmbgBCwwA8Oy1') {
				if(isset($quiz_id)) {
					$quiz = Quiz::find($quiz_id);
					//get client
					$client = $quiz->client;
					$device = $client->devices()->where("name", "=", "WEB")->first();

					if(!isset($device)) {
						$device = new Device();
									$device->name = "WEB";
									$device->client()->associate($client);
									$device->mac = md5("WEB".$client->id.rand());
									$device->push_token = md5("WEB".$client->id.rand());

									$device->save();

						$device->generateToken();
					}
					$this->device = $device;
				}
		}
	}
}
