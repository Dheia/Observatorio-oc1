<?php namespace Tresfera\Talent\Models;

use Model;

use Tresfera\Talent\Models\Result;
use Tresfera\Talent\Models\Evaluacion;
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
    public $table = 'tresfera_talent_rapports';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        'evaluacion' => [
          'Tresfera\Talent\Models\Evaluacion'
        ]
    ];

    public $jsonable  = ["data"];


    public function beforeCreate() {
      
    }

    public function getMd5() {
      return md5($this->evaluacion_id);
    }

    public function getUrl() {
      return url("/informes/".$this->getMd5().".pdf");      
    }

    public function getFile() {
      return base_path("/informes/".$this->getMd5().".pdf");
    }

    public function generateData() {
      //$this->evaluacion_id;
      $this->data = SELF::getDataRapport($this->evaluacion_id);
      $this->save();
    }
    static function otherLang($lang) {
      if($lang == "es") return "en";
      return "es";
    }
    static function getLangs() {
      return ['es','en'];
    }
    
    public function generatePdf() {
      return PDF::loadTemplate('talentapp',$this->data)
                            ->setOptions(['isRemoteEnabled' => true,'dpi' => 300])
                            ->save($this->getFile())->stream();
    }

    public function render() {
      return PDF::loadTemplate('talentapp',$this->data)
                            ->setOptions(['isRemoteEnabled' => true,'dpi' => 300])
                            ->save($this->getFile())->stream($this->getFile());
    }
    
    static function getDataRapport($id_evaluacion) {
        $evaluacion = Evaluacion::find($id_evaluacion);
        //$frases = $evaluacion->getFrases();
  
        $evaluacion = \Tresfera\Talent\Models\Evaluacion::find($id_evaluacion);
  
        /*$resultAuto = Result::where("is_autoevaluacion",1)
                            ->where("evaluacion_id",$evaluacion->id)
                            ->where("tresfera_taketsystem_answers.duplicated",0)
                            ->where("tresfera_taketsystem_results.duplicated",0)
                            ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');*/
        $frases = [
          'es' => "Ficha técnica: n = 368 muestreo accidental. Precisión 0,05 en el caso de la màxima indeterminación (NC = 95%). Fiabilidad de factores (α Cronbach) entre 0,741 a 0,893. Validez de constructo estimada mediante CFI = 0,936 TLI = 0,952.
          Estudio psicométrico realizado por el grupo de investigación SGR 269 de la Universitat de Barcelona.",
          'en' => 'This is an english adaptation of the original spanish scale as a consequence of a backtranslation procedure. The psychometrical validation of this adaptation is pending of the final sampling.
          The results of the original scale are:
          n = 368; e = 0,051 in case of maximum indetermination (IC of 95%). Reliability using Cronbach α present a range between .741 to .893. Construct validity according to CFA shown CFI = .936 and TLI = .952.
          Psychometrical analysis carried out by the research group SGR 269 of the University of Barcelona. '
        ];
        

        $dimensiones = [
          "trabajo" => [
            "ITEM32r",
            "ITEM11",
            "ITEM3",
            "ITEM31",
            "ITEM9r",
            "ITEM14",
            "ITEM34",
            "ITEM13r"
          ], 
          "comunicacion" => [
            "ITEM38","ITEM39","ITEM35","ITEM23","ITEM49","ITEM37"
          ], 
          "liderazgo" => [
            "ITEM22",  "ITEM21",  "ITEM15",  "ITEM5",  "ITEM30",  "ITEM4"
          ], 
          "orientacion" => [
            "ITEM42",  "ITEM41",  "ITEM45",  "ITEM49",  "ITEM37",  "ITEM36"
          ]
        ];
        $result = [
          "trabajo" => [], 
          "comunicacion" => [], 
          "liderazgo" => [], 
          "orientacion" => []
        ];

        $evaluacion = \Tresfera\Talent\Models\Evaluacion::find($id_evaluacion);
  
        $resultBase = Result::where("evaluacion_id",$evaluacion->id)
                            ->where("tresfera_talent_answers.duplicated",0)
                            ->where("tresfera_talent_results.duplicated",0)
                            ->join('tresfera_talent_answers', 'tresfera_talent_results.id', '=', 'tresfera_talent_answers.result_id');

        foreach($dimensiones as $dimension=>$questions) {
          
          $data['value'][$dimension] = with(clone $resultBase)
                                          ->select(\DB::raw("SUM(value) as value"))
                                          ->whereIn("question",$questions)->first()->value;
          $data['percentil'][$dimension] =  SELF::getPercentilFromValue($data['value'][$dimension],$dimension);
          $data['level'][$dimension] = SELF::getLevelFromValue($data['percentil'][$dimension]);
          
          $data['frases'][$dimension] = SELF::getFraseFromValue($data['percentil'][$dimension],$dimension, $evaluacion->getLang());
          $data['media'][$dimension] = SELF::getMediaFromValue($data['value'][$dimension],$dimension);
        }

        $data['lang'] = $evaluacion->getLang();
        $data['frase'] = $frases[isset($evaluacion->id)?$evaluacion->getLang():'es'];
        
        $free_1 = with(clone $resultBase)->select(\DB::raw("value"))->where("question_id","responsable_free")->first();
        //dd(with(clone $resultBase)->select(\DB::raw("value"))->where("question_id","responsable_free")->toSql());
        if(isset($free_1))
          $data['free_1'] = $free_1->value;
        
        $free_2 = with(clone $resultBase)->select(\DB::raw("value"))->where("question_id","pregunta2_free")->first();
        if(isset($free_2))
          $data['free_2'] = $free_2->value;
        
        $free_3 = with(clone $resultBase)->select(\DB::raw("value"))->where("question_id","pregunta3_free")->first();
        if(isset($free_3))
          $data['free_3'] = $free_3->value;

        $data['name'] = $evaluacion->name;
        $data['name_proyecto'] = $evaluacion->proyecto->name;
        return $data;
      }
      static function getMediaFromValue($value,$dimension) {
        $tabla = [
          "trabajo" => [
            "media" => 24.98,
            "desviacion" => 8.509
          ],
          "comunicacion" => [
            "media" => 20.79,
            "desviacion" => 5.909
          ],
          "liderazgo" => [
            "media" => 12.02,
            "desviacion" => 4.523
          ],
          "orientacion" => [
            "media" => 14.33,
            "desviacion" => 4.951
          ]
        ];
        //min -3 -- max +3
        $z = ($value-$tabla[$dimension]['media'])/$tabla[$dimension]['desviacion'];
        if($z > 3) return 3;
        if($z < -3) return -3;
        return $z;
      }
      static function getFraseFromValue($value,$dimension, $lang = 'es') {
        $tabla = [
          "trabajo" => [
            15 => [
              'es' => 'Le cuesta movilizar a su equipo que no lo percibe como auténtico líder. No es capaz de hacerse entender sin conflicto. Tiene dificultades para mantener la motivación de las personas que dirige.',
              'en' => 'Trouble mobilising the team, which doesn’t perceive the assessed as a true leader. Unable to be understood without a conflict. Difficulties to keep up the motivation of the led people.'
            ],
            25 => [
              'es' => 'Es capaz de generar actuaciones de líder, pero no puede consolidarlas de manera habitual y reiterada. No desarrolla las estrategias necesarias para apuntalar su liderazgo.',
              'en' => 'Capable of generating leader actions, but cannot consolidate them in a regular and repeated way. Does not develop the necessary strategies to underpin the leadership.'
            ],
            75 => [
              'es' => 'Es un líder capaz de generar confianza. Se preocupa de mantener al equipo unido y, normalmente, lo consigue. Es un comunicador eficaz que transmite y contagia un buen nivel de energía a sus colaboradores.',
              'en' => 'A leader who is able to generate trust. Cares about keeping the team together and, usually, manages to do it. Efficient communicator who transmits and passes on a good level of energy to the team members.'
            ],
            85 => [
              'es' => 'Suele generar confianza y liderazgo continuado y suficiente. Al mismo tiempo presenta algunas limitaciones para que ese liderazgo sea asumido incondicionalmente y de forma masiva.',
              'en' => 'Usually generates trust and leadership in a continuous and sufficient way. At the same time there are a few limitations to make this leadership be assumed unconditionally and massively by the others.'
            ],
            100 => [
              'es' => 'Es un líder sólido. Ofrece dirección, articula y define la visión y convierte los intangibles en objetivos concretos. Consigue ilusionar a su equipo generando compromiso.',
              'en' => 'Solid leader. Offers direction, articulates and defines the vision and turns intangibles into specific targets. Manages to engage the team generating commitment.'
            ]
          ],
          "comunicacion" => [
            15 => [
              'es' => 'Su capacidad de escucha es limitada y esto reduce sus posibilidades de empatizar con los demás. No  se preocupa de cuidar las formas ni busca el modo más efectivo de entenderse o influir en el interlocutor.',
              'en' => 'The ability to listen is limited, thus reducing the chances to empathize with the others. Neither tries to mind manners nor looks for the most effective way to understand or have an influence on the other person.'
            ],
            25 => [
              'es' => 'Presenta algunas competencias en el ámbito de la comunicación interpersonal, pero éstas son limitadas y no es capaz de usarlas de forma eficiente. No es percibido como un comunicador eficaz.',
              'en' => 'Shows a few competences in the field of interpersonal communication, but limited. Unable to use them in an efficient way. Not perceived as an efficient communicator.'
            ],
            60 => [
              'es' => 'Establece un ritmo adecuado de habla y escucha activa teniendo en cuenta las necesidades del otro. Entiende y se hace entender mostrando buenos argumentos.',
              'en' => 'Right rhythm for active speaking and listening, considering the needs of the other person. Good abilities to understand and be understood, showing good arguments.'
            ],
            80 => [
              'es' => 'Tiene suficientes habilidades como para ser un comunicador solvente, sin que ello le lleve a las más altas cotas de dominio de los recursos comunicativos.',
              'en' => 'Enough abilities to be a reliable communicator, but without achieving the highest level of control of communication resources.'
            ],
            100 => [
              'es' => 'Identifica rápidamente el estilo de comunicación de su interlocutor y adapta su tono y lenguaje. Es asertivo y claro: dice lo que tiene que decir teniendo en cuenta los sentimientos de la otra persona. Convence e influye.',
              'en' => 'Quickly identifies the communication style of the other person, adapting tone and language. Assertive and clear: says what has to be said taking into account the feelings of the other person. Convinces and influences.'
            ]
          ],
          "liderazgo" => [
            20 => [
              'es' => 'Marca las distancias y pone obstáculos para trabajar en armonía con los demás. Antepone sus propios intereses individuales a los colectivos. Busca tener razón sin valorar las contribuciones o motivos ajenos.',
              'en' => 'Marks distances and places obstacles to work in harmony with the others. Gives preference to individual interests against collective interests. Tries to be right without assessing the contributions or reasons of others.'
            ],
            40 => [
              'es' => 'Es capaz de reconocer las aportaciones de las personas del equipo de trabajo y las tiene en cuenta, pero ello no hace que se convierta en un verdadero “jugador” de equipo',
              'en' => 'Able to recognise the contribution of the people in the working team, taking them into account, but not turning into a real “team player”.'
            ],
            60 => [
              'es' => 'Trabaja conjuntamente con los demás, en la aspiración de integrar los esfuerzos individuales que permitan lograr resultados plurales. Asume la responsabilidad compartida',
              'en' => 'Works constantly with the others, aspiring to integrate individual efforts in order to be able to achieve plural results. Assumes the shared responsibility.'
            ],
            80 => [
              'es' => 'Se trata de un perfil competente en el trabajo colaborativo y de equipo, aunque de forma puntual puede mostrar actitudes y acciones poco acordes con este perfil.',
              'en' => 'Competent profile in terms of collaborative work and teamwork, although sometimes with attitudes and actions that do not fit this profile.'
            ],
            100 => [
              'es' => 'Se concentra es el beneficio colectivo y en construir una buena dinámica colaborativa. Contribuye activamente para mantener un tono socio afectivo positivo entre los miembros del equipo.',
              'en' => 'Focusses on collective benefits and on building good collaborative dynamics. Contributes actively to keep a positive social-affective tone between the team members.'
            ]
          ],
          "orientacion" => [
            20 => [
              'es' => 'Persigue el resultado a cualquier precio minimizando opiniones o situaciones que contribuirían a una mejor decisión. Expresa frustración ante la ineficiencia o pérdida de tiempo pero no aborda las mejoras necesarias.',
              'en' => 'Pursues the result at any price, minimising opinions or situations that would contribute to a better decision. Expresses frustration when faced with inefficiency or loss of time, but does not address the necessary improvements.'
            ],
            40 => [
              'es' => 'Entiende claramente la necesidad de una organización de prioridades, pero es incapaz de ejercerla y de generar listas de prioridades adecuadas y ajustadas al contexto.',
              'en' => 'Understands clearly the need to organise priorities, but is unable to exercise it and to generate lists with priorities that are adequate for and adjusted to the context.'
            ],
            60 => [
              'es' => 'Se concentra en la generación de prioridades y las estudia adecuadamente conectándolas con los resultados a conseguir. Muestra suficientes competencias para ello, aunque su logro puede ser algo limitado.',
              'en' => 'Focusses on the generation of priorities and analyses them adequately connecting them with the results to be achieved. She shows competences enough for it, although the achievement may be somewhat limited.'
            ],
            80 => [
              'es' => 'Se enfoca en conseguir los resultados de modo eficiente y ágil. Busca proactivamente la información o los recursos que le ayude a conseguirlos. Analiza los resultados y establece planes de mejora.',
              'en' => 'Focusses on achieving results in an efficient and agile way. Searches proactively for the information or the resources that will help to achieve the results. Analyses the results and establishes improvement plans.'
            ],
            100 => [
              'es' => 'Actúa con ambición (bien entendida), autonomía, dinamismo y rapidez para anticiparse o resolver aquellas situaciones que amenazan con ralentizar el logro. Promueve la mejora continua y la eficiencia.',
              'en' => 'Acts with ambition (well understood), autonomy, dynamism and speed in order to anticipate or resolve those situations which threaten to slow down the achievement. Promotes continuous improvement and efficiency.'
            ]
          ],
        ];
        foreach($tabla[$dimension] as $percentil=>$val) {
          
          if($percentil == $value || ($percentil > $value))
            return $val[$lang];
        }
      }
      static function getLevelFromValue($value) {
        
        if($value < 15) {
          return 1;
        } elseif($value >= 15 and $value <= 24) {
          return 2;
        } elseif($value >= 25 and $value <= 75) {
          return 3;
        } elseif($value >= 75 and $value <= 85) {
          return 4;
        } elseif($value > 85) {
          return 5;
        }
  
      }
      static function getPercentilFromValue($value, $dimension) {
        $tabla = [
          "trabajo" => [
            1 => 8,
            5 => 12,
            10 => 15,
            15 => 16,
            20 => 17,
            25 => 17,
            30 => 19,
            35 => 20,
            40 => 21,
            45 => 21,
            50 => 24,
            55 => 25,
            60 => 27,
            65 => 29,
            70 => 31,
            75 => 32,
            80 => 33,
            85 => 36,
            90 => 37,
            95 => 38,
            100 => 44,
          ],
          "comunicacion" => [
            1 => 8,
            5 => 11,
            10 => 14,
            15 => 14,
            20 => 15.2,
            25 => 17,
            30 => 17,
            35 => 18,
            40 => 18.4,
            45 => 19,
            50 => 20,
            55 => 21,
            60 => 22,
            65 => 23,
            70 => 24,
            75 => 24,
            80 => 27,
            85 => 28,
            90 => 29,
            95 => 30,
            100 => 33,
          ],
          "liderazgo" => [
            1 => 6,
            5 => 6,
            10 => 7,
            15 => 7,
            20 => 8,
            25 => 8,
            30 => 9,
            35 => 10,
            40 => 11,
            45 => 11,
            50 => 12,
            55 => 12,
            60 => 12,
            65 => 14,
            70 => 14,
            75 => 15,
            80 => 15.8,
            85 => 17,
            90 => 18,
            95 => 20,
            100 => 29,
          ],
          "orientacion" => [
            1 => 6,
            5 => 6,
            10 => 8,
            15 => 9,
            20 => 10,
            25 => 10,
            30 => 11,
            35 => 11,
            40 => 13,
            45 => 13.25,
            50 => 14,
            55 => 14,
            60 => 16,
            65 => 16,
            70 => 17,
            75 => 18,
            80 => 18,
            85 => 19,
            90 => 20,
            95 => 24,
            100 => 27,
          ],
        ];
        foreach($tabla[$dimension] as $percentil=>$val) {
          if($val == $value || ($val > $value))
            return $percentil;
        }
        return 100;
      }
      
}
