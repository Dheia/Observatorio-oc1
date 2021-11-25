<?php namespace Tresfera\Buildyouup\Models;

use Model;

use Tresfera\Buildyouup\Models\Result;
use Tresfera\Taketsystem\Models\Quiz;
use Tresfera\Taketsystem\Models\Slide;
use Tresfera\Buildyouup\Models\Equipo;
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
    public $table = 'tresfera_buildyouup_rapports';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        'evaluacion' => [
          'Tresfera\Buildyouup\Models\Equipo'
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

    public function generateData($player) {
      //$this->evaluacion_id;
      $this->data = SELF::getDataRapport($this->evaluacion_id,$player);
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
      return PDF::loadTemplate('buildyouup',$this->data)
                            ->setOptions(['isRemoteEnabled' => true,'dpi' => 150])
                            ->save($this->getFile())->stream();
    }

    public function render() {
      return PDF::loadTemplate('buildyouup',$this->data)
                            ->setOptions(['isRemoteEnabled' => true,'dpi' => 150])
                            ->save($this->getFile())->stream($this->getFile());
    }
    
    static function getDataRapport($id_evaluacion,$player=null) {
        //$frases = $evaluacion->getFrases();  
        /*$resultAuto = Result::where("is_autoevaluacion",1)
                            ->where("evaluacion_id",$evaluacion->id)
                            ->where("tresfera_taketsystem_answers.duplicated",0)
                            ->where("tresfera_taketsystem_results.duplicated",0)
                            ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');*/
        
        

        $dimensiones = [
          "C1" => "Iniciativa y Proactividad / Organización",
          "C2" => "Orientación a resultados / Visión estratégica",
          "C3" => "Adaptación al cambio / Agilidad",
          "C4" => "Gestión del estrés / Tolerancia a la frustración /  Auto-motivación",
          "C5" => "Trabajo en equipo / Cooperación",
          "C6" => "Comunicación  / Aprendizaje colaborativo"
        ];


        $result = [
          "trabajo" => [], 
          "comunicacion" => [], 
          "liderazgo" => [], 
          "orientacion" => []
        ];

  
        $resultBase = Result::where("tresfera_buildyouup_answers.duplicated",0)
                            ->where("tresfera_buildyouup_answers.value",">",0)
                            ->join('tresfera_buildyouup_answers', 'tresfera_buildyouup_results.id', '=', 'tresfera_buildyouup_answers.result_id');
        
        if($player) {
          $resultBase->where("email",$player);
        }
        $data = [];

        if(is_array($id_evaluacion)) {
          $resultBase->whereIn("evaluacion_id",$id_evaluacion);
        } else {
          $evaluacion = Equipo::find($id_evaluacion);
          $resultBase->where("evaluacion_id",$evaluacion->id);
          if($player) {
            $player_array = $evaluacion->getPlayer($player);
            if($player_array) {
              $data['notas'] = $player_array['notas'];
            }
          }     
        }
        foreach($dimensiones as $code_base=>$dimension) {
          $data[$code_base] = [];
          $data[$code_base]['value'] = with(clone $resultBase)
                          ->select(\DB::raw("SUM(value) as value"))
                          ->whereIn("question_id",[$code_base."A",$code_base."B"])->avg("value");
          $data[$code_base]['icon'] = SELF::getIcon($data[$code_base]['value']);

          $value1 = with(clone $resultBase)
                        ->select(\DB::raw("SUM(value) as value"))
                        ->whereIn("question_id",[$code_base."A"])->avg("value");
          $value2 = with(clone $resultBase)
                        ->select(\DB::raw("SUM(value) as value"))
                        ->whereIn("question_id",[$code_base."B"])->avg("value");
          $data[$code_base]['frases'] = [];  
          $data[$code_base]['frases'][0] = SELF::getFrase($code_base."A",$value1);
          $data[$code_base]['frases'][1] = SELF::getFrase($code_base."B",$value2);
        }
        
        
        $data['name'] = $player;
        return $data;
      }
      static function getIcon($value) {
        if($value < 2) {
          return ["Individuals","https://talentapp360.taket.es/storage/app/media/buildyouup/informe/BuildUp_Individuals.png"];
        } elseif($value < 3) {
          return ["Group","https://talentapp360.taket.es/storage/app/media/buildyouup/informe/BuildUp_Group.png"];
        } elseif($value < 3.5) {
          return ["Team","https://talentapp360.taket.es/storage/app/media/buildyouup/informe/BuildUp_Team.png"];
        } else {
          return ["High Performance Team","https://talentapp360.taket.es/storage/app/media/buildyouup/informe/BuildUp_High%20Performance%20Team.png"];
        }
        return;
      }
      static function getFrase($type,$value) {
        $competencias = [
          "C1A" => [
            4 => "The team has initiative and is able to make decisions quickly about the actions to be carried out, act early and decisively. Congratulations!!",
            3 => "The team needs their time to make decisions about the actions to be taken but are not passive waiting to see what happens. That's the attitude! Although we have to see if it’s possible to improve in agility.",
            2 => "The team has trouble making decisions about the actions to be taken by they own. You need to ask questions to see what to do. Come on, you can do it! It's a matter of paying attention and daring!",
            1 => "The team prefers not to make decisions about the actions to be performed. It crashes and doesn't know what to do quite often. Come on, dare you!",
          ],
          "C1B" => [
            4 => "The team assigns roles and tasks to the different members before starting the action so that everyone knows what they have to do. Excellent! It is easier for everyone and are gained in effectiveness and efficiency.",
            3 => "The team proposes roles and tasks to the different members as it seems they are needed. Great! Although doing it at the beginning gains in effectiveness and efficiency.",
            2 => "The team makes some suggestion on the fly about how roles and tasks should be assigned in the team but without much emphasis. Stand firm! And give more importance to the organization for the effectiveness and efficiency of the team.",
            1 => "The team sees unnecessary to assign roles and tasks to they members and aren’t afraid of the chaos that can occur about that. Try something different! You will see the benefits in effectiveness and efficiency.",
          ],
          "C1C" => [
            4 => "Asignas roles y tareas a los distintos jugadores del equipo antes de empezar para que cada cuál sepa lo que tiene que hacer. ¡Excelente! Es más fácil para todos y se gana en eficacia y eficiencia. Tu nivel de organización de cara a asegurar el proceso y el objetivo durante el juego es ORO.",
            3 => "Propones roles y tareas a los distintos jugadores del equipo a medida que te parece que se va necesitando. ¡Genial! aunque haciéndolo al inicio se gana en eficacia y eficiencia. Tu nivel de organización de cara a asegurar el proceso y el objetivo durante el juego es CANDIDATO A ORO.",
            2 => "Haces alguna sugerencia sobre la marcha acerca de cómo deberían asignarse los roles y tareas en el equipo aunque sin mucho énfasis. ¡Ponte firme! Y dale más  importancia a la organización en pro de la eficacia y la eficiencia del equipo. Tu nivel de organización de cara a asegurar el proceso y el objetivo durante el juego es BETA.",
            1 => "Te parece innecesario asignar roles y tareas al los miembros del equipo y no temes el caos que puede producirse al no hacerlo. ¡Prueba algo distinto! Verás los beneficios en eficacia y eficiencia. Tu nivel de organización de cara a asegurar el proceso y el objetivo durante el juego es ALFA.",
          ],  
          
          "C2A" => [
            4 => "The team acts with ambition (well understood), autonomy, dynamism and speed to achieve the objective. Set the strategy a priori (before) to be more agile and efficient. Congratulations!!",
            3 => "The team focuses on achieving the objective and proposes strategies as it gets to know the activity environment. . That's the attitude! although I would have to see if it can improve in agility.",
            2 => "The team understands the need to establish strategies and priorities but does not consider that it should be done in a structured way. Come on, you can do it! It's a matter of paying attention and daring.",
            1 => "The team places no importance on the need to establish strategies and priorities and prefers to improvise and adapt as it progresses. Have you ever wondered if that is the best way to achieve the goal?"
          ],
          "C2B" => [
            4 => "The team is very curious and proactively searches for the information offered by the activity so that nothing escapes in case it can contribute to the achievement of the objective. Excellent! Having that information helps to focus on the task.",
            3 => "The team is attentive to the information that is shown in the activity to understand what is happening at each moment and that the objective is achieved. Well done! although perhaps you could be even more curious and look proactively.",
            2 => "The team discovers without looking for it, part of the information that is shown in the activity and incorporates it. That would be useful only at that time. Put the curious mode! And pay attention to anything that may be useful.",
            1 => "The team is immersed in the activity solving it as they can, without being aware of the information that can be derived from the activity or taking it into account. Come on, open your eyes! Everything will be easier for you."
          ],
          "C2C" => [
            4 => "Demuestras buena capacidad para resolver de forma ordenada los problemas que presenta el juego. ¡Enhorabuena! Ser ágil detectando problemas y dándoles solución facilita el avance. Tu nivel de resolución de problemas durante el juego es ORO. ",
            3 => "Vas resolviendo con efectividad los problemas que se presentan aportando las soluciones. ¡Estupendo! Pasaría a genial si fueras un poco más ágil. Tu nivel de resolución de problemas durante el juego es CANDIDATO A ORO. ",
            2 => "Tus aportaciones a la solución de problemas no son, del todo, efectivas. ¡Ve más allá! y busca cómo aprovechar tu potencial resolutivo analizando lo que está pasando.  Tu nivel de resolución de problemas durante el juego es BETA.",
            1 => "¿Seguro que no sabes qué hacer? Los problemas son retos a superar y no tienen que abrumarte. ¡Ánimo, tú puedes! Siempre hay una solución si sabes encontrarla. Tu nivel de resolución de problemas durante el juego es ALFA. ",
          ],  

          "C3A" => [
            4 => "The team is curious and acts with the desire to know more proactively looking for the novelties that the activity presents and exploring them quickly. Congratulations!! That is the way to detect opportunities.",
            3 => "The team is attentive to the new elements or situations of the activity unknown until now. When he discovers them, he starts up naturally to get them to understand and move forward. Very good! although perhaps you could increase your curiosity and proactively look for them.",
            2 => "The team believes that the flow is marked by the activity itself and is carried away even if some new situations catch you by surprise, perhaps taking away agility. Cheer up! It is a matter of paying attention and being more curious, so you will be prepared for whatever comes up.",
            1 => "The team would need a slower pace to give it time to assimilate the new situations that appear. Everything is going too fast and seems not to know. Come on, open your eyes! Everything will be easier if you pay more attention."
          ],
          "C3B" => [
            4 => "The team is interested in all the novel elements of the activity, it encourages you to discover and try. Super! This is a skill of great value.",
            3 => "The team show that it can keep up with the changes and it’s not a problem. That's the attitude! Part of the challenge of the activity is to discover new things and it’s better not to be disturbed even to feel stimulated by it.",
            2 => "The team puts nervous when they have to think about new situations on the activity. Activate the \"browser\" mode! and don't worry if you enter an unknown area. As soon you know these elements, sooner you will become familiar with them.",
            1 => "The team prefers a known dynamic work which operates without problem, than having to adapt all the time. Change the chip! Don’t be angry or overwhelmed because that will reduce your progress in the activity. Open your mind and get into action."
          ],
          "C3C" => [
            4 => "Aprendes rápido y eficazmente, incorporando estos aprendizajes en los nuevos retos que se presentan en el juego. ¡Qué crac! Es la mejor manera de responder e ir ganando efectividad. Tu habilidad para aprender ante situaciones nuevas durante el juego es ORO. ",
            3 => "Vas aprendiendo a base de repetir las dinámicas o evitar los errores previos. ¡Estupendo! Pasaría a genial si fueras un poco más ágil con el ritmo de aprendizaje. Tu habilidad para aprender ante situaciones nuevas durante el juego es CANDIDATO A ORO. ",
            2 => "Necesitas tiempo y varias oportunidades para incorporar lo que has ido aprendiendo sobre el juego así que cuando aparecen elementos nuevos, quizás aún no has aprendido del todo lo básico y repites algunos errores. ¡Vamos, tú puedes!  Es cuestión de estar más atento.  Tu habilidad para aprender ante situaciones nuevas durante el juego es BETA. ",
            1 => "¿Seguro que no aprendes? Cada paso que das  en el juego hay nuevos elementos y también otros que ya conoces. ¡Ponte en modo “esponja”! Que no te abrume la novedad, confía en ti y en tu capacidad, con práctica y voluntad puedes conseguirlo. Tu habilidad para aprender ante situaciones nuevas durante el juego es ALFA. ",
          ],  

          "C4A" => [
            4 => "The team stays calm in good spirits without being affected too much by the stressful situations that the activity presents. What a pros! It is fortunate to respond to pressure with a positive attitude.",
            3 => "The team demonstrates that it does what is necessary to avoid losing nerves in situations of stress. Great! It is a good response although the ideal would be not to have to make an effort or even feel stimulated by the challenge it involves.",
            2 => "The team gets nervous when things get complicated in the activity. Activate the \"keep calm\" mode! Don't let it affect you when you have to respond quickly or skillfully. It's about getting results and the nerves don't help.",
            1 => "The team prefers a more leisurely dynamic in which it does not feel this pressure of time, objectives, etc. Change the chip! Neither be exasperated nor overwhelmed because in that state errors occur and affect the results."
          ],
          "C4B" => [
            4 => "The team reacts constructively and purposefully to frustrating situations that do not fit within their expectations. Congratulations!! This allows you to redefine new actions without intoxicating yourself with negative emotions.",
            3 => "The team stays in good spirits. Despite the frustrations, he is able to identify positive aspects even when the results do not fit as planned. That's the attitude! Persevere and even propose new ways to face the challenge.",
            2 => "The team is discouraged when the results are not as expected or desired and comments are made about it expressing frustration. Up that encourage! You can get stronger from the \"falls\" or failures if you are able to recover and learn.",
            1 => "The team needs their time and perspective to recover emotionally from situations that cause frustration. For a moment you lose the papers and look for guilty or excuses to justify the failure. Have you wondered if that is the best way to overcome that?"
          ],
          "C4C" => [
            4 => "Te involucras activamente en cada reto que va presentando el juego y lo emprendes con estusiasmo y energia creativa animando a tus compañeros a través de tu propia motivación. ¡Tienes un súperpoder!! Consigues disfrutar con los desafíos. Tu capacidad para automotivarte durante el juego es ORO.",
            3 => "Vas dándote mensajes de ánimo e impulso para mantener un buen grado de motivación frente a los diferentes desafíos del juego. ¡Muy bien! Pasaría a excelente si además lo expresaras para conseguir estimular a otros en ese espíritu positivo. Tu capacidad para automotivarte durante el juego es CANDIDATO A ORO. ",
            2 => "Te muestras algo desanimado cuando los resultados no te acompañan. Necesitas tu tiempo para recuperarte pero eres capaz de hacerlo si te lo propones. ¡Venga, sé positivo!  Al fin y al cabo, si te quedas apático no vas a pasártelo bien. Tu capacidad para automotivarte durante el juego es BETA.",
            1 => "¿Como que ya no te interesa seguir? Demuéstrate a ti mismo que puedes conseguirlo, insiste y persiste. ¡Cambia el chip! La indiferencia o el desánimo son tus enemigos, una buena dosis de motivación podrá con ellos.  Tu capacidad para automotivarte durante el juego es ALFA.",
          ],  

          "C5A" => [
            4 => "The team is aware of the needs of its members and of building a good collaborative dynamic and a positive tone among them. There is trust between them and everyone can do their part. Super! That is being a good team.",
            3 => "Team members like to contribute and act together assuming shared responsibility. That's the attitude! If you also anticipate to respond to what is needed and, in addition, you put a touch of humor when you need to encourage, you would already be a super-team.",
            2 => "The team is able to collaborate if necessary but does not like to be aware of the needs of others, you believe that if someone needs something, they will ask for it. Come on, anticipate! And take the opportunity to show the most positive side.",
            1 => "Team members act independently with respect to the team and its objectives, almost individually. There are members who disconnect and others want to do everything. Try to turn it around! You will see the benefits of collaborating and focus together on the objective."
          ],
          "C5B" => [
            4 => "The team cooperates and is encouraged naturally and at all times and situations. He worries and takes care that each of the members feels supported and supported. Excellent! No wonder people want to team up with you.",
            3 => "Team members offer help between locating someone in a hurry. They are well disposed to it and everyone knows and counts on it. That's the attitude! although perhaps you could be more proactive and tell it.",
            2 => "The team responds when one of they members is required to help others if they need it, but does not leave them at first. Come on, empathize a little more! Pay more attention to the needs of the team and encourage them to achieve the goal.",
            1 => "The team or one of its members is reluctant to help others by giving reasons and justifications for not doing so. Put yourself in “here I am! and ask yourself if it is not better for the purpose to join forces and have that attitude of support instead of looking for excuses."
          ],
          "C5C" => [
            4 => "Cooperas y animas de forma natural y en todo momento y situación. Te preocupas y ocupas para que de cada uno de los miembros del equipo se sienta apoyado y respaldado. ¡Excelente! No es extraño que la gente quiera hacer equipo contigo. Tu habilidad para la cooperación durante el juego es ORO.",
            3 => "Ofreces tu ayuda a los demás cuando los ves en un apuro. Te muestras bien dispuesto a ello y los otros jugadores lo saben y cuentan contigo. ¡Esa es la actitud! aunque quizás podrías ser más proactivo. Tu habilidad para la cooperación durante el juego es CANDIDATO A ORO. ",
            2 => "Respondes cuando eres requerido ayudando a los demás si te necesitan pero la verdad es que no sale de ti a la primera. ¡Vamos, empatiza un poco más! Pon más atención a las necesidades del equipo y anímalos a conseguir el objetivo. Tu habilidad para la cooperación durante el juego es BETA.",
            1 => "Te muestras reticente a la hora de ayudar a los demás dando razones y justificaciones para no hacerlo. ¡Ponte en modo “aquí estoy! y pregúntate si no es mejor para el objetivo sumar fuerzas y tener esa actitud de apoyo en lugar de buscar excusas. Tu habilidad para la cooperación durante el juego es ALFA.",
          ],  

          "C6A" => [
            4 => "The team communicates spontaneously and fluently. They enjoy sharing knowledge, make jokes, talk each other ... They even celebrate successes. Congratulations!",
            3 => "The team understands that commenting on the play and interacting with members is something necessary to learn and achieve the goal. Well seen! Perhaps also contributing comments that contribute to team cohesion would be an improvement.",
            2 => "The team communicates little. Some comments are made but communication is not flowing naturally and sometimes they correct each other when there are errors. Come on, throw yourself! Surely you have something else to say and contribute to the team environment.",
            1 => "The team doesn't relate fluently but its members focus on the activity if they just comment more than concerns the task. Don't be shy! This is a team activity and an opportunity to relate better."
          ],
          "C6B" => [
            4 => "The members of the team pay attention to each other about what each one says in each moment, they even ask questions to know the opinion of the other, if they have doubts or how they feel. That is a quality listener!",
            3 => "The team doesn't always have the level of full attention to the needs of its members and, therefore, they are heard halfway. Go for it! Being aware that you can improve it you are already on the road. You just have to awaken your senses.",
            2 => "The team shows little interest in what their members say, sometimes they even interrupt each other or someone does not let the other speak without being aware of what the other is trying to say or communicate. Come on, open your ears! Perhaps what is said helps.",
            1 => "The team prefers that everyone goes to their own, focused on their own tasks, not for lack of interest but because they understand that the task is first and that there is only one way to do things. Wake up! Don’t lose the perspective of exchange especially to achieve the objective of the activity."
          ],
          "C6C" => [
            4 => "Compartes y aportas el conocimiento que tienes del juego y lo que vas aprendiendo mientras avanzas. ¡Enhorabuena! Parece que tienes vocación por enseñar. Tu capacidad para compartir conocimiento durante el juego es ORO.",
            3 => "Propones algunos trucos y consejos para facilitar el aprendizaje de otros pero normalmente lo haces respondiendo a las preguntas que plantean los miembros del equipo. ¡Muy bien! aunque quizás podrías ser más proactivo y hacerlo de manera espontánea. Tu capacidad para compartir conocimiento durante el juego es CANDIDATO A ORO.",
            2 => "Aportas consejos y mejoras a partir de errores de los demás buscando que no se repitan. ¡Vamos, tú puedes!  Es cuestión de no ver sólo lo que se hace mal y estar dispuesto a aprender juntos. Tu capacidad para compartir conocimiento durante el juego es BETA.",
            1 => "Te muestras indiferente o apático en la transferencia de conocimientos a otros. ¿Crees que es una buena estrategia de equipo de cara a conseguir el mejor resultado? Ábrete a los demás y comparte. Tu capacidad para compartir conocimiento durante el juego es ALFA.",
          ],  
        ];
        if(isset($competencias[$type][$value]))
            return $competencias[$type][$value];
       
      }
}
