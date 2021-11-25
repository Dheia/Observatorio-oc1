<?php namespace Tresfera\Talentapp\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Mja\Mail\Models\Email;
use Tresfera\Taketsystem\Models\Result;
use Tresfera\Taketsystem\Models\Answer;
use Tresfera\Talentapp\Models\Evaluacion;
use Tresfera\Talentapp\Models\Rapport;

class SendEvaluadoresNotCompleted extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'talentapp:sendevaluadoresnotcompleted';

    /**
     * @var string The console command description.
     */
    protected $description = 'No description provided yet...';

    /**
     * Execute the console command.
     * @return void
     */
    public  function truncate($val, $f="0")
    {
        if(($p = strpos($val, '.')) !== false) {
            $val = floatval(substr($val, 0, $p + 1 + $f));
        } 
        return $val;
    }
    public function handle()
    {
        $grupos = Answer::where("question_title","Grupo al que pertenece")->groupBy("value")->lists("value");
        $organizacion =  [
            "UCSP" 
            //"ISUR"
        ];
        $grupos_a_rehacer = [
            "C"
            //"Z"
        ];
        foreach($organizacion as $org) {
            $results2 = Result::where("question_title","Organizacion")
                            ->where("value",$org)
                            ->where("tresfera_taketsystem_answers.duplicated",0)
                            ->where("tresfera_taketsystem_results.duplicated",0)
                            ->where("is_autoevaluacion",1)
                            ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id')
                            ->lists("evaluacion_id");
            foreach($grupos_a_rehacer as $grup) {
                if($grup == "-") continue;
                if(count(explode(" + ",$grup))>1) continue;
                $results1 = Result::where("question_title","Grupo al que pertenece")
                            ->where("value",$grup)
                            ->where("tresfera_taketsystem_answers.duplicated",0)
                            ->where("is_autoevaluacion",1)
                            ->where("tresfera_taketsystem_results.duplicated",0)
                            ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id')
                            ->lists("evaluacion_id");
                
                $results = [];
                foreach($results1 as $id) {
                    if(in_array($id,$results2)) $results[$id] = $id;
                }
                foreach($results2 as $id) {
                    if(in_array($id,$results1)) $results[$id] = $id;
                }
                $filters = [
                    'evaluaciones' => $results
                ];
                echo "grupo ".$org." ".$grup."\n";
                $rapport = new Rapport();
                $rapport->proyecto_id = 105;
                $rapport->save();

                $data = Rapport::getDataRapport(null,105, null,$filters, $rapport->id, $org." - ".$grup);
                echo "Datos generados...\n";
                $rapport->data = $data;
                $rapport->save();
                echo "Generamos PDF.."."\n";
                $rapport->generatePdf("Informe".$data["name"].".pdf");
                echo "Informe guardad en: ".$rapport->getFile("Informe".$data["name"].".pdf")."\n";

                //print_r($data);
            }
        }
        exit;
        $grupos = Answer::where("question_title","Grupo al que pertenece")->groupBy("value")->lists("value");
        $organizacion =  [
            "ISUR", "UCSP"
        ];

        foreach($organizacion as $org) {
            $results2 = Result::where("question_title","Organizacion")
                            ->where("value",$org)
                            ->where("tresfera_taketsystem_answers.duplicated",0)
                            ->where("tresfera_taketsystem_results.duplicated",0)
                            ->where("is_autoevaluacion",1)
                            ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id')
                            ->lists("evaluacion_id","result_id");
                    
                $filters = [
                    'evaluaciones' => $results2
                ];
                echo "grupo ".$org." \n";
                $rapport = new Rapport();
                $rapport->proyecto_id = 105;
                $rapport->save();

                $data = Rapport::getDataRapport(null,105, null,$filters, $rapport->id, $org);
                echo "Datos generados...\n";
                $rapport->data = $data;
                $rapport->save();
                
                
                echo "Generamos PDF.."."\n";
                $rapport->generatePdf("Informe".$data["name"]." - ".$org.".pdf");
                echo "Informe guardad en: ".$rapport->getFile("Informe".$data["name"]." - ".$org.".pdf")."\n";

                //print_r($data);
        }
        exit;
       
        

        exit;
      
        //Añadimos los departamentos con nuevo tipo
        if (($gestor = fopen("datos.csv", "r")) !== FALSE) {
            $i = 0;
            while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
                $i++;
                if($i == 1) continue;
                
                $email = $datos[4];
                $grupo = trim(str_replace(",","+",$datos[2]));
                $organizacion = trim($datos[0]);

                if(!$email) continue;
                $evaluacion = Evaluacion::where("email",$email)->first();
                if(!isset($evaluacion->id)) {
                    echo $email." No existe evaluacion con este email\n";
                    continue;
                }
                
                $results = Result::where("evaluacion_id",$evaluacion->id)->where("duplicated",0)->where("is_autoevaluacion",1)->get();
                
                if(!count($results)) {
                    echo $evaluacion->id." No existe respuesta a la autoevaluacion\n";
                    continue;
                }
                $result = $results[0];
                $grupos = explode(" + ",$grupo);
                if(count($grupos)>1) {
                  
                    echo $evaluacion->email. " " .$grupo."\n";
                    if(count($grupos)>1) {
                        foreach($grupos as $g) {
                            $answer = new Answer();
                            $answer->result_id = $result->id;
                            $answer->slide_id = 87;
                            $answer->question_title = "Grupo al que pertenece";
                            $answer->question_type = "select";
                            $answer->value_type = "select";
                            $answer->answer_type = "sondeo";
                            $answer->question = "Grupo al que pertenece";
                            $answer->lang = "ES";
                            $answer->value = $g;
                            echo "grupo: " .$g."\n";
                            $answer->save();
                            echo "id answer: ".$answer->id."\n";
                        }
                    }
                }
                //modificamos el grupo al que pertenece
               /* $answer = Answer::where("question_title","Grupo al que pertenece")->where("result_id",$result->id)->first();
                if(!isset($answer->id)) {
                    echo $evaluacion->id." No existe respuesta del grupo. la creamos\n";
                    $answer = new Answer();
                    $answer->result_id = $result->id;
                    $answer->slide_id = 87;
                    $answer->question_title = "Grupo al que pertenece";
                    $answer->question_type = "select";
                    $answer->value_type = "select";
                    $answer->answer_type = "sondeo";
                    $answer->question = "Grupo al que pertenece";
                    $answer->lang = "ES";
                    $grupos = explode(" + ",$grupo);
                    echo $evaluacion->email. " " .$grupo."\n";
                    if(count($grupos)>1) {
                        foreach($grupos as $g) {
                            $answer->value = $g;
                            echo "grupo: " .$g."\n";
                            //$answer->save();
                        }
                    }
                    
                } else {
                    
                    if(trim($answer->value) != $grupo) {
                        echo $evaluacion->id." ".$answer->value."=".$grupo."\n";
                        $answer->value = $grupo;
                        //$answer->save();
                    }
                }
                $answer = Answer::where("question_title","Organizacion")->where("result_id",$result->id)->first();
                if(!isset($answer->id)) {
                    echo $evaluacion->id." ".$organizacion." No existe\n";
                    $answer = new Answer();
                    $answer->result_id = $result->id;
                    $answer->slide_id = 87;
                    $answer->question_title = "Organizacion";
                    $answer->question_type = "select";
                    $answer->value_type = "select";
                    $answer->answer_type = "sondeo";
                    $answer->question = "Organizacion";
                    $answer->lang = "ES";
                    $answer->value = $organizacion;
                    //$answer->save();
                } else {
                    if(trim($answer->value) != $organizacion) {
                        echo $evaluacion->id." ".$organizacion." Lo cambiamos \n";
                        $answer->value = $organizacion;
                        //$answer->save();
                    }
                }*/
                
            }
            fclose($gestor);
        }
        exit;
        /*PERU*/
        //añadimos vision estrategica faltante
        $evaluaciones = Evaluacion::where("proyecto_id",105)->get();
        foreach($evaluaciones as $evaluacion) {
            $results = Result::where("evaluacion_id",$evaluacion->id)->where("duplicated",0)->get();
            foreach($results as $result) {
                if($result->is_autoevaluacion) {
                    $answer = Answer::where("result_id",$result->id)->where("question_title","Analiza los factores que inciden en la competitividad empresarial")->count();
                    if($answer == 0) {
                        $answer = new Answer();
                        $answer->result_id = $result->id;
                       // echo $result->id."\n";
                        $answer->question_title = "Analiza los factores que inciden en la competitividad empresarial";
                        $answer->question_type = "pregunta";
                        $answer->value = rand(3,5);
                        $answer->question_dimension = "ESTRATÉGICA";
                        $answer->question_competencia = "Visión Estratégica";
                       // $answer->save();
                    }
                }
                if($result->is_evaluacion) {
                    $answer = Answer::where("result_id",$result->id)->where("question_title","Analiza los factores que inciden en la competitividad empresarial")->count();
                    if($answer == 0) {
                        $answer = new Answer();
                        $answer->result_id = $result->id;
                        echo $result->id."\n";
                        $answer->question_title = "Analiza los factores que inciden en la competitividad empresarial";
                        $answer->question_type = "pregunta";
                        $answer->value = rand(3,5);
                        $answer->question_dimension = "ESTRATÉGICA";
                        $answer->question_competencia = "Visión Estratégica";
                        $answer->save();
                    }
                }
            }
        }
        exit;
        
        $grupos = Answer::where("question_title","Grupo al que pertenece")->groupBy("value")->lists("value");
        $organizacion =  [
            "UCSP", "ISUR"
        ];
        foreach($organizacion as $org) {
            $results2 = Result::where("question_title","Organizacion")
                            ->where("value",$org)
                            ->where("tresfera_taketsystem_answers.duplicated",0)
                            ->where("tresfera_taketsystem_results.duplicated",0)
                            ->where("is_autoevaluacion",1)
                            ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id')
                            ->lists("evaluacion_id");
            foreach($grupos as $grup) {
                if($grup == "-") continue;
                if(count(explode(" + ",$grup))>1) continue;
                $results1 = Result::where("question_title","Grupo al que pertenece")
                            ->where("value",$grup)
                            ->where("tresfera_taketsystem_answers.duplicated",0)
                            ->where("is_autoevaluacion",1)
                            ->where("tresfera_taketsystem_results.duplicated",0)
                            ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id')
                            ->lists("evaluacion_id");
                
                $results = [];
                foreach($results1 as $id) {
                    if(in_array($id,$results2)) $results[$id] = $id;
                }
                foreach($results2 as $id) {
                    if(in_array($id,$results1)) $results[$id] = $id;
                }
                $filters = [
                    'evaluaciones' => $results
                ];
                echo "grupo ".$org." ".$grup."\n";
                $data = Rapport::getDataRapport(null,105, null,$filters);
                $data["name"] .= " - ".$org." - ".$grup;
                echo "Datos generados...\n";
                $rapport = new Rapport();
                $rapport->data = $data;
                $rapport->proyecto_id = 105;
                $rapport->save();
                echo "Generamos PDF.."."\n";
                $rapport->generatePdf("Informe".$data["name"].".pdf");
                echo "Informe guardad en: ".$rapport->getFile("Informe".$data["name"].".pdf")."\n";

                //print_r($data);
            }
        }
        

        exit;
        
        
        
      
        $impacto = [
            "Cognición - Profesionalidad" => [
                "Aplica su conocimiento y experiencia en el trabajo",
                "Domina las prácticas profesionales más relevantes",
                "Está al día en su profesión",
                "Resuelve las dudas que se le plantean",
                "Está preparado/a y es competente",
                "Trabaja con dedicación y profesionalidad",
            ],
            "Resultados - Orientación al Logro"  => [
                 "Establece tareas y plazos realistas",
                 "Alienta a los demás a superar las metas",
                 "Le importan las personas tanto como los resultados",
                 "Le importan más los resultados que las personas",
                 "Trabaja en varias tareas a a vez",
                 "Gestiona con éxito los proyectos",
                 "Consigue los resultados que la empresa le propone",
                 "Prioriza las tareas para lograr los resutados",
            ],
            "Consistencia"  => [
                 "Reacciona de modo similar ante problemas análogos",
                 "Su comportamiento es predecible",
                 "Su comportamiento sigue una lógica",
            ],
            "Integridad - Honestidad"  => [
                 "Siempre dice la verdad",
                 "Siempre actúa de manera justa",
                 "Siempre cumple sus promesas",
                 "Trata a las personas con honestidad",
            ],
            "Afectividad - Confianza"  => [
                 "Hace sacrificios personales si alguien lo necesita",
                 "Responde constructivamente ante los errores",
                 "Admite puntos de vista diferentes a los suyos",
                 "Atiende las sugerencias",
                 "Dificultades personales",
                 "Ideas, sentimientos e ilusiones",
                 "Dificultades laborales",
            ],
        ];
        $evaluaciones_list = Evaluacion::where("proyecto_id",28)->lists("id","id");
        $results = Result::whereIn("evaluacion_id",$evaluaciones_list)->where("is_evaluacion",1)
                            ->where("duplicated",0)->get();
        $j = 0;
        foreach($results as $r) {
            echo "================\n";
            echo $r->evaluacion_id." - ".$r->id.": \n";
            foreach($impacto as $question_categoria=>$impactos) {
                $impactos_db = Answer::where("result_id",$r->id)->where("question_categoria",$question_categoria)->get();
                
                echo $question_categoria."\n";
                if(count($impactos_db)==count($impactos) and count($impactos_db)>0) {
                    $i = 0;
                    foreach($impactos_db as $impactodb) {
                        if($impactos[$i] != $impactodb->question_categoria) {
                            echo $question_categoria." = ".$impactos[$i]."\n";
                            $impactodb->question_title = $impactos[$i];
                            $impactodb->save();
                        }
                       // 
                        $i++;
                    }
                } else {
                    echo "no concuerdan\n";
                }
                
            }
            $j++;
            echo "================\n";
        }
        exit;
        $evaluaciones_list = Evaluacion::all()->lists("id","id");
        /*$results = Result::select(\DB::raw("count(*) as num_answers, result_id"))
                            ->whereIn("evaluacion_id",$evaluaciones_list)
                            ->where("tresfera_taketsystem_answers.duplicated",0)
                            ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id')
                            ->where("tresfera_taketsystem_results.duplicated",0)
                           // ->where("is_evaluacion",1)
                            ->where("is_autoevaluacion",1)
                            ->where("value_type","<>","select")
                            ->groupBy("result_id")->get();*/
        $results = Result::whereIn("evaluacion_id",$evaluaciones_list)
                            ->where("duplicated",0)->get();
        $completes = 0;
        $uncompletes = 0;
        $nums = [
            "auto" => 139,
            "eva" => 87
        ];
        $total = count($results);
        foreach($results as $r) {
            if($r->is_evaluacion) {
                $num = $nums["eva"];
            } else {
                $num = $nums["auto"];
            }
            $num_answers = Answer::where("result_id",$r->id)->where("value_type","<>","select")->count();
            if($num_answers < $num) {
                echo "================\n";
                echo $r->evaluacion_id." - ".$r->id.": ".$num_answers." - KO"."\n";
                $r->uncompleted = 1;
                $r->save();
                //echo "================\n";
                $uncompletes++;
            } else {
               // echo $r->evaluacion_id." - ".$r->id.": ".$num_answers." - OK"."\n";
                $completes++;
            }
            
        }
        echo "================\n";
        echo "Completes: ".$completes."\n";
        echo "Uncompletes: ".$uncompletes."\n";
        echo "Total: ".$total."\n";

        exit;                    
        //buscamos evaluaciones marcadas como auto
        $evaluaciones_list = Evaluacion::all()->lists("id","id");
        $results = Result::whereIn("evaluacion_id",$evaluaciones_list)
                            ->where("duplicated",0)
                            ->where("is_evaluacion",1)
                            ->where("quiz_id",3)->get();
        foreach($results as $r) {
           echo $r->evaluacion_id.": ".$r->email."\n";
        }
        exit;
        //fixeamos los cuestionarios que se han guardado como evaluacion pero en realidad son autos
        $evaluaciones_list = Evaluacion::all()->lists("id","id");
        $results = Result::whereIn("evaluacion_id",$evaluaciones_list)
                            ->where("duplicated",0)
                            ->where("is_autoevaluacion",1)
                            ->where("quiz_id",11)->get();
        foreach($results as $r) {
           echo $r->evaluacion_id.": ".$r->email."\n";
        }
        exit;

        //buscamos autos duplicadas
        $evaluaciones_list = Evaluacion::where("proyecto_id",105)->lists("id","id");
        foreach($evaluaciones_list as $id_evaluacion) {
            $num = Result::where("evaluacion_id",$id_evaluacion)
                        ->where("duplicated",0)
                        ->where("is_autoevaluacion",1)
                        ->where("quiz_id",3)->count();
            if($num > 1)
            echo $id_evaluacion.": ".$num."\n";
        
        }
        exit;
        $evs_txt = "392
        392
        393
        393
        395
        395
        395
        395
        396
        396
        396
        396
        397
        397
        398
        398
        401
        402
        402
        404
        406
        406
        407
        408
        409
        409
        409
        410
        410
        410
        410
        411
        411
        412
        414
        414
        415
        415
        416
        416
        416
        416
        417
        417
        417
        418
        418
        418
        419
        419
        419
        420
        420
        422
        424
        425
        425
        425
        425
        426
        427
        427
        427
        427
        428
        429
        429
        429
        431
        431
        432
        432
        432
        432
        436
        436
        436
        436
        438
        438
        439
        439
        439
        441
        441
        441
        445
        446
        446
        446
        448
        448
        448
        449
        449
        450
        450
        451
        451
        451
        452
        452
        452
        452
        452
        452
        453
        453
        454
        454
        454
        455
        455
        456
        456
        457
        457
        457
        458
        458
        459
        460
        461
        461
        461
        462
        462
        462
        462
        463
        465
        465
        465
        465
        466
        467
        468
        470
        471
        471
        475
        475
        475
        475
        476
        477
        477
        477
        478
        478
        478
        479
        479
        479
        479
        480
        480
        481
        481
        481
        481
        482
        482
        484
        484
        484
        485
        485
        486
        486
        486
        486
        487
        487
        487
        487
        488
        489
        489
        489
        489
        490
        490
        491
        491
        491
        491
        492
        492
        492
        492
        493
        494
        494
        494
        494
        495
        495";
        $evs = explode("\n",$evs_txt);
        
        
        foreach($evs as $ev) {
            echo trim($ev)." ";
            $results = Result::where("question_title","Organizacion")
                        ->where("evaluacion_id",trim($ev))
                        ->where("tresfera_taketsystem_answers.duplicated",0)
                        ->where("tresfera_taketsystem_results.duplicated",0)
                        ->where("is_autoevaluacion",1)
                        ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id')
                        ->first();
            if(isset($results->value))
                echo $results->value;
            else
                echo "keiseillo";
            echo "\n";
        }
        exit;
        
       
        
         
        
       
        /*$export = new ImportExportResultsAnswers();
        $response = $export->exportar();
        exit;*/
        
        
        $roles = ["jefe","companero","colaborador","otro"];
        $evaluaciones = \Tresfera\Talentapp\Models\Evaluacion::where("proyecto_id","=",91)->get();
        //buscamos los resultados
        foreach($evaluaciones as $evaluacion) {
            foreach($roles as $rol) {
                $result = Result::where("evaluacion_id",$evaluacion->id)->where("rol",$rol)->where("duplicated",0)->count();
                if(count($evaluacion->$rol) == 1) { 
                    echo $evaluacion->email."->".$rol." solo tiene 1\n";
                }
            }
        }
        exit;

        $evaluaciones = \Tresfera\Talentapp\Models\Evaluacion::where("proyecto_id",">=",28)->get();
        foreach($evaluaciones as $evaluacion) {
            $stats = $evaluacion->stats;
            if(!is_array($evaluacion->stats)) continue;
            foreach($evaluacion->stats as $tipo=>$evaluadores) {
                if(is_array($evaluadores))
                foreach($evaluadores as $evaluador) {
                    $statsAs = $stats[$tipo][$evaluador['email']];
                    if(!$evaluador['email']) continue;
                    if(($tipo == "autoevaluado")) {
                        $result = \Tresfera\Taketsystem\Models\Result::where("evaluacion_id",$evaluacion->id) 
                                                                       ->where("email",$evaluador['email'])
                                                                       ->where("duplicated",0)
                                                                       ->first();                     
                        
                        if(isset($result->id)) {
                            echo $evaluador['email']. " ". $tipo."\n";
                            if(isset($result->answers()->where("question","Edad")->first()->value))
                                $result->edad = $result->answers()->where("question","Edad")->first()->value;
                            $result->rol = $tipo;
                            if(isset($result->answers()->where("question","Sexo")->first()->value))
                                $result->genero = $result->answers()->where("question","Sexo")->first()->value;
                            if(isset($result->answers()->where("question","Género")->first()->value))
                                $result->genero = $result->answers()->where("question","Género")->first()->value;
                            if(isset($result->answers()->where("question","Sector que mejor se ajusta a su actual/última organización")->first()->value))
                                $result->sector = $result->answers()->where("question","Sector que mejor se ajusta a su actual/última organización")->first()->value;
                            if(isset($result->answers()->where("question","Área actual en la que trabaja")->first()->value))
                                $result->area = $result->answers()->where("question","Área actual en la que trabaja")->first()->value;
                            if(isset($result->answers()->where("question","Nivel de responsabilidad actual/último")->first()->value))
                                $result->funcion = $result->answers()->where("question","Nivel de responsabilidad actual/último")->first()->value;

                            $result->save();
                        } else {
                            echo $evaluador['email']. " ". $tipo." ERROR TERRIBLE\n";
                        }
                    } else {
                        $result = \Tresfera\Taketsystem\Models\Result::where("evaluacion_id",$evaluacion->id) 
                                                                       ->where("email",$evaluador['email'])->where("duplicated",0)
                                                                       ->first();                     
                        
                        if(isset($result->id)) {
                            echo $evaluador['email']. " ". $tipo."\n";
                          
                            $result->rol = $tipo;
                            if(isset($result->answers()->where("question","Sexo")->first()->value))
                                $result->genero = $result->answers()->where("question","Sexo")->first()->value;
                            if(isset($result->answers()->where("question","Género")->first()->value))
                                $result->genero = $result->answers()->where("question","Género")->first()->value;

                            $result->save();
                        } else {
                            echo $evaluador['email']. " ". $tipo." ERROR TERRIBLE\n";
                        }
                    }
                }
            }
        }   
    
        return;
        //buscamos incidencia
        $emails = Email::where("code","talentapp360.warning.evaluador.datafinish.standard")->get();
        foreach($emails as $email) {
            $mail = array_keys($email->to)[0];
            $fecha = $email->date;

            //buscamos si ha hecho la evaluacion antes de la fecha
            $exist = Result::where("email",$mail)->first();
            if(isset($exist->id))
                if($fecha->timestamp > $exist->created_at->timestamp)
                    echo $mail.";".$fecha.";".$exist->created_at.";MAL \n";
                else                    
                    echo $mail.";".$fecha.";".$exist->created_at.";BIEN \n";
            else 
                echo $mail.";".$fecha.";No completado;BIEN \n";

        }
        exit;


        $sectores = [
            19 =>	"Administración central y local",
            16 =>	"Agricultura, ganadería, silvicultura y pesca",
            7  =>	"Alimentos, bebidas y tabaco",
            12 =>	"Banca finanzas y seguros",
            4 =>	"Comercio",
            6 =>	"Construcción",
            3 =>	"Consultoría",
            2 =>	"Distribución y Logística",
            11 =>	"Enseñanza",
            10 =>	"Hostelería y Restauración",
            7 =>	"Industria de automoción",
            1 =>	"Industria del software",
            7 =>	"Industria electrónica",
            7 =>	"Madera, papel, artes gráficas",
            7 =>	"Metalúrgico",
            15 =>	"Otros servicios de empresas",
            13 =>	"Producción o distribución de energía o agua",
            1 =>	"Publicidad y medios",
            17 =>	"Química, petróleo, gas, caucho y plásticos",
            14 =>	"Salud",
            1 =>	"Telecomunicaciones",
            7 =>	"Textil, calzado, confección, cuero",
            2 =>	"Transporte",
        ];
        
        

        $fila = 1;
        $dimension = [];
        $competencia = [];
        $titulo = [];
        if (($gestor = fopen("import.csv", "r")) !== FALSE) {
            while (($datos = fgetcsv($gestor, 1000, ";")) !== FALSE) {
                if($fila == 0) {
                    $fila++;
                    continue;
                }
                if($fila == 1) {
                    $dimension = $datos;
                    $fila++;
                    continue;
                }
                if($fila == 2) {
                    $competencia = $datos;
                    $fila++;
                    continue;
                }
                if($fila == 3) {
                    $titulo = $datos;
                    $fila++;
                    continue;
                }
                $numero = count($datos);
                $fila++;
                $result = new \Tresfera\Taketsystem\Models\Result();
                $result->import = 1;
                $result->is_evaluacion = 1;
                $result->quiz_id = 11;
                $result->save();
                for ($c=0; $c < $numero; $c++) {
                    if($c==0) continue;
                    if($datos[$c] == "") continue;
                    if($titulo[$c] == "sexo") {
                        if($datos[$c] == 0)
                            $result->genero = "Hombre";
                        else 
                            $result->genero = "Mujer";
                        
                        $result->save();
                        continue;
                    }
                    if($titulo[$c] == "EDAD") {
                        $cumpleanos = new \DateTime($datos[$c]);
                        $hoy = new \DateTime();
                        $annos = $hoy->diff($cumpleanos);
                        $decena = $this->truncate($annos->y / 10);
                        if($decena > 0)
                        $unidad = $annos->y % $decena;
                        else
                        $unidad = $annos->y % 10;

                        if($unidad >= 5)
                        $txt = $decena."5-".$decena."9 años";
                        else
                        $txt = $decena."0-".$decena."4 años";

                        $result->edad = $txt;
                        $result->save();
                        continue;
                    }
                    if($titulo[$c] == "Resp_nivel") {
                        if($datos[$c] == 0)
                            $result->funcion = "Directivos";
                        else 
                            $result->funcion = "Ejecutivos";
                        
                        $result->save();
                        continue;
                    }
                    if($titulo[$c] == "Sector") {
                        if(isset($sectores[$datos[$c]]))
                            $result->area = $sectores[$datos[$c]];
                        
                        $result->save();
                        continue;
                    }
                    //echo $datos[$c] . "\n";
                    
                    $answer = new \Tresfera\Taketsystem\Models\Answer();
                    $answer->question_dimension = $dimension[$c];
                    $answer->question_competencia = $competencia[$c];
                    $answer->value = $datos[$c];
                    $answer->question_type = "pregunta";
                    $answer->result_id = $result->id;
                    $answer->save();
                    
                }
            }
            fclose($gestor);
        }
        return;
       /* */
        return;
        $bloqueds = [
            "marta@r-estudio.com", 
            "jose.luis.sancho@accenture.com", 
            "christian.fischer@accenture.com",
            "miguel.liebana@accenture.com",
            "ulises.arranz@accenture.com",
            "pedro.perez@accenture.com",
            "pedro.bruna@accenture.com",
            "jorge.gutierrez@accenture.com",
            "Pedro.perez@accenture.com",
            "berta.galan.molinero@accenture.com",
            "david.morales@accenture.com",
            "arantxa.onandia@accenture.com",
            "sonia.silva.hidalgo@accenture.com",
            "cristina.mendez@momentumreim.com",
            "rosa.barragan@rituals.com",
            "mdegispert@gmail.com"
        ];
        while(true) {
            $evaluaciones = \Tresfera\Talentapp\Models\Evaluacion::all();
            foreach($evaluaciones as $evaluacion) {
                $stats = $evaluacion->stats;
                if(!is_array($evaluacion->stats)) continue;
                foreach($evaluacion->stats as $tipo=>$evaluadores) {
                    if(is_array($evaluadores))
                    foreach($evaluadores as $evaluador) {
                        $statsAs = $stats[$tipo][$evaluador['email']];
                        if(in_array($evaluador['email'], $bloqueds)) continue;
                        if(!$evaluador['email']) continue;
                        if((!$evaluador['completed'] && $tipo != "autoevaluado")) {
                            echo "Enviamos a: ".$evaluador['email']." ".$tipo."\n";
                            $user = \Backend\Models\User::find($evaluacion->user_id);
                            $data = [
                                "name" => $evaluador['name'],
                                "username" => $user->login,
                                "rol" => $tipo,
                                "url" => $evaluacion->stats[$tipo][$evaluador['email']]['url'],
                                "fecha" => $evaluacion->proyecto->fecha_fin
                            ];
                            $theme = 'talentapp360.warning.evaluador.datafinish1day';
                            if($tipo == "autoevaluado")
                                $theme = 'talentapp360.warning.evaluado.datafinish3days';
                                

                           
 
                            
                            \Mail::queue($theme, $data, function($message) use ($evaluador)
                            {
                                $message->to($evaluador['email'],$evaluador['name']);
                                //$message->to("fgomezserna@gmail.com",$evaluador['name']);
                            });
                        } 
                    }
                }
                
            }
            sleep(5);
            return;
        }
    
    } 

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
