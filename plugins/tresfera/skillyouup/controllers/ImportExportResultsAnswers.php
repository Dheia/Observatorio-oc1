<?php namespace Tresfera\Skillyouup\Controllers;

use Lang;
//use Backend\Behaviors\ImportExportController;
use League\Csv\AbstractCsv;
use League\Csv\Writer as CsvWriter;
use SplTempFileObject;


use Tresfera\Taketsystem\Models\Result;
use Tresfera\Taketsystem\Models\Answer;
use Tresfera\Skillyouup\Models\Proyecto;
use Tresfera\Skillyouup\Models\Equipo;
use Tresfera\Taketsystem\Models\Slide;

class ImportExportResultsAnswers //extends ImportExportController
{
    
    public function exportar()
    {
        try {
            $options = [];
            $defaultOptions = [
                'fileName' => "datosBrutosSkillyouup360_".date("d-m-Y").".csv",
                'delimiter' => ';',
                'enclosure' => '"'
            ];

            $options = array_merge($defaultOptions, $options);


            /*
            * Prepare CSV
            */
            $csv = CsvWriter::createFromFileObject(new SplTempFileObject);
            $csv->setOutputBOM(AbstractCsv::BOM_UTF8);
            $csv->setDelimiter($options['delimiter']);
            $csv->setEnclosure($options['enclosure']);

            $results = Result::join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', 'tresfera_taketsystem_answers.result_id')
                            ->where("tresfera_taketsystem_answers.question_dimension","<>","")
                            ->where("tresfera_taketsystem_answers.question_competencia","<>","")
                            ->where("tresfera_taketsystem_answers.duplicated",0)
                            ->where("tresfera_taketsystem_results.duplicated",0)
                            ->where("tresfera_taketsystem_results.evaluacion_id","<>",0)
                            ->orderBy("tresfera_taketsystem_answers.question_dimension","asc")
                            ->orderBy("tresfera_taketsystem_answers.question_competencia","asc")
                            ->orderBy("tresfera_taketsystem_answers.slide_id","asc")
                            ->get();
        
            $headers = [];
            // HEADERS (1) QUESTION_DIMENSION & QUESTION_COMPETENCIA - 60
            $headers[0] = [];
            $headers[1] = [];

            $tmp_competencias = [];

            foreach($results as $result)
            {
                if(!$result->evaluacion_id) continue;
                $ev = Equipo::find($result->evaluacion_id);
                if(!isset($ev->proyecto_id)) continue;
                $pr = Proyecto::find($ev->proyecto_id);
                if(!isset($pr->id)) continue;
                if($result->question_dimension && $result->question_competencia)
                {
                    if( !isset($tmp_competencias[$result->question_dimension]) )
                    {
                        $tmp_competencias[$result->question_dimension] = [];
                    }
                    if( !isset($tmp_competencias[$result->question_dimension][$result->question_competencia]) )
                    {
                        $tmp_competencias[$result->question_dimension][$result->question_competencia] = [];
                    }
                    if( !in_array($result->slide_id, $tmp_competencias[$result->question_dimension][$result->question_competencia]) )
                    {
                        array_push($tmp_competencias[$result->question_dimension][$result->question_competencia], $result->slide_id);
                    }
                }
            }

            //dd($tmp_competencias);

            foreach($tmp_competencias as $dimension => $competencia)
            {
                foreach($competencia as $name_competencia => $slides)
                {
                    $i=1;
                    foreach($slides as $slide_id)
                    {
                        array_push($headers[0], $dimension);
                        array_push($headers[1], $name_competencia.$i);
                        $i++;
                        if($name_competencia == "Visión Estratégica")
                        {
                            if($i == 3) break;
                        }
                        else
                        {
                            if($i == 4) break;
                        }
                    }
                }
            }


            //dd($headers[1]);

            

            // HEADERS (2) QUESTION_TYPE & QUESTION_CATEGORIA - 80
            $headers2[0] = [];
            $headers2[1] = [];

            $results2 = Slide::where('page', 'explicativas/iese_motivos')->take(20)->get();

            for($i=0; $i<4; $i++)
            {
                foreach($results2 as $r)
                {
                    array_push($headers2[0], $r->name);
                }
            }

            for($i=0; $i<20; $i++)
            {
                array_push($headers2[1], "EXT - Estratega");
            }
            for($i=0; $i<20; $i++)
            {
                array_push($headers2[1], "INT - Ejecutivo");
            }
            for($i=0; $i<20; $i++)
            {
                array_push($headers2[1], "TRA - Integrador");
            }
            for($i=0; $i<20; $i++)
            {
                array_push($headers2[1], "PRO");
            }


            // HEADERS (3) - Impacto
            $headers3[0] = [ 
                "Impacto 1: Profesionalidad", 
                "Impacto 2: Orientación al Logro",
                "Impacto 3",
                "Impacto 4: Honestidad",
                "Impacto 5: Afectividad - Confianza"
            ];
            $headers3[1] = [ 
                "Cognición - Profesionalidad", 
                "Resultados - Orientación al Logro", 
                "Consistencia", 
                "Integridad - Honestidad",
                "Afectividad - Confianza"
            ];

            $questions_title = [];
            $headers3[2] = [];
            $headers3[3] = [];

            foreach($headers3[1] as $header)
            {
                $results2 = Answer::where("question_type", "motivo")
                            ->where("question_categoria", $header)
                            ->where("result_id", 2358)
                            ->select("question_title")
                            ->groupBy("question_title")
                            ->orderBy("slide_id", "desc")
                            ->get();

                foreach($results2 as $result)
                {
                    if(trim($result->question_title) != "")
                    {
                        array_push($questions_title, $result->question_title);
                        array_push($headers3[2], $header);
                        array_push($headers3[3], $result->question_title);
                    }
                }
            }

            // HEADERS (4) - Segmentación 
            $ans = Answer::join('tresfera_taketsystem_results', 'tresfera_taketsystem_results.id', 'tresfera_taketsystem_answers.result_id')
                        ->join('tresfera_skillyouup_evaluacion', 'tresfera_taketsystem_results.evaluacion_id', 'tresfera_skillyouup_evaluacion.id')
                        ->where('tresfera_skillyouup_evaluacion.lang','es')
                        ->where('tresfera_taketsystem_answers.question_type','select')
                        ->where("tresfera_taketsystem_results.evaluacion_id","<>",0)
                        ->select('tresfera_taketsystem_answers.*', 'tresfera_skillyouup_evaluacion.lang as idioma' )
                        ->orderBy('tresfera_taketsystem_answers.result_id','asc')
                        ->orderBy('tresfera_taketsystem_answers.slide_id','asc')
                        ->get();

            $headers4[0] = [];
            $headers4[1] = [];

            $columns_ingles = [
                "Sex",
                "Age",
                "Country",
                "Highest level of studies finished",
                "Total number of years you have worked until today",
                "Total number of companies you have worked for until today",
                "Total number of years you have worked abroad",
                "Current/latest level of responsibility",
                "Current area of work",
                "Total number of different areas you have worked in until today",
                "Indicate which industry best fits your current/latest organization",
                "Total number of different industries you have worked in until today",
                "Number of people working in your current company",
                "Do you have people under your responsibility?",
                "How many people work under your responsibility?",
                "Marital status",
                "Number of children",
                "Total number of daily hours dedicated to taking care of your family (home, partner, children, parents…)",
                "Total number of daily hours dedicated to your personal care",
                "Total number of anual hours dedicated to training"
            ];

            //$id_old = $ans[0]->result_id;

            foreach($ans as $an)
            {
                //if($id_old != $an->result_id) break;
                
                if( !in_array($an->question_title, $headers4[1]) && $an->idioma=="es" && !in_array($an->question_title, $columns_ingles) )
                {
                    array_push($headers4[0], "Segmentación");
                    array_push($headers4[1], $an->question_title);
                }
                //id_old = $an->result_id;
            }

            // HEADERS (1) QUESTION_DIMENSION & QUESTION_COMPETENCIA - 60
            // HEADERS (2) QUESTION_TYPE & QUESTION_CATEGORIA - 80
            // HEADERS (3) - Impacto
            // HEADERS (4) - Segmentación 

            $info = [ "ID Evaluación", "Rol", "ID Result" ];

            // AÑADIMOS HEADERS AL CSV
            $h1 = array_merge($info, $headers[0], $headers2[0], $headers3[2], $headers4[0]);  // $headers[0] + $headers2[0] + $headers3[0] + $headers4[0]; //array_merge($headers[0], $headers2[0]);
            $h2 = array_merge(["","",""], $headers[1], $headers2[1], $headers3[3], $headers4[1]); //array_merge($headers[1], $headers2[1]);
            $csv->insertOne($h1);
            $csv->insertOne($h2);

            // EXTRAEMOS DATOS Y LOS AÑADIMOS AL CSV
            $results = Result::join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', 'tresfera_taketsystem_answers.result_id')
                            ->where("tresfera_taketsystem_answers.question_dimension","<>","")
                            ->where("tresfera_taketsystem_answers.question_competencia","<>","")
                            ->where("tresfera_taketsystem_answers.duplicated",0)
                            ->where("tresfera_taketsystem_results.duplicated",0)
                            ->where("tresfera_taketsystem_results.evaluacion_id","<>",0)
                            ->orderBy("tresfera_taketsystem_answers.result_id","asc")
                            ->orderBy("tresfera_taketsystem_answers.question_dimension","asc")
                            ->orderBy("tresfera_taketsystem_answers.question_competencia","asc")
                            ->get();
                            
            $tmp = [];
            $id_old = $results[0]->result_id;
            $evaluacion_id_old = $results[0]->evaluacion_id;
            $rol_old = $results[0]->rol;
            if($rol_old == "") $rol_old = "autoevaluado";
            $competencias = [];
            $competencias_added = [];
            
            foreach($results as $result)
            {
                if(!$result->evaluacion_id) continue;
                $ev = Equipo::find($result->evaluacion_id);
                if(!isset($ev->proyecto_id)) continue;
                $pr = Proyecto::find($ev->proyecto_id);
                if(!isset($pr->id)) continue;

                if($id_old != $result->result_id)
                {
                    $tmp = array_merge($tmp, [ $evaluacion_id_old, $rol_old, $id_old ]);
                    $tmp = array_merge($tmp, $this->getDatosCompetencias($id_old, $tmp_competencias));
                    $tmp = array_merge($tmp, $this->getDatosCategoria($id_old));
                    $tmp = array_merge($tmp, $this->getDatosImpacto($id_old, $headers3[2], $questions_title));
                    $tmp = array_merge($tmp, $this->getDatosSegmentacion($id_old, $headers4[1]));
                    if($tmp) $csv->insertOne($tmp);
                    
                    $tmp = [];
                    $competencias = [];
                }
                $id_old = $result->result_id;
                $evaluacion_id_old = $result->evaluacion_id;
                $rol_old = $result->rol;
                if($rol_old == "") $rol_old = "autoevaluado";
            }

            $tmp = array_merge($tmp, [ $evaluacion_id_old, $rol_old, $id_old ]);
            $tmp = array_merge($tmp, $this->getDatosCompetencias($id_old, $tmp_competencias));
            $tmp = array_merge($tmp, $this->getDatosCategoria($id_old));
            $tmp = array_merge($tmp, $this->getDatosImpacto($id_old, $headers3[1], $questions_title));
            $tmp = array_merge($tmp, $this->getDatosSegmentacion($id_old, $headers4[1]));
            if($tmp) $csv->insertOne($tmp);


            /*
            * Output
            */
            ob_start();
            $csv->output($options['fileName']);
            $content = ob_get_clean();
            
            //echo "\n\n".$content;exit;
            $ok = true;
            // Guardamos información en el archivo .csv
            //echo "Guardamos en fichero"."\n";

            $path = base_path("informes/");
            $file = $options['fileName'];
            if (!$fp = fopen($path.$file, "w")) {
                echo "No se ha podido abrir el archivo";
                $ok = false;
            }
            fwrite($fp, $content);
            fclose($fp);
            //echo "Fin"."\n";

        } catch(\Exception $e) {
            $ok = false;
            echo $e->getMessage() . " - Line: " . $e->getLine();
        }

        return [ 
            "ok" => $ok,
            "path" => "informes/".$file,
            //"content" => $content
        ];
    }


    private function getDatosCompetencias($result_id, $competencias)
    {
        $tmp = [];

        //dd($competencias);
        foreach($competencias as $dimension => $competencia)
        {
            foreach($competencia as $name_competencia => $slides)
            {
                $tmp2 = [];
                foreach($slides as $slide_id)
                {
                    $r = Answer::where("result_id", $result_id)
                            ->where("question_dimension", $dimension)
                            ->where("question_competencia", $name_competencia)
                            ->where("slide_id", $slide_id)
                            ->orderBy("id", "desc") 
                            ->first();
                    if(count($r)>0) 
                    {
                        array_push($tmp, $r->value);
                        array_push($tmp2, $r->value);
                    }
                    //else array_push($tmp, "-");

                    if($name_competencia == "Visión Estratégica")
                    {
                        if( count($tmp2) == 2 ) break;
                    }
                    else 
                    {
                        if( count($tmp2) == 3 ) break;
                    }
                }

            }
        }
        return $tmp;
    }

    private function getDatosCategoria($result_id)
    {
        $tmp = [];
        
        $results = Answer::where("result_id", $result_id)
                        ->where("question_type", "motivo")
                        ->where("question_categoria", "EXT - Estratega")
                        ->orderBy("slide_id", "asc") 
                        ->get();

        $slide_id = -1;
        if(count($results)>0)
        {
            foreach($results as $result)
            {
                if($slide_id == $result->slide_id) $tmp[count($tmp)-1] = $result->value;
                else array_push($tmp, $result->value);
                $slide_id = $result->slide_id;
            }
        }
        else
        {
            for($i=0; $i<20; $i++)
                array_push($tmp, "-");
        }

        $results = Answer::where("result_id", $result_id)
                        ->where("question_type", "motivo")
                        ->where("question_categoria", "INT - Ejecutivo")
                        ->orderBy("slide_id", "asc") 
                        ->get();

        $slide_id = -1;
        if(count($results)>0)
        {
            foreach($results as $result)
            {
                if($slide_id == $result->slide_id) $tmp[count($tmp)-1] = $result->value;
                else array_push($tmp, $result->value);
                $slide_id = $result->slide_id;
            }
        }
        else
        {
            for($i=0; $i<20; $i++)
                array_push($tmp, "-");
        }

        $results = Answer::where("result_id", $result_id)
                        ->where("question_type", "motivo")
                        ->where("question_categoria", "TRA - Integrador")
                        ->orderBy("slide_id", "asc") 
                        ->get();

        $slide_id = -1;
        if(count($results)>0)
        {
            foreach($results as $result)
            {
                if($slide_id == $result->slide_id) $tmp[count($tmp)-1] = $result->value;
                else array_push($tmp, $result->value);
                $slide_id = $result->slide_id;
            }
        }
        else
        {
            for($i=0; $i<20; $i++)
                array_push($tmp, "-");
        }

        $results = Answer::where("result_id", $result_id)
                        ->where("question_type", "motivo")
                        ->where("question_categoria", "PRO")
                        ->orderBy("slide_id", "asc") 
                        ->get();

        $slide_id = -1;
        if(count($results)>0)
        {
            foreach($results as $result)
            {
                if($slide_id == $result->slide_id) $tmp[count($tmp)-1] = $result->value;
                else array_push($tmp, $result->value);
                $slide_id = $result->slide_id;
            }
        }
        else
        {
            for($i=0; $i<20; $i++)
                array_push($tmp, "-");
        }
        
        //echo $result_id." ".count($tmp)." , ";
        return $tmp;
    }

    public function getDatosImpacto($result_id, $headers, $questions_title)
    {
        $tmp = [];
        $translate = [
            'Aplica su conocimiento y experiencia en el trabajo' => ['They apply their knowledge and expertise to the job','He/She applies his/her knowledge and expertise to the job'],
            'Domina las prácticas profesionales más relevantes' => ['They master the most relevant professional techniques','He/She masters the most relevant professional techniques'],
            'Está al día en su profesión' => ['They are up to date in their job','He/She is up to date in their job'],
            'Está preparado/a y es competente' => ['They are ready and competent','He/She is ready and competent'],
            'Trabaja con dedicación y profesionalidad' => ['They work with dedication and professionality','He/She works with dedication and professionalism'],
            'Resuelve las dudas que se le plantean' => ['They solve the doubts presented to them','He/She solves the doubts presented to him/her'],
            'Establece tareas y plazos realistas' => ['They set realistic tasks and deadlines'],
            'Alienta a los demás a superar las metas' => ['He/She encourages others to reach goals', 'They encourage others to reach the goals'],
            'Le importan las personas tanto como los resultados' => ['He/She cares about people as much as results','They care about the people as much as the results'],
            'Le importan más los resultados que las personas' => ['They care about the results more than the people','He/She cares about results more than people'],
            'Consigue los resultados que la empresa le propone' => ['They achieve the goals the company sets for them', 'He/She achieves goals the company sets for him/her'],
            'Prioriza las tareas para lograr los resutados' => ['He/She prioritizes tasks to achieve results', 'They prioritize the tasks to achieve the results'],
            'Trabaja en varias tareas a a vez' => ['He/She multitasks', 'They multitask'],
            'Gestiona con éxito los proyectos' => ['He/She manages projects successfully','They manage the projects successfully'],
            'Su comportamiento es predecible' => ['Their behavior is predictable','His/Her behavior is predictable'],
            'Su comportamiento sigue una lógica' => ['Their behavior follows a logic','His/Her behavior follows a logic'],
            'Reacciona de modo similar ante problemas análogos' => ['They react similarly upon analogous problems','He/She reacts similarly upon related problems'],
            'Siempre cumple sus promesas' => ['Always keeps their promises','Always keeps his/her promises'],
            'Trata a las personas con honestidad' => ['Treats people with honesty'],
            'Siempre dice la verdad' => ['Always tells the truth'],
            'Siempre actúa de manera justa' => ['Always acts justly'],
            'Hace sacrificios personales si alguien lo necesita' => ['Make personal sacrifices if someone needs it?','Make personal sacrifices if someone needs it'],
            'Responde constructivamente ante los errores' => ['Respond constructively upon mistakes?','Respond constructively upon mistakes'],
            'Admite puntos de vista diferentes a los suyos' => ['Admit different points of view?','Admit different points of view'],
            'Atiende las sugerencias' => ['Listen to suggestions?','Listen to suggestions'],
            'Ideas, sentimientos e ilusiones' => ['Ideas, feelings and hopes?','Ideas, feelings and hopes'],
            'Dificultades laborales' => ['Work-related difficulties?','Work-related difficulties'],
            'Dificultades personales' => ['Personal difficulties?', 'Personal difficulties'],
        ];
        $i=0;
        foreach($headers as $header)
        {
            $results = Answer::where("result_id", $result_id)
            ->where("question_type", "motivo")
            ->where("question_categoria", $header)
            ->whereIn("question_title", array_merge([$questions_title[$i]],$translate[$questions_title[$i]]))
            ->orderBy("slide_id", "desc") 
            ->first();

            if($results && count($results)>0)
            {
                if(isset($results->value)) array_push($tmp, $results->value);
                else array_push($tmp, "-");
            }
            else
            {
                array_push($tmp, "-");
            }
            $i++;
        }
        return $tmp;
    }

    public function getDatosSegmentacion($result_id, $headers)
    {
        $tmp = [];

        foreach($headers as $header)
        {
            $ans = Answer::where('result_id', $result_id)
                    ->where('question_type', 'select')
                    ->where('question_title', $header)
                    ->orderBy('slide_id','desc')
                    ->first();
            if($ans && count($ans)>0)
            {
                if(isset($ans->value)) array_push($tmp, $ans->value);
                else array_push($tmp, "-");
            }
            else
                array_push($tmp, "-");
        }
        /*
        $ans = Answer::join('tresfera_taketsystem_results', 'tresfera_taketsystem_results.id', 'tresfera_taketsystem_answers.result_id')
                    ->join('tresfera_skillyouup_evaluacion', 'tresfera_taketsystem_results.evaluacion_id', 'tresfera_skillyouup_evaluacion.id')
                    ->where('tresfera_taketsystem_answers.result_id', $result_id)
                    ->where('tresfera_skillyouup_evaluacion.lang','es')
                    ->where('tresfera_taketsystem_answers.question_type','select')
                    ->select('tresfera_taketsystem_answers.*', 'tresfera_skillyouup_evaluacion.lang as idioma' )
                    ->orderBy('tresfera_taketsystem_answers.result_id','asc')
                    ->orderBy('tresfera_taketsystem_answers.slide_id','asc')
                    ->get();
        
        $slide_id = -1;
        foreach($ans as $result)
        {
            if($slide_id == $result->slide_id) $tmp[count($tmp)-1] = $result->value;
            else array_push($tmp, $result->value);
            $slide_id = $result->slide_id;
        }*/
        
        return $tmp;
    }
}

