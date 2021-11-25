<?php namespace Tresfera\Skillyouup\Models;

use Model;

use Tresfera\Skillyouup\Models\Result;
use Tresfera\Taketsystem\Models\Quiz;
use Tresfera\Taketsystem\Models\Slide;
use Tresfera\Skillyouup\Models\Equipo;
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
    public $table = 'tresfera_skillyouup_rapports';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        'evaluacion' => [
          'Tresfera\Skillyouup\Models\Equipo'
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
      return PDF::loadTemplate('skillyouup',$this->data)
                            ->setOptions(['isRemoteEnabled' => true,'dpi' => 150])
                            ->save($this->getFile())->stream();
    }

    public function render() {
      return PDF::loadTemplate('skillyouup',$this->data)
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

  
        $resultBase = Result::where("tresfera_skillyouup_answers.duplicated",0)
                            ->where("tresfera_skillyouup_answers.value",">",0)
                            
                            ->join('tresfera_skillyouup_answers', 'tresfera_skillyouup_results.id', '=', 'tresfera_skillyouup_answers.result_id');
        
        if($player) {
          $resultBase->where("email",$player);
        }

        if(is_array($id_evaluacion)) {
          $resultBase->whereIn("evaluacion_id",$id_evaluacion);
        } else {
          $evaluacion = Equipo::find($id_evaluacion);
          $resultBase->where("evaluacion_id",$evaluacion->id);     
        }
        $data = [];
        foreach($dimensiones as $code_base=>$dimension) {
          $data[$code_base] = [];
          $data[$code_base]['value'] = with(clone $resultBase)
                          ->select(\DB::raw("SUM(value) as value"))
                          ->whereIn("question_id",[$code_base."A",$code_base."B"])->avg("value");
          $data[$code_base]['icon'] = SELF::getIcon($data[$code_base]['value'],$evaluacion->lang);

          $value1 = with(clone $resultBase)
                        ->select(\DB::raw("SUM(value) as value"))
                        ->whereIn("question_id",[$code_base."A"])->avg("value");
          $value2 = with(clone $resultBase)
                        ->select(\DB::raw("SUM(value) as value"))
                        ->whereIn("question_id",[$code_base."B"])->avg("value");
          $data[$code_base]['frases'] = [];  
          $data[$code_base]['frases'][0] = SELF::getFrase($code_base."A",$value1,$evaluacion->lang);
          $data[$code_base]['frases'][1] = SELF::getFrase($code_base."B",$value2,$evaluacion->lang);
          $data['lang'] = $evaluacion->lang;
        }
        $data['name'] = $player;
        return $data;
      }
      static function getIcon($value,$lang="es") {
        if($lang=="es")
        if($value < 2) {
          return ["Pinche","https://talentapp360.taket.es/storage/app/media/skillyouup/informe/fork.png"];
        } elseif($value < 3) {
          return ["Cocinero","https://talentapp360.taket.es/storage/app/media/skillyouup/informe/kitchen.png"];
        } elseif($value < 3.5) {
          return ["Chef","https://talentapp360.taket.es/storage/app/media/skillyouup/informe/spatula.png"];
        } else {
          return ["Masterchef","https://talentapp360.taket.es/storage/app/media/skillyouup/informe/chef-hat.png"];
        }
        if($lang=="en")
        if($value < 2) {
          return ["Kitchen helper","https://talentapp360.taket.es/storage/app/media/skillyouup/informe/fork.png"];
        } elseif($value < 3) {
          return ["Cook","https://talentapp360.taket.es/storage/app/media/skillyouup/informe/kitchen.png"];
        } elseif($value < 3.5) {
          return ["Chef","https://talentapp360.taket.es/storage/app/media/skillyouup/informe/spatula.png"];
        } else {
          return ["Masterchef","https://talentapp360.taket.es/storage/app/media/skillyouup/informe/chef-hat.png"];
        }
        return;
      }
      static function getFrase($type,$value,$lang="es") {
        if($lang=="es")
        $competencias = [
          "C1A" => [
            4 => "Tienes iniciativa y eres capaz de tomar decisiones rápida y ágilmente sobre las acciones a realizar. Actúas de forma anticipada y resolutiva. ¡¡Felicidades!!",
            3 => "Necesitas tomarte tu tiempo para tomar decisiones sobre las acciones a realizar pero no estás pasivo esperando a ver lo que pasa. ¡Esa es la actitud! aunque tendrías que ver si puedes mejorar en agilidad.",
            2 => "Te cuesta tomar decisiones sobre las acciones a realizar de forma autónoma. Puede que dependas de los demás para ver qué hacer. ¡Vamos, tú puedes! es cuestión de poner atención y atreverse!.",
            1 => "Prefieres no tomar decisiones sobre las acciones a realizar. Te bloqueas y no sabes qué hacer con bastante frecuencia. ¡Venga, atrévete!",
          ],
          "C1B" => [
            4 => "Asignas roles y tareas a los distintos jugadores del equipo antes de empezar para que cada cuál sepa lo que tiene que hacer. ¡Excelente! Es más fácil para todos y se gana en eficacia y eficiencia.",
            3 => "Propones roles y tareas a los distintos jugadores del equipo a medida que te parece que se va necesitando. ¡Genial! aunque haciéndolo al inicio se gana en eficacia y eficiencia.",
            2 => "Haces alguna sugerencia sobre la marcha acerca de cómo deberían asignarse los roles y tareas en el equipo aunque sin mucho énfasis. ¡Ponte firme! Y dale más  importancia a la organización en pro de la eficacia y la eficiencia del equipo.",
            1 => "Te parece innecesario asignar roles y tareas al los miembros del equipo y no temes el caos que puede producirse al no hacerlo. ¡Prueba algo distinto! Verás los beneficios en eficacia y eficiencia.",
          ],
          "C1C" => [
            4 => "Asignas roles y tareas a los distintos jugadores del equipo antes de empezar para que cada cuál sepa lo que tiene que hacer. ¡Excelente! Es más fácil para todos y se gana en eficacia y eficiencia. Tu nivel de organización de cara a asegurar el proceso y el objetivo durante el juego es ORO.",
            3 => "Propones roles y tareas a los distintos jugadores del equipo a medida que te parece que se va necesitando. ¡Genial! aunque haciéndolo al inicio se gana en eficacia y eficiencia. Tu nivel de organización de cara a asegurar el proceso y el objetivo durante el juego es CANDIDATO A ORO.",
            2 => "Haces alguna sugerencia sobre la marcha acerca de cómo deberían asignarse los roles y tareas en el equipo aunque sin mucho énfasis. ¡Ponte firme! Y dale más  importancia a la organización en pro de la eficacia y la eficiencia del equipo. Tu nivel de organización de cara a asegurar el proceso y el objetivo durante el juego es BETA.",
            1 => "Te parece innecesario asignar roles y tareas al los miembros del equipo y no temes el caos que puede producirse al no hacerlo. ¡Prueba algo distinto! Verás los beneficios en eficacia y eficiencia. Tu nivel de organización de cara a asegurar el proceso y el objetivo durante el juego es ALFA.",
          ],  
          
          "C2A" => [
            4 => "Actúas con ambición (bien entendida), autonomía, dinamismo y rapidez para conseguir el objetivo. Fijas estrategia a priori para ser más ágiles y eficientes. ¡¡Felicidades!!",
            3 => "Te enfocas en conseguir el objetivo y vas planteando estrategias a medida que vas conociendo el entorno de juego. . ¡Esa es la actitud! aunque tendrías que ver si puedes mejorar en agilidad.",
            2 => "Entiendes la necesidad de establecer estrategias y prioridades pero no consideras que haya que hacerlo de forma estructurada. . ¡Vamos, tú puedes! es cuestión de poner atención y atreverse",
            1 => "Concedes nula importancia a la necesidad de establecer estrategias y prioridades y prefieres improvisar y adaptarte a medida que avanzas. ¿Te has preguntado si  esa es la mejor manera de conseguir el objetivo?"
          ],
          "C2B" => [
            4 => "Te muestras muy curioso y buscas proactivamente la información que te ofrece el juego de modo que no se te escape nada que pueda contribuir a la consecución del objetivo. . ¡Excelente! Disponer de esa información ayuda a enfocar.",
            3 => "Estás atento a la información que va mostrándote  el juego para entender lo que va pasando en cada momento y que se consiga el objetivo. ¡Bien hecho! aunque quizás podrías ser curioso a tope y buscarla proactivamente.",
            2 => "Descubres sin buscarla, parte de la información que va mostrándote  el juego y la incorporas si te resulta útil en ese momento. ¡Activa el  modo curioso! Y pon atención a cualquier cosa que te facilite el juego.",
            1 => "Te sumerges en el juego resolviendo como puedes sin estar pendiente de la información que va apareciendo en pantalla ni tenerla en cuenta. ¡Venga, abre los ojos! Todo te resultará más sencillo."
          ],
          "C2C" => [
            4 => "Demuestras buena capacidad para resolver de forma ordenada los problemas que presenta el juego. ¡Enhorabuena! Ser ágil detectando problemas y dándoles solución facilita el avance. Tu nivel de resolución de problemas durante el juego es ORO. ",
            3 => "Vas resolviendo con efectividad los problemas que se presentan aportando las soluciones. ¡Estupendo! Pasaría a genial si fueras un poco más ágil. Tu nivel de resolución de problemas durante el juego es CANDIDATO A ORO. ",
            2 => "Tus aportaciones a la solución de problemas no son, del todo, efectivas. ¡Ve más allá! y busca cómo aprovechar tu potencial resolutivo analizando lo que está pasando.  Tu nivel de resolución de problemas durante el juego es BETA.",
            1 => "¿Seguro que no sabes qué hacer? Los problemas son retos a superar y no tienen que abrumarte. ¡Ánimo, tú puedes! Siempre hay una solución si sabes encontrarla. Tu nivel de resolución de problemas durante el juego es ALFA. ",
          ],  

          "C3A" => [
            4 => "Eres curioso y actúas con ganas de saber más buscando proactivamente las novedades  que presenta el juego y explorándolas rápidamente. ¡¡Enhorabuena!! Esa es la manera de detectar las oportunidades.",
            3 => "Estás atento a los nuevos elementos o situaciones de juego hasta ahora desconocidos.  Cuando los descubres te poner en marcha de forma natural para conseguir entenderlos y avanzar. ¡Muy bien! aunque quizás podrías ser curioso a tope y buscarlos proactivamente.",
            2 => "Consideras que el flujo lo marca el juego y te dejas llevar aunque algunas situaciones nuevas te pillen por sorpresa quizás restándote agilidad. ¡Anímate! es cuestión de poner atención y ser más curioso, así estarás preparado para lo que surja.",
            1 => "Necesitarías un ritmo más lento para que te diera tiempo a asimilar las nuevas situaciones que aparecen. Todo va demasiado rápido y parece que no te enteras. . ¡Venga, abre los ojos! Todo te resultará más sencillo y prestas más atención."
          ],
          "C3B" => [
            4 => "Te muestras interesado en todos los elementos novedosos del juego, te estimula descubrir y probar. ¡Súper! Esto es una habilidad de gran valor.",
            3 => "Demuestras que puedes ir al ritmo de los cambios y que ello no te supone ningún problema. ¡Esa es la actitud! Parte de la gracia del juego es descubrir cosas nuevas y es mejor no alterarse incluso sentirse estimulado por ello.",
            2 => "Te pones algo nervioso a la hora de abordar situaciones nuevas en el juego. ¡Activa tu modo “explorador”! y no te preocupes si entras en zona desconocida. Cuanto antes conozcas esos elementos, antes te familiarizarás con ellos.",
            1 => "Prefieres una dinámica conocida en la que te desenvuelves sin problema que tener que adaptarte todo el rato. ¡Cambia el chip! Ni te enojes ni te agobies porque eso va a obstaculizar tu progreso en el juego. Abre la mente y ponte en acción."
          ],
          "C3C" => [
            4 => "Aprendes rápido y eficazmente, incorporando estos aprendizajes en los nuevos retos que se presentan en el juego. ¡Qué crac! Es la mejor manera de responder e ir ganando efectividad. Tu habilidad para aprender ante situaciones nuevas durante el juego es ORO. ",
            3 => "Vas aprendiendo a base de repetir las dinámicas o evitar los errores previos. ¡Estupendo! Pasaría a genial si fueras un poco más ágil con el ritmo de aprendizaje. Tu habilidad para aprender ante situaciones nuevas durante el juego es CANDIDATO A ORO. ",
            2 => "Necesitas tiempo y varias oportunidades para incorporar lo que has ido aprendiendo sobre el juego así que cuando aparecen elementos nuevos, quizás aún no has aprendido del todo lo básico y repites algunos errores. ¡Vamos, tú puedes!  Es cuestión de estar más atento.  Tu habilidad para aprender ante situaciones nuevas durante el juego es BETA. ",
            1 => "¿Seguro que no aprendes? Cada paso que das  en el juego hay nuevos elementos y también otros que ya conoces. ¡Ponte en modo “esponja”! Que no te abrume la novedad, confía en ti y en tu capacidad, con práctica y voluntad puedes conseguirlo. Tu habilidad para aprender ante situaciones nuevas durante el juego es ALFA. ",
          ],  

          "C4A" => [
            4 => "Te mantienes calmado y con buen ánimo sin afectarte demasiado por  las situaciones de estrés que presenta el juego. ¡¡Vaya crac!! Es una suerte responder ante la presión con una actitud positiva.",
            3 => "Demuestras que haces lo necesario para no perder los nervios ante las situaciones de estrés. ¡Genial! Es una buena respuesta aunque lo ideal sería no tener ni que esforzarte en ello incluso sentirse estimulado por el reto que supone.",
            2 => "Te pones algo nervioso cuando la cosa se complica en el juego. ¡Activa tu modo “keepcalm”! y no te alteres cuando hay que responder con rapidez o destreza. Se trata de conseguir resultados y los nervios no ayudan.",
            1 => "Prefieres una dinámica más pausada en la que no sientas esta presión de tiempo, de objetivos, etc.. ¡Cambia el chip! Ni te exasperes ni te agobies porque en ese estado se producen errores y afecta a los resultados."
          ],
          "C4B" => [
            4 => "Reaccionas de manera constructiva y propositiva ante situaciones frustrantes que no encajan dentro de tus expectativas o las del equipo. ¡¡Enhorabuena!! Esto te permite redefinir nuevas acciones sin intoxicarte de emociones negativas.",
            3 => "Te mantienes con buen ánimo a pesar de las frustraciones eres capaz de identificar aspectos positivos aún cuando los resultados no encajan dentro de lo previsto. ¡Esa es la actitud! Perseverar e incluso proponer nuevas formas de afrontar el reto.",
            2 => "Te desanimas cuando los resultados no son los esperados o deseados y haces comentarios al respecto expresando tu frustración. ¡Arriba ese ánimo”! se puede salir fortalecido de las “caídas” o fracasos si eres capaz de reponerte y aprender.",
            1 => "Necesitas tu tiempo y perspectiva para reponerte anímicamente de las situaciones que te frustran. Por un momento pierdes los papeles y te culpas o culpas a otros del fracaso ¿Te has preguntado si esa es la mejor manera de superar el momento"
          ],
          "C4C" => [
            4 => "Te involucras activamente en cada reto que va presentando el juego y lo emprendes con estusiasmo y energia creativa animando a tus compañeros a través de tu propia motivación. ¡Tienes un súperpoder!! Consigues disfrutar con los desafíos. Tu capacidad para automotivarte durante el juego es ORO.",
            3 => "Vas dándote mensajes de ánimo e impulso para mantener un buen grado de motivación frente a los diferentes desafíos del juego. ¡Muy bien! Pasaría a excelente si además lo expresaras para conseguir estimular a otros en ese espíritu positivo. Tu capacidad para automotivarte durante el juego es CANDIDATO A ORO. ",
            2 => "Te muestras algo desanimado cuando los resultados no te acompañan. Necesitas tu tiempo para recuperarte pero eres capaz de hacerlo si te lo propones. ¡Venga, sé positivo!  Al fin y al cabo, si te quedas apático no vas a pasártelo bien. Tu capacidad para automotivarte durante el juego es BETA.",
            1 => "¿Como que ya no te interesa seguir? Demuéstrate a ti mismo que puedes conseguirlo, insiste y persiste. ¡Cambia el chip! La indiferencia o el desánimo son tus enemigos, una buena dosis de motivación podrá con ellos.  Tu capacidad para automotivarte durante el juego es ALFA.",
          ],  

          "C5A" => [
            4 => "Estás pendiente de las necesidades de tus compañeros de equipo y de construir una buena dinámica colaborativa y un tono positivo entre los miembros. Confías en ellos y dejas hacer ¡Súper! Eso es ser un buen jugador de equipo.",
            3 => "Te gusta contribuir y juegas conjuntamente con los demás asumiendo la responsabilidad compartida. ¡Esa es la actitud! Si además te anticiparas a lo que necesitan los demás y pusieras tu toque de humor  cuando haga falta animar, ya serías un crac",
            2 => "Eres capaz de colaborar si es necesario pero no te gusta estar pendiente de las necesidades de los demás, crees que si alguien necesita algo, ya lo pedirá. ¡Venga, anticípate! Y aprovecha para mostrar tu lado más positivo.",
            1 => "Te muestras independiente respecto al equipo y juegas casi individualmente. Lo quieres hacer todo. ¡Prueba a darle la vuelta! Veras los beneficios de colaborar y enfocaros juntos al objetivo."
          ],
          "C5B" => [
            4 => "Cooperas y animas de forma natural y en todo momento y situación. Te preocupas y ocupas para que de cada uno de los miembros del equipo se sienta apoyado y respaldado. ¡Excelente! No es extraño que la gente quiera hacer equipo contigo.",
            3 => "Ofreces tu ayuda a los demás cuando los ves en un apuro. Te muestras bien dispuesto a ello y los otros jugadores lo saben y cuentan contigo. ¡Esa es la actitud! aunque quizás podrías ser más proactivo",
            2 => "Respondes cuando eres requerido ayudando a los demás si te necesitan pero la verdad es que no sale de ti a la primera. ¡Vamos, empatiza un poco más! Pon más atención a las necesidades del equipo y anímalos a conseguir el objetivo.",
            1 => "Te muestras reticente a la hora de ayudar a los demás dando razones y justificaciones para no hacerlo. ¡Ponte en modo “aquí estoy! y pregúntate si no es mejor para el objetivo sumar fuerzas y tener esa actitud de apoyo en lugar de buscar excusas"
          ],
          "C5C" => [
            4 => "Cooperas y animas de forma natural y en todo momento y situación. Te preocupas y ocupas para que de cada uno de los miembros del equipo se sienta apoyado y respaldado. ¡Excelente! No es extraño que la gente quiera hacer equipo contigo. Tu habilidad para la cooperación durante el juego es ORO.",
            3 => "Ofreces tu ayuda a los demás cuando los ves en un apuro. Te muestras bien dispuesto a ello y los otros jugadores lo saben y cuentan contigo. ¡Esa es la actitud! aunque quizás podrías ser más proactivo. Tu habilidad para la cooperación durante el juego es CANDIDATO A ORO. ",
            2 => "Respondes cuando eres requerido ayudando a los demás si te necesitan pero la verdad es que no sale de ti a la primera. ¡Vamos, empatiza un poco más! Pon más atención a las necesidades del equipo y anímalos a conseguir el objetivo. Tu habilidad para la cooperación durante el juego es BETA.",
            1 => "Te muestras reticente a la hora de ayudar a los demás dando razones y justificaciones para no hacerlo. ¡Ponte en modo “aquí estoy! y pregúntate si no es mejor para el objetivo sumar fuerzas y tener esa actitud de apoyo en lugar de buscar excusas. Tu habilidad para la cooperación durante el juego es ALFA.",
          ],  

          "C6A" => [
            4 => "Te comunicas de forma espontánea y fluida con tus compañeros de equipo. Disfrutas compartiendo avance conocimiento, haces bromas, comentas…. Incluso celebras los éxitos. ¡Felicidades!",
            3 => "Entiendes que comentar la jugada e interactuar con tus compañeros de equipo es algo necesario para aprender y conseguir el objetivo. ¡Bien visto! quizás aportar también comentarios que contribuyan a la cohesión de equipo sería una mejora.",
            2 => "Intervienes poco y haces algún comentario normalmente respondiendo a lo que dicen los demás. También corriges cuando hay errores. ¡Vamos, lánzate! Seguro que tienes algo más que decir que contribuye al ambiente de equipo.",
            1 => "Parece que no te relacionas con soltura sino que más bien te quedas al margen de los comentarios de equipo y apenas participas en la conversación. ¡No seas tímido! Esta es una actividad de equipo y una oportunidad de relacionarse mejor."
          ],
          "C6B" => [
            4 => "Prestas atención a lo que los miembros del equipo dicen en cada momento, incluso les preguntas para saber su opinión, si tienen dudas o cómo se sienten. ¡Vaya crac!",
            3 => "Te gustaría estar más por los demás y ejercer una escucha de calidad pero no siempre tienes el nivel de atención a tope o el tiempo y, por tanto, escuchas a medias.  ¡Ve a por ello! Siendo consciente de que puedes mejorarlo ya estas en el camino. Solo tienes que despertar tus sentidos.",
            2 => "Muestras poco interés en lo que te dicen, incluso a veces no dejas hablar al otro e interrumpes sin ser consciente de lo que el otro está intentando decir o comunicar. ¡Vamos, abre los oídos! Quizás lo que te dicen te sirva de ayuda.",
            1 => "Prefieres estar a la tuya, concentrado en tus propias tareas, no por falta de interés sino porque bastante tienes con estar atento a la pantalla. ¡Despierta!  No pierdas la perspectiva de intercambio especialmente en situación de juego."
          ],
          "C6C" => [
            4 => "Compartes y aportas el conocimiento que tienes del juego y lo que vas aprendiendo mientras avanzas. ¡Enhorabuena! Parece que tienes vocación por enseñar. Tu capacidad para compartir conocimiento durante el juego es ORO.",
            3 => "Propones algunos trucos y consejos para facilitar el aprendizaje de otros pero normalmente lo haces respondiendo a las preguntas que plantean los miembros del equipo. ¡Muy bien! aunque quizás podrías ser más proactivo y hacerlo de manera espontánea. Tu capacidad para compartir conocimiento durante el juego es CANDIDATO A ORO.",
            2 => "Aportas consejos y mejoras a partir de errores de los demás buscando que no se repitan. ¡Vamos, tú puedes!  Es cuestión de no ver sólo lo que se hace mal y estar dispuesto a aprender juntos. Tu capacidad para compartir conocimiento durante el juego es BETA.",
            1 => "Te muestras indiferente o apático en la transferencia de conocimientos a otros. ¿Crees que es una buena estrategia de equipo de cara a conseguir el mejor resultado? Ábrete a los demás y comparte. Tu capacidad para compartir conocimiento durante el juego es ALFA.",
          ],  
        ];
        if($lang=="en")
        $competencias = [
          "C1A" => [
            4 => "You have initiative and you are able to make quick and agile decisions about the actions to be carried out. You act early and decisively. Congratulations!!",
            3 => "You need to take your time to make decisions about the actions to be performed but you are not passive waiting to see what happens. That's the attitude! although you should see if you can improve in agility.",
            2 => "You have trouble making decisions about the actions to be taken autonomously. You may depend on others to see what to do. Come on, you can do it! It's a matter of paying attention and daring!",
            1 => "You prefer not to make decisions about the actions to be performed. You get blocked and you don't know what to do quite often. Come on, dare!",
          ],
          "C1B" => [
            4 => "You assign roles and tasks to the different players of the team before starting so that everyone knows what they have to do. Excellent! It is easier for everyone and you gained  effectiveness and efficiency.",
            3 => "You propose roles and tasks to the different players of the team as it seems to be needed. Great! although doing it at the beginning gains  effectiveness and efficiency.",
            2 => "You make some suggestions on the fly about how roles and tasks should be assigned in the team, but without much emphasis. Stand firm! And give more importance to the organization for the effectiveness and efficiency of the team.",
            1 => "You think it’s unnecessary to assign roles and tasks to team members and you are not afraid of the chaos if you don’t do it. Try something different! You will see the benefits in effectiveness and efficiency.",
          ],
          "C1C" => [
            4 => "You act with ambition (well understood), autonomy, dynamism and speed to achieve the goal. You set a priori the strategy to be more agile and efficient. Congratulations!!",
            3 => "You focus on achieving the objective and you are considering strategies as you get to know the game environment. That is the attitude! Although you should see if you can improve in agility.",
            2 => "You understand the need to establish strategies and priorities but do not consider that it should be done in a structured way. Come on you can do it! It's a matter of paying attention and daring.",
            1 => "You place no importance on the need to establish strategies and priorities and prefer to improvise and adapt as you go. Have you ever wondered if that is the best way to achieve the goal?",
          ],  
          
          "C2A" => [
            4 => "You act with ambition (well understood), autonomy, dynamism and speed to achieve the goal. You set a priori the strategy to be more agile and efficient. Congratulations!!",
            3 => "You focus on achieving the objective and you are considering strategies as you get to know the game environment. That is the attitude! Although you should see if you can improve in agility.",
            2 => "You understand the need to establish strategies and priorities but do not consider that it should be done in a structured way. Come on you can do it! It's a matter of paying attention and daring.",
            1 => "You place no importance on the need to establish strategies and priorities and prefer to improvise and adapt as you go. Have you ever wondered if that is the best way to achieve the goal?",
          ],
          "C2B" => [
            4 => "You are very curious and proactively looking for the information that the game offers you, so that you do not miss anything that can contribute to the achievement of the objective. Having that information helps focus.",
            3 => "You take caution to the information that the game shows you to understand what is happening in each moment and if the objective is achieved. Well done! Although maybe you could be curious and search it proactively..",
            2 => "You discover without looking for it some of the information that the game shows you incorporating it if it's useful to you at that time. Put the curious mode on! And pay attention to anything that makes the game easier.",
            1 => "You immerse yourself in the game and solve it on your own, without being aware of the information that appears on the screen or take it into account. Come on, open your eyes! Everything will be easier for you."
           ],
          "C2C" => [
            4 => "Demuestras buena capacidad para resolver de forma ordenada los problemas que presenta el juego. ¡Enhorabuena! Ser ágil detectando problemas y dándoles solución facilita el avance. Tu nivel de resolución de problemas durante el juego es ORO. ",
            3 => "Vas resolviendo con efectividad los problemas que se presentan aportando las soluciones. ¡Estupendo! Pasaría a genial si fueras un poco más ágil. Tu nivel de resolución de problemas durante el juego es CANDIDATO A ORO. ",
            2 => "Tus aportaciones a la solución de problemas no son, del todo, efectivas. ¡Ve más allá! y busca cómo aprovechar tu potencial resolutivo analizando lo que está pasando.  Tu nivel de resolución de problemas durante el juego es BETA.",
            1 => "¿Seguro que no sabes qué hacer? Los problemas son retos a superar y no tienen que abrumarte. ¡Ánimo, tú puedes! Siempre hay una solución si sabes encontrarla. Tu nivel de resolución de problemas durante el juego es ALFA. ",
          ],  

          "C3A" => [
            4 => "You are curious and act with the desire to know more proactively looking for the novelties that the game presents and exploring them quickly. Congratulations!! That is the way to detect opportunities.",
            3 => "You are attentive to the new elements or unknown  game situations. When you discover them, you start up naturally to get them to understand and move forward. Very good! although maybe you could be curious butt and proactively look for them.",
            2 => "You consider that the flow is marked by the game and you get carried away even if some new situations catch you by surprise perhaps losing agility. Cheer up! It's a matter of paying attention and being more curious, so you'll be prepared for whatever comes up.",
            1 => "You would need a slower rhythm to give you time to assimilate the new situations that appear. Everything is going too fast and you don't seem to know. . Come on, open your eyes! Everything will be easier if you pay more attention."
          ],
          "C3B" => [
            4 => "You are interested in all the novel elements of the game, it stimulates you to discover and try. Super! This is a skill of great value.",
            3 => "You show that you can keep up with the changes and this is not a problem for you. That's the attitude! Part of the game's fun is discovering new things and it is better not to be disturbed even to feel stimulated by it.",
            2 => "You get a little nervous when you have to address new situations in the game. Put your \"browser\" mode on! And don't worry if you enter an unknown area. The sooner you know those elements, the sooner you will become familiar with them.",
            1 => "You prefer a known dynamic develop without problems where you have to adapt all the time. Change the chip! Don't be angry or overwhelmed because that will hamper your progress in the game. Open your mind and get into action."
          ],
          "C3C" => [
            4 => "Aprendes rápido y eficazmente, incorporando estos aprendizajes en los nuevos retos que se presentan en el juego. ¡Qué crac! Es la mejor manera de responder e ir ganando efectividad. Tu habilidad para aprender ante situaciones nuevas durante el juego es ORO. ",
            3 => "Vas aprendiendo a base de repetir las dinámicas o evitar los errores previos. ¡Estupendo! Pasaría a genial si fueras un poco más ágil con el ritmo de aprendizaje. Tu habilidad para aprender ante situaciones nuevas durante el juego es CANDIDATO A ORO. ",
            2 => "Necesitas tiempo y varias oportunidades para incorporar lo que has ido aprendiendo sobre el juego así que cuando aparecen elementos nuevos, quizás aún no has aprendido del todo lo básico y repites algunos errores. ¡Vamos, tú puedes!  Es cuestión de estar más atento.  Tu habilidad para aprender ante situaciones nuevas durante el juego es BETA. ",
            1 => "¿Seguro que no aprendes? Cada paso que das  en el juego hay nuevos elementos y también otros que ya conoces. ¡Ponte en modo “esponja”! Que no te abrume la novedad, confía en ti y en tu capacidad, con práctica y voluntad puedes conseguirlo. Tu habilidad para aprender ante situaciones nuevas durante el juego es ALFA. ",
          ],  

          "C4A" => [
            4 => "You stay calm and in good spirits without being affected too much by the stressful situations that the game presents. What a pro! It is fortunate to respond to pressure with a positive attitude.",
            3 => "You show that you do what is necessary to avoid losing your cool in situations of stress. Great! It is a good response although ideally you don’t have to get strive for it even you could feel stimulated for it.",
            2 => "You get a little nervous when things get complicated in the game. Put your “keepcalm” mode on! And don't get upset when you have to respond quickly or skillfully. It's about getting results and nerves don't help.",
            1 => "You prefer a more leisurely dynamic in which you don't feel this pressure of time, objectives, etc. Change the chip! Do not be exasperated or overwhelmed because in that state mistakes happen and affects the results."
          ],
          "C4B" => [
            4 => "You react constructively and purposefully to frustrating situations that do not fit within your expectations or those of the team. Congratulations!! This allows you to redefine new actions without intoxicating yourself with negative emotions. ",
            3 => "You stay in good spirits despite the frustrations you are able to identify positive aspects even when the results do not fit as expected. That's the attitude! Improve and even propose new ways to face the challenge.",
            2 => "You get discouraged when the results are not as expected or desired and make comments about it expressing your frustration. Cheer Up! You can get stronger from the \"falls\" or failures if you are able to recover and learn.",
            1 => "You need your time and perspective to recover emotionally from situations that frustrate you. For a moment you lose control and blame yourself or blame others for the failure. Have you ever wondered if that is the best way to overcome the moment?"
          ],
          "C4C" => [
            4 => "Te involucras activamente en cada reto que va presentando el juego y lo emprendes con estusiasmo y energia creativa animando a tus compañeros a través de tu propia motivación. ¡Tienes un súperpoder!! Consigues disfrutar con los desafíos. Tu capacidad para automotivarte durante el juego es ORO.",
            3 => "Vas dándote mensajes de ánimo e impulso para mantener un buen grado de motivación frente a los diferentes desafíos del juego. ¡Muy bien! Pasaría a excelente si además lo expresaras para conseguir estimular a otros en ese espíritu positivo. Tu capacidad para automotivarte durante el juego es CANDIDATO A ORO. ",
            2 => "Te muestras algo desanimado cuando los resultados no te acompañan. Necesitas tu tiempo para recuperarte pero eres capaz de hacerlo si te lo propones. ¡Venga, sé positivo!  Al fin y al cabo, si te quedas apático no vas a pasártelo bien. Tu capacidad para automotivarte durante el juego es BETA.",
            1 => "¿Como que ya no te interesa seguir? Demuéstrate a ti mismo que puedes conseguirlo, insiste y persiste. ¡Cambia el chip! La indiferencia o el desánimo son tus enemigos, una buena dosis de motivación podrá con ellos.  Tu capacidad para automotivarte durante el juego es ALFA.",
          ],  

          "C5A" => [
            4 => "You are aware of the needs of your teammates and of building a good collaborative dynamic and a positive tone among the members. You trust them and let them do Super! That is being a good team player.",
            3 => "You like to contribute and you play together with others assuming shared responsibilities. That's the attitude! If you also anticipate what others need and put your touch of humor when you need to cheer up, you would be a pro.",
            2 => "You are able to collaborate if necessary but you do not like to be aware of the needs of others, you think that if someone needs something, they will ask for it. Come on, anticipate! And take the opportunity to show your most positive side.",
            1 => "You show yourself independent of the team and play almost individually. You want to do everything. Try to turn it around! You will see the benefits of collaborating and focus together on the objective."
          ],
          "C5B" => [
            4 => "You cooperate and encourage naturally and at all times and situations. You care about  each of the team members, and assure they  feel backed and supported. Excellent!  It’s not a surprise that people want to team up with you.",
            3 => "You offer your help to others when you see them in a hurry. You are willing to do so and the other players know it and count on you. That's the attitude! although maybe you could be more proactive.",
            2 => "You respond when you are required to help others if they need you, but the truth is that  you don’t think in that first. Come on, empathize a little more! Pay more attention to the needs of the team and encourage them to achieve the goal.",
            1 => "You are reluctant to help others by giving reasons and justifications for not doing so. Get into mode “here I am! and ask yourself if it’s not better for the purpose to join forces and have that attitude of support instead of looking for excuses."
          ],
          "C5C" => [
            4 => "Cooperas y animas de forma natural y en todo momento y situación. Te preocupas y ocupas para que de cada uno de los miembros del equipo se sienta apoyado y respaldado. ¡Excelente! No es extraño que la gente quiera hacer equipo contigo. Tu habilidad para la cooperación durante el juego es ORO.",
            3 => "Ofreces tu ayuda a los demás cuando los ves en un apuro. Te muestras bien dispuesto a ello y los otros jugadores lo saben y cuentan contigo. ¡Esa es la actitud! aunque quizás podrías ser más proactivo. Tu habilidad para la cooperación durante el juego es CANDIDATO A ORO. ",
            2 => "Respondes cuando eres requerido ayudando a los demás si te necesitan pero la verdad es que no sale de ti a la primera. ¡Vamos, empatiza un poco más! Pon más atención a las necesidades del equipo y anímalos a conseguir el objetivo. Tu habilidad para la cooperación durante el juego es BETA.",
            1 => "Te muestras reticente a la hora de ayudar a los demás dando razones y justificaciones para no hacerlo. ¡Ponte en modo “aquí estoy! y pregúntate si no es mejor para el objetivo sumar fuerzas y tener esa actitud de apoyo en lugar de buscar excusas. Tu habilidad para la cooperación durante el juego es ALFA.",
          ],  

          "C6A" => [
            4 => "You communicate spontaneously and fluently with your teammates. You enjoy sharing knowledge, make jokes, speak… You even celebrate successes. Congratulations!",
            3 => "You understand that talking on the play and interacting with your teammates is something necessary to learn and achieve the goal. Well seen! Perhaps also making comments that contribute to team cohesion would be an improvement.",
            2 => "You interfere and make a comment normally responding to what others say. You also make a correction when you have mistakes. Come on, throw yourself! Surely you have something else to say that contributes to the team environment.",
            1 => "It seems that you don't relate fluently but rather that, you stay out of team comments and just participate in the conversation. Do not be shy! This is a team activity and an opportunity to relate better."
          ],
          "C6B" => [
            4 => "You pay attention to what team members say at all times, you even ask them to know their opinion, if you have doubts or to see  how they feel. What a pro!",
            3 => "You would like to be more attentive to others and exercise quality listening but you don't always have the level of attention to the fullest, or all the  time and you listen halfway. Go for it! Being aware that you can improve is to be already on the road. You just have to awaken your senses.",
            2 => "You show little interest in what they tell you, sometimes you don't even let the other speak and interrupt without being aware of what the other is trying to say or communicate. Come on, open your ears! Maybe what they say helps you.",
            1 => "You prefer to be at your own, focused on your own tasks, not because of  lack of interest it’s because you have enough to be attentive for the screen. Awake! Don’t lose the exchange perspective especially in a game situation."
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
