<?php namespace Tresfera\Talentapp\Models;

use Model;

use Tresfera\Taketsystem\Models\Result;
use Tresfera\Taketsystem\Models\Quiz;
use Tresfera\Taketsystem\Models\Slide;
use Tresfera\TalentApp\Models\Evaluacion;
use Renatio\DynamicPDF\Classes\PDF;

/**
 * Model
 */
class Rapport extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_talentapp_rapports';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
      'evaluacion' => [
        'Tresfera\TalentApp\Models\Evaluacion'
      ],
      'proyecto' => [
        'Tresfera\TalentApp\Models\Proyecto'
      ]
    ];

    public $jsonable  = ["data"];

    public function beforeCreate() {
      
    }
    static function getRapportGlobal() {
      $rapport = \Tresfera\TalentApp\Models\Rapport::where("global","<>","0000-00-00 00:00:00")
                ->where("generated_at","<>","0000-00-00 00:00:00")->orderBy("global","DESC")->first();
      return $rapport;
    }
    static function getRapportGlobalInProgress() {
      $rapport = \Tresfera\TalentApp\Models\Rapport::where("global","<>","0000-00-00 00:00:00")
                ->whereNull("generated_at")->orderBy("global","DESC")->first();
      return $rapport;
    }
    static function getQuizzes() {
      return [
        "autoevaluacion" => [
          'es' => Quiz::find(3),
          'en' => Quiz::find(16),
        ],
        "evaluacion" => [
          'es' => Quiz::find(11),
          'en' => Quiz::find(13),
        ],
      ];
    }
    static function otherLang($lang) {
      if($lang == "es") return "en";
      return "es";
    }
    static function getLangs() {
      return ['es','en'];
    }
    static function translate($string) {
     // echo "buscamos: ".$string."\n";
      //recorremos los idiomas
      //recorremos los tipos de evaluacion
      foreach(SELF::getQuizzes() as $tipo=>$quizzes) {
    //    echo $tipo."\n";
        //recorremossssssssssssssssssssss los quizzes
        foreach($quizzes as $lang=>$quiz) {
          $slides = Slide::where("quiz_id",$quiz->id)
          ->whereIn("page",["explicativas/selects","explicativas/selects_en"])->orderBy("order")->get();
    //      echo " " . $lang."";
     //     echo " ".$quiz->id."\n";
          $i = 0;
          foreach($slides as $slide) {

            $campos = $slide->syntax_data;
            foreach($campos as $id=>$campo) {
              if( $id == "selects")
                foreach($campo as $id2=>$campo2) {
                    
                    foreach($campo2 as $id3=>$campo3) {
                      //echo $string." ".$campo3."\n";
                      if($campo3 == $string) {
//                        echo "Final: ".$i."\n";
                        $slides = Slide::where("quiz_id",$quizzes[SELF::otherLang($lang)]->id)
                        ->whereIn("page",["explicativas/selects","explicativas/selects_en"])->orderBy("order")->get();
                        if(isset($slides[$i]->syntax_data[$id][$id2][$id3])) 
                          return $slides[$i]->syntax_data[$id][$id2][$id3];
                      }
                    }
                }
            }
            $i++;
          }
        }
      }
    }

    public function getMd5() {
      return md5($this->evaluacion_id);
    }

    public function getUrl() {
      if(!is_file(base_path("/informes/".$this->getFileName()))) {
        if(is_file(base_path("/informes/".$this->getMd5().".pdf")))
          rename(base_path("/informes/".$this->getMd5().".pdf"),base_path("/informes/".$this->getFileName()));
      }
      return url("/informes/".$this->getFileName());      
    }

    public function getFileName() {
      if($this->evaluacion_id)
       return str_slug($this->evaluacion->name)."_talentapp360_".$this->created_at->format('Y-m-d').".pdf";
      if($this->proyecto_id)
       return str_slug($this->proyecto->name)."_talentapp360_".$this->created_at->format('Y-m-d').".pdf";
      if($this->global)
       return str_slug("global")."_talentapp360_".$this->created_at->format('Y-m-d_h:i:s').".pdf";

    }

    public function getFile($name="") {
      if($name) {
        return base_path("/informes/".$name);
      }
      if(!is_file(base_path("/informes/".$this->getFileName()))) {
        if(is_file(base_path("/informes/".$this->getMd5().".pdf")))
          rename(base_path("/informes/".$this->getMd5().".pdf"),base_path("/informes/".$this->getFileName()));
      }
      return base_path("/informes/".$this->getFileName());
    }

    public function generateData() {
      $evaluacion = \Tresfera\Talentapp\Models\Evaluacion::find($this->evaluacion_id);
      if(isset($evaluacion->id) && in_array('autoevaluacion',$evaluacion->tipo) && $evaluacion->proyecto->type != "edu") {

        $this->data = SELF::getDataAutoevaluadoRapport($this->evaluacion_id);
        //$data['competencias_masvaloradas'] = $competencias_masvaloradas->toArray();
      } else {
        if($this->proyecto_id) {
          $this->data = SELF::getDataRapport(null,$this->proyecto_id);
        }
        elseif($this->evaluacion_id) {
          $this->data = SELF::getDataRapport($this->evaluacion_id);
        }
        else
          $this->data = SELF::getDataRapport(null,null,1);

      }
      $this->save();
    }

    public function generatePdf($name="") {
      $theme = 'renatio::invoice';
      if($this->evaluacion->isAutoevaluacion()) {
        $theme = 'talentapp:autoevaluacion';
      }

      if(isset($this->evaluacion->id))
      if($this->evaluacion->proyecto->type == "edu")
        $theme = 'talentapp360:educacion';
       echo $theme;

      return PDF::loadTemplate($theme,$this->data)
                            ->setOptions(['isRemoteEnabled' => true,'dpi' => 150])
                            ->setPaper('a4', 'landscape')->save($this->getFile($name))->stream();
    }

    public function render() {
      $theme = 'renatio::invoice';

      if($this->evaluacion->isAutoevaluacion())
        $theme = 'talentapp:autoevaluacion';
      
      return PDF::loadTemplate($theme,$this->data)
                            ->setOptions(['isRemoteEnabled' => true,'dpi' => 150])
                            ->setPaper('a4', 'landscape')->save($this->getFile())->stream($this->getFile());
    }

    static function getDataRapport($id_evaluacion, $id_proyecto=null, $global=null, $filters=[], $rapport_id = null, $name=null) {
      if($id_evaluacion) {
        $evaluacion = Evaluacion::find($id_evaluacion);
        $frases = $evaluacion->getFrases();
      }
      if($id_proyecto) {
        $proyecto = Proyecto::find($id_proyecto);
        $frases = $proyecto->evaluaciones()->first()->getFrases();       
      }
      if($global) {
        $evaluacion = new Evaluacion();
        $frases = $evaluacion->getFrases();       
      }
        
        $hombre = ["Hombre","Male"];
        $mujer = ["Mujer","Female"];
        $generos = [
          "Hombre" => $hombre,
          "Male" => $hombre,
          "Female" => $mujer,
          "Mujer" => $mujer
        ];
        $edades_0 = ["15-19 year old","15-19 años"];
        $edades_1 = ["20-24 year old","20-24 años"];
        $edades_2 = ["25-29 year old","25-29 años"];
        $edades_3 = ["30-34 year old","30-34 años"];
        $edades_4 = ["35-39 year old","35-39 años"];
        $edades_5 = ["40-44 year old","40-44 años"];
        $edades_6 = ["45-49 year old","45-49 años"];
        $edades_7 = ["50-54 year old","50-54 años"];
        $edades_8 = ["55-59 year old","55-59 años"];
        $edades_9 = ["60-64 year old","60-64 años"];
        $edades_10 = ["65-69 year old","65-69 años"];
        $edades_11 = ["70 years or older","70 años o más"];

        $edades = [
          "15-19 year old" => $edades_0,
          "20-24 year old" => $edades_1,
          "25-29 year old" => $edades_2,
          "30-34 year old" => $edades_3,
          "35-39 year old" => $edades_4,
          "40-44 year old" => $edades_5,
          "45-49 year old" => $edades_6,
          "50-54 year old" => $edades_7,
          "55-59 year old" => $edades_8,
          "60-64 year old" => $edades_9,
          "65-69 year old" => $edades_10,
          "70 years or older" => $edades_11,
          "15-19 años" => $edades_0,
          "20-24 años" => $edades_1,
          "25-29 años" => $edades_2,
          "30-34 años" => $edades_3,
          "35-39 años" => $edades_4,
          "40-44 años" => $edades_5,
          "45-49 años" => $edades_6,
          "50-54 años" => $edades_7,
          "55-59 años" => $edades_8,
          "60-64 años" => $edades_9,
          "65-69 años" => $edades_10,
          "70 años o más" => $edades_11,
        ];

        if($id_evaluacion) {
          $evaluacion = \Tresfera\Talentapp\Models\Evaluacion::find($id_evaluacion);
  
          $resultAuto = Result::where("is_autoevaluacion",1)
                              ->where("evaluacion_id",$evaluacion->id)
                              ->where("tresfera_taketsystem_answers.duplicated",0)
                              ->where("tresfera_taketsystem_results.duplicated",0)
                              ->where("tresfera_taketsystem_answers.value",">",0)
                              ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');
          if($evaluacion->proyecto->type=="edu") {
           /* $evaluacionesEdu = \Tresfera\Talentapp\Models\Evaluacion::join("tresfera_talentapp_proyecto","tresfera_talentapp_proyecto_good.id","tresfera_talentapp_evaluacion.proyecto_id")
                                  ->where("type","edu")->lists("proyecto_id","tresfera_talentapp_evaluacion.id");*/
            $resultEval = Result::whereIn("quiz_id",[26,27])
              ->where("tresfera_taketsystem_answers.duplicated",0)
              ->where("tresfera_taketsystem_results.duplicated",0)
              ->where("tresfera_taketsystem_answers.value",">",0)
              ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');
          } else {
            $resultEval = Result::where("is_evaluacion",1)
              ->where("evaluacion_id",$evaluacion->id)
              ->where("tresfera_taketsystem_answers.duplicated",0)
              ->where("tresfera_taketsystem_results.duplicated",0)
              ->where("tresfera_taketsystem_answers.value",">",0)
              ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');
          }
    
          $resultTotal = Result::whereIn("quiz_id",[3,16])
                                ->where("tresfera_taketsystem_answers.duplicated",0)
                                ->where("tresfera_taketsystem_results.duplicated",0)                            
                                ->where("tresfera_taketsystem_answers.value",">",0)
                                ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');
    
        } elseif($id_proyecto) {
          $proyecto = \Tresfera\Talentapp\Models\Proyecto::find($id_proyecto);
          $resultAuto = Result::where("is_autoevaluacion",1)
                            ->whereIn("evaluacion_id",$proyecto->evaluaciones()->lists("id"))
                            ->where("tresfera_taketsystem_results.duplicated", 0);

          $resultEval = Result::where("is_evaluacion",1)
                      ->whereIn("evaluacion_id",$proyecto->evaluaciones()->lists("id"))
                      ->where("tresfera_taketsystem_results.duplicated",0);

          $resultTotal = Result::whereIn("quiz_id",[3,16])
                      ->where("tresfera_taketsystem_results.duplicated",0);

          if(count($filters)) {
            $resultAuto = Result::where("is_autoevaluacion",1)
              ->whereIn("evaluacion_id",$filters["evaluaciones"])
              ->where("tresfera_taketsystem_answers.duplicated", 0)
              ->where("tresfera_taketsystem_results.duplicated", 0)
              ->where("tresfera_taketsystem_answers.value", ">", 0)
              ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id')
              ->groupBy("tresfera_taketsystem_answers.result_id");

            $resultEval = Result::where("is_evaluacion",1)
                ->whereIn("evaluacion_id",$filters["evaluaciones"])
                ->where("tresfera_taketsystem_answers.duplicated",0)
                ->where("tresfera_taketsystem_results.duplicated",0)
                ->where("tresfera_taketsystem_answers.value",">",0)
                ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id')
                ->groupBy("tresfera_taketsystem_answers.result_id");
          }
          $totalCount =  with(clone $resultTotal)->count();
          $autoCount =  count(with(clone $resultAuto)->lists("tresfera_taketsystem_results.id"));
          $roles = ["jefe"=>"Superiores","companero"=>"Compañeros","colaborador"=>"Colaboradores","otro"=>"Otros"];
          foreach($roles as $rol=>$title) {
            $evalCount[$rol] =  [
              "count" => count(with(clone $resultEval)->where("rol",$rol)->lists("tresfera_taketsystem_results.id")),
              "title" => $title
            ];
          }
          //return [$autoCount,$evalCount,$totalCount];
          $resultAuto = Result::where("is_autoevaluacion",1)
              ->whereIn("evaluacion_id",$proyecto->evaluaciones()->lists("id"))
              ->where("tresfera_taketsystem_answers.duplicated", 0)
              ->where("tresfera_taketsystem_results.duplicated", 0)
              ->where("tresfera_taketsystem_answers.value", ">", 0)
              ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

          $resultEval = Result::where("is_evaluacion",1)
              ->whereIn("evaluacion_id",$proyecto->evaluaciones()->lists("id"))
              ->where("tresfera_taketsystem_answers.duplicated",0)
              ->where("tresfera_taketsystem_results.duplicated",0)
              ->where("tresfera_taketsystem_answers.value",">",0)
              ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

          $resultTotal = Result::whereIn("quiz_id",[3,16])
              ->where("tresfera_taketsystem_answers.duplicated",0)
              ->where("tresfera_taketsystem_results.duplicated",0)                            
              ->where("tresfera_taketsystem_answers.value",">",0)
              ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');
          if(count($filters)) {
            $resultAuto = Result::where("is_autoevaluacion",1)
              ->whereIn("evaluacion_id",$filters["evaluaciones"])
              ->where("tresfera_taketsystem_answers.duplicated", 0)
              ->where("tresfera_taketsystem_results.duplicated", 0)
              ->where("tresfera_taketsystem_answers.value", ">", 0)
              ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

            $resultEval = Result::where("is_evaluacion",1)
                ->whereIn("evaluacion_id",$filters["evaluaciones"])
                ->where("tresfera_taketsystem_answers.duplicated",0)
                ->where("tresfera_taketsystem_results.duplicated",0)
                ->where("tresfera_taketsystem_answers.value",">",0)
                ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

            $resultTotal = Result::whereIn("quiz_id",[3,16])
                ->where("tresfera_taketsystem_answers.duplicated",0)
                ->where("tresfera_taketsystem_results.duplicated",0)                            
                ->where("tresfera_taketsystem_answers.value",">",0)
                ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');
  
          }
        } elseif($global) {
          $resultAuto = Result::where("is_autoevaluacion",1)
                              ->where("tresfera_taketsystem_results.duplicated",0)
                              ->where("tresfera_taketsystem_results.import",0);
          $resultAutoImport = Result::where("is_autoevaluacion",1)
                              ->where("tresfera_taketsystem_results.import",1)
                              ->where("tresfera_taketsystem_results.duplicated",0);
          $resultEval = Result::where("is_evaluacion",1)
                              ->where("tresfera_taketsystem_results.duplicated",0);
          $resultTotal = Result::whereIn("quiz_id",[3,16])
                              ->where("tresfera_taketsystem_results.duplicated",0);  
                       
          $totalCount =  with(clone $resultTotal)->count();
          $autoCount =  with(clone $resultAuto)->count();
          $autoImportCount =  with(clone $resultAutoImport)->count();

          $roles = ["jefe"=>"Superiores","companero"=>"Compañeros","colaborador"=>"Colaboradores","otro"=>"Otros"];
          foreach($roles as $rol=>$title) {
            $evalCount[$rol] =  [
              "count" => with(clone $resultEval)->where("rol",$rol)->count(),
              "title" => $title
            ];
          }

          $resultAuto = Result::where("is_autoevaluacion",1)
                      ->where("tresfera_taketsystem_answers.duplicated",0)
                      ->where("tresfera_taketsystem_results.duplicated",0)
                      ->where("tresfera_taketsystem_answers.value",">",0)
                      ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');
          $resultEval = Result::where("is_evaluacion",1)
                      ->where("tresfera_taketsystem_answers.duplicated",0)
                      ->where("tresfera_taketsystem_results.duplicated",0)
                      ->where("tresfera_taketsystem_answers.value",">",0)
                      ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');
          $resultTotal = Result::whereIn("quiz_id",[3,16])
                          ->where("tresfera_taketsystem_answers.duplicated",0)
                          ->where("tresfera_taketsystem_results.duplicated",0)                            
                          ->where("tresfera_taketsystem_answers.value",">",0)
                          ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

        }
        
        

        $competencias = [];                      
  
        $dimension_estrategica_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","ESTRATÉGICA")->first()->value;;
        $dimension_estrategica_auto = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","ESTRATÉGICA")->first()->value;
        $dimension_estrategica_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","ESTRATÉGICA")->first()->value;      ;

        $dimension_interpersonal_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","INTERPERSONAL")->first()->value;
        $dimension_interpersonal_auto = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","INTERPERSONAL")->first()->value;
        $dimension_interpersonal_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","INTERPERSONAL")->first()->value;
  
        $dimension_autogestion_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","AUTOGESTIÓN")->first()->value;;
        $dimension_autogestion_auto = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","AUTOGESTIÓN")->first()->value;
        $dimension_autogestion_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","AUTOGESTIÓN")->first()->value;
  
        $dimension_autodesarrollo_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","AUTODESARROLLO")->first()->value;;
        $dimension_autodesarrollo_auto = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","AUTODESARROLLO")->first()->value;
        $dimension_autodesarrollo_total =  with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","AUTODESARROLLO")->first()->value;
  
        $dimension_autoliderazgo_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","AUTOGOBIERNO")->first()->value;;
        $dimension_autoliderazgo_auto = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","AUTOGOBIERNO")->first()->value;
        $dimension_autoliderazgo_total =  with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","AUTOGOBIERNO")->first()->value;
  
  
        //pag 14
        $dimension_estrategica_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_estrategica_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_estrategica_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("rol","companero")
        ->first()->value;
        $dimension_estrategica_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("rol","otros")
        ->first()->value;
      
        $dimension_estrategica_estrategica_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Visión Estratégica")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_estrategica_estrategica_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Visión Estratégica")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_estrategica_estrategica_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Visión Estratégica")
        ->where("rol","companero")
        ->first()->value;
        $dimension_estrategica_estrategica_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Visión Estratégica")
        ->where("rol","otros")
        ->first()->value;
  
        $estrategica_estrategica_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Visión Estratégica")
        ->where("question_dimension","ESTRATÉGICA")
        ->first()->value;
        $estrategica_estrategica_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Visión Estratégica")
        ->where("question_dimension","ESTRATÉGICA")
        ->first()->value;
        $estrategica_estrategica_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Visión Estratégica")
        ->where("question_dimension","ESTRATÉGICA")
        ->first()->value;
  
        $competencias["Visión Estratégica"] = [
          "evaluadores" => $estrategica_estrategica_evaluadores,
          "autoevaluador" => $estrategica_estrategica_autoevaluador,
          "total" => $estrategica_estrategica_total,
          "diferencia" => $estrategica_estrategica_autoevaluador - $estrategica_estrategica_evaluadores,
        ];
  
  
        $dimension_estrategica_organizacion_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Visión de la Organización")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_estrategica_organizacion_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Visión de la Organización")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_estrategica_organizacion_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Visión de la Organización")
        ->where("rol","companero")
        ->first()->value;
        $dimension_estrategica_organizacion_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Visión de la Organización")
        ->where("rol","otros")
        ->first()->value;
  
        $estrategica_organizacion_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Visión de la Organización")
        ->where("question_dimension","ESTRATÉGICA")
        ->first()->value;
        $estrategica_organizacion_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Visión de la Organización")
        ->where("question_dimension","ESTRATÉGICA")
        ->first()->value;
        $estrategica_organizacion_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Visión de la Organización")
        ->where("question_dimension","ESTRATÉGICA")
        ->first()->value;
        $competencias["Visión de la Organización"] = [
          "evaluadores" => $estrategica_organizacion_evaluadores,
          "autoevaluador" => $estrategica_organizacion_autoevaluador,
          "total" => $estrategica_organizacion_total,
          "diferencia" => $estrategica_organizacion_autoevaluador - $estrategica_organizacion_evaluadores,
        ];
  
        $dimension_estrategica_networking_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Networking")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_estrategica_networking_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Networking")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_estrategica_networking_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Networking")
        ->where("rol","companero")
        ->first()->value;
        $dimension_estrategica_networking_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Networking")
        ->where("rol","otros")
        ->first()->value;
  
        $estrategica_networking_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Networking")
        ->where("question_dimension","ESTRATÉGICA")
        ->first()->value;
        $estrategica_networking_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Networking")
        ->where("question_dimension","ESTRATÉGICA")
        ->first()->value;
        $estrategica_networking_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Networking")
        ->where("question_dimension","ESTRATÉGICA")
        ->first()->value;
  
        $competencias["Networking"] = [
          "evaluadores" => $estrategica_networking_evaluadores,
          "autoevaluador" => $estrategica_networking_autoevaluador,
          "total" => $estrategica_networking_total,
          "diferencia" => $estrategica_networking_autoevaluador - $estrategica_networking_evaluadores,
        ];
        
  
        $dimension_estrategica_cliente_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Orientación al Cliente")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_estrategica_cliente_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Orientación al Cliente")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_estrategica_cliente_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Orientación al Cliente")
        ->where("rol","companero")
        ->first()->value;
        $dimension_estrategica_cliente_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Orientación al Cliente")
        ->where("rol","otros")
        ->first()->value;
  
        $estrategica_cliente_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Orientación al Cliente")
        ->where("question_dimension","ESTRATÉGICA")
        ->first()->value;
        $estrategica_cliente_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Orientación al Cliente")
        ->where("question_dimension","ESTRATÉGICA")
        ->first()->value;
        $estrategica_cliente_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Orientación al Cliente")
        ->where("question_dimension","ESTRATÉGICA")
        ->first()->value;
  
        $competencias["Orientación al Cliente"] = [
          "evaluadores" => $estrategica_cliente_evaluadores,
          "autoevaluador" => $estrategica_cliente_autoevaluador,
          "total" => $estrategica_cliente_total,
          "diferencia" => $estrategica_cliente_autoevaluador - $estrategica_cliente_evaluadores,
        ];
        if($id_evaluacion) {
        if( isset($evaluacion->result->edad) and isset($edades[$evaluacion->result->edad]))
        {
          $estrategica_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","ESTRATÉGICA")
          ->whereIn("edad",$edades[$evaluacion->result->edad])
          ->first()->value;
        }
        //else if(isset($evaluacion->result->age) )
        else if( isset($evaluacion->result->age) and isset($edades[$evaluacion->result->age]))
        {
          $estrategica_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","ESTRATÉGICA")
          ->where("edad",$evaluacion->result->age)
          ->first()->value;
        }
        else $estrategica_edad = "";

        if(isset($evaluacion->result->sector) )
        {
          $estrategica_sector = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
            ->where("question_dimension","ESTRATÉGICA")
            ->whereIn("sector",[$evaluacion->result->sector,SELF::translate($evaluacion->result->sector)])

            ->first()->value;
        }
        else $estrategica_sector = "";

        //if(isset($evaluacion->result->genero) )
        if( isset($evaluacion->result->genero) and isset($generos[$evaluacion->result->genero]))
        {
          $estrategica_genero = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","ESTRATÉGICA")
          ->whereIn("genero",$generos[$evaluacion->result->genero])
          ->first()->value;
        }
        else $estrategica_genero = "";

        
        if( isset($evaluacion->result->area) )
        {
          $estrategica_area = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","ESTRATÉGICA")
          ->whereIn("area",[$evaluacion->result->area,SELF::translate($evaluacion->result->area)])

          ->first()->value;
        }
        else $estrategica_area = "";

        
        if( isset($evaluacion->result->funcion) )
        {
          $estrategica_funcion = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
            ->where("question_dimension","ESTRATÉGICA")
            ->whereIn("funcion",[$evaluacion->result->funcion,SELF::translate($evaluacion->result->funcion)])
            ->first()->value;
        }
        else $estrategica_funcion = "";
        }
          //$this->generatePolar();
  
        //pag 14b
        $dimension_interpersonal_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","INTERPERSONAL")
          ->where("rol","jefe")
          ->first()->value;
        $dimension_interpersonal_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","INTERPERSONAL")
          ->where("rol","colaborador")
          ->first()->value;
        $dimension_interpersonal_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","INTERPERSONAL")
          ->where("rol","companero")
          ->first()->value;
        $dimension_interpersonal_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","INTERPERSONAL")
          ->where("rol","otros")
          ->first()->value;
  
        $dimension_interpersonal_estrategica_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Comunicación")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_interpersonal_estrategica_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Comunicación")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_interpersonal_estrategica_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Comunicación")
        ->where("rol","companero")
        ->first()->value;
        $dimension_interpersonal_estrategica_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Comunicación")
        ->where("rol","otros")
        ->first()->value;
  
        $interpersonal_estrategica_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Comunicación")
        ->where("question_dimension","INTERPERSONAL")
        ->first()->value;
        $interpersonal_estrategica_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Comunicación")
        ->where("question_dimension","INTERPERSONAL")
        ->first()->value;
        $interpersonal_estrategica_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Comunicación")
        ->where("question_dimension","INTERPERSONAL")
        ->first()->value;
  
        $competencias["Comunicación"] = [
          "evaluadores" => $interpersonal_estrategica_evaluadores,
          "autoevaluador" => $interpersonal_estrategica_autoevaluador,
          "total" => $interpersonal_estrategica_total,
          "diferencia" => $interpersonal_estrategica_autoevaluador - $interpersonal_estrategica_evaluadores,
        ];
  
        $dimension_interpersonal_organizacion_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Delegación")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_interpersonal_organizacion_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Delegación")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_interpersonal_organizacion_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Delegación")
        ->where("rol","companero")
        ->first()->value;
        $dimension_interpersonal_organizacion_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Delegación")
        ->where("rol","otros")
        ->first()->value;
  
        $interpersonal_organizacion_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Delegación")
        ->where("question_dimension","INTERPERSONAL")
        ->first()->value;
        $interpersonal_organizacion_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Delegación")
        ->where("question_dimension","INTERPERSONAL")
        ->first()->value;
        $interpersonal_organizacion_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Delegación")
        ->where("question_dimension","INTERPERSONAL")
        ->first()->value;
  
        $competencias["Delegación"] = [
          "evaluadores" => $interpersonal_organizacion_evaluadores,
          "autoevaluador" => $interpersonal_organizacion_autoevaluador,
          "total" => $interpersonal_organizacion_total,
          "diferencia" => $interpersonal_organizacion_autoevaluador - $interpersonal_organizacion_evaluadores,
        ];
  
  
        $dimension_interpersonal_networking_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Coaching")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_interpersonal_networking_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Coaching")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_interpersonal_networking_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Coaching")
        ->where("rol","companero")
        ->first()->value;
        $dimension_interpersonal_networking_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Coaching")
        ->where("rol","otros")
        ->first()->value;
  
        $interpersonal_networking_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Coaching")
        ->where("question_dimension","INTERPERSONAL")
        ->first()->value;
        $interpersonal_networking_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Coaching")
        ->where("question_dimension","INTERPERSONAL")
        ->first()->value;
        $interpersonal_networking_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Coaching")
        ->where("question_dimension","INTERPERSONAL")
        ->first()->value;
        
        $competencias["Coaching"] = [
          "evaluadores" => $interpersonal_networking_evaluadores,
          "autoevaluador" => $interpersonal_networking_autoevaluador,
          "total" => $interpersonal_networking_total,
          "diferencia" => $interpersonal_networking_autoevaluador - $interpersonal_networking_evaluadores,
        ];
  
        $dimension_interpersonal_cliente_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Trabajo en Equipo")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_interpersonal_cliente_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Trabajo en Equipo")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_interpersonal_cliente_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Trabajo en Equipo")
        ->where("rol","companero")
        ->first()->value;
        $dimension_interpersonal_cliente_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Trabajo en Equipo")
        ->where("rol","otros")
        ->first()->value;
  
        $interpersonal_cliente_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Trabajo en Equipo")
        ->where("question_dimension","INTERPERSONAL")
        ->first()->value;
        $interpersonal_cliente_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Trabajo en Equipo")
        ->where("question_dimension","INTERPERSONAL")
        ->first()->value;
        $interpersonal_cliente_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Trabajo en Equipo")
        ->where("question_dimension","INTERPERSONAL")
        ->first()->value;
        $competencias["Trabajo en Equipo"] = [
          "evaluadores" => $interpersonal_cliente_evaluadores,
          "autoevaluador" => $interpersonal_cliente_autoevaluador,
          "total" => $interpersonal_cliente_total,
          "diferencia" => $interpersonal_cliente_autoevaluador - $interpersonal_cliente_evaluadores,
        ];
        if($id_evaluacion) {

        //if(isset($evaluacion->result->edad) )
        if( isset($evaluacion->result->edad) and isset($edades[$evaluacion->result->edad]))
        {
          $interpersonal_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","INTERPERSONAL")
          ->whereIn("edad",$edades[$evaluacion->result->edad])
          ->first()->value;
        }
        //else if(isset($evaluacion->result->age) )
        else if( isset($evaluacion->result->age) and isset($edades[$evaluacion->result->age]))
        {
          $interpersonal_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","INTERPERSONAL")
          ->where("edad",$evaluacion->result->age)
          ->first()->value;
        }
        else $interpersonal_edad = "";
        
        if( isset($evaluacion->result->sector) )
        {
          $interpersonal_sector = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","INTERPERSONAL")
          ->whereIn("sector",[$evaluacion->result->sector,SELF::translate($evaluacion->result->sector)])
          ->first()->value;
        }
        else $interpersonal_sector = "";

        //if(isset($evaluacion->result->genero) )
        if( isset($evaluacion->result->genero) and isset($generos[$evaluacion->result->genero]))
        {
          $interpersonal_genero = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","INTERPERSONAL")
          ->whereIn("genero",$generos[$evaluacion->result->genero])
          ->first()->value;
        }
        else $interpersonal_genero = "";

        if( isset($evaluacion->result->area) )
        {
          $interpersonal_area = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","INTERPERSONAL")
          
          ->whereIn("area",[$evaluacion->result->area,SELF::translate($evaluacion->result->area)])
          ->first()->value;
        }
        else $interpersonal_area = "";

        if( isset($evaluacion->result->funcion) )
        {
          $interpersonal_funcion = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","INTERPERSONAL")
          ->whereIn("funcion",[$evaluacion->result->funcion,SELF::translate($evaluacion->result->funcion)])
          ->first()->value;
        }
        else $interpersonal_funcion = "";
      }
        
        //pag 14C
        $dimension_autogestion_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_autogestion_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_autogestion_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("rol","companero")
        ->first()->value;
        $dimension_autogestion_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("rol","otros")
        ->first()->value;
  
        $dimension_autogestion_estrategica_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Optimismo")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_autogestion_estrategica_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Optimismo")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_autogestion_estrategica_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Optimismo")
        ->where("rol","companero")
        ->first()->value;
        $dimension_autogestion_estrategica_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Optimismo")
        ->where("rol","otros")
        ->first()->value;
  
        $autogestion_estrategica_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Optimismo")
        ->where("question_dimension","AUTOGESTION")
        ->first()->value;
        $autogestion_estrategica_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Optimismo")
        ->where("question_dimension","AUTOGESTION")
        ->first()->value;
        $autogestion_estrategica_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Optimismo")
        ->where("question_dimension","AUTOGESTION")
        ->first()->value;
        $competencias["Optimismo"] = [
          "evaluadores" => $autogestion_estrategica_evaluadores,
          "autoevaluador" => $autogestion_estrategica_autoevaluador,
          "total" => $autogestion_estrategica_total,
          "diferencia" => $autogestion_estrategica_autoevaluador - $autogestion_estrategica_evaluadores,
        ];
        $dimension_autogestion_organizacion_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Gestión del Tiempo")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_autogestion_organizacion_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Gestión del Tiempo")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_autogestion_organizacion_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Gestión del Tiempo")
        ->where("rol","companero")
        ->first()->value;
        $dimension_autogestion_organizacion_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Gestión del Tiempo")
        ->where("rol","otros")
        ->first()->value;
  
        $autogestion_organizacion_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Gestión del Tiempo")
        ->where("question_dimension","AUTOGESTION")
        ->first()->value;
        $autogestion_organizacion_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Gestión del Tiempo")
        ->where("question_dimension","AUTOGESTION")
        ->first()->value;
        $autogestion_organizacion_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Gestión del Tiempo")
        ->where("question_dimension","AUTOGESTION")
        ->first()->value;
        $competencias["Gestión del Tiempo"] = [
          "evaluadores" => $autogestion_organizacion_evaluadores,
          "autoevaluador" => $autogestion_organizacion_autoevaluador,
          "total" => $autogestion_organizacion_total,
          "diferencia" => $autogestion_organizacion_autoevaluador - $autogestion_organizacion_evaluadores,
        ];
        $dimension_autogestion_networking_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Iniciativa")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_autogestion_networking_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Iniciativa")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_autogestion_networking_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Iniciativa")
        ->where("rol","companero")
        ->first()->value;
        $dimension_autogestion_networking_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Iniciativa")
        ->where("rol","otros")
        ->first()->value;
  
        $autogestion_networking_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Iniciativa")
        ->where("question_dimension","AUTOGESTION")
        ->first()->value;
        $autogestion_networking_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Iniciativa")
        ->where("question_dimension","AUTOGESTION")
        ->first()->value;
        $autogestion_networking_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Iniciativa")
        ->where("question_dimension","AUTOGESTION")
        ->first()->value;
  
        $competencias["Iniciativa"] = [
          "evaluadores" => $autogestion_networking_evaluadores,
          "autoevaluador" => $autogestion_networking_autoevaluador,
          "total" => $autogestion_networking_total,
          "diferencia" => $autogestion_networking_autoevaluador - $autogestion_networking_evaluadores,
        ];
  
        $dimension_autogestion_cliente_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Gestión del Estrés")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_autogestion_cliente_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Gestión del Estrés")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_autogestion_cliente_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Gestión del Estrés")
        ->where("rol","companero")
        ->first()->value;
        $dimension_autogestion_cliente_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Gestión del Estrés")
        ->where("rol","otros")
        ->first()->value;
  
        $autogestion_cliente_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Gestión del Estrés")
        ->where("question_dimension","AUTOGESTION")
        ->first()->value;
        $autogestion_cliente_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Gestión del Estrés")
        ->where("question_dimension","AUTOGESTION")
        ->first()->value;
        $autogestion_cliente_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Gestión del Estrés")
        ->where("question_dimension","AUTOGESTION")
        ->first()->value;
        $competencias["Gestión del Estrés"] = [
          "evaluadores" => $autogestion_cliente_evaluadores,
          "autoevaluador" => $autogestion_cliente_autoevaluador,
          "total" => $autogestion_cliente_total,
          "diferencia" => $autogestion_cliente_autoevaluador - $autogestion_cliente_evaluadores,
        ];
        if($id_evaluacion) {

        //if(isset($evaluacion->result->edad) )
        if( isset($evaluacion->result->edad) and isset($edades[$evaluacion->result->edad]))
        {
          $autogestion_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","AUTOGESTION")
          ->whereIn("edad",$edades[$evaluacion->result->edad])
          ->first()->value;
        }
        //else if(isset($evaluacion->result->age) )
        else if( isset($evaluacion->result->age) and isset($edades[$evaluacion->result->age]))
        {
          $autogestion_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","AUTOGESTION")
          ->where("edad",$evaluacion->result->age)
          ->first()->value;
        }
        else $autogestion_edad = "";

        if( isset($evaluacion->result->sector) )
        {
          $autogestion_sector = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","AUTOGESTION")
          ->whereIn("sector",[$evaluacion->result->sector,SELF::translate($evaluacion->result->sector)])
          ->first()->value;
        }
        else $autogestion_sector = "";

        //if(isset($evaluacion->result->genero) )
        if( isset($evaluacion->result->genero) and isset($generos[$evaluacion->result->genero]))
        {
          $autogestion_genero = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","AUTOGESTION")
          ->whereIn("genero",$generos[$evaluacion->result->genero])
          ->first()->value;
        }
        else $autogestion_genero = "";

        if( isset($evaluacion->result->area) )
        {
          $autogestion_area = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","AUTOGESTION")
          ->whereIn("area",[$evaluacion->result->area,SELF::translate($evaluacion->result->area)])
          ->first()->value;
        }
        else $autogestion_area = "";

        if( isset($evaluacion->result->funcion) )
        {
          $autogestion_funcion = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","AUTOGESTION")
          ->whereIn("funcion",[$evaluacion->result->funcion,SELF::translate($evaluacion->result->funcion)])
          ->first()->value;
        }
        else $autogestion_funcion = "";
      }
        
     //pag 14D
     $dimension_autodesarrollo_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("rol","jefe")
     ->first()->value;
     $dimension_autodesarrollo_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("rol","colaborador")
     ->first()->value;
     $dimension_autodesarrollo_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("rol","companero")
     ->first()->value;
     $dimension_autodesarrollo_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("rol","otros")
     ->first()->value;
  
     $dimension_autodesarrollo_estrategica_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Aprendizaje")
     ->where("rol","jefe")
     ->first()->value;
     $dimension_autodesarrollo_estrategica_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Aprendizaje")
     ->where("rol","colaborador")
     ->first()->value;
     $dimension_autodesarrollo_estrategica_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Aprendizaje")
     ->where("rol","companero")
     ->first()->value;
     $dimension_autodesarrollo_estrategica_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Aprendizaje")
     ->where("rol","otros")
     ->first()->value;
  
     $autodesarrollo_estrategica_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_competencia","Aprendizaje")
     ->where("question_dimension","AUTODESARROLLO")
     ->first()->value;
     $autodesarrollo_estrategica_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
     ->where("question_competencia","Aprendizaje")
     ->where("question_dimension","AUTODESARROLLO")
     ->first()->value;
     $autodesarrollo_estrategica_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
     ->where("question_competencia","Aprendizaje")
     ->where("question_dimension","AUTODESARROLLO")
     ->first()->value;
     $competencias["Aprendizaje"] = [
      "evaluadores" => $autodesarrollo_estrategica_evaluadores,
      "autoevaluador" => $autodesarrollo_estrategica_autoevaluador,
      "total" => $autodesarrollo_estrategica_total,
      "diferencia" => $autodesarrollo_estrategica_autoevaluador - $autodesarrollo_estrategica_evaluadores,
    ];
     $dimension_autodesarrollo_organizacion_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Autoconocimiento")
     ->where("rol","jefe")
     ->first()->value;
     $dimension_autodesarrollo_organizacion_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Autoconocimiento")
     ->where("rol","colaborador")
     ->first()->value;
     $dimension_autodesarrollo_organizacion_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Autoconocimiento")
     ->where("rol","companero")
     ->first()->value;
     $dimension_autodesarrollo_organizacion_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Autoconocimiento")
     ->where("rol","otros")
     ->first()->value;
  
     $autodesarrollo_organizacion_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_competencia","Autoconocimiento")
     ->where("question_dimension","AUTODESARROLLO")
     ->first()->value;
     $autodesarrollo_organizacion_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
     ->where("question_competencia","Autoconocimiento")
     ->where("question_dimension","AUTODESARROLLO")
     ->first()->value;
     $autodesarrollo_organizacion_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
     ->where("question_competencia","Autoconocimiento")
     ->where("question_dimension","AUTODESARROLLO")
     ->first()->value;
     $competencias["Autoconocimiento"] = [
      "evaluadores" => $autodesarrollo_organizacion_evaluadores,
      "autoevaluador" => $autodesarrollo_organizacion_autoevaluador,
      "total" => $autodesarrollo_organizacion_total,
      "diferencia" => $autodesarrollo_organizacion_autoevaluador - $autodesarrollo_organizacion_evaluadores,
    ];
     $dimension_autodesarrollo_networking_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Autocrítica")
     ->where("rol","jefe")
     ->first()->value;
     $dimension_autodesarrollo_networking_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Autocrítica")
     ->where("rol","colaborador")
     ->first()->value;
     $dimension_autodesarrollo_networking_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Autocrítica")
     ->where("rol","companero")
     ->first()->value;
     $dimension_autodesarrollo_networking_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Autocrítica")
     ->where("rol","otros")
     ->first()->value;
  
     $autodesarrollo_networking_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_competencia","Autocrítica")
     ->where("question_dimension","AUTODESARROLLO")
     ->first()->value;
     $autodesarrollo_networking_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
     ->where("question_competencia","Autocrítica")
     ->where("question_dimension","AUTODESARROLLO")
     ->first()->value;
     $autodesarrollo_networking_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
     ->where("question_competencia","Autocrítica")
     ->where("question_dimension","AUTODESARROLLO")
     ->first()->value;
     $competencias["Autocrítica"] = [
      "evaluadores" => $autodesarrollo_networking_evaluadores,
      "autoevaluador" => $autodesarrollo_networking_autoevaluador,
      "total" => $autodesarrollo_networking_total,
      "diferencia" => $autodesarrollo_networking_autoevaluador - $autodesarrollo_networking_evaluadores,
    ];
     $dimension_autodesarrollo_cliente_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Ambición")
     ->where("rol","jefe")
     ->first()->value;
     $dimension_autodesarrollo_cliente_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Ambición")
     ->where("rol","colaborador")
     ->first()->value;
     $dimension_autodesarrollo_cliente_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Ambición")
     ->where("rol","companero")
     ->first()->value;
     $dimension_autodesarrollo_cliente_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Ambición")
     ->where("rol","otros")
     ->first()->value;
  
     $autodesarrollo_cliente_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_competencia","Ambición")
     ->where("question_dimension","AUTODESARROLLO")
     ->first()->value;
     $autodesarrollo_cliente_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
     ->where("question_competencia","Ambición")
     ->where("question_dimension","AUTODESARROLLO")
     ->first()->value;
     $autodesarrollo_cliente_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
     ->where("question_competencia","Ambición")
     ->where("question_dimension","AUTODESARROLLO")
     ->first()->value;
     $competencias["Ambición"] = [
      "evaluadores" => $autodesarrollo_cliente_evaluadores,
      "autoevaluador" => $autodesarrollo_cliente_autoevaluador,
      "total" => $autodesarrollo_cliente_total,
      "diferencia" => $autodesarrollo_cliente_autoevaluador - $autodesarrollo_cliente_evaluadores,
    ];
    if($id_evaluacion) {

    //if(isset($evaluacion->result->edad) )
    if( isset($evaluacion->result->edad) and isset($edades[$evaluacion->result->edad]))
    {
      $autodesarrollo_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","AUTODESARROLLO")
      ->whereIn("edad",$edades[$evaluacion->result->edad])
      ->first()->value;
    }
    //else if(isset($evaluacion->result->age) )
    else if( isset($evaluacion->result->age) and isset($edades[$evaluacion->result->age]))
    {
      $autodesarrollo_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","AUTODESARROLLO")
      ->where("edad",$evaluacion->result->age)
      ->first()->value;
    }
    else $autodesarrollo_edad = "";

    if( isset($evaluacion->result->sector) )
    {
     $autodesarrollo_sector = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->whereIn("sector",[$evaluacion->result->sector,SELF::translate($evaluacion->result->sector)])
     ->first()->value;
    }
    else $autodesarrollo_sector = "";

    //if(isset($evaluacion->result->genero) )
    if( isset($evaluacion->result->genero) and isset($generos[$evaluacion->result->genero]))
    {
      $autodesarrollo_genero = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->whereIn("genero",$generos[$evaluacion->result->genero])
     ->first()->value;
    }
    else $autodesarrollo_genero = "";

    if( isset($evaluacion->result->area) )
    {
     $autodesarrollo_area = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->whereIn("area",[$evaluacion->result->area,SELF::translate($evaluacion->result->area)])
     ->first()->value;
    }
    else $autodesarrollo_area = "";

    if( isset($evaluacion->result->funcion) )
    {
     $autodesarrollo_funcion = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->whereIn("funcion",[$evaluacion->result->funcion,SELF::translate($evaluacion->result->funcion)])
     ->first()->value;
    }
    else $autodesarrollo_funcion = "";
  }
  
           //pag 14E
           $dimension_autoliderazgo_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("rol","jefe")
           ->first()->value;
           $dimension_autoliderazgo_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("rol","colaborador")
           ->first()->value;
           $dimension_autoliderazgo_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("rol","companero")
           ->first()->value;
           $dimension_autoliderazgo_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("rol","otros")
           ->first()->value;
     
           $dimension_autoliderazgo_estrategica_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Integridad")
           ->where("rol","jefe")
           ->first()->value;
           $dimension_autoliderazgo_estrategica_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Integridad")
           ->where("rol","colaborador")
           ->first()->value;
           $dimension_autoliderazgo_estrategica_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Integridad")
           ->where("rol","companero")
           ->first()->value;
           $dimension_autoliderazgo_estrategica_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Integridad")
           ->where("rol","otros")
           ->first()->value;
     
           $autoliderazgo_estrategica_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia","Integridad")
           ->where("question_dimension","AUTOGOBIERNO")
           ->first()->value;
           $autoliderazgo_estrategica_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia","Integridad")
           ->where("question_dimension","AUTOGOBIERNO")
           ->first()->value;
           $autoliderazgo_estrategica_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia","Integridad")
           ->where("question_dimension","AUTOGOBIERNO")
           ->first()->value;
           $competencias["Integridad"] = [
            "evaluadores" => $autoliderazgo_estrategica_evaluadores,
            "autoevaluador" => $autoliderazgo_estrategica_autoevaluador,
            "total" => $autoliderazgo_estrategica_total,
            "diferencia" => $autoliderazgo_estrategica_autoevaluador - $autoliderazgo_estrategica_evaluadores,
          ];
           $dimension_autoliderazgo_organizacion_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Toma de Decisiones")
           ->where("rol","jefe")
           ->first()->value;
           $dimension_autoliderazgo_organizacion_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Toma de Decisiones")
           ->where("rol","colaborador")
           ->first()->value;
           $dimension_autoliderazgo_organizacion_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Toma de Decisiones")
           ->where("rol","companero")
           ->first()->value;
           $dimension_autoliderazgo_organizacion_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Toma de Decisiones")
           ->where("rol","otros")
           ->first()->value;
     
           $autoliderazgo_organizacion_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia","Toma de Decisiones")
           ->where("question_dimension","AUTOGOBIERNO")
           ->first()->value;
           $autoliderazgo_organizacion_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia","Toma de Decisiones")
           ->where("question_dimension","AUTOGOBIERNO")
           ->first()->value;
           $autoliderazgo_organizacion_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia","Toma de Decisiones")
           ->where("question_dimension","AUTOGOBIERNO")
           ->first()->value;
     
           $competencias["Toma de Decisiones"] = [
            "evaluadores" => $autoliderazgo_organizacion_evaluadores,
            "autoevaluador" => $autoliderazgo_organizacion_autoevaluador,
            "total" => $autoliderazgo_organizacion_total,
            "diferencia" => $autoliderazgo_organizacion_autoevaluador - $autoliderazgo_organizacion_evaluadores,
          ];
  
           $dimension_autoliderazgo_networking_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Autocontrol")
           ->where("rol","jefe")
           ->first()->value;
           $dimension_autoliderazgo_networking_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Autocontrol")
           ->where("rol","colaborador")
           ->first()->value;
           $dimension_autoliderazgo_networking_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Autocontrol")
           ->where("rol","companero")
           ->first()->value;
           $dimension_autoliderazgo_networking_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Autocontrol")
           ->where("rol","otros")
           ->first()->value;
     
           $autoliderazgo_networking_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia","Autocontrol")
           ->where("question_dimension","AUTOGOBIERNO")
           ->first()->value;
           $autoliderazgo_networking_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia","Autocontrol")
           ->where("question_dimension","AUTOGOBIERNO")
           ->first()->value;
           $autoliderazgo_networking_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia","Autocontrol")
           ->where("question_dimension","AUTOGOBIERNO")
           ->first()->value;
     
           $competencias["Autocontrol"] = [
            "evaluadores" => $autoliderazgo_networking_evaluadores,
            "autoevaluador" => $autoliderazgo_networking_autoevaluador,
            "total" => $autoliderazgo_networking_total,
            "diferencia" => $autoliderazgo_networking_autoevaluador - $autoliderazgo_networking_evaluadores,
          ];
  
           $dimension_autoliderazgo_cliente_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Equilibrio Emocional")
           ->where("rol","jefe")
           ->first()->value;
           $dimension_autoliderazgo_cliente_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Equilibrio Emocional")
           ->where("rol","colaborador")
           ->first()->value;
           $dimension_autoliderazgo_cliente_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Equilibrio Emocional")
           ->where("rol","companero")
           ->first()->value;
           $dimension_autoliderazgo_cliente_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Equilibrio Emocional")
           ->where("rol","otros")
           ->first()->value;
     
           $autoliderazgo_cliente_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia","Equilibrio Emocional")
           ->where("question_dimension","AUTOGOBIERNO")
           ->first()->value;
           $autoliderazgo_cliente_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia","Equilibrio Emocional")
           ->where("question_dimension","AUTOGOBIERNO")
           ->first()->value;
           $autoliderazgo_cliente_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia","Equilibrio Emocional")
           ->where("question_dimension","AUTOGOBIERNO")
           ->first()->value;
     
           $competencias["Equilibrio Emocional"] = [
            "evaluadores" => $autoliderazgo_cliente_evaluadores,
            "autoevaluador" => $autoliderazgo_cliente_autoevaluador,
            "total" => $autoliderazgo_cliente_total,
            "diferencia" => $autoliderazgo_cliente_autoevaluador - $autoliderazgo_cliente_evaluadores,
          ];
          if($id_evaluacion) {
  
          //if(isset($evaluacion->result->edad) )
          if( isset($evaluacion->result->edad) and isset($edades[$evaluacion->result->edad]))
          {
            
            $autoliderazgo_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
            ->where("question_dimension","AUTOGOBIERNO")
            ->whereIn("edad",$edades[$evaluacion->result->edad])
            ->first()->value;
          }
          else if( isset($evaluacion->result->age) and isset($edades[$evaluacion->result->age]))
          {
            $autoliderazgo_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
            ->where("question_dimension","AUTOGOBIERNO")
            ->where("edad",$edades[$evaluacion->result->age])
            ->first()->value;
          }
          else $autoliderazgo_edad = "";

          if( isset($evaluacion->result->sector) )
          {
           $autoliderazgo_sector = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->whereIn("sector",[$evaluacion->result->sector,SELF::translate($evaluacion->result->sector)])
           ->first()->value;
          }
          else $autoliderazgo_sector = "";

          //if(isset($evaluacion->result->genero) )
          if( isset($evaluacion->result->genero) and isset($generos[$evaluacion->result->genero]))
          {
           $autoliderazgo_genero = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->whereIn("genero",$generos[$evaluacion->result->genero])
           ->first()->value;
          }
          else $autoliderazgo_genero = "";
          if( isset($evaluacion->result->area) )
          {
           $autoliderazgo_area = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->whereIn("area",[$evaluacion->result->area,SELF::translate($evaluacion->result->area)])
           ->first()->value;
          }
          else $autoliderazgo_area = "";

          if( isset($evaluacion->result->funcion) )
          {
           $autoliderazgo_funcion = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->whereIn("funcion",[$evaluacion->result->funcion,SELF::translate($evaluacion->result->funcion)])
           ->first()->value;
          }
          else $autoliderazgo_funcion = "";
        }

     

        $data = [
          "fecha" => \Carbon\Carbon::now()->format("d-m-Y"),
          "dimension_estrategica_evaluadores"   => $dimension_estrategica_evaluadores,
          "dimension_estrategica_auto"          => $dimension_estrategica_auto,
          "dimension_estrategica_total"         => $dimension_estrategica_total,
          "dimension_interpersonal_evaluadores" => $dimension_interpersonal_evaluadores,
          "dimension_interpersonal_auto"        => $dimension_interpersonal_auto,
          "dimension_interpersonal_total"       => $dimension_interpersonal_total,
          "dimension_autogestion_evaluadores"   => $dimension_autogestion_evaluadores,
          "dimension_autogestion_auto"          => $dimension_autogestion_auto,
          "dimension_autogestion_total"         => $dimension_autogestion_total,
          "dimension_autodesarrollo_evaluadores"=> $dimension_autodesarrollo_evaluadores,
          "dimension_autodesarrollo_auto"       => $dimension_autodesarrollo_auto,
          "dimension_autodesarrollo_total"      => $dimension_autodesarrollo_total,
          "dimension_autoliderazgo_evaluadores" => $dimension_autoliderazgo_evaluadores,
          "dimension_autoliderazgo_auto"        => $dimension_autoliderazgo_auto,
          "dimension_autoliderazgo_otros"         => $dimension_autoliderazgo_otros,
          "dimension_autoliderazgo_total"         => $dimension_autoliderazgo_total,
  
          //pag 14
          "dimension_estrategica_jefe"          => $dimension_estrategica_jefe?$dimension_estrategica_jefe:0,
          "dimension_estrategica_colaborador"   => $dimension_estrategica_colaborador?$dimension_estrategica_colaborador:0,
          "dimension_estrategica_companero"     => $dimension_estrategica_companero?$dimension_estrategica_companero:0,
          "dimension_estrategica_otros"          => $dimension_estrategica_otros?$dimension_estrategica_otros:0,
  
          "dimension_estrategica_estrategica_jefe"          => $dimension_estrategica_estrategica_jefe?$dimension_estrategica_estrategica_jefe:0,
          "dimension_estrategica_estrategica_colaborador"   => $dimension_estrategica_estrategica_colaborador?$dimension_estrategica_estrategica_colaborador:0,
          "dimension_estrategica_estrategica_companero"     => $dimension_estrategica_estrategica_companero?$dimension_estrategica_estrategica_companero:0,
          "dimension_estrategica_estrategica_otros"         => $dimension_estrategica_estrategica_otros?$dimension_estrategica_estrategica_otros:0,
          "estrategica_estrategica_evaluadores"             => $estrategica_estrategica_evaluadores?$estrategica_estrategica_evaluadores:0,
          "estrategica_estrategica_autoevaluador"           => $estrategica_estrategica_autoevaluador?$estrategica_estrategica_autoevaluador:0,
          "estrategica_estrategica_total"                   => $estrategica_estrategica_total?$estrategica_estrategica_total:0,
  
  
          "dimension_estrategica_organizacion_jefe"          => $dimension_estrategica_organizacion_jefe?$dimension_estrategica_organizacion_jefe:0,
          "dimension_estrategica_organizacion_colaborador"   => $dimension_estrategica_organizacion_colaborador?$dimension_estrategica_organizacion_colaborador:0,
          "dimension_estrategica_organizacion_companero"     => $dimension_estrategica_organizacion_companero?$dimension_estrategica_organizacion_companero:0,
          "dimension_estrategica_organizacion_otros"         => $dimension_estrategica_organizacion_otros?$dimension_estrategica_organizacion_otros:0,
          "estrategica_organizacion_evaluadores"             => $estrategica_organizacion_evaluadores?$estrategica_organizacion_evaluadores:0,
          "estrategica_organizacion_autoevaluador"           => $estrategica_organizacion_autoevaluador?$estrategica_organizacion_autoevaluador:0,
          "estrategica_organizacion_total"                   => $estrategica_organizacion_total?$estrategica_organizacion_total:0,
  
          "dimension_estrategica_networking_jefe"          => $dimension_estrategica_networking_jefe?$dimension_estrategica_networking_jefe:0,
          "dimension_estrategica_networking_colaborador"   => $dimension_estrategica_networking_colaborador?$dimension_estrategica_networking_colaborador:0,
          "dimension_estrategica_networking_companero"     => $dimension_estrategica_networking_companero?$dimension_estrategica_networking_companero:0,
          "dimension_estrategica_networking_otros"         => $dimension_estrategica_networking_otros?$dimension_estrategica_networking_otros:0,
          "estrategica_networking_evaluadores"             => $estrategica_networking_evaluadores?$estrategica_networking_evaluadores:0,
          "estrategica_networking_autoevaluador"           => $estrategica_networking_autoevaluador?$estrategica_networking_autoevaluador:0,
          "estrategica_networking_total"                   => $estrategica_networking_total?$estrategica_networking_total:0,
  
          "dimension_estrategica_cliente_jefe"          => $dimension_estrategica_cliente_jefe?$dimension_estrategica_cliente_jefe:0,
          "dimension_estrategica_cliente_colaborador"   => $dimension_estrategica_cliente_colaborador?$dimension_estrategica_cliente_colaborador:0,
          "dimension_estrategica_cliente_companero"     => $dimension_estrategica_cliente_companero?$dimension_estrategica_cliente_companero:0,
          "dimension_estrategica_cliente_otros"          => $dimension_estrategica_cliente_otros?$dimension_estrategica_cliente_otros:0,
          "estrategica_cliente_evaluadores"             => $estrategica_cliente_evaluadores?$estrategica_cliente_evaluadores:0,
          "estrategica_cliente_autoevaluador"           => $estrategica_cliente_autoevaluador?$estrategica_cliente_autoevaluador:0,
          "estrategica_cliente_total"                   => $estrategica_cliente_total?$estrategica_cliente_total:0,
          
          "estrategica_edad"                            => isset($estrategica_edad)?$estrategica_edad:"",
          "estrategica_sector"                          => isset($estrategica_sector)?$estrategica_sector:"",
          "estrategica_genero"                          => isset($estrategica_genero)?$estrategica_genero:"",
          "estrategica_area"                            => isset($estrategica_area)?$estrategica_area:"",
          "estrategica_funcion"                         => isset($estrategica_funcion)?$estrategica_funcion:"",
  
          /* FIN 14 */
  
          //pag 14B
          "dimension_interpersonal_jefe"          => $dimension_interpersonal_jefe?$dimension_interpersonal_jefe:0,
          "dimension_interpersonal_colaborador"   => $dimension_interpersonal_colaborador?$dimension_interpersonal_colaborador:0,
          "dimension_interpersonal_companero"     => $dimension_interpersonal_companero?$dimension_interpersonal_companero:0,
          "dimension_interpersonal_otros"          => $dimension_interpersonal_otros?$dimension_interpersonal_otros:0,
  
          "dimension_interpersonal_estrategica_jefe"          => $dimension_interpersonal_estrategica_jefe?$dimension_interpersonal_estrategica_jefe:0,
          "dimension_interpersonal_estrategica_colaborador"   => $dimension_interpersonal_estrategica_colaborador?$dimension_interpersonal_estrategica_colaborador:0,
          "dimension_interpersonal_estrategica_companero"     => $dimension_interpersonal_estrategica_companero?$dimension_interpersonal_estrategica_companero:0,
          "dimension_interpersonal_estrategica_otros"         => $dimension_interpersonal_estrategica_otros?$dimension_interpersonal_estrategica_otros:0,
          "interpersonal_estrategica_evaluadores"             => $interpersonal_estrategica_evaluadores?$interpersonal_estrategica_evaluadores:0,
          "interpersonal_estrategica_autoevaluador"           => $interpersonal_estrategica_autoevaluador?$interpersonal_estrategica_autoevaluador:0,
          "interpersonal_estrategica_total"                   => $interpersonal_estrategica_total?$interpersonal_estrategica_total:0,
  
  
          "dimension_interpersonal_organizacion_jefe"          => $dimension_interpersonal_organizacion_jefe?$dimension_interpersonal_organizacion_jefe:0,
          "dimension_interpersonal_organizacion_colaborador"   => $dimension_interpersonal_organizacion_colaborador?$dimension_interpersonal_organizacion_colaborador:0,
          "dimension_interpersonal_organizacion_companero"     => $dimension_interpersonal_organizacion_companero?$dimension_interpersonal_organizacion_companero:0,
          "dimension_interpersonal_organizacion_otros"         => $dimension_interpersonal_organizacion_otros?$dimension_interpersonal_organizacion_otros:0,
          "interpersonal_organizacion_evaluadores"             => $interpersonal_organizacion_evaluadores?$interpersonal_organizacion_evaluadores:0,
          "interpersonal_organizacion_autoevaluador"           => $interpersonal_organizacion_autoevaluador?$interpersonal_organizacion_autoevaluador:0,
          "interpersonal_organizacion_total"                   => $interpersonal_organizacion_total?$interpersonal_organizacion_total:0,
  
          "dimension_interpersonal_networking_jefe"          => $dimension_interpersonal_networking_jefe?$dimension_interpersonal_networking_jefe:0,
          "dimension_interpersonal_networking_colaborador"   => $dimension_interpersonal_networking_colaborador?$dimension_interpersonal_networking_colaborador:0,
          "dimension_interpersonal_networking_companero"     => $dimension_interpersonal_networking_companero?$dimension_interpersonal_networking_companero:0,
          "dimension_interpersonal_networking_otros"         => $dimension_interpersonal_networking_otros?$dimension_interpersonal_networking_otros:0,
          "interpersonal_networking_evaluadores"             => $interpersonal_networking_evaluadores?$interpersonal_networking_evaluadores:0,
          "interpersonal_networking_autoevaluador"           => $interpersonal_networking_autoevaluador?$interpersonal_networking_autoevaluador:0,
          "interpersonal_networking_total"                   => $interpersonal_networking_total?$interpersonal_networking_total:0,
  
          "dimension_interpersonal_cliente_jefe"          => $dimension_interpersonal_cliente_jefe?$dimension_interpersonal_cliente_jefe:0,
          "dimension_interpersonal_cliente_colaborador"   => $dimension_interpersonal_cliente_colaborador?$dimension_interpersonal_cliente_colaborador:0,
          "dimension_interpersonal_cliente_companero"     => $dimension_interpersonal_cliente_companero?$dimension_interpersonal_cliente_companero:0,
          "dimension_interpersonal_cliente_otros"          => $dimension_interpersonal_cliente_otros?$dimension_interpersonal_cliente_otros:0,
          "interpersonal_cliente_evaluadores"             => $interpersonal_cliente_evaluadores?$interpersonal_cliente_evaluadores:0,
          "interpersonal_cliente_autoevaluador"           => $interpersonal_cliente_autoevaluador?$interpersonal_cliente_autoevaluador:0,
          "interpersonal_cliente_total"                   => $interpersonal_cliente_total?$interpersonal_cliente_total:0,
          
          "interpersonal_edad"                            => isset($interpersonal_edad)?$interpersonal_edad:"",
          "interpersonal_sector"                          => isset($interpersonal_sector)?$interpersonal_sector:"",
          "interpersonal_genero"                          => isset($interpersonal_genero)?$interpersonal_genero:"",
          "interpersonal_area"                            => isset($interpersonal_area)?$interpersonal_area:"",
          "interpersonal_funcion"                         => isset($interpersonal_funcion)?$interpersonal_funcion:"",
  
          /* FIN 14B */
  
          //pag 14C
          "dimension_autogestion_jefe"          => $dimension_autogestion_jefe?$dimension_autogestion_jefe:0,
          "dimension_autogestion_colaborador"   => $dimension_autogestion_colaborador?$dimension_autogestion_colaborador:0,
          "dimension_autogestion_companero"     => $dimension_autogestion_companero?$dimension_autogestion_companero:0,
          "dimension_autogestion_otros"          => $dimension_autogestion_otros?$dimension_autogestion_otros:0,
  
          "dimension_autogestion_estrategica_jefe"          => $dimension_autogestion_estrategica_jefe?$dimension_autogestion_estrategica_jefe:0,
          "dimension_autogestion_estrategica_colaborador"   => $dimension_autogestion_estrategica_colaborador?$dimension_autogestion_estrategica_colaborador:0,
          "dimension_autogestion_estrategica_companero"     => $dimension_autogestion_estrategica_companero?$dimension_autogestion_estrategica_companero:0,
          "dimension_autogestion_estrategica_otros"         => $dimension_autogestion_estrategica_otros?$dimension_autogestion_estrategica_otros:0,
          "autogestion_estrategica_evaluadores"             => $autogestion_estrategica_evaluadores?$autogestion_estrategica_evaluadores:0,
          "autogestion_estrategica_autoevaluador"           => $autogestion_estrategica_autoevaluador?$autogestion_estrategica_autoevaluador:0,
          "autogestion_estrategica_total"                   => $autogestion_estrategica_total?$autogestion_estrategica_total:0,
  
  
          "dimension_autogestion_organizacion_jefe"          => $dimension_autogestion_organizacion_jefe?$dimension_autogestion_organizacion_jefe:0,
          "dimension_autogestion_organizacion_colaborador"   => $dimension_autogestion_organizacion_colaborador?$dimension_autogestion_organizacion_colaborador:0,
          "dimension_autogestion_organizacion_companero"     => $dimension_autogestion_organizacion_companero?$dimension_autogestion_organizacion_companero:0,
          "dimension_autogestion_organizacion_otros"         => $dimension_autogestion_organizacion_otros?$dimension_autogestion_organizacion_otros:0,
          "autogestion_organizacion_evaluadores"             => $autogestion_organizacion_evaluadores?$autogestion_organizacion_evaluadores:0,
          "autogestion_organizacion_autoevaluador"           => $autogestion_organizacion_autoevaluador?$autogestion_organizacion_autoevaluador:0,
          "autogestion_organizacion_total"                   => $autogestion_organizacion_total?$autogestion_organizacion_total:0,
  
          "dimension_autogestion_networking_jefe"          => $dimension_autogestion_networking_jefe?$dimension_autogestion_networking_jefe:0,
          "dimension_autogestion_networking_colaborador"   => $dimension_autogestion_networking_colaborador?$dimension_autogestion_networking_colaborador:0,
          "dimension_autogestion_networking_companero"     => $dimension_autogestion_networking_companero?$dimension_autogestion_networking_companero:0,
          "dimension_autogestion_networking_otros"         => $dimension_autogestion_networking_otros?$dimension_autogestion_networking_otros:0,
          "autogestion_networking_evaluadores"             => $autogestion_networking_evaluadores?$autogestion_networking_evaluadores:0,
          "autogestion_networking_autoevaluador"           => $autogestion_networking_autoevaluador?$autogestion_networking_autoevaluador:0,
          "autogestion_networking_total"                   => $autogestion_networking_total?$autogestion_networking_total:0,
  
          "dimension_autogestion_cliente_jefe"          => $dimension_autogestion_cliente_jefe?$dimension_autogestion_cliente_jefe:0,
          "dimension_autogestion_cliente_colaborador"   => $dimension_autogestion_cliente_colaborador?$dimension_autogestion_cliente_colaborador:0,
          "dimension_autogestion_cliente_companero"     => $dimension_autogestion_cliente_companero?$dimension_autogestion_cliente_companero:0,
          "dimension_autogestion_cliente_otros"          => $dimension_autogestion_cliente_otros?$dimension_autogestion_cliente_otros:0,
          "autogestion_cliente_evaluadores"             => $autogestion_cliente_evaluadores?$autogestion_cliente_evaluadores:0,
          "autogestion_cliente_autoevaluador"           => $autogestion_cliente_autoevaluador?$autogestion_cliente_autoevaluador:0,
          "autogestion_cliente_total"                   => $autogestion_cliente_total?$autogestion_cliente_total:0,
          
          "autogestion_edad"                            => isset($autogestion_edad)?$autogestion_edad:"",
          "autogestion_sector"                          => isset($autogestion_sector)?$autogestion_sector:"",
          "autogestion_genero"                          => isset($autogestion_genero)?$autogestion_genero:"",
          "autogestion_area"                            => isset($autogestion_area)?$autogestion_area:"",
          "autogestion_funcion"                         => isset($autogestion_funcion)?$autogestion_funcion:"",
  
          /* FIN 14C */
         //pag 14C
         "dimension_autodesarrollo_jefe"          => $dimension_autodesarrollo_jefe?$dimension_autodesarrollo_jefe:0,
         "dimension_autodesarrollo_colaborador"   => $dimension_autodesarrollo_colaborador?$dimension_autodesarrollo_colaborador:0,
         "dimension_autodesarrollo_companero"     => $dimension_autodesarrollo_companero?$dimension_autodesarrollo_companero:0,
         "dimension_autodesarrollo_otros"          => $dimension_autodesarrollo_otros?$dimension_autodesarrollo_otros:0,
  
         "dimension_autodesarrollo_estrategica_jefe"          => $dimension_autodesarrollo_estrategica_jefe?$dimension_autodesarrollo_estrategica_jefe:0,
         "dimension_autodesarrollo_estrategica_colaborador"   => $dimension_autodesarrollo_estrategica_colaborador?$dimension_autodesarrollo_estrategica_colaborador:0,
         "dimension_autodesarrollo_estrategica_companero"     => $dimension_autodesarrollo_estrategica_companero?$dimension_autodesarrollo_estrategica_companero:0,
         "dimension_autodesarrollo_estrategica_otros"         => $dimension_autodesarrollo_estrategica_otros?$dimension_autodesarrollo_estrategica_otros:0,
         "autodesarrollo_estrategica_evaluadores"             => $autodesarrollo_estrategica_evaluadores?$autodesarrollo_estrategica_evaluadores:0,
         "autodesarrollo_estrategica_autoevaluador"           => $autodesarrollo_estrategica_autoevaluador?$autodesarrollo_estrategica_autoevaluador:0,
         "autodesarrollo_estrategica_total"                   => $autodesarrollo_estrategica_total?$autodesarrollo_estrategica_total:0,
  
  
         "dimension_autodesarrollo_organizacion_jefe"          => $dimension_autodesarrollo_organizacion_jefe?$dimension_autodesarrollo_organizacion_jefe:0,
         "dimension_autodesarrollo_organizacion_colaborador"   => $dimension_autodesarrollo_organizacion_colaborador?$dimension_autodesarrollo_organizacion_colaborador:0,
         "dimension_autodesarrollo_organizacion_companero"     => $dimension_autodesarrollo_organizacion_companero?$dimension_autodesarrollo_organizacion_companero:0,
         "dimension_autodesarrollo_organizacion_otros"         => $dimension_autodesarrollo_organizacion_otros?$dimension_autodesarrollo_organizacion_otros:0,
         "autodesarrollo_organizacion_evaluadores"             => $autodesarrollo_organizacion_evaluadores?$autodesarrollo_organizacion_evaluadores:0,
         "autodesarrollo_organizacion_autoevaluador"           => $autodesarrollo_organizacion_autoevaluador?$autodesarrollo_organizacion_autoevaluador:0,
         "autodesarrollo_organizacion_total"                   => $autodesarrollo_organizacion_total?$autodesarrollo_organizacion_total:0,
  
         "dimension_autodesarrollo_networking_jefe"          => $dimension_autodesarrollo_networking_jefe?$dimension_autodesarrollo_networking_jefe:0,
         "dimension_autodesarrollo_networking_colaborador"   => $dimension_autodesarrollo_networking_colaborador?$dimension_autodesarrollo_networking_colaborador:0,
         "dimension_autodesarrollo_networking_companero"     => $dimension_autodesarrollo_networking_companero?$dimension_autodesarrollo_networking_companero:0,
         "dimension_autodesarrollo_networking_otros"         => $dimension_autodesarrollo_networking_otros?$dimension_autodesarrollo_networking_otros:0,
         "autodesarrollo_networking_evaluadores"             => $autodesarrollo_networking_evaluadores?$autodesarrollo_networking_evaluadores:0,
         "autodesarrollo_networking_autoevaluador"           => $autodesarrollo_networking_autoevaluador?$autodesarrollo_networking_autoevaluador:0,
         "autodesarrollo_networking_total"                   => $autodesarrollo_networking_total?$autodesarrollo_networking_total:0,
  
         "dimension_autodesarrollo_cliente_jefe"          => $dimension_autodesarrollo_cliente_jefe?$dimension_autodesarrollo_cliente_jefe:0,
         "dimension_autodesarrollo_cliente_colaborador"   => $dimension_autodesarrollo_cliente_colaborador?$dimension_autodesarrollo_cliente_colaborador:0,
         "dimension_autodesarrollo_cliente_companero"     => $dimension_autodesarrollo_cliente_companero?$dimension_autodesarrollo_cliente_companero:0,
         "dimension_autodesarrollo_cliente_otros"          => $dimension_autodesarrollo_cliente_otros?$dimension_autodesarrollo_cliente_otros:0,
         "autodesarrollo_cliente_evaluadores"             => $autodesarrollo_cliente_evaluadores?$autodesarrollo_cliente_evaluadores:0,
         "autodesarrollo_cliente_autoevaluador"           => $autodesarrollo_cliente_autoevaluador?$autodesarrollo_cliente_autoevaluador:0,
         "autodesarrollo_cliente_total"                   => $autodesarrollo_cliente_total?$autodesarrollo_cliente_total:0,
         
         "autodesarrollo_edad"                            => isset($autodesarrollo_edad)?$autodesarrollo_edad:"",
         "autodesarrollo_sector"                          => isset($autodesarrollo_sector)?$autodesarrollo_sector:"",
         "autodesarrollo_genero"                          => isset($autodesarrollo_genero)?$autodesarrollo_genero:"",
         "autodesarrollo_area"                            => isset($autodesarrollo_area)?$autodesarrollo_area:"",
         "autodesarrollo_funcion"                         => isset($autodesarrollo_funcion)?$autodesarrollo_funcion:"",
  
         /* FIN 14C */
  
         //pag 14C
         "dimension_autoliderazgo_jefe"          => $dimension_autoliderazgo_jefe?$dimension_autoliderazgo_jefe:0,
         "dimension_autoliderazgo_colaborador"   => $dimension_autoliderazgo_colaborador?$dimension_autoliderazgo_colaborador:0,
         "dimension_autoliderazgo_companero"     => $dimension_autoliderazgo_companero?$dimension_autoliderazgo_companero:0,
         "dimension_autoliderazgo_otros"          => $dimension_autoliderazgo_otros?$dimension_autoliderazgo_otros:0,
  
         "dimension_autoliderazgo_estrategica_jefe"          => $dimension_autoliderazgo_estrategica_jefe?$dimension_autoliderazgo_estrategica_jefe:0,
         "dimension_autoliderazgo_estrategica_colaborador"   => $dimension_autoliderazgo_estrategica_colaborador?$dimension_autoliderazgo_estrategica_colaborador:0,
         "dimension_autoliderazgo_estrategica_companero"     => $dimension_autoliderazgo_estrategica_companero?$dimension_autoliderazgo_estrategica_companero:0,
         "dimension_autoliderazgo_estrategica_otros"         => $dimension_autoliderazgo_estrategica_otros?$dimension_autoliderazgo_estrategica_otros:0,
         "autoliderazgo_estrategica_evaluadores"             => $autoliderazgo_estrategica_evaluadores?$autoliderazgo_estrategica_evaluadores:0,
         "autoliderazgo_estrategica_autoevaluador"           => $autoliderazgo_estrategica_autoevaluador?$autoliderazgo_estrategica_autoevaluador:0,
         "autoliderazgo_estrategica_total"                   => $autoliderazgo_estrategica_total?$autoliderazgo_estrategica_total:0,
  
  
         "dimension_autoliderazgo_organizacion_jefe"          => $dimension_autoliderazgo_organizacion_jefe?$dimension_autoliderazgo_organizacion_jefe:0,
         "dimension_autoliderazgo_organizacion_colaborador"   => $dimension_autoliderazgo_organizacion_colaborador?$dimension_autoliderazgo_organizacion_colaborador:0,
         "dimension_autoliderazgo_organizacion_companero"     => $dimension_autoliderazgo_organizacion_companero?$dimension_autoliderazgo_organizacion_companero:0,
         "dimension_autoliderazgo_organizacion_otros"         => $dimension_autoliderazgo_organizacion_otros?$dimension_autoliderazgo_organizacion_otros:0,
         "autoliderazgo_organizacion_evaluadores"             => $autoliderazgo_organizacion_evaluadores?$autoliderazgo_organizacion_evaluadores:0,
         "autoliderazgo_organizacion_autoevaluador"           => $autoliderazgo_organizacion_autoevaluador?$autoliderazgo_organizacion_autoevaluador:0,
         "autoliderazgo_organizacion_total"                   => $autoliderazgo_organizacion_total?$autoliderazgo_organizacion_total:0,
  
         "dimension_autoliderazgo_networking_jefe"          => $dimension_autoliderazgo_networking_jefe?$dimension_autoliderazgo_networking_jefe:0,
         "dimension_autoliderazgo_networking_colaborador"   => $dimension_autoliderazgo_networking_colaborador?$dimension_autoliderazgo_networking_colaborador:0,
         "dimension_autoliderazgo_networking_companero"     => $dimension_autoliderazgo_networking_companero?$dimension_autoliderazgo_networking_companero:0,
         "dimension_autoliderazgo_networking_otros"         => $dimension_autoliderazgo_networking_otros?$dimension_autoliderazgo_networking_otros:0,
         "autoliderazgo_networking_evaluadores"             => $autoliderazgo_networking_evaluadores?$autoliderazgo_networking_evaluadores:0,
         "autoliderazgo_networking_autoevaluador"           => $autoliderazgo_networking_autoevaluador?$autoliderazgo_networking_autoevaluador:0,
         "autoliderazgo_networking_total"                   => $autoliderazgo_networking_total?$autoliderazgo_networking_total:0,
  
         "dimension_autoliderazgo_cliente_jefe"          => $dimension_autoliderazgo_cliente_jefe?$dimension_autoliderazgo_cliente_jefe:0,
         "dimension_autoliderazgo_cliente_colaborador"   => $dimension_autoliderazgo_cliente_colaborador?$dimension_autoliderazgo_cliente_colaborador:0,
         "dimension_autoliderazgo_cliente_companero"     => $dimension_autoliderazgo_cliente_companero?$dimension_autoliderazgo_cliente_companero:0,
         "dimension_autoliderazgo_cliente_otros"          => $dimension_autoliderazgo_cliente_otros?$dimension_autoliderazgo_cliente_otros:0,
         "autoliderazgo_cliente_evaluadores"             => $autoliderazgo_cliente_evaluadores?$autoliderazgo_cliente_evaluadores:0,
         "autoliderazgo_cliente_autoevaluador"           => $autoliderazgo_cliente_autoevaluador?$autoliderazgo_cliente_autoevaluador:0,
         "autoliderazgo_cliente_total"                   => $autoliderazgo_cliente_total?$autoliderazgo_cliente_total:0,
         
         "autoliderazgo_edad"                            => isset($autoliderazgo_edad)?$autoliderazgo_edad:"",
         "autoliderazgo_sector"                          => isset($autoliderazgo_sector)?$autoliderazgo_sector:"",
         "autoliderazgo_genero"                          => isset($autoliderazgo_genero)?$autoliderazgo_genero:"",
         "autoliderazgo_area"                            => isset($autoliderazgo_area)?$autoliderazgo_area:"",
         "autoliderazgo_funcion"                         => isset($autoliderazgo_funcion)?$autoliderazgo_funcion:"",
  
         /* FIN 14C */
         //"competencias" => collect($competencias),
        ];
  
        if($id_evaluacion) {
          $data["idioma"] = $evaluacion->lang?$evaluacion->lang:$evaluacion->proyecto->lang;
          $data["name"] = $evaluacion->name;
          $data["rapport_id"] = $evaluacion->rapport_id;
        }
        if($id_proyecto) {
          $data["idioma"] = 'es';
          $data["name"] = $proyecto->name;
          $data["rapport_id"] = $proyecto->rapport_id;
          $data["proyecto_id"] = $proyecto->id;
          $evaluacion = $proyecto->evaluaciones()->first();
        }
        if($global) {
          $data["idioma"] = 'es';
          $data["name"] = "Global";
          $rapport = Rapport::getRapportGlobalInProgress();
          $data["rapport_id"] = $rapport->id; 
          $evaluacion = Evaluacion::all()[0];
        }
        if($rapport_id) {
          $data["rapport_id"] = $rapport_id; 
        }
        if($name) {
          $data["name"] = $name;
        }
        if(isset($autoCount)) $data['autoCount'] = $autoCount;
        if(isset($evalCount)) $data['evalCount'] = $evalCount;
        if(isset($totalCount)) $data['totalCount'] = $totalCount;
        if(isset($autoImportCount)) $data['autoImportCount'] = $autoImportCount;

        foreach($competencias as $key=>$competencia) {
          if(!$competencia['autoevaluador']) unset($competencias[$key]);
        }
        $competencias_sobrevaloradas = collect($competencias)->sortByDesc("diferencia");
        $i = 0;
        foreach($competencias_sobrevaloradas as $competencia => $valores) {
          //if($i>4) break;
          $valores['diferencia_total'] = $valores['total'] - $valores['evaluadores'];
          $valores['title']           = $evaluacion->translateCompetencia($competencia);
          $competencias_sobrevaloradas[$competencia] = $valores;
          if( $valores['diferencia'] <= 0 ) unset($competencias_sobrevaloradas[$competencia]);
          else $i++;
        }
        $data['competencias_sobrevaloradas'] = collect($competencias_sobrevaloradas)->slice(0,4);
  
        $competencias_infravaloradas = collect($competencias)->sortBy("diferencia");
        $i = 0;
        foreach($competencias_infravaloradas as $competencia => $valores) {
          //if($i>4) break;
          $valores['diferencia_total'] = $valores['total'] - $valores['evaluadores'];
          $valores['title']           = $evaluacion->translateCompetencia($competencia);
          if(isset($competencias_infravaloradas[$competencia]))
            $competencias_infravaloradas[$competencia] = $valores;
          if( $valores['diferencia'] >= 0 ) unset($competencias_infravaloradas[$competencia]);
          else $i++;
        }
        $data['competencias_infravaloradas'] = collect($competencias_infravaloradas)->slice(0,4);
  
        
        $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
        'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
        'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
        'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
  
        //$competencias_masvaloradas = collect($competencias)->sortByDesc("evaluadores")->slice(0,3);
        if(isset($evaluacion->id) and $evaluacion->proyecto->type == "edu") {
          $competencias_masvaloradas = collect($competencias)->sortByDesc("autoevaluador")->slice(0,3);
        } else {
          $competencias_masvaloradas = collect($competencias)->sortByDesc("evaluadores")->slice(0,3);
        }
        foreach($competencias_masvaloradas as $competencia => $valores) {
          
          $q = with(clone $resultEval)->select(\DB::raw("question_dimension as value"))
          ->where("question_competencia",$competencia)
          ->first();
          if(!$q) {
            continue;
          }
          $dimension = $q->value;
           $dimension_autoliderazgo_networking_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia",$competencia)
           ->where("rol","jefe")
           ->where("question_dimension",$dimension)
           ->first()->value;
           $dimension_autoliderazgo_networking_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia",$competencia)
           ->where("question_dimension",$dimension)
            ->where("rol","colaborador")
           ->first()->value;
           $dimension_autoliderazgo_networking_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia",$competencia)
           ->where("question_dimension",$dimension)
           ->where("rol","companero")
           ->first()->value;
           $dimension_autoliderazgo_networking_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia",$competencia)
           ->where("question_dimension",$dimension)
           ->where("rol","otros")
           ->first()->value;
          $valores['jefe']            = $dimension_autoliderazgo_networking_jefe?$dimension_autoliderazgo_networking_jefe:0;
          $valores['colaborador']     = $dimension_autoliderazgo_networking_colaborador?$dimension_autoliderazgo_networking_colaborador:0;
          $valores['companero']       = $dimension_autoliderazgo_networking_companero?$dimension_autoliderazgo_networking_companero:0;
          $valores['title']           = $evaluacion->translateCompetencia($competencia);
          $valores['otros']           = $dimension_autoliderazgo_networking_otros?$dimension_autoliderazgo_networking_otros:0;
          $valores['dimension']       = strtolower(strtr($dimension,$unwanted_array));
  
          $competencias_masvaloradas[$competencia] = $valores;
  
            
        }
        if(isset($evaluacion->id) and $evaluacion->proyecto->type == "edu") {
          $competencias_peorvaloradas = collect($competencias)->sortBy("autoevaluador")->slice(0,3);
        } else {
          $competencias_peorvaloradas = collect($competencias)->sortBy("evaluadores")->slice(0,3);
        }
        foreach($competencias_peorvaloradas as $competencia => $valores) {
          $q = with(clone $resultEval)->select(\DB::raw("question_dimension as value"))
          ->where("question_competencia",$competencia)
          ->first();
          if(!$q) {
            continue;
          }
          $dimension = $q->value;

          $dimension_autoliderazgo_networking_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
          ->where("question_competencia",$competencia)
          ->where("question_dimension",$dimension)
          ->where("rol","jefe")
          ->first()->value;
  
          $dimension_autoliderazgo_networking_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
          ->where("question_competencia",$competencia)
          ->where("rol","colaborador")
          ->where("question_dimension",$dimension)
          ->first()->value;
  
          $dimension_autoliderazgo_networking_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
          ->where("question_competencia",$competencia)
          ->where("rol","companero")
          ->where("question_dimension",$dimension)
          ->first()->value;
  
          $dimension_autoliderazgo_networking_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
          ->where("question_competencia",$competencia)
          ->where("question_dimension",$dimension)
          ->where("rol","otros")
          ->first()->value;
  
          
  
          $valores['dimension']       = strtolower(strtr($dimension,$unwanted_array));
  
       /*   eval("\$dimension_autoliderazgo_networking_jefe = \$dimension_".$valores['dimension']."_estrategica_jefe;");
          eval("\$dimension_autoliderazgo_networking_colaborador = \$dimension_".$valores['dimension']."_estrategica_colaborador;");
          eval("\$dimension_autoliderazgo_networking_companero = \$dimension_".$valores['dimension']."_estrategica_companero;");
          eval("\$dimension_autoliderazgo_networking_otros = \$dimension_".$valores['dimension']."_estrategica_otros;");*/
  
          $valores['jefe']            = $dimension_autoliderazgo_networking_jefe?$dimension_autoliderazgo_networking_jefe:0;
          $valores['colaborador']     = $dimension_autoliderazgo_networking_colaborador?$dimension_autoliderazgo_networking_colaborador:0;
          $valores['companero']       = $dimension_autoliderazgo_networking_companero?$dimension_autoliderazgo_networking_companero:0;
          $valores['title']           = $evaluacion->translateCompetencia($competencia);
          $valores['otros']           = $dimension_autoliderazgo_networking_otros?$dimension_autoliderazgo_networking_otros:0;
          $valores['dimension']       = strtolower(strtr($dimension,$unwanted_array));
          $valores['frases']          = $frases[$competencia];
          if(isset($competencias_peorvaloradas[$competencia]))
            $competencias_peorvaloradas[$competencia] = $valores;
       }
        $data['competencias_peorvaloradas'] = $competencias_peorvaloradas->toArray();
        $data['competencias_masvaloradas'] = $competencias_masvaloradas->toArray();
  
        $resultMotivoAuto = Result::where("is_autoevaluacion",1)
                            ->where("evaluacion_id",$evaluacion->id)
                            ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id')
                            ->where("tresfera_taketsystem_answers.question_type", "motivo")
                            ->where("tresfera_taketsystem_results.duplicated",0)
                            ->orderBy("tresfera_taketsystem_answers.slide_id", "asc") 
                            ->orderBy("tresfera_taketsystem_answers.id", "asc") 
                            ->get();
        
        $tmp = [];
        $slide_id = -1;

        foreach($resultMotivoAuto as $m)
        {
          if($slide_id == $m->slide_id) $tmp[count($tmp)-1] = $m;
          else array_push($tmp, $m);
          $slide_id = $m->slide_id;
        }

        $estratega = 0;
        $ejecutivo = 0;
        $integrador = 0;
        foreach($tmp as $t)
        {
          if($t->question_categoria == "EXT - Estratega")
          {
            $estratega += $t->value;
          }
          else if($t->question_categoria == "INT - Ejecutivo")
          {
            $ejecutivo += $t->value;
          }
          else if($t->question_categoria == "TRA - Integrador")
          {
            $integrador += $t->value;
          }
        }
        /*
        $total = with(clone $resultAuto)->select(\DB::raw("SUM(value) as value"))
                ->where("question_type","motivo")
                ->where("question_categoria","<>","PRO")
                ->first()->value;
        $estratega = with(clone $resultAuto)->select(\DB::raw("SUM(value) as value"))
                ->where("question_type", "motivo")
                ->where("question_categoria", "EXT - Estratega")
                ->first()->value;
        $ejecutivo = with(clone $resultAuto)->select(\DB::raw("SUM(value) as value"))
                ->where("question_type", "motivo")
                ->where("question_categoria", "INT - Ejecutivo")
                ->first()->value;
        $integrador = with(clone $resultAuto)->select(\DB::raw("SUM(value) as value"))
                ->where("question_type", "motivo")
                ->where("question_categoria", "TRA - Integrador")
                ->first()->value;
  *//*
        $total = $estratega+$ejecutivo+$integrador;
  
        $data['motivos'] = [
          "estratega" => $estratega,
          "ejecutivo" => $ejecutivo,
          "integrador" => $integrador,
          "estratega_percent" => $estratega/$total*100,
          "ejecutivo_percent" => $ejecutivo/$total*100,
          "integrador_percent" => $integrador/$total*100,
        ];
  */
      if($id_evaluacion) {

        $resultAutoMotivos = Result::where("is_autoevaluacion",1)
        ->where("evaluacion_id",$evaluacion->id)
        ->where("tresfera_taketsystem_results.duplicated",0)
        ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

      } elseif($id_proyecto) {
        $resultAutoMotivos = Result::where("is_autoevaluacion",1)
                            ->whereIn("evaluacion_id",$proyecto->evaluaciones()->lists("id"))
                            ->where("tresfera_taketsystem_results.duplicated",0)
                            ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');
      } elseif($global) {
        $resultAutoMotivos = Result::where("is_autoevaluacion",1)
                            ->where("tresfera_taketsystem_results.duplicated",0)
                            ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

      }
 
 
      $total = Result::where("is_autoevaluacion",1)
      ->where("evaluacion_id",$evaluacion->id)
      ->where("tresfera_taketsystem_results.duplicated",0)
      ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id')
            ->select(\DB::raw("SUM(value) as value"))
            ->where("question_type","motivo")
            ->where("question_categoria","<>","PRO")
            ->first()->value;
      $estratega = with(clone $resultAutoMotivos)->select(\DB::raw("SUM(value) as value"))
            ->where("question_type", "motivo")
            ->where("question_categoria", "EXT - Estratega")
            ->first()->value;
      $ejecutivo = with(clone $resultAutoMotivos)->select(\DB::raw("SUM(value) as value"))
            ->where("question_type", "motivo")
            ->where("question_categoria", "INT - Ejecutivo")
            ->first()->value;
      $integrador = with(clone $resultAutoMotivos)->select(\DB::raw("SUM(value) as value"))
            ->where("question_type", "motivo")
            ->where("question_categoria", "TRA - Integrador")
            ->first()->value;
            $total = $estratega + $ejecutivo + $integrador;

       $data['motivos'] = [
        "estratega" => $estratega?$estratega:0,
        "ejecutivo" => $ejecutivo?$ejecutivo:0,
        "integrador" => $integrador?$integrador:0,
        "estratega_percent" => $estratega/$total*100,
        "ejecutivo_percent" => $ejecutivo/$total*100,
        "integrador_percent" => $integrador/$total*100,
       ];

        if($id_evaluacion) {

          $resultMotivoEval = Result::where("is_evaluacion",1)
                              ->where("evaluacion_id",$evaluacion->id)
                              ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id')
                              ->where("tresfera_taketsystem_answers.question_type", "motivo")
                              ->where("tresfera_taketsystem_results.duplicated",0)
                              ->orderBy("tresfera_taketsystem_answers.slide_id", "asc") 
                              ->orderBy("tresfera_taketsystem_answers.id", "asc") 
                              ->get();
        } elseif($id_proyecto) {

          $resultMotivoEval = Result::where("is_evaluacion",1)
                              ->whereIn("evaluacion_id",$proyecto->evaluaciones()->lists("id"))
                              ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id')
                              ->where("tresfera_taketsystem_answers.question_type", "motivo")
                              ->where("tresfera_taketsystem_results.duplicated",0)
                              ->orderBy("tresfera_taketsystem_answers.slide_id", "asc") 
                              ->orderBy("tresfera_taketsystem_answers.id", "asc") 
                              ->get();
        
        }elseif($global) {
          $resultMotivoEval = Result::where("is_evaluacion",1)
                              ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id')
                              ->where("tresfera_taketsystem_answers.question_type", "motivo")
                              ->where("tresfera_taketsystem_results.duplicated",0)
                              ->orderBy("tresfera_taketsystem_answers.slide_id", "asc") 
                              ->orderBy("tresfera_taketsystem_answers.id", "asc") 
                              ->get();
        }
       
        
    /*    $tmp = [];
        $slide_id = -1;

        foreach($resultMotivoEval as $m)
        {
          if($slide_id == $m->slide_id) $tmp[count($tmp)-1] = $m;
          else array_push($tmp, $m);
          $slide_id = $m->slide_id;
        }

        $profesionalidad = 0;
        $logro = 0;
        $honestidad = 0;
        $consistencia = 0;
        $confianza = 0;
        foreach($tmp as $t)
        {
          if($t->no_analizable == 0)
          {
            if($t->question_categoria == "Cognición - Profesionalidad")
            {
              $profesionalidad += $t->value;
            }
            else if($t->question_categoria == "Resultados - Orientación al Logro")
            {
              $logro += $t->value;
            }
            else if($t->question_categoria == "Integridad - Honestidad")
            {
              $honestidad += $t->value;
            }
            else if($t->question_categoria == "Consistencia")
            {
              $consistencia += $t->value;
            }
            else if($t->question_categoria == "Afectividad - Confianza")
            {
              $confianza += $t->value;
            }
          }
          
        }*/

        if($id_evaluacion) {
          $resultEvalMotivos = Result::where("is_evaluacion",1)
                    ->where("evaluacion_id",$evaluacion->id)
                    ->where("tresfera_taketsystem_results.duplicated",0)
                    ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');
          $total_evaluadores = Result::where("is_evaluacion",1)
                ->where("evaluacion_id",$evaluacion->id)
                ->where("duplicated",0)
                ->where("import",0)
                ->count();
        } elseif($id_proyecto) {
          $resultEvalMotivos = Result::where("is_evaluacion",1)
                ->whereIn("evaluacion_id",$proyecto->evaluaciones()->lists("id"))
                ->where("tresfera_taketsystem_results.duplicated",0)
                ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');
          $total_evaluadores = Result::where("is_evaluacion",1)
                ->whereIn("evaluacion_id",$proyecto->evaluaciones()->lists("id"))
                ->where("duplicated",0)
                ->where("import",0)
                ->count();
        }  elseif($global) {
          $resultEvalMotivos = Result::where("is_evaluacion",1)
                ->where("tresfera_taketsystem_results.duplicated",0)
                ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');
          $total_evaluadores = Result::where("is_evaluacion",1)
                ->where("duplicated",0)
                ->where("import",0)
                ->count();
        } 

        

      $profesionalidad_rows = with(clone $resultEvalMotivos)
       ->where("question_type", "motivo")
       ->where("question_categoria", "Cognición - Profesionalidad")
       ->where("no_analizable","=","0")
       ->limit(6*$total_evaluadores)
       ->get();
       $profesionalidad=0;
       foreach($profesionalidad_rows as $row) {
         $profesionalidad += $row->value;
       } 
      $logro_rows = with(clone $resultEvalMotivos)
        ->where("question_type", "motivo")
        ->where("question_categoria", "Resultados - Orientación al Logro")
        ->where("no_analizable","=","0")
        ->limit(4*$total_evaluadores)
        ->get();
      $logro=0;
      foreach($logro_rows as $row) {
        $logro += $row->value;
      }
      $honestidad_row = with(clone $resultEvalMotivos)
        ->where("question_type", "motivo")
        ->where("question_categoria", "Integridad - Honestidad")
        ->where("no_analizable","=","0")
        ->limit(4*$total_evaluadores)
        ->get();
      $honestidad=0;
      foreach($honestidad_row as $row) {
        $honestidad += $row->value;
      } 
  
      $consistencia_row = with(clone $resultEvalMotivos)
        ->where("question_type", "motivo")
        ->where("question_categoria", "Consistencia")
        ->where("no_analizable","=","0")
        ->limit(3*$total_evaluadores)
        ->get();
      $consistencia=0;
      foreach($consistencia_row as $row) {
        $consistencia += $row->value;
      } 
        
      $confianza_row = with(clone $resultEvalMotivos)
        ->where("question_type", "motivo")
        ->where("question_categoria", "Afectividad - Confianza")
        ->where("no_analizable","=","0")
        ->limit(7*$total_evaluadores)
        ->get();
      $confianza=0;
      foreach($confianza_row as $row) {
        $confianza += $row->value;
      } 
     
  

       // $total_evaluadores = count($tmp);
      $total_profesionalidad = 6*5*$total_evaluadores;
      $total_logro = 4*5*$total_evaluadores;
      $total_honestidad = 4*5*$total_evaluadores;
      $total_consistencia = 3*5*$total_evaluadores;
      $total_confianza = 7*5*$total_evaluadores;
       
      if($total_profesionalidad > 0 and $total_logro > 0 and $total_honestidad > 0 and $total_consistencia > 0 and $total_confianza > 0 )
      $data['impactos'] = [
        "profesionalidad" => $profesionalidad/$total_profesionalidad*100,
        "logro" => $logro/$total_logro*100,
        "honestidad" =>  $honestidad/$total_honestidad*100,
        "consistencia" => $consistencia/$total_consistencia*100,
        "confianza" => $confianza/$total_confianza*100,
       ];
       
  /*  
        $resultMotivoAuto = Result::whereIn("quiz_id",[3,11])
                            ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id')
                            ->where("tresfera_taketsystem_answers.question_type", "motivo")
                            ->where("tresfera_taketsystem_results.duplicated",0)
                            ->where("tresfera_taketsystem_answers.no_analizable",0)
                            ->orderBy("tresfera_taketsystem_answers.slide_id", "asc") 
                            ->orderBy("tresfera_taketsystem_answers.id", "asc") 
                            ->get();
                                    
        $tmp = [];
        $slide_id = -1;
        foreach($resultMotivoAuto as $m)
        {
          if($slide_id == $m->slide_id) $tmp[count($tmp)-1] = $m;
          else 
          {
            array_push($tmp, $m);
            
          }
          $slide_id = $m->slide_id;
        }
        
        $profesionalidad = 0;
        $logro = 0;
        $honestidad = 0;
        $consistencia = 0;
        $confianza = 0;
         

        foreach($tmp as $t)
        {
          if( isset($t->question_categoria) ) 
          {
            if( $t->question_categoria == "Cognición - Profesionalidad")
            {
              $profesionalidad += $t->value;
            }
            else if($t->question_categoria == "Resultados - Orientación al Logro")
            {
              $logro += $t->value;
            }
            else if($t->question_categoria == "Integridad - Honestidad")
            {
              $honestidad += $t->value;
            }
            else if($t->question_categoria == "Consistencia")
            {
              $consistencia += $t->value;
            }
            else if($t->question_categoria == "Afectividad - Confianza")
            {
              $confianza += $t->value;
            }
          }
        }
*/

        $resultTotalMotivos = Result::where("is_evaluacion",1)
                    ->where("evaluacion_id",">",0)
                    ->where("tresfera_taketsystem_results.duplicated",0)
                    ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

        $total_evaluadores = Result::where("is_evaluacion",1)
              ->where("duplicated",0)->where("import",0)->count();

       $profesionalidad_row = with(clone $resultTotalMotivos)
        ->where("question_type", "motivo")
        ->where("question_categoria", "Cognición - Profesionalidad")
        ->where("no_analizable","=","0")
        ->take(6*$total_evaluadores)
        ->get();
        $profesionalidad=0;
        foreach($profesionalidad_row as $row) {
          $profesionalidad += $row->value;
        } 
       
       $logro_row = with(clone $resultTotalMotivos)
        ->where("question_type", "motivo")
        ->where("question_categoria", "Resultados - Orientación al Logro")
        ->where("no_analizable","=","0")
        ->take(4*$total_evaluadores)
        ->get();
        $logro=0;
        foreach($logro_row as $row) {
          $logro += $row->value;
        } 
        
        $honestidad_row = with(clone $resultTotalMotivos)
        ->where("question_type", "motivo")
        ->where("question_categoria", "Integridad - Honestidad")
        ->where("no_analizable","=","0")
        ->take(4*$total_evaluadores)
        ->get();
        $honestidad=0;
        foreach($honestidad_row as $row) {
          $honestidad += $row->value;
        } 
  
       $consistencia_row = with(clone $resultTotalMotivos)
        ->where("question_type", "motivo")
        ->where("question_categoria", "Consistencia")
        ->where("no_analizable","=","0")
        ->take(3*$total_evaluadores)
        ->get();
        $consistencia=0;
        foreach($consistencia_row as $row) {
          $consistencia += $row->value;
        } 
        
        $confianza_row = with(clone $resultTotalMotivos)
        ->where("question_type", "motivo")
        ->where("question_categoria", "Afectividad - Confianza")
        ->where("no_analizable","=","0")
        ->take(7*$total_evaluadores)
        ->get();
        $confianza=0;
        foreach($confianza_row as $row) {
          $confianza += $row->value;
        } 
     
        
  
      
      
       //$total_evaluadores = count($tmp);

       $total_profesionalidad = 6*5*$total_evaluadores;
       $total_logro = 4*5*$total_evaluadores;
       $total_honestidad = 4*5*$total_evaluadores;
       $total_consistencia = 3*5*$total_evaluadores;
       $total_confianza = 7*5*$total_evaluadores;
       
       $data['impactos_total'] = [
        "profesionalidad" => ($profesionalidad) ? $profesionalidad/$total_profesionalidad*100 : 0,
        "logro" => ($logro) ? $logro/$total_logro*100 : 0,
        "honestidad" => ($honestidad) ? $honestidad/$total_honestidad*100 : 0,
        "consistencia" => ($consistencia) ? $consistencia/$total_consistencia*100 : 0,
        "confianza" => ($confianza) ? $confianza/$total_confianza*100 : 0,
       ];
       
       $data["evaluacion_id"] = $id_evaluacion;
  
       //dd($data);
       return $data;
      }
      static function getDataAutoevaluadoRapport($id_evaluacion) {
        $evaluacion = Evaluacion::find($id_evaluacion);

        $frases = $evaluacion->getFrases();
        $hombre = ["Hombre","Male"];
        $mujer = ["Mujer","Female"];
        $generos = [
          "Hombre" => $hombre,
          "Male" => $hombre,
          "Female" => $mujer,
          "Mujer" => $mujer
        ];
        $edades_0 = ["15-19 year old","15-19 años"];
        $edades_1 = ["20-24 year old","20-24 años"];
        $edades_2 = ["25-29 year old","25-29 años"];
        $edades_3 = ["30-34 year old","30-34 años"];
        $edades_4 = ["35-39 year old","35-39 años"];
        $edades_5 = ["40-44 year old","40-44 años"];
        $edades_6 = ["45-49 year old","45-49 años"];
        $edades_7 = ["50-54 year old","50-54 años"];
        $edades_8 = ["55-59 year old","55-59 años"];
        $edades_9 = ["60-64 year old","60-64 años"];
        $edades_10 = ["65-69 year old","65-69 años"];
        $edades_11 = ["70 years or older","70 años o más"];

        $edades = [
          "15-19 year old" => $edades_0,
          "20-24 year old" => $edades_1,
          "25-29 year old" => $edades_2,
          "30-34 year old" => $edades_3,
          "35-39 year old" => $edades_4,
          "40-44 year old" => $edades_5,
          "45-49 year old" => $edades_6,
          "50-54 year old" => $edades_7,
          "55-59 year old" => $edades_8,
          "60-64 year old" => $edades_9,
          "65-69 year old" => $edades_10,
          "70 years or older" => $edades_11,
          "15-19 años" => $edades_0,
          "20-24 años" => $edades_1,
          "25-29 años" => $edades_2,
          "30-34 años" => $edades_3,
          "35-39 años" => $edades_4,
          "40-44 años" => $edades_5,
          "45-49 años" => $edades_6,
          "50-54 años" => $edades_7,
          "55-59 años" => $edades_8,
          "60-64 años" => $edades_9,
          "65-69 años" => $edades_10,
          "70 años o más" => $edades_11,
        ];


        $frases = $evaluacion->getFrases();
  
        $evaluacion = \Tresfera\Talentapp\Models\Evaluacion::find($id_evaluacion);
  
        $resultAuto = Result::where("is_autoevaluacion",1)
                            ->where("evaluacion_id",$evaluacion->id)
                            ->where("tresfera_taketsystem_answers.duplicated",0)
                            ->where("tresfera_taketsystem_results.duplicated",0)
                            ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');
  
        $resultEval = Result::where("is_autoevaluacion",1)
                              ->where("evaluacion_id",$evaluacion->id)
                              ->where("tresfera_taketsystem_answers.duplicated",0)
                              ->where("tresfera_taketsystem_results.duplicated",0)
                              ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');
  
        $resultTotal = Result::whereIn("quiz_id",[3,16])
                              ->where("tresfera_taketsystem_answers.duplicated",0)
                              ->where("tresfera_taketsystem_results.duplicated",0)                            
                              ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');
  
             
        $competencias = [];                      
  
        $dimension_estrategica_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","ESTRATÉGICA")->first()->value;;
        $dimension_estrategica_auto = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","ESTRATÉGICA")->first()->value;
        $dimension_estrategica_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","ESTRATÉGICA")->first()->value;      ;
  
        $dimension_interpersonal_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","INTERPERSONAL")->first()->value;
        $dimension_interpersonal_auto = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","INTERPERSONAL")->first()->value;
        $dimension_interpersonal_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","INTERPERSONAL")->first()->value;
  
        $dimension_autogestion_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","AUTOGESTIÓN")->first()->value;;
        $dimension_autogestion_auto = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","AUTOGESTIÓN")->first()->value;
        $dimension_autogestion_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","AUTOGESTIÓN")->first()->value;
  
        $dimension_autodesarrollo_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","AUTODESARROLLO")->first()->value;;
        $dimension_autodesarrollo_auto = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","AUTODESARROLLO")->first()->value;
        $dimension_autodesarrollo_total =  with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","AUTODESARROLLO")->first()->value;
  
        $dimension_autoliderazgo_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","AUTOGOBIERNO")->first()->value;;
        $dimension_autoliderazgo_auto = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","AUTOGOBIERNO")->first()->value;
        $dimension_autoliderazgo_total =  with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","AUTOGOBIERNO")->first()->value;
  
  
        //pag 14
        $dimension_estrategica_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_estrategica_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_estrategica_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("rol","companero")
        ->first()->value;
        $dimension_estrategica_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("rol","otros")
        ->first()->value;
  
        $dimension_estrategica_estrategica_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Visión Estratégica")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_estrategica_estrategica_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Visión Estratégica")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_estrategica_estrategica_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Visión Estratégica")
        ->where("rol","companero")
        ->first()->value;
        $dimension_estrategica_estrategica_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Visión Estratégica")
        ->where("rol","otros")
        ->first()->value;
  
        $estrategica_estrategica_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Visión Estratégica")
        ->where("question_dimension","ESTRATÉGICA")
        ->first()->value;
        $estrategica_estrategica_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Visión Estratégica")
        ->where("question_dimension","ESTRATÉGICA")
        ->first()->value;
        $estrategica_estrategica_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Visión Estratégica")
        ->where("question_dimension","ESTRATÉGICA")
        ->first()->value;
  
        $competencias["Visión Estratégica"] = [
          "evaluadores" => $estrategica_estrategica_evaluadores,
          "autoevaluador" => $estrategica_estrategica_autoevaluador,
          "total" => $estrategica_estrategica_total,
          "diferencia" => $estrategica_estrategica_autoevaluador - $estrategica_estrategica_evaluadores,
        ];
  
  
        $dimension_estrategica_organizacion_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Visión de la Organización")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_estrategica_organizacion_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Visión de la Organización")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_estrategica_organizacion_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Visión de la Organización")
        ->where("rol","companero")
        ->first()->value;
        $dimension_estrategica_organizacion_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Visión de la Organización")
        ->where("rol","otros")
        ->first()->value;
  
        $estrategica_organizacion_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Visión de la Organización")
        ->where("question_dimension","ESTRATÉGICA")
        ->first()->value;
        $estrategica_organizacion_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Visión de la Organización")
        ->where("question_dimension","ESTRATÉGICA")
        ->first()->value;
        $estrategica_organizacion_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Visión de la Organización")
        ->where("question_dimension","ESTRATÉGICA")
        ->first()->value;
        $competencias["Visión de la Organización"] = [
          "evaluadores" => $estrategica_organizacion_evaluadores,
          "autoevaluador" => $estrategica_organizacion_autoevaluador,
          "total" => $estrategica_organizacion_total,
          "diferencia" => $estrategica_organizacion_autoevaluador - $estrategica_organizacion_evaluadores,
        ];
  
        $dimension_estrategica_networking_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Networking")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_estrategica_networking_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Networking")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_estrategica_networking_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Networking")
        ->where("rol","companero")
        ->first()->value;
        $dimension_estrategica_networking_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Networking")
        ->where("rol","otros")
        ->first()->value;
  
        $estrategica_networking_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Networking")
        ->where("question_dimension","ESTRATÉGICA")
        ->first()->value;
        $estrategica_networking_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Networking")
        ->where("question_dimension","ESTRATÉGICA")
        ->first()->value;
        $estrategica_networking_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Networking")
        ->where("question_dimension","ESTRATÉGICA")
        ->first()->value;
  
        $competencias["Networking"] = [
          "evaluadores" => $estrategica_networking_evaluadores,
          "autoevaluador" => $estrategica_networking_autoevaluador,
          "total" => $estrategica_networking_total,
          "diferencia" => $estrategica_networking_autoevaluador - $estrategica_networking_evaluadores,
        ];
        
  
        $dimension_estrategica_cliente_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Orientación al Cliente")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_estrategica_cliente_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Orientación al Cliente")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_estrategica_cliente_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Orientación al Cliente")
        ->where("rol","companero")
        ->first()->value;
        $dimension_estrategica_cliente_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATÉGICA")
        ->where("question_competencia","Orientación al Cliente")
        ->where("rol","otros")
        ->first()->value;
  
        $estrategica_cliente_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Orientación al Cliente")
        ->where("question_dimension","ESTRATÉGICA")
        ->first()->value;
        $estrategica_cliente_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Orientación al Cliente")
        ->where("question_dimension","ESTRATÉGICA")
        ->first()->value;
        $estrategica_cliente_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Orientación al Cliente")
        ->where("question_dimension","ESTRATÉGICA")
        ->first()->value;
  
        $competencias["Orientación al Cliente"] = [
          "evaluadores" => $estrategica_cliente_evaluadores,
          "autoevaluador" => $estrategica_cliente_autoevaluador,
          "total" => $estrategica_cliente_total,
          "diferencia" => $estrategica_cliente_autoevaluador - $estrategica_cliente_evaluadores,
        ];
  
        if( isset($evaluacion->result->edad) )
        {
          $estrategica_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","ESTRATÉGICA")
          ->whereIn("edad",$edades[$evaluacion->result->edad])
          ->first()->value;

        }
        //else if(isset($evaluacion->result->age) )
        else if( isset($evaluacion->result->age) and isset($edades[$evaluacion->result->age]))
        {
          $estrategica_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","ESTRATÉGICA")
          ->where("edad",$evaluacion->result->age)
          ->first()->value;
        }
        else $estrategica_edad = "";


        if( isset($evaluacion->result->sector) )
        {
        $estrategica_sector = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","ESTRATÉGICA")
          ->whereIn("sector",[$evaluacion->result->sector,SELF::translate($evaluacion->result->sector)])
          ->first()->value;
        }
        else $estrategica_sector = "";

        if( isset($evaluacion->result->genero) )
        {
        $estrategica_genero = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","ESTRATÉGICA")
          ->whereIn("genero",$generos[$evaluacion->result->genero])
          ->first()->value;
        }
        else $estrategica_genero = "";

        if( isset($evaluacion->result->area) )
        {
        $estrategica_area = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","ESTRATÉGICA")
          ->whereIn("area",[$evaluacion->result->area,SELF::translate($evaluacion->result->area)])
          ->first()->value;
        }
        else $estrategica_area = "";

        if( isset($evaluacion->result->funcion) )
        {
        $estrategica_funcion = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","ESTRATÉGICA")
          ->whereIn("funcion",[$evaluacion->result->funcion,SELF::translate($evaluacion->result->funcion)])
          ->first()->value;
        }
        else $estrategica_funcion = "";

  
          //$this->generatePolar();
  
        //pag 14b
        $dimension_interpersonal_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","INTERPERSONAL")
          ->where("rol","jefe")
          ->first()->value;
        $dimension_interpersonal_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","INTERPERSONAL")
          ->where("rol","colaborador")
          ->first()->value;
        $dimension_interpersonal_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","INTERPERSONAL")
          ->where("rol","companero")
          ->first()->value;
        $dimension_interpersonal_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","INTERPERSONAL")
          ->where("rol","otros")
          ->first()->value;
  
        $dimension_interpersonal_estrategica_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Comunicación")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_interpersonal_estrategica_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Comunicación")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_interpersonal_estrategica_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Comunicación")
        ->where("rol","companero")
        ->first()->value;
        $dimension_interpersonal_estrategica_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Comunicación")
        ->where("rol","otros")
        ->first()->value;
  
        $interpersonal_estrategica_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Comunicación")
        ->where("question_dimension","INTERPERSONAL")
        ->first()->value;
        $interpersonal_estrategica_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Comunicación")
        ->where("question_dimension","INTERPERSONAL")
        ->first()->value;
        $interpersonal_estrategica_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Comunicación")
        ->where("question_dimension","INTERPERSONAL")
        ->first()->value;
  
        $competencias["Comunicación"] = [
          "evaluadores" => $interpersonal_estrategica_evaluadores,
          "autoevaluador" => $interpersonal_estrategica_autoevaluador,
          "total" => $interpersonal_estrategica_total,
          "diferencia" => $interpersonal_estrategica_autoevaluador - $interpersonal_estrategica_evaluadores,
        ];
  
        $dimension_interpersonal_organizacion_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Delegación")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_interpersonal_organizacion_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Delegación")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_interpersonal_organizacion_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Delegación")
        ->where("rol","companero")
        ->first()->value;
        $dimension_interpersonal_organizacion_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Delegación")
        ->where("rol","otros")
        ->first()->value;
  
        $interpersonal_organizacion_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Delegación")
        ->where("question_dimension","INTERPERSONAL")
        ->first()->value;
        $interpersonal_organizacion_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Delegación")
        ->where("question_dimension","INTERPERSONAL")
        ->first()->value;
        $interpersonal_organizacion_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Delegación")
        ->where("question_dimension","INTERPERSONAL")
        ->first()->value;
  
        $competencias["Delegación"] = [
          "evaluadores" => $interpersonal_organizacion_evaluadores,
          "autoevaluador" => $interpersonal_organizacion_autoevaluador,
          "total" => $interpersonal_organizacion_total,
          "diferencia" => $interpersonal_organizacion_autoevaluador - $interpersonal_organizacion_evaluadores,
        ];
  
  
        $dimension_interpersonal_networking_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Coaching")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_interpersonal_networking_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Coaching")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_interpersonal_networking_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Coaching")
        ->where("rol","companero")
        ->first()->value;
        $dimension_interpersonal_networking_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Coaching")
        ->where("rol","otros")
        ->first()->value;
  
        $interpersonal_networking_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Coaching")
        ->where("question_dimension","INTERPERSONAL")
        ->first()->value;
        $interpersonal_networking_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Coaching")
        ->where("question_dimension","INTERPERSONAL")
        ->first()->value;
        $interpersonal_networking_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Coaching")
        ->where("question_dimension","INTERPERSONAL")
        ->first()->value;
        
        $competencias["Coaching"] = [
          "evaluadores" => $interpersonal_networking_evaluadores,
          "autoevaluador" => $interpersonal_networking_autoevaluador,
          "total" => $interpersonal_networking_total,
          "diferencia" => $interpersonal_networking_autoevaluador - $interpersonal_networking_evaluadores,
        ];
  
        $dimension_interpersonal_cliente_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Trabajo en Equipo")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_interpersonal_cliente_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Trabajo en Equipo")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_interpersonal_cliente_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Trabajo en Equipo")
        ->where("rol","companero")
        ->first()->value;
        $dimension_interpersonal_cliente_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->where("question_competencia","Trabajo en Equipo")
        ->where("rol","otros")
        ->first()->value;
  
        $interpersonal_cliente_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Trabajo en Equipo")
        ->where("question_dimension","INTERPERSONAL")
        ->first()->value;
        $interpersonal_cliente_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Trabajo en Equipo")
        ->where("question_dimension","INTERPERSONAL")
        ->first()->value;
        $interpersonal_cliente_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Trabajo en Equipo")
        ->where("question_dimension","INTERPERSONAL")
        ->first()->value;
        $competencias["Trabajo en Equipo"] = [
          "evaluadores" => $interpersonal_cliente_evaluadores,
          "autoevaluador" => $interpersonal_cliente_autoevaluador,
          "total" => $interpersonal_cliente_total,
          "diferencia" => $interpersonal_cliente_autoevaluador - $interpersonal_cliente_evaluadores,
        ];
        //if( isset($evaluacion->result->edad) )
        if( isset($evaluacion->result->edad) and isset($edades[$evaluacion->result->edad]))
        {
          $interpersonal_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","INTERPERSONAL")
          ->whereIn("edad",$edades[$evaluacion->result->edad])
          ->first()->value;
        }
        //else if( isset($evaluacion->result->age) )
        else if( isset($evaluacion->result->age) and isset($edades[$evaluacion->result->age]))
        {
          $interpersonal_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","INTERPERSONAL")
          ->where("edad",$evaluacion->result->age)
          ->first()->value;
        }
        else $interpersonal_edad = "";

        if( isset($evaluacion->result->sector) )
        {
        $interpersonal_sector = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->whereIn("sector",[$evaluacion->result->sector,SELF::translate($evaluacion->result->sector)])
        ->first()->value;
        }
        else $interpersonal_sector = "";

        if( isset($evaluacion->result->genero) )
        {
        $interpersonal_genero = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->whereIn("genero",$generos[$evaluacion->result->genero])
        ->first()->value;
        }
        else $interpersonal_genero = "";

        if( isset($evaluacion->result->area) )
        {
        $interpersonal_area = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->whereIn("area",[$evaluacion->result->area,SELF::translate($evaluacion->result->area)])
        ->first()->value;
        }
        else $interpersonal_area = "";

        if( isset($evaluacion->result->funcion) )
        {
        $interpersonal_funcion = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","INTERPERSONAL")
        ->whereIn("funcion",[$evaluacion->result->funcion,SELF::translate($evaluacion->result->funcion)])
        ->first()->value;
        }
        else $interpersonal_funcion = "";

  
        //pag 14C
        $dimension_autogestion_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_autogestion_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_autogestion_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("rol","companero")
        ->first()->value;
        $dimension_autogestion_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("rol","otros")
        ->first()->value;
  
        $dimension_autogestion_estrategica_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Optimismo")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_autogestion_estrategica_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Optimismo")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_autogestion_estrategica_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Optimismo")
        ->where("rol","companero")
        ->first()->value;
        $dimension_autogestion_estrategica_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Optimismo")
        ->where("rol","otros")
        ->first()->value;
  
        $autogestion_estrategica_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Optimismo")
        ->where("question_dimension","AUTOGESTION")
        ->first()->value;
        $autogestion_estrategica_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Optimismo")
        ->where("question_dimension","AUTOGESTION")
        ->first()->value;
        $autogestion_estrategica_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Optimismo")
        ->where("question_dimension","AUTOGESTION")
        ->first()->value;
        $competencias["Optimismo"] = [
          "evaluadores" => $autogestion_estrategica_evaluadores,
          "autoevaluador" => $autogestion_estrategica_autoevaluador,
          "total" => $autogestion_estrategica_total,
          "diferencia" => $autogestion_estrategica_autoevaluador - $autogestion_estrategica_evaluadores,
        ];
        $dimension_autogestion_organizacion_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Gestión del Tiempo")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_autogestion_organizacion_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Gestión del Tiempo")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_autogestion_organizacion_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Gestión del Tiempo")
        ->where("rol","companero")
        ->first()->value;
        $dimension_autogestion_organizacion_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Gestión del Tiempo")
        ->where("rol","otros")
        ->first()->value;
  
        $autogestion_organizacion_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Gestión del Tiempo")
        ->where("question_dimension","AUTOGESTION")
        ->first()->value;
        $autogestion_organizacion_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Gestión del Tiempo")
        ->where("question_dimension","AUTOGESTION")
        ->first()->value;
        $autogestion_organizacion_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Gestión del Tiempo")
        ->where("question_dimension","AUTOGESTION")
        ->first()->value;
        $competencias["Gestión del Tiempo"] = [
          "evaluadores" => $autogestion_organizacion_evaluadores,
          "autoevaluador" => $autogestion_organizacion_autoevaluador,
          "total" => $autogestion_organizacion_total,
          "diferencia" => $autogestion_organizacion_autoevaluador - $autogestion_organizacion_evaluadores,
        ];
        $dimension_autogestion_networking_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Iniciativa")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_autogestion_networking_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Iniciativa")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_autogestion_networking_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Iniciativa")
        ->where("rol","companero")
        ->first()->value;
        $dimension_autogestion_networking_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Iniciativa")
        ->where("rol","otros")
        ->first()->value;
  
        $autogestion_networking_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Iniciativa")
        ->where("question_dimension","AUTOGESTION")
        ->first()->value;
        $autogestion_networking_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Iniciativa")
        ->where("question_dimension","AUTOGESTION")
        ->first()->value;
        $autogestion_networking_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Iniciativa")
        ->where("question_dimension","AUTOGESTION")
        ->first()->value;
  
        $competencias["Iniciativa"] = [
          "evaluadores" => $autogestion_networking_evaluadores,
          "autoevaluador" => $autogestion_networking_autoevaluador,
          "total" => $autogestion_networking_total,
          "diferencia" => $autogestion_networking_autoevaluador - $autogestion_networking_evaluadores,
        ];
  
        $dimension_autogestion_cliente_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Gestión del Estrés")
        ->where("rol","jefe")
        ->first()->value;
        $dimension_autogestion_cliente_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Gestión del Estrés")
        ->where("rol","colaborador")
        ->first()->value;
        $dimension_autogestion_cliente_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Gestión del Estrés")
        ->where("rol","companero")
        ->first()->value;
        $dimension_autogestion_cliente_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","AUTOGESTION")
        ->where("question_competencia","Gestión del Estrés")
        ->where("rol","otros")
        ->first()->value;
  
        $autogestion_cliente_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Gestión del Estrés")
        ->where("question_dimension","AUTOGESTION")
        ->first()->value;
        $autogestion_cliente_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Gestión del Estrés")
        ->where("question_dimension","AUTOGESTION")
        ->first()->value;
        $autogestion_cliente_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_competencia","Gestión del Estrés")
        ->where("question_dimension","AUTOGESTION")
        ->first()->value;
        $competencias["Gestión del Estrés"] = [
          "evaluadores" => $autogestion_cliente_evaluadores,
          "autoevaluador" => $autogestion_cliente_autoevaluador,
          "total" => $autogestion_cliente_total,
          "diferencia" => $autogestion_cliente_autoevaluador - $autogestion_cliente_evaluadores,
        ];

        //if(isset($evaluacion->result->edad) )
        if( isset($evaluacion->result->edad) and isset($edades[$evaluacion->result->edad]))
        {
          $autogestion_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","AUTOGESTION")
          ->whereIn("edad",$edades[$evaluacion->result->edad])
          ->first()->value;
        }
        //else if(isset($evaluacion->result->age) )
        else if( isset($evaluacion->result->age) and isset($edades[$evaluacion->result->age]))
        {
          $autogestion_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","AUTOGESTION")
          ->where("edad",$evaluacion->result->age)
          ->first()->value;
        }
        else $autogestion_edad = "";

        if( isset($evaluacion->result->sector) )
        {
          $autogestion_sector = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","AUTOGESTION")
          ->whereIn("sector",[$evaluacion->result->sector,SELF::translate($evaluacion->result->sector)])
          ->first()->value;
        }
        else $autogestion_sector = "";

        if( isset($evaluacion->result->genero) and isset($generos[$evaluacion->result->genero]))
        //if(isset($evaluacion->result->genero) )
        {
          $autogestion_genero = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","AUTOGESTION")
          ->whereIn("genero",$generos[$evaluacion->result->genero])
          ->first()->value;
        }
        else $autogestion_genero = "";

        if( isset($evaluacion->result->area) )
        {
          $autogestion_area = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","AUTOGESTION")
          ->whereIn("area",[$evaluacion->result->area,SELF::translate($evaluacion->result->area)])
          ->first()->value;
        }
        else $autogestion_area = "";

        if( isset($evaluacion->result->funcion) )
        {
          $autogestion_funcion = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
          ->where("question_dimension","AUTOGESTION")
          ->whereIn("funcion",[$evaluacion->result->funcion,SELF::translate($evaluacion->result->funcion)])
          ->first()->value;
        }
        else $autogestion_funcion = "";

  
     //pag 14D
     $dimension_autodesarrollo_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("rol","jefe")
     ->first()->value;
     $dimension_autodesarrollo_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("rol","colaborador")
     ->first()->value;
     $dimension_autodesarrollo_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("rol","companero")
     ->first()->value;
     $dimension_autodesarrollo_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("rol","otros")
     ->first()->value;
  
     $dimension_autodesarrollo_estrategica_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Aprendizaje")
     ->where("rol","jefe")
     ->first()->value;
     $dimension_autodesarrollo_estrategica_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Aprendizaje")
     ->where("rol","colaborador")
     ->first()->value;
     $dimension_autodesarrollo_estrategica_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Aprendizaje")
     ->where("rol","companero")
     ->first()->value;
     $dimension_autodesarrollo_estrategica_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Aprendizaje")
     ->where("rol","otros")
     ->first()->value;
  
     $autodesarrollo_estrategica_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_competencia","Aprendizaje")
     ->where("question_dimension","AUTODESARROLLO")
     ->first()->value;
     $autodesarrollo_estrategica_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
     ->where("question_competencia","Aprendizaje")
     ->where("question_dimension","AUTODESARROLLO")
     ->first()->value;
     $autodesarrollo_estrategica_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
     ->where("question_competencia","Aprendizaje")
     ->where("question_dimension","AUTODESARROLLO")
     ->first()->value;
     $competencias["Aprendizaje"] = [
      "evaluadores" => $autodesarrollo_estrategica_evaluadores,
      "autoevaluador" => $autodesarrollo_estrategica_autoevaluador,
      "total" => $autodesarrollo_estrategica_total,
      "diferencia" => $autodesarrollo_estrategica_autoevaluador - $autodesarrollo_estrategica_evaluadores,
    ];
     $dimension_autodesarrollo_organizacion_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Autoconocimiento")
     ->where("rol","jefe")
     ->first()->value;
     $dimension_autodesarrollo_organizacion_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Autoconocimiento")
     ->where("rol","colaborador")
     ->first()->value;
     $dimension_autodesarrollo_organizacion_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Autoconocimiento")
     ->where("rol","companero")
     ->first()->value;
     $dimension_autodesarrollo_organizacion_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Autoconocimiento")
     ->where("rol","otros")
     ->first()->value;
  
     $autodesarrollo_organizacion_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_competencia","Autoconocimiento")
     ->where("question_dimension","AUTODESARROLLO")
     ->first()->value;
     $autodesarrollo_organizacion_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
     ->where("question_competencia","Autoconocimiento")
     ->where("question_dimension","AUTODESARROLLO")
     ->first()->value;
     $autodesarrollo_organizacion_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
     ->where("question_competencia","Autoconocimiento")
     ->where("question_dimension","AUTODESARROLLO")
     ->first()->value;
     $competencias["Autoconocimiento"] = [
      "evaluadores" => $autodesarrollo_organizacion_evaluadores,
      "autoevaluador" => $autodesarrollo_organizacion_autoevaluador,
      "total" => $autodesarrollo_organizacion_total,
      "diferencia" => $autodesarrollo_organizacion_autoevaluador - $autodesarrollo_organizacion_evaluadores,
    ];
     $dimension_autodesarrollo_networking_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Autocrítica")
     ->where("rol","jefe")
     ->first()->value;
     $dimension_autodesarrollo_networking_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Autocrítica")
     ->where("rol","colaborador")
     ->first()->value;
     $dimension_autodesarrollo_networking_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Autocrítica")
     ->where("rol","companero")
     ->first()->value;
     $dimension_autodesarrollo_networking_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Autocrítica")
     ->where("rol","otros")
     ->first()->value;
  
     $autodesarrollo_networking_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_competencia","Autocrítica")
     ->where("question_dimension","AUTODESARROLLO")
     ->first()->value;
     $autodesarrollo_networking_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
     ->where("question_competencia","Autocrítica")
     ->where("question_dimension","AUTODESARROLLO")
     ->first()->value;
     $autodesarrollo_networking_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
     ->where("question_competencia","Autocrítica")
     ->where("question_dimension","AUTODESARROLLO")
     ->first()->value;
     $competencias["Autocrítica"] = [
      "evaluadores" => $autodesarrollo_networking_evaluadores,
      "autoevaluador" => $autodesarrollo_networking_autoevaluador,
      "total" => $autodesarrollo_networking_total,
      "diferencia" => $autodesarrollo_networking_autoevaluador - $autodesarrollo_networking_evaluadores,
    ];
     $dimension_autodesarrollo_cliente_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Ambición")
     ->where("rol","jefe")
     ->first()->value;
     $dimension_autodesarrollo_cliente_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Ambición")
     ->where("rol","colaborador")
     ->first()->value;
     $dimension_autodesarrollo_cliente_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Ambición")
     ->where("rol","companero")
     ->first()->value;
     $dimension_autodesarrollo_cliente_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->where("question_competencia","Ambición")
     ->where("rol","otros")
     ->first()->value;
  
     $autodesarrollo_cliente_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
     ->where("question_competencia","Ambición")
     ->where("question_dimension","AUTODESARROLLO")
     ->first()->value;
     $autodesarrollo_cliente_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
     ->where("question_competencia","Ambición")
     ->where("question_dimension","AUTODESARROLLO")
     ->first()->value;
     $autodesarrollo_cliente_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
     ->where("question_competencia","Ambición")
     ->where("question_dimension","AUTODESARROLLO")
     ->first()->value;
     $competencias["Ambición"] = [
      "evaluadores" => $autodesarrollo_cliente_evaluadores,
      "autoevaluador" => $autodesarrollo_cliente_autoevaluador,
      "total" => $autodesarrollo_cliente_total,
      "diferencia" => $autodesarrollo_cliente_autoevaluador - $autodesarrollo_cliente_evaluadores,
    ];

    //if(isset($evaluacion->result->edad) )
    if( isset($evaluacion->result->edad) and isset($edades[$evaluacion->result->edad]))
    {
      $autodesarrollo_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","AUTODESARROLLO")
      ->whereIn("edad",$edades[$evaluacion->result->edad])
      ->first()->value;
    }
    //else if(isset($evaluacion->result->age) )
    else if( isset($evaluacion->result->age) and isset($edades[$evaluacion->result->age]))
    {
      $autodesarrollo_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","AUTODESARROLLO")
      ->where("edad",$evaluacion->result->age)
      ->first()->value;
    }
    else $autodesarrollo_edad = "";
    
    if( isset($evaluacion->result->sector) )
    {
     $autodesarrollo_sector = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->whereIn("sector",[$evaluacion->result->sector,SELF::translate($evaluacion->result->sector)])
     ->first()->value;
    }
    else $autodesarrollo_sector = "";

    //if(isset($evaluacion->result->genero) )
    if( isset($evaluacion->result->genero) and isset($generos[$evaluacion->result->genero]))
    {
     $autodesarrollo_genero = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->whereIn("genero",$generos[$evaluacion->result->genero])
     ->first()->value;
    }
    else $autodesarrollo_genero = "";

    if( isset($evaluacion->result->area) )
    {
     $autodesarrollo_area = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->whereIn("area",[$evaluacion->result->area,SELF::translate($evaluacion->result->area)])
     ->first()->value;
    }
    else $autodesarrollo_area = "";

    if( isset($evaluacion->result->funcion) )
    {
     $autodesarrollo_funcion = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
     ->where("question_dimension","AUTODESARROLLO")
     ->whereIn("funcion",[$evaluacion->result->funcion,SELF::translate($evaluacion->result->funcion)])
     ->first()->value;
    }
    else $autodesarrollo_funcion = "";

  
           //pag 14E
           $dimension_autoliderazgo_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("rol","jefe")
           ->first()->value;
           $dimension_autoliderazgo_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("rol","colaborador")
           ->first()->value;
           $dimension_autoliderazgo_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("rol","companero")
           ->first()->value;
           $dimension_autoliderazgo_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("rol","otros")
           ->first()->value;
     
           $dimension_autoliderazgo_estrategica_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Integridad")
           ->where("rol","jefe")
           ->first()->value;
           $dimension_autoliderazgo_estrategica_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Integridad")
           ->where("rol","colaborador")
           ->first()->value;
           $dimension_autoliderazgo_estrategica_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Integridad")
           ->where("rol","companero")
           ->first()->value;
           $dimension_autoliderazgo_estrategica_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Integridad")
           ->where("rol","otros")
           ->first()->value;
     
           $autoliderazgo_estrategica_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia","Integridad")
           ->where("question_dimension","AUTOGOBIERNO")
           ->first()->value;
           $autoliderazgo_estrategica_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia","Integridad")
           ->where("question_dimension","AUTOGOBIERNO")
           ->first()->value;
           $autoliderazgo_estrategica_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia","Integridad")
           ->where("question_dimension","AUTOGOBIERNO")
           ->first()->value;
           $competencias["Integridad"] = [
            "evaluadores" => $autoliderazgo_estrategica_evaluadores,
            "autoevaluador" => $autoliderazgo_estrategica_autoevaluador,
            "total" => $autoliderazgo_estrategica_total,
            "diferencia" => $autoliderazgo_estrategica_autoevaluador - $autoliderazgo_estrategica_evaluadores,
          ];
           $dimension_autoliderazgo_organizacion_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Toma de Decisiones")
           ->where("rol","jefe")
           ->first()->value;
           $dimension_autoliderazgo_organizacion_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Toma de Decisiones")
           ->where("rol","colaborador")
           ->first()->value;
           $dimension_autoliderazgo_organizacion_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Toma de Decisiones")
           ->where("rol","companero")
           ->first()->value;
           $dimension_autoliderazgo_organizacion_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Toma de Decisiones")
           ->where("rol","otros")
           ->first()->value;
     
           $autoliderazgo_organizacion_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia","Toma de Decisiones")
           ->where("question_dimension","AUTOGOBIERNO")
           ->first()->value;
           $autoliderazgo_organizacion_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia","Toma de Decisiones")
           ->where("question_dimension","AUTOGOBIERNO")
           ->first()->value;
           $autoliderazgo_organizacion_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia","Toma de Decisiones")
           ->where("question_dimension","AUTOGOBIERNO")
           ->first()->value;
     
           $competencias["Toma de Decisiones"] = [
            "evaluadores" => $autoliderazgo_organizacion_evaluadores,
            "autoevaluador" => $autoliderazgo_organizacion_autoevaluador,
            "total" => $autoliderazgo_organizacion_total,
            "diferencia" => $autoliderazgo_organizacion_autoevaluador - $autoliderazgo_organizacion_evaluadores,
          ];
  
           $dimension_autoliderazgo_networking_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Autocontrol")
           ->where("rol","jefe")
           ->first()->value;
           $dimension_autoliderazgo_networking_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Autocontrol")
           ->where("rol","colaborador")
           ->first()->value;
           $dimension_autoliderazgo_networking_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Autocontrol")
           ->where("rol","companero")
           ->first()->value;
           $dimension_autoliderazgo_networking_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Autocontrol")
           ->where("rol","otros")
           ->first()->value;
     
           $autoliderazgo_networking_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia","Autocontrol")
           ->where("question_dimension","AUTOGOBIERNO")
           ->first()->value;
           $autoliderazgo_networking_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia","Autocontrol")
           ->where("question_dimension","AUTOGOBIERNO")
           ->first()->value;
           $autoliderazgo_networking_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia","Autocontrol")
           ->where("question_dimension","AUTOGOBIERNO")
           ->first()->value;
     
           $competencias["Autocontrol"] = [
            "evaluadores" => $autoliderazgo_networking_evaluadores,
            "autoevaluador" => $autoliderazgo_networking_autoevaluador,
            "total" => $autoliderazgo_networking_total,
            "diferencia" => $autoliderazgo_networking_autoevaluador - $autoliderazgo_networking_evaluadores,
          ];
  
           $dimension_autoliderazgo_cliente_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Equilibrio Emocional")
           ->where("rol","jefe")
           ->first()->value;
           $dimension_autoliderazgo_cliente_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Equilibrio Emocional")
           ->where("rol","colaborador")
           ->first()->value;
           $dimension_autoliderazgo_cliente_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Equilibrio Emocional")
           ->where("rol","companero")
           ->first()->value;
           $dimension_autoliderazgo_cliente_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->where("question_competencia","Equilibrio Emocional")
           ->where("rol","otros")
           ->first()->value;
     
           $autoliderazgo_cliente_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia","Equilibrio Emocional")
           ->where("question_dimension","AUTOGOBIERNO")
           ->first()->value;
           $autoliderazgo_cliente_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia","Equilibrio Emocional")
           ->where("question_dimension","AUTOGOBIERNO")
           ->first()->value;
           $autoliderazgo_cliente_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
           ->where("question_competencia","Equilibrio Emocional")
           ->where("question_dimension","AUTOGOBIERNO")
           ->first()->value;
     
           $competencias["Equilibrio Emocional"] = [
            "evaluadores" => $autoliderazgo_cliente_evaluadores,
            "autoevaluador" => $autoliderazgo_cliente_autoevaluador,
            "total" => $autoliderazgo_cliente_total,
            "diferencia" => $autoliderazgo_cliente_autoevaluador - $autoliderazgo_cliente_evaluadores,
          ];
  

          //if(isset($evaluacion->result->edad) )
          if( isset($evaluacion->result->edad) and isset($edades[$evaluacion->result->edad]))
          {
            $autoliderazgo_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
            ->where("question_dimension","AUTOGOBIERNO")
            ->whereIn("edad",$edades[$evaluacion->result->edad])
            ->first()->value;
          }
          //else if(isset($evaluacion->result->age) )
          else if( isset($evaluacion->result->age) and isset($edades[$evaluacion->result->age]))
          {
            $autoliderazgo_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
            ->where("question_dimension","AUTOGOBIERNO")
            ->where("edad",$evaluacion->result->age)
            ->first()->value;
          }
          else $autoliderazgo_edad = "";

          if( isset($evaluacion->result->sector) )
          {
           $autoliderazgo_sector = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->whereIn("sector",[$evaluacion->result->sector,SELF::translate($evaluacion->result->sector)])
           ->first()->value;
          }
          else $autoliderazgo_sector = "";

          //if(isset($evaluacion->result->genero) )
        if( isset($evaluacion->result->genero) and isset($generos[$evaluacion->result->genero]))
        {
           $autoliderazgo_genero = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->whereIn("genero",$generos[$evaluacion->result->genero])
           ->first()->value;
          }
          else $autoliderazgo_genero = "";

          if( isset($evaluacion->result->area) )
          {
           $autoliderazgo_area = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->whereIn("area",[$evaluacion->result->area,SELF::translate($evaluacion->result->area)])
           ->first()->value;
          }
          else $autoliderazgo_area = "";
          
          if( isset($evaluacion->result->funcion) )
          {
           $autoliderazgo_funcion = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
           ->where("question_dimension","AUTOGOBIERNO")
           ->whereIn("funcion",[$evaluacion->result->funcion,SELF::translate($evaluacion->result->funcion)])
           ->first()->value;
          }
          else $autoliderazgo_funcion = "";
  
        $data = [
          "name" => $evaluacion->name,
          "idioma" => $evaluacion->lang,
          "fecha" => \Carbon\Carbon::now()->format("d-m-Y"),
          "dimension_estrategica_evaluadores"   => $dimension_estrategica_evaluadores,
          "dimension_estrategica_auto"          => $dimension_estrategica_auto,
          "dimension_estrategica_total"         => $dimension_estrategica_total,
          "dimension_interpersonal_evaluadores" => $dimension_interpersonal_evaluadores,
          "dimension_interpersonal_auto"        => $dimension_interpersonal_auto,
          "dimension_interpersonal_total"       => $dimension_interpersonal_total,
          "dimension_autogestion_evaluadores"   => $dimension_autogestion_evaluadores,
          "dimension_autogestion_auto"          => $dimension_autogestion_auto,
          "dimension_autogestion_total"         => $dimension_autogestion_total,
          "dimension_autodesarrollo_evaluadores"=> $dimension_autodesarrollo_evaluadores,
          "dimension_autodesarrollo_auto"       => $dimension_autodesarrollo_auto,
          "dimension_autodesarrollo_total"      => $dimension_autodesarrollo_total,
          "dimension_autoliderazgo_evaluadores" => $dimension_autoliderazgo_evaluadores,
          "dimension_autoliderazgo_auto"        => $dimension_autoliderazgo_auto,
          "dimension_autoliderazgo_otros"         => $dimension_autoliderazgo_otros,
          "dimension_autoliderazgo_total"         => $dimension_autoliderazgo_total,
  
          //pag 14
          "dimension_estrategica_jefe"          => $dimension_estrategica_jefe?$dimension_estrategica_jefe:0,
          "dimension_estrategica_colaborador"   => $dimension_estrategica_colaborador?$dimension_estrategica_colaborador:0,
          "dimension_estrategica_companero"     => $dimension_estrategica_companero?$dimension_estrategica_companero:0,
          "dimension_estrategica_otros"          => $dimension_estrategica_otros?$dimension_estrategica_otros:0,
  
          "dimension_estrategica_estrategica_jefe"          => $dimension_estrategica_estrategica_jefe?$dimension_estrategica_estrategica_jefe:0,
          "dimension_estrategica_estrategica_colaborador"   => $dimension_estrategica_estrategica_colaborador?$dimension_estrategica_estrategica_colaborador:0,
          "dimension_estrategica_estrategica_companero"     => $dimension_estrategica_estrategica_companero?$dimension_estrategica_estrategica_companero:0,
          "dimension_estrategica_estrategica_otros"         => $dimension_estrategica_estrategica_otros?$dimension_estrategica_estrategica_otros:0,
          "estrategica_estrategica_evaluadores"             => $estrategica_estrategica_evaluadores?$estrategica_estrategica_evaluadores:0,
          "estrategica_estrategica_autoevaluador"           => $estrategica_estrategica_autoevaluador?$estrategica_estrategica_autoevaluador:0,
          "estrategica_estrategica_total"                   => $estrategica_estrategica_total?$estrategica_estrategica_total:0,
  
  
          "dimension_estrategica_organizacion_jefe"          => $dimension_estrategica_organizacion_jefe?$dimension_estrategica_organizacion_jefe:0,
          "dimension_estrategica_organizacion_colaborador"   => $dimension_estrategica_organizacion_colaborador?$dimension_estrategica_organizacion_colaborador:0,
          "dimension_estrategica_organizacion_companero"     => $dimension_estrategica_organizacion_companero?$dimension_estrategica_organizacion_companero:0,
          "dimension_estrategica_organizacion_otros"         => $dimension_estrategica_organizacion_otros?$dimension_estrategica_organizacion_otros:0,
          "estrategica_organizacion_evaluadores"             => $estrategica_organizacion_evaluadores?$estrategica_organizacion_evaluadores:0,
          "estrategica_organizacion_autoevaluador"           => $estrategica_organizacion_autoevaluador?$estrategica_organizacion_autoevaluador:0,
          "estrategica_organizacion_total"                   => $estrategica_organizacion_total?$estrategica_organizacion_total:0,
  
          "dimension_estrategica_networking_jefe"          => $dimension_estrategica_networking_jefe?$dimension_estrategica_networking_jefe:0,
          "dimension_estrategica_networking_colaborador"   => $dimension_estrategica_networking_colaborador?$dimension_estrategica_networking_colaborador:0,
          "dimension_estrategica_networking_companero"     => $dimension_estrategica_networking_companero?$dimension_estrategica_networking_companero:0,
          "dimension_estrategica_networking_otros"         => $dimension_estrategica_networking_otros?$dimension_estrategica_networking_otros:0,
          "estrategica_networking_evaluadores"             => $estrategica_networking_evaluadores?$estrategica_networking_evaluadores:0,
          "estrategica_networking_autoevaluador"           => $estrategica_networking_autoevaluador?$estrategica_networking_autoevaluador:0,
          "estrategica_networking_total"                   => $estrategica_networking_total?$estrategica_networking_total:0,
  
          "dimension_estrategica_cliente_jefe"          => $dimension_estrategica_cliente_jefe?$dimension_estrategica_cliente_jefe:0,
          "dimension_estrategica_cliente_colaborador"   => $dimension_estrategica_cliente_colaborador?$dimension_estrategica_cliente_colaborador:0,
          "dimension_estrategica_cliente_companero"     => $dimension_estrategica_cliente_companero?$dimension_estrategica_cliente_companero:0,
          "dimension_estrategica_cliente_otros"          => $dimension_estrategica_cliente_otros?$dimension_estrategica_cliente_otros:0,
          "estrategica_cliente_evaluadores"             => $estrategica_cliente_evaluadores?$estrategica_cliente_evaluadores:0,
          "estrategica_cliente_autoevaluador"           => $estrategica_cliente_autoevaluador?$estrategica_cliente_autoevaluador:0,
          "estrategica_cliente_total"                   => $estrategica_cliente_total?$estrategica_cliente_total:0,
          
          "estrategica_edad"                            => $estrategica_edad?$estrategica_edad:0,
          "estrategica_sector"                          => $estrategica_sector?$estrategica_sector:0,
          "estrategica_genero"                          => $estrategica_genero?$estrategica_genero:0,
          "estrategica_area"                            => $estrategica_area?$estrategica_area:0,
          "estrategica_funcion"                         => $estrategica_funcion?$estrategica_funcion:0,
  
          /* FIN 14 */
  
          //pag 14B
          "dimension_interpersonal_jefe"          => $dimension_interpersonal_jefe?$dimension_interpersonal_jefe:0,
          "dimension_interpersonal_colaborador"   => $dimension_interpersonal_colaborador?$dimension_interpersonal_colaborador:0,
          "dimension_interpersonal_companero"     => $dimension_interpersonal_companero?$dimension_interpersonal_companero:0,
          "dimension_interpersonal_otros"          => $dimension_interpersonal_otros?$dimension_interpersonal_otros:0,
  
          "dimension_interpersonal_estrategica_jefe"          => $dimension_interpersonal_estrategica_jefe?$dimension_interpersonal_estrategica_jefe:0,
          "dimension_interpersonal_estrategica_colaborador"   => $dimension_interpersonal_estrategica_colaborador?$dimension_interpersonal_estrategica_colaborador:0,
          "dimension_interpersonal_estrategica_companero"     => $dimension_interpersonal_estrategica_companero?$dimension_interpersonal_estrategica_companero:0,
          "dimension_interpersonal_estrategica_otros"         => $dimension_interpersonal_estrategica_otros?$dimension_interpersonal_estrategica_otros:0,
          "interpersonal_estrategica_evaluadores"             => $interpersonal_estrategica_evaluadores?$interpersonal_estrategica_evaluadores:0,
          "interpersonal_estrategica_autoevaluador"           => $interpersonal_estrategica_autoevaluador?$interpersonal_estrategica_autoevaluador:0,
          "interpersonal_estrategica_total"                   => $interpersonal_estrategica_total?$interpersonal_estrategica_total:0,
  
  
          "dimension_interpersonal_organizacion_jefe"          => $dimension_interpersonal_organizacion_jefe?$dimension_interpersonal_organizacion_jefe:0,
          "dimension_interpersonal_organizacion_colaborador"   => $dimension_interpersonal_organizacion_colaborador?$dimension_interpersonal_organizacion_colaborador:0,
          "dimension_interpersonal_organizacion_companero"     => $dimension_interpersonal_organizacion_companero?$dimension_interpersonal_organizacion_companero:0,
          "dimension_interpersonal_organizacion_otros"         => $dimension_interpersonal_organizacion_otros?$dimension_interpersonal_organizacion_otros:0,
          "interpersonal_organizacion_evaluadores"             => $interpersonal_organizacion_evaluadores?$interpersonal_organizacion_evaluadores:0,
          "interpersonal_organizacion_autoevaluador"           => $interpersonal_organizacion_autoevaluador?$interpersonal_organizacion_autoevaluador:0,
          "interpersonal_organizacion_total"                   => $interpersonal_organizacion_total?$interpersonal_organizacion_total:0,
  
          "dimension_interpersonal_networking_jefe"          => $dimension_interpersonal_networking_jefe?$dimension_interpersonal_networking_jefe:0,
          "dimension_interpersonal_networking_colaborador"   => $dimension_interpersonal_networking_colaborador?$dimension_interpersonal_networking_colaborador:0,
          "dimension_interpersonal_networking_companero"     => $dimension_interpersonal_networking_companero?$dimension_interpersonal_networking_companero:0,
          "dimension_interpersonal_networking_otros"         => $dimension_interpersonal_networking_otros?$dimension_interpersonal_networking_otros:0,
          "interpersonal_networking_evaluadores"             => $interpersonal_networking_evaluadores?$interpersonal_networking_evaluadores:0,
          "interpersonal_networking_autoevaluador"           => $interpersonal_networking_autoevaluador?$interpersonal_networking_autoevaluador:0,
          "interpersonal_networking_total"                   => $interpersonal_networking_total?$interpersonal_networking_total:0,
  
          "dimension_interpersonal_cliente_jefe"          => $dimension_interpersonal_cliente_jefe?$dimension_interpersonal_cliente_jefe:0,
          "dimension_interpersonal_cliente_colaborador"   => $dimension_interpersonal_cliente_colaborador?$dimension_interpersonal_cliente_colaborador:0,
          "dimension_interpersonal_cliente_companero"     => $dimension_interpersonal_cliente_companero?$dimension_interpersonal_cliente_companero:0,
          "dimension_interpersonal_cliente_otros"          => $dimension_interpersonal_cliente_otros?$dimension_interpersonal_cliente_otros:0,
          "interpersonal_cliente_evaluadores"             => $interpersonal_cliente_evaluadores?$interpersonal_cliente_evaluadores:0,
          "interpersonal_cliente_autoevaluador"           => $interpersonal_cliente_autoevaluador?$interpersonal_cliente_autoevaluador:0,
          "interpersonal_cliente_total"                   => $interpersonal_cliente_total?$interpersonal_cliente_total:0,
          
          "interpersonal_edad"                            => $interpersonal_edad,
          "interpersonal_sector"                          => $interpersonal_sector,
          "interpersonal_genero"                          => $interpersonal_genero,
          "interpersonal_area"                            => $interpersonal_area,
          "interpersonal_funcion"                         => $interpersonal_funcion,
  
          /* FIN 14B */
  
          //pag 14C
          "dimension_autogestion_jefe"          => $dimension_autogestion_jefe?$dimension_autogestion_jefe:0,
          "dimension_autogestion_colaborador"   => $dimension_autogestion_colaborador?$dimension_autogestion_colaborador:0,
          "dimension_autogestion_companero"     => $dimension_autogestion_companero?$dimension_autogestion_companero:0,
          "dimension_autogestion_otros"          => $dimension_autogestion_otros?$dimension_autogestion_otros:0,
  
          "dimension_autogestion_estrategica_jefe"          => $dimension_autogestion_estrategica_jefe?$dimension_autogestion_estrategica_jefe:0,
          "dimension_autogestion_estrategica_colaborador"   => $dimension_autogestion_estrategica_colaborador?$dimension_autogestion_estrategica_colaborador:0,
          "dimension_autogestion_estrategica_companero"     => $dimension_autogestion_estrategica_companero?$dimension_autogestion_estrategica_companero:0,
          "dimension_autogestion_estrategica_otros"         => $dimension_autogestion_estrategica_otros?$dimension_autogestion_estrategica_otros:0,
          "autogestion_estrategica_evaluadores"             => $autogestion_estrategica_evaluadores?$autogestion_estrategica_evaluadores:0,
          "autogestion_estrategica_autoevaluador"           => $autogestion_estrategica_autoevaluador?$autogestion_estrategica_autoevaluador:0,
          "autogestion_estrategica_total"                   => $autogestion_estrategica_total?$autogestion_estrategica_total:0,
  
  
          "dimension_autogestion_organizacion_jefe"          => $dimension_autogestion_organizacion_jefe?$dimension_autogestion_organizacion_jefe:0,
          "dimension_autogestion_organizacion_colaborador"   => $dimension_autogestion_organizacion_colaborador?$dimension_autogestion_organizacion_colaborador:0,
          "dimension_autogestion_organizacion_companero"     => $dimension_autogestion_organizacion_companero?$dimension_autogestion_organizacion_companero:0,
          "dimension_autogestion_organizacion_otros"         => $dimension_autogestion_organizacion_otros?$dimension_autogestion_organizacion_otros:0,
          "autogestion_organizacion_evaluadores"             => $autogestion_organizacion_evaluadores?$autogestion_organizacion_evaluadores:0,
          "autogestion_organizacion_autoevaluador"           => $autogestion_organizacion_autoevaluador?$autogestion_organizacion_autoevaluador:0,
          "autogestion_organizacion_total"                   => $autogestion_organizacion_total?$autogestion_organizacion_total:0,
  
          "dimension_autogestion_networking_jefe"          => $dimension_autogestion_networking_jefe?$dimension_autogestion_networking_jefe:0,
          "dimension_autogestion_networking_colaborador"   => $dimension_autogestion_networking_colaborador?$dimension_autogestion_networking_colaborador:0,
          "dimension_autogestion_networking_companero"     => $dimension_autogestion_networking_companero?$dimension_autogestion_networking_companero:0,
          "dimension_autogestion_networking_otros"         => $dimension_autogestion_networking_otros?$dimension_autogestion_networking_otros:0,
          "autogestion_networking_evaluadores"             => $autogestion_networking_evaluadores?$autogestion_networking_evaluadores:0,
          "autogestion_networking_autoevaluador"           => $autogestion_networking_autoevaluador?$autogestion_networking_autoevaluador:0,
          "autogestion_networking_total"                   => $autogestion_networking_total?$autogestion_networking_total:0,
  
          "dimension_autogestion_cliente_jefe"          => $dimension_autogestion_cliente_jefe?$dimension_autogestion_cliente_jefe:0,
          "dimension_autogestion_cliente_colaborador"   => $dimension_autogestion_cliente_colaborador?$dimension_autogestion_cliente_colaborador:0,
          "dimension_autogestion_cliente_companero"     => $dimension_autogestion_cliente_companero?$dimension_autogestion_cliente_companero:0,
          "dimension_autogestion_cliente_otros"          => $dimension_autogestion_cliente_otros?$dimension_autogestion_cliente_otros:0,
          "autogestion_cliente_evaluadores"             => $autogestion_cliente_evaluadores?$autogestion_cliente_evaluadores:0,
          "autogestion_cliente_autoevaluador"           => $autogestion_cliente_autoevaluador?$autogestion_cliente_autoevaluador:0,
          "autogestion_cliente_total"                   => $autogestion_cliente_total?$autogestion_cliente_total:0,
          
          "autogestion_edad"                            => $autogestion_edad,
          "autogestion_sector"                          => $autogestion_sector,
          "autogestion_genero"                          => $autogestion_genero,
          "autogestion_area"                            => $autogestion_area,
          "autogestion_funcion"                         => $autogestion_funcion,
  
          /* FIN 14C */
         //pag 14C
         "dimension_autodesarrollo_jefe"          => $dimension_autodesarrollo_jefe?$dimension_autodesarrollo_jefe:0,
         "dimension_autodesarrollo_colaborador"   => $dimension_autodesarrollo_colaborador?$dimension_autodesarrollo_colaborador:0,
         "dimension_autodesarrollo_companero"     => $dimension_autodesarrollo_companero?$dimension_autodesarrollo_companero:0,
         "dimension_autodesarrollo_otros"          => $dimension_autodesarrollo_otros?$dimension_autodesarrollo_otros:0,
  
         "dimension_autodesarrollo_estrategica_jefe"          => $dimension_autodesarrollo_estrategica_jefe?$dimension_autodesarrollo_estrategica_jefe:0,
         "dimension_autodesarrollo_estrategica_colaborador"   => $dimension_autodesarrollo_estrategica_colaborador?$dimension_autodesarrollo_estrategica_colaborador:0,
         "dimension_autodesarrollo_estrategica_companero"     => $dimension_autodesarrollo_estrategica_companero?$dimension_autodesarrollo_estrategica_companero:0,
         "dimension_autodesarrollo_estrategica_otros"         => $dimension_autodesarrollo_estrategica_otros?$dimension_autodesarrollo_estrategica_otros:0,
         "autodesarrollo_estrategica_evaluadores"             => $autodesarrollo_estrategica_evaluadores?$autodesarrollo_estrategica_evaluadores:0,
         "autodesarrollo_estrategica_autoevaluador"           => $autodesarrollo_estrategica_autoevaluador?$autodesarrollo_estrategica_autoevaluador:0,
         "autodesarrollo_estrategica_total"                   => $autodesarrollo_estrategica_total?$autodesarrollo_estrategica_total:0,
  
  
         "dimension_autodesarrollo_organizacion_jefe"          => $dimension_autodesarrollo_organizacion_jefe?$dimension_autodesarrollo_organizacion_jefe:0,
         "dimension_autodesarrollo_organizacion_colaborador"   => $dimension_autodesarrollo_organizacion_colaborador?$dimension_autodesarrollo_organizacion_colaborador:0,
         "dimension_autodesarrollo_organizacion_companero"     => $dimension_autodesarrollo_organizacion_companero?$dimension_autodesarrollo_organizacion_companero:0,
         "dimension_autodesarrollo_organizacion_otros"         => $dimension_autodesarrollo_organizacion_otros?$dimension_autodesarrollo_organizacion_otros:0,
         "autodesarrollo_organizacion_evaluadores"             => $autodesarrollo_organizacion_evaluadores?$autodesarrollo_organizacion_evaluadores:0,
         "autodesarrollo_organizacion_autoevaluador"           => $autodesarrollo_organizacion_autoevaluador?$autodesarrollo_organizacion_autoevaluador:0,
         "autodesarrollo_organizacion_total"                   => $autodesarrollo_organizacion_total?$autodesarrollo_organizacion_total:0,
  
         "dimension_autodesarrollo_networking_jefe"          => $dimension_autodesarrollo_networking_jefe?$dimension_autodesarrollo_networking_jefe:0,
         "dimension_autodesarrollo_networking_colaborador"   => $dimension_autodesarrollo_networking_colaborador?$dimension_autodesarrollo_networking_colaborador:0,
         "dimension_autodesarrollo_networking_companero"     => $dimension_autodesarrollo_networking_companero?$dimension_autodesarrollo_networking_companero:0,
         "dimension_autodesarrollo_networking_otros"         => $dimension_autodesarrollo_networking_otros?$dimension_autodesarrollo_networking_otros:0,
         "autodesarrollo_networking_evaluadores"             => $autodesarrollo_networking_evaluadores?$autodesarrollo_networking_evaluadores:0,
         "autodesarrollo_networking_autoevaluador"           => $autodesarrollo_networking_autoevaluador?$autodesarrollo_networking_autoevaluador:0,
         "autodesarrollo_networking_total"                   => $autodesarrollo_networking_total?$autodesarrollo_networking_total:0,
  
         "dimension_autodesarrollo_cliente_jefe"          => $dimension_autodesarrollo_cliente_jefe?$dimension_autodesarrollo_cliente_jefe:0,
         "dimension_autodesarrollo_cliente_colaborador"   => $dimension_autodesarrollo_cliente_colaborador?$dimension_autodesarrollo_cliente_colaborador:0,
         "dimension_autodesarrollo_cliente_companero"     => $dimension_autodesarrollo_cliente_companero?$dimension_autodesarrollo_cliente_companero:0,
         "dimension_autodesarrollo_cliente_otros"          => $dimension_autodesarrollo_cliente_otros?$dimension_autodesarrollo_cliente_otros:0,
         "autodesarrollo_cliente_evaluadores"             => $autodesarrollo_cliente_evaluadores?$autodesarrollo_cliente_evaluadores:0,
         "autodesarrollo_cliente_autoevaluador"           => $autodesarrollo_cliente_autoevaluador?$autodesarrollo_cliente_autoevaluador:0,
         "autodesarrollo_cliente_total"                   => $autodesarrollo_cliente_total?$autodesarrollo_cliente_total:0,
         
         "autodesarrollo_edad"                            => $autodesarrollo_edad,
         "autodesarrollo_sector"                          => $autodesarrollo_sector,
         "autodesarrollo_genero"                          => $autodesarrollo_genero,
         "autodesarrollo_area"                            => $autodesarrollo_area,
         "autodesarrollo_funcion"                         => $autodesarrollo_funcion,
  
         /* FIN 14C */
  
         //pag 14C
         "dimension_autoliderazgo_jefe"          => $dimension_autoliderazgo_jefe?$dimension_autoliderazgo_jefe:0,
         "dimension_autoliderazgo_colaborador"   => $dimension_autoliderazgo_colaborador?$dimension_autoliderazgo_colaborador:0,
         "dimension_autoliderazgo_companero"     => $dimension_autoliderazgo_companero?$dimension_autoliderazgo_companero:0,
         "dimension_autoliderazgo_otros"          => $dimension_autoliderazgo_otros?$dimension_autoliderazgo_otros:0,
  
         "dimension_autoliderazgo_estrategica_jefe"          => $dimension_autoliderazgo_estrategica_jefe?$dimension_autoliderazgo_estrategica_jefe:0,
         "dimension_autoliderazgo_estrategica_colaborador"   => $dimension_autoliderazgo_estrategica_colaborador?$dimension_autoliderazgo_estrategica_colaborador:0,
         "dimension_autoliderazgo_estrategica_companero"     => $dimension_autoliderazgo_estrategica_companero?$dimension_autoliderazgo_estrategica_companero:0,
         "dimension_autoliderazgo_estrategica_otros"         => $dimension_autoliderazgo_estrategica_otros?$dimension_autoliderazgo_estrategica_otros:0,
         "autoliderazgo_estrategica_evaluadores"             => $autoliderazgo_estrategica_evaluadores?$autoliderazgo_estrategica_evaluadores:0,
         "autoliderazgo_estrategica_autoevaluador"           => $autoliderazgo_estrategica_autoevaluador?$autoliderazgo_estrategica_autoevaluador:0,
         "autoliderazgo_estrategica_total"                   => $autoliderazgo_estrategica_total?$autoliderazgo_estrategica_total:0,
  
  
         "dimension_autoliderazgo_organizacion_jefe"          => $dimension_autoliderazgo_organizacion_jefe?$dimension_autoliderazgo_organizacion_jefe:0,
         "dimension_autoliderazgo_organizacion_colaborador"   => $dimension_autoliderazgo_organizacion_colaborador?$dimension_autoliderazgo_organizacion_colaborador:0,
         "dimension_autoliderazgo_organizacion_companero"     => $dimension_autoliderazgo_organizacion_companero?$dimension_autoliderazgo_organizacion_companero:0,
         "dimension_autoliderazgo_organizacion_otros"         => $dimension_autoliderazgo_organizacion_otros?$dimension_autoliderazgo_organizacion_otros:0,
         "autoliderazgo_organizacion_evaluadores"             => $autoliderazgo_organizacion_evaluadores?$autoliderazgo_organizacion_evaluadores:0,
         "autoliderazgo_organizacion_autoevaluador"           => $autoliderazgo_organizacion_autoevaluador?$autoliderazgo_organizacion_autoevaluador:0,
         "autoliderazgo_organizacion_total"                   => $autoliderazgo_organizacion_total?$autoliderazgo_organizacion_total:0,
  
         "dimension_autoliderazgo_networking_jefe"          => $dimension_autoliderazgo_networking_jefe?$dimension_autoliderazgo_networking_jefe:0,
         "dimension_autoliderazgo_networking_colaborador"   => $dimension_autoliderazgo_networking_colaborador?$dimension_autoliderazgo_networking_colaborador:0,
         "dimension_autoliderazgo_networking_companero"     => $dimension_autoliderazgo_networking_companero?$dimension_autoliderazgo_networking_companero:0,
         "dimension_autoliderazgo_networking_otros"         => $dimension_autoliderazgo_networking_otros?$dimension_autoliderazgo_networking_otros:0,
         "autoliderazgo_networking_evaluadores"             => $autoliderazgo_networking_evaluadores?$autoliderazgo_networking_evaluadores:0,
         "autoliderazgo_networking_autoevaluador"           => $autoliderazgo_networking_autoevaluador?$autoliderazgo_networking_autoevaluador:0,
         "autoliderazgo_networking_total"                   => $autoliderazgo_networking_total?$autoliderazgo_networking_total:0,
  
         "dimension_autoliderazgo_cliente_jefe"          => $dimension_autoliderazgo_cliente_jefe?$dimension_autoliderazgo_cliente_jefe:0,
         "dimension_autoliderazgo_cliente_colaborador"   => $dimension_autoliderazgo_cliente_colaborador?$dimension_autoliderazgo_cliente_colaborador:0,
         "dimension_autoliderazgo_cliente_companero"     => $dimension_autoliderazgo_cliente_companero?$dimension_autoliderazgo_cliente_companero:0,
         "dimension_autoliderazgo_cliente_otros"          => $dimension_autoliderazgo_cliente_otros?$dimension_autoliderazgo_cliente_otros:0,
         "autoliderazgo_cliente_evaluadores"             => $autoliderazgo_cliente_evaluadores?$autoliderazgo_cliente_evaluadores:0,
         "autoliderazgo_cliente_autoevaluador"           => $autoliderazgo_cliente_autoevaluador?$autoliderazgo_cliente_autoevaluador:0,
         "autoliderazgo_cliente_total"                   => $autoliderazgo_cliente_total?$autoliderazgo_cliente_total:0,
         
         "autoliderazgo_edad"                            => $autoliderazgo_edad?$autoliderazgo_edad:0,
         "autoliderazgo_sector"                          => $autoliderazgo_sector?$autoliderazgo_sector:0,
         "autoliderazgo_genero"                          => $autoliderazgo_genero?$autoliderazgo_genero:0,
         "autoliderazgo_area"                            => $autoliderazgo_area?$autoliderazgo_area:0,
         "autoliderazgo_funcion"                         => $autoliderazgo_funcion?$autoliderazgo_funcion:0,
  
         /* FIN 14C */
         //"competencias" => collect($competencias),
        ];
        foreach($competencias as $key=>$competencia) {
          if(!$competencia['autoevaluador']) unset($competencias[$key]);
        }
        $data["rapport_id"] = $evaluacion->rapport_id;
        $competencias_sobrevaloradas = collect($competencias)->sortByDesc("diferencia");
        $i = 0;
        foreach($competencias_sobrevaloradas as $competencia => $valores) {
          //if($i>4) break;
          $valores['diferencia_total'] = $valores['total'] - $valores['evaluadores'];
          $valores['title']           = $evaluacion->translateCompetencia($competencia);
          $competencias_sobrevaloradas[$competencia] = $valores;
          if( $valores['diferencia'] <= 0 ) unset($competencias_sobrevaloradas[$competencia]);
          else $i++;
        }
        $data['competencias_sobrevaloradas'] = collect($competencias_sobrevaloradas)->slice(0,4);
  
        $competencias_infravaloradas = collect($competencias)->sortBy("diferencia");
        $i = 0;
        foreach($competencias_infravaloradas as $competencia => $valores) {
          //if($i>4) break;
          $valores['diferencia_total'] = $valores['total'] - $valores['evaluadores'];
          if(!$valores['diferencia_total']) {
            unset($competencias_infravaloradas[$competencia]);
            continue;
          } 
          $valores['title']           = $evaluacion->translateCompetencia($competencia);
          $competencias_infravaloradas[$competencia] = $valores;
          if( $valores['diferencia'] >= 0 ) unset($competencias_infravaloradas[$competencia]);
          else $i++;
        }
        $data['competencias_infravaloradas'] = collect($competencias_infravaloradas)->slice(0,4);
        
        $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
        'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
        'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
        'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
  
        $competencias_masvaloradas = collect($competencias)->sortByDesc("evaluadores")->slice(0,3);
        foreach($competencias_masvaloradas as $competencia => $valores) {
          $dim = with(clone $resultAuto)->select(\DB::raw("question_dimension as value"))
          ->where("question_competencia",$competencia)
          ->first();
          if(!isset($dim->value)) continue;

          $dimension = with(clone $resultAuto)->select(\DB::raw("question_dimension as value"))
          ->where("question_competencia",$competencia)
          ->first()->value;
   
          $valores['title']           = $evaluacion->translateCompetencia($competencia);
          $valores['otros']           = $dimension_autoliderazgo_networking_otros?$dimension_autoliderazgo_networking_otros:0;
          $valores['dimension']       = strtolower(strtr($dimension,$unwanted_array));
  
          $competencias_masvaloradas[$competencia] = $valores;
  
            
        }
        $competencias_peorvaloradas = collect($competencias)->sortBy("evaluadores")->slice(0,3);
        foreach($competencias_peorvaloradas as $competencia => $valores) {
          $dim = with(clone $resultAuto)->select(\DB::raw("question_dimension as value"))
          ->where("question_competencia",$competencia)
          ->first();
          if(!isset($dim->value) || !$dim->value) continue;
          $dimension = with(clone $resultAuto)->select(\DB::raw("question_dimension as value"))
          ->where("question_competencia",$competencia)
          ->first()->value;
  
          $valores['dimension']       = strtolower(strtr($dimension,$unwanted_array));
  
       /*   eval("\$dimension_autoliderazgo_networking_jefe = \$dimension_".$valores['dimension']."_estrategica_jefe;");
          eval("\$dimension_autoliderazgo_networking_colaborador = \$dimension_".$valores['dimension']."_estrategica_colaborador;");
          eval("\$dimension_autoliderazgo_networking_companero = \$dimension_".$valores['dimension']."_estrategica_companero;");
          eval("\$dimension_autoliderazgo_networking_otros = \$dimension_".$valores['dimension']."_estrategica_otros;");*/
  
          $valores['title']           = $evaluacion->translateCompetencia($competencia);
          $valores['otros']           = $dimension_autoliderazgo_networking_otros?$dimension_autoliderazgo_networking_otros:0;
          $valores['dimension']       = strtolower(strtr($dimension,$unwanted_array));
          
          if(isset($frases[$competencia]))
           $valores['frases']          = $frases[$competencia];
          $competencias_peorvaloradas[$competencia] = $valores;
       }
        $data['competencias_peorvaloradas'] = $competencias_peorvaloradas->toArray();
        $data['competencias_masvaloradas'] = $competencias_masvaloradas->toArray();
        /*
 

        $resultMotivoAuto = Result::where("is_autoevaluacion",1)
                            ->where("evaluacion_id",$evaluacion->id)
                            ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id')
                            ->where("tresfera_taketsystem_answers.question_type", "motivo")
                            ->where("tresfera_taketsystem_results.duplicated",0)
                            ->orderBy("tresfera_taketsystem_answers.slide_id", "asc") 
                            ->orderBy("tresfera_taketsystem_answers.id", "asc") 
                            ->get();
        
        $tmp = [];
        $slide_id = -1;

        foreach($resultMotivoAuto as $m)
        {
          if($slide_id == $m->slide_id) $tmp[count($tmp)-1] = $m;
          else array_push($tmp, $m);
          $slide_id = $m->slide_id;
        }

        $estratega = 0;
        $ejecutivo = 0;
        $integrador = 0;
        foreach($tmp as $t)
        {
          if($t->question_categoria == "EXT - Estratega")
          {
            $estratega += $t->value;
          }
          else if($t->question_categoria == "INT - Ejecutivo")
          {
            $ejecutivo += $t->value;
          }
          else if($t->question_categoria == "TRA - Integrador")
          {
            $integrador += $t->value;
          }
        }
        
       $total = $estratega+$ejecutivo+$integrador;*/
       
       $resultAutoMotivos = Result::where("is_autoevaluacion",1)
                            ->where("evaluacion_id",$evaluacion->id)
                            ->where("tresfera_taketsystem_results.duplicated",0)
                            ->where("tresfera_taketsystem_answers.duplicated",0)
                            ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');
                            
      $total = with(clone $resultAutoMotivos)->select(\DB::raw("SUM(value) as value"))
            ->where("question_type","motivo")
            ->where("question_categoria","<>","PRO")
            ->first()->value;
      $estratega = with(clone $resultAutoMotivos)->select(\DB::raw("SUM(value) as value"))
            ->where("question_type", "motivo")
            ->where("question_categoria", "EXT - Estratega")
            ->first()->value;
      $ejecutivo = with(clone $resultAutoMotivos)->select(\DB::raw("SUM(value) as value"))
            ->where("question_type", "motivo")
            ->where("question_categoria", "INT - Ejecutivo")
            ->first()->value;

      $integrador = with(clone $resultAutoMotivos)->select(\DB::raw("SUM(value) as value"))
            ->where("question_type", "motivo")
            ->where("question_categoria", "TRA - Integrador")
            ->first()->value;
  
      if($total) {
        $data['motivos'] = [
          "estratega" => $estratega,
          "ejecutivo" => $ejecutivo,
          "integrador" => $integrador,
          "estratega_percent" => $estratega/$total*100,
          "ejecutivo_percent" => $ejecutivo/$total*100,
          "integrador_percent" => $integrador/$total*100,
        ];
      } else
      $data['motivos'] = [
        "estratega" => $estratega,
        "ejecutivo" => $ejecutivo,
        "integrador" => $integrador
      ];
      
  
      $data["evaluacion_id"] = $id_evaluacion;
  
      //dd($data);
      return $data;
    }
}
