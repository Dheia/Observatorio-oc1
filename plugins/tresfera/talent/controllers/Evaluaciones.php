<?php namespace Tresfera\Talent\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Renatio\DynamicPDF\Classes\PDF;
use Tresfera\Taketsystem\Models\Result;
use Queue;

class Evaluaciones extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        //$this->addCss("/plugins/tresfera/talent/assets/css/custom.css", "1.0.0");
    }

    static function getDataRapport($id_evaluacion) {
      $frases = [
        "Vision Estratégica" => [
          "Analiza la situación del mercado",
          "Analiza las tendencias y prácticas más relevantes del ámbito empresarial",
          "Conoce las innovaciones que producen ventaja competitiva",
          "Sabe describir en pocas líneas las características de su empresa ",
          "Sabe cuáles son las fortalezas y debilidades de su empresa ",
          "Busca información sobre el sector a nivel local, nacional e internacional",
          "Analiza los factores que crean ventaja competitiva",
          "Analiza el entorno para aprovechar las oportunidades",
          "Define los objetivos y prioridades estratégicas",
        ],
        "Visión de la Organización" => [
          "Conoce los resultados de otras áreas y/o departamentos",
          "Conoce la relación de su trabajo con el de otras áreas y/o departamentos",
          "Puede describir en pocas líneas las funciones de otras áreas y/o departamentos",
          "Informa de los temas de su área que puedan afectar a otros",
          "Acepta el feedback de otras áreas y/o departamentos",
          "Sabe que procesos inciden en otras áreas y /departamentos",
          "Respeta las funciones asignadas a otras áreas",
          "Facilita el trabajo a otras áreas y/o departamentos",
          "Concreta procesos de mejora más allá de su propia función",
          
        ],
        "Orientación al Cliente" => [
          "Resuelve las quejas y sugerencias buscando en qué y cómo mejorar",
          "Sabe ganarse el respeto y confianza de los clientes",
          "Orienta su trabajo a satisfacer las necesidades de los clientes",
          "Sabe escuchar, sin ofenderse, para conocer mejor a las personas y sus necesidades",
          "Establece y mantiene relaciones de confianza y respeto con los clientes",
          "Dedica tiempo a pensar cómo satisfacer mejor las necesidades reales (presentes y futuras)",
          "Se preocupa por mejorar constantemente la calidad de los servicios y productos",
          "Diseña los procesos y establece los plazos en función de las necesidades reales",
          "Cuida los detalles para ofrecer un buen servicio",
 
        ],
        "Networking" => [
          "Adopta una posición activa y mantiene contacto con personas clave",
          "Sabe pedir opinión a las personas adecuadas ante situaciones difíciles",
          "Algunas personas acuden habitualmente a Vd., de manera informal, para comentar asuntos profesionales",
          "Asiste con regularidad  a reuniones clave, congresos, etc.",
          "Reserva tiempo para mantener y desarrollar relaciones con profesionales de su área u otras áreas de conocimiento",
          "Mantiene reuniones informales en su empresa para estar al día de cuestiones relevantes",
          "Dedica tiempo a sus contactos ",
          "Sabe qué personas, eventos e instituciones son clave para su actividad",
          "Sabe pedir y hacer favores a sus conocidos",

        ],
        "Comunicación" => [
          "Organiza las ideas y selecciona la información",
          "Sus mensajes son concretos y tienen contenido",
          "Cuida la actitud, el lenguaje, y la expresión",
          "Adapta el mensaje a la preparación intelectual, emocional y/o edad del interlocutor...",
          "Es flexible y se asegura de que le han entendido",
          "Escoge el medio idóneo (reunión, entrevista...) y el momento adecuado",
          "Se esfuerza por entender el punto de vista del otro",
          "Muestra empatía y formula preguntas a lo largo de la conversación",
          "Deja hablar sin interrumpir, tratando de comprender y asimilar lo que le dicen",

        ],
        "Delegación" => [
          "Conoce las capacidades de sus colaboradores",
          "Sabe encajar a cada persona en el perfil del puesto más adecuado a sus capacidades",
          "Delega las tareas y proyectos en función de las capacidades de los colaboradores",
          "Establece objetivos y plazos y fomenta el sentido de responsabilidad y profesionalidad",
          "Planifica las tareas y proporciona la ayuda, los recursos y el seguimiento necesarios",
          "Transmite la información y establece límites y criterios generales de actuación",
          "Evita entrar en detalles minuciosos de cómo deben realizar su tarea",
          "Delega todo aquello que la situación lo permita, sin perder la dirección del proyecto",
          "Fomenta la iniciativa, dando el margen necesario",

        ],
        "Coaching" => [
          "Dedica tiempo y atención a sus colaboradores",
          "Está accesible y evita dejarse llevar por el exceso de trabajo o la falta de interés",
          "Pregunta y escucha para entender las circunstancias, intereses y expectativas",
          "Se centra en hechos concretos",
          "Corrige constructivamente, aportando posibles soluciones",
          "Destaca los aspectos positivos y basa su relación en la confianza",
          "Invierte tiempo en el desarrollo de las personas",
          "Ayuda a diagnosticar correctamente las fortalezas y áreas de mejora de las personas",
          "Establece una agenda de seguimiento periódico con sus colaboradores y la respeta",

        ],
        "Trabajo en Equipo" => [
          "Conoce los objetivos y la dinámica de las reuniones",
          "Participa activamente en la toma de decisiones y las asume personalmente",
          "Lleva a cabo las tareas que se le encomiendan",
          "Crea un ambiente proactivo",
          "Promueve el diálogo constructivo entre los miembros del equipo",
          "Evita las alusiones personales en los momentos de discrepancia",
          "Sabe integrar sus conocimientos y habilidades de modo que beneficien al equipo",
          "Basa su relación en la interdependencia y colaboración y disfruta de los logros de todos",
          "Confía en lo que hacen los demás miembros del equipo y escucha sus puntos de vista",

        ],
        "Gestión del Tiempo" => [
          "Prevé y decide el mejor momento para cumplir las tareas que le competen",
          "Dedica el tiempo necesario a cada tarea, respeta los plazos, es diligente",
          "Dispone de tiempo para sí mismo, la familia y los amigos",
          "Repasa periódicamente las tareas que debe hacer",
          "Sabe qué y cuándo debe hacer cada cosa",
          "Lleva su agenda con orden, respetando lo previsto",
          "Determina las prioridades de los diferentes compromisos",
          "Respeta los plazos y dedica el tiempo a lo importante, sin dejarse llevar por lo urgente",
          "Evita interrupciones innecesarias sin caer en la precipitación",

        ],
        "Gestión del Estrés" => [
          "Distingue las situaciones en las que aparece el estrés y sabe cómo hacerle frente ",
          "Sabe relajarse y utilizar las estrategias  adecuadas",
          "Ve las cosas en perspectiva evitando las circunstancias que le producen estrés",
          "Tiene voluntad para respetar los horarios de sueño, descanso...",
          "Tiene un horario para el trabajo, el descanso, la familia.... y procura cumplirlo",
          "Dedica tiempo a hobbies y ocupaciones más allá del trabajo",
          "Trata de establecer y de cuidar relaciones interpersonales profundas",
          "Es capaz de cortar con el trabajo cuando está con la familia o los amigos",
          "Dedica tiempo suficiente para hacer vida social",

        ],
        "Optimismo" => [
          "Está convencido de que las cosas saldrán",
          "Ve lo positivo de cada situación, sin dejarse llevar por el escepticismo o la experiencia",
          "Se muestra seguro cuando debe tomar decisiones",
          "No se desanima ante las dificultades ni desiste ante los obstáculos del entorno",
          "Sabe pasar página sin hundirse ante los reveses profesionales y personales",
          "Aprende de los errores y piensa más en los aciertos y éxitos que en los fracasos",
          "No se deja llevar por el pesimismo ante las primeras dificultades",
          "Saca lo mejor de cada situación",
          "Celebra las pequeñas victorias",

        ],
        "Iniciativa" => [
          "Actúa con independencia en su trabajo, sin consultar cada paso",
          "No se conforma con el estado actual de las cosas y busca cómo mejorarlas",
          "Asume nuevos retos",
          "No se deja llevar por las situaciones y cree que es posible cambiarlas",
          "No se conforma con lo que ya funciona y cree que hay margen para mejorar las cosas",
          "Dedica tiempo a pensar cómo mejorar y a encontrar nuevas formas de hacer las cosas",
          "No se conforma con la primera solución y genera diversas alternativas ",
          "Identifica posibilidades de cambio, sin dejarse dominar por el miedo al fracaso o al error",
          "Tiene una actitud de curiosidad y busca distintas soluciones para mejorar las cosas",

        ],
        "Aprendizaje" => [
          "Tiene un plan de formación a corto, medio y largo plazo",
          "Tiene un tiempo concreto para su formación personal y profesional",
          "Está al día de los conocimientos propios de sus funciones",
          "Tiene actualmente un objetivo claro y concreto de mejora personal y profesional",
          "Tiene constancia en la mejora de sus conocimientos, capacidades y habilidades",
          "Ha logrado en los últimos meses mejorar en algo concreto personal o profesional",
          "Adquirir nuevos conocimientos que le permiten mejorar",
          "Aprende nuevas formas de trabajar que le hacen más flexible",
          "Está disponible para asumir nuevas tareas o actividades laborales",

        ],
        "Autoconocimiento" => [
          "Dedica tiempo a reflexionar sobre sí mismo y su comportamiento",
          "Reflexiona sobre sus experiencias y su modo de hacer las cosas",
          "Sabe cuáles son sus puntos fuertes y sus áreas de mejora",
          "Contrasta lo que piensa de sí mismo con personas que le conocen y en las que confía",
          "Genera confianza para que le puedan decir las cosas que debe mejorar",
          "Agradece las sugerencias que le manifiestan los demás",
          "Sabe identificar y comprender sus reacciones emocionales (enfados, incomodidad...)",
          "Controla sus sentimientos de modo que no interfieran en su trabajo ni en el de los demás",
          "Sabe comportarse de acuerdo con su posición",

        ],
        "Autocrítica" => [
          "Acepta su responsabilidad ante los fallos, sin buscar otros culpables,  y pide disculpas",
          "Admite que hace cosas peor que otras y que hay errores que pueden evitarse",
          "Reconoce que hay aspectos de su actuación que puede mejorar",
          "Agradece el consejo de los demás y sabe pedir disculpas",
          "Acepta con sencillez la opinión de los demás sin ponerse a la defensiva",
          "Se deja ayudar en aquellos aspectos en los que necesita mejorar",
          "No tiene miedo a la opinión sincera ni a que los demás le conozcan",
          "Sabe reírse de sí mismo",
          "Sabe ver en las críticas razonadas oportunidades de mejora",

        ],
        "Ambición" => [
          "Asume retos difíciles pero alcanzables y los persigue con tenacidad",
          "Se propone objetivos a largo plazo, con metas concretas para alcanzarlos",
          "Sabe mantener el esfuerzo aunque el resultado no sea inmediato",
          "Acomete las tareas con decisión, sin desanimarse, acabando los proyectos hasta el final",
          "Defiende sus puntos de vista con determinación y respeto",
          "Ejercita su voluntad con pequeños retos diarios, sin dejar las cosas a medias",
          "No se conforma con la mediocridad y el continuismo",
          "Se plantea metas elevadas y las persigue con determinación",
          "Busca proyectos que le ilusionan y motivan, sin caer en la rutina",

        ],
        "Toma de Decisiones" => [
          "Selecciona la información relevante para establecer las causas del problema",
          "Dedica el tiempo suficiente a analizar las circunstancias y definir el problema",
          "Se centra en los hechos y evita caer en intuiciones o en percepciones subjetivas",
          "Desarrolla alternativas que eliminan una o varias causas principales del problema",
          "Analiza distintas alternativas y compara los pros y contras de cada una",
          "Prevé las posibles consecuencias que pueden tener las alternativas planteadas",
          "Determina qué criterios son relevantes para decidir entre diversas alternativas",
          "Escoge una alternativa en función de los criterios definidos",
          "Diseña un plan de acción realista y concreto",

        ],
        "Integridad" => [
          "No cambia su actuación en función de las circunstancias",
          "Presenta la verdad de forma amable, sin tapujos y en el momento adecuado",
          "Toma postura sin hacer promesas que no puede cumplir",
          "Es un ejemplo para los que trabajan con ella/él",
          "Hace lo que dice y asume los compromisos que ha adquirido",
          "No cambia sus principios y valores ante cualquier tipo de presión",
          "Recaba la versión de las partes implicadas y los datos precisos al hacer valoraciones",
          "Comprende y corrige en lugar de juzgar y criticar",
          "Busca el equilibrio entre el cumplimiento estricto de la norma y la flexibilidad",

        ],
        "Autocontrol" => [
          "No se deja llevar por lo que más le apetece en cada momento",
          "Se concentra a fondo en los temas, sin saltar de uno a otro",
          "Es capaz de superar  el cansancio ante tareas complejas",
          "Hace los sacrificios necesarios para lograr sus objetivos",
          "Mantiene los compromisos a pesar del esfuerzo y las dificultades  ",
          "Realiza las tareas hasta el final, procurando hacerlas bien y cuidando los detalles ",
          "No se deja engañar ni busca excusas para acometer acciones costosas",
          "Ejercita el autocontrol, haciendo lo que debe en cada momento",
          "Supera las dificultades que conlleva realizar las tareas programadas ",

        ],
        "Equilibrio Emocional" => [
          "Es paciente con las propias limitaciones y con las de los demás",
          "Apacigua los ánimos en momentos de especial tensión",
          "Ante las discusiones trata de tomar distancia y adoptar un papel conciliador, sin darse por aludido ante ataques personales",
          "Sabe ponerse en el lugar de la otra persona, buscando poder ayudar",
          "Es oportuno en sus comentarios y sabe encontrar el momento adecuado",
          "Trata de tomar distancia y adoptar un papel conciliador",
          "Evita explosiones de mal humor, manteniendo un ánimo estable",
          "Expresa sus sentimientos de manera natural, sin excentricidades ni exageraciones",
          "Reacciona de manera proporcionada ante circunstancias tensas",

        ],
      ];

      $evaluacion = \Tresfera\Talent\Models\Evaluacion::find($id_evaluacion);

      $resultAuto = Result::where("is_autoevaluacion",1)
                          ->where("evaluacion_id",$evaluacion->id)
                          ->where("tresfera_taketsystem_answers.duplicated",0)
                          ->where("tresfera_taketsystem_results.duplicated",0)
                          ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

      $resultEval = Result::where("is_evaluacion",1)
                            ->where("evaluacion_id",$evaluacion->id)
                            ->where("tresfera_taketsystem_answers.duplicated",0)
                            ->where("tresfera_taketsystem_results.duplicated",0)
                            ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

      $resultTotal = Result::whereIn("quiz_id",[3,11])
                            ->where("tresfera_taketsystem_answers.duplicated",0)
                            ->where("tresfera_taketsystem_results.duplicated",0)                            
                            ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

           
      $competencias = [];                      

      $dimension_estrategica_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","ESTRATEGICA")->first()->value;;
      $dimension_estrategica_auto = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","ESTRATEGICA")->first()->value;
      $dimension_estrategica_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","ESTRATEGICA")->first()->value;      ;

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
      ->where("question_dimension","ESTRATEGICA")
      ->where("rol","jefe")
      ->first()->value;
      $dimension_estrategica_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("rol","colaborador")
      ->first()->value;
      $dimension_estrategica_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("rol","companero")
      ->first()->value;
      $dimension_estrategica_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("rol","otros")
      ->first()->value;

      $dimension_estrategica_estrategica_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Vision Estratégica")
      ->where("rol","jefe")
      ->first()->value;
      $dimension_estrategica_estrategica_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Vision Estratégica")
      ->where("rol","colaborador")
      ->first()->value;
      $dimension_estrategica_estrategica_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Vision Estratégica")
      ->where("rol","companero")
      ->first()->value;
      $dimension_estrategica_estrategica_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Vision Estratégica")
      ->where("rol","otros")
      ->first()->value;

      $estrategica_estrategica_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_competencia","Vision Estratégica")
      ->where("question_dimension","ESTRATEGICA")
      ->first()->value;
      $estrategica_estrategica_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
      ->where("question_competencia","Vision Estratégica")
      ->where("question_dimension","ESTRATEGICA")
      ->first()->value;
      $estrategica_estrategica_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_competencia","Vision Estratégica")
      ->where("question_dimension","ESTRATEGICA")
      ->first()->value;

      $competencias["Vision Estratégica"] = [
        "evaluadores" => $estrategica_estrategica_evaluadores,
        "autoevaluador" => $estrategica_estrategica_autoevaluador,
        "total" => $estrategica_estrategica_total,
        "diferencia" => $estrategica_estrategica_autoevaluador - $estrategica_estrategica_evaluadores,
      ];


      $dimension_estrategica_organizacion_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Visión de la Organización")
      ->where("rol","jefe")
      ->first()->value;
      $dimension_estrategica_organizacion_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Visión de la Organización")
      ->where("rol","colaborador")
      ->first()->value;
      $dimension_estrategica_organizacion_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Visión de la Organización")
      ->where("rol","companero")
      ->first()->value;
      $dimension_estrategica_organizacion_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Visión de la Organización")
      ->where("rol","otros")
      ->first()->value;

      $estrategica_organizacion_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_competencia","Visión de la Organización")
      ->where("question_dimension","ESTRATEGICA")
      ->first()->value;
      $estrategica_organizacion_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
      ->where("question_competencia","Visión de la Organización")
      ->where("question_dimension","ESTRATEGICA")
      ->first()->value;
      $estrategica_organizacion_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_competencia","Visión de la Organización")
      ->where("question_dimension","ESTRATEGICA")
      ->first()->value;
      $competencias["Visión de la Organización"] = [
        "evaluadores" => $estrategica_organizacion_evaluadores,
        "autoevaluador" => $estrategica_organizacion_autoevaluador,
        "total" => $estrategica_organizacion_total,
        "diferencia" => $estrategica_organizacion_autoevaluador - $estrategica_organizacion_evaluadores,
      ];

      $dimension_estrategica_networking_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Networking")
      ->where("rol","jefe")
      ->first()->value;
      $dimension_estrategica_networking_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Networking")
      ->where("rol","colaborador")
      ->first()->value;
      $dimension_estrategica_networking_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Networking")
      ->where("rol","companero")
      ->first()->value;
      $dimension_estrategica_networking_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Networking")
      ->where("rol","otros")
      ->first()->value;

      $estrategica_networking_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_competencia","Networking")
      ->where("question_dimension","ESTRATEGICA")
      ->first()->value;
      $estrategica_networking_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
      ->where("question_competencia","Networking")
      ->where("question_dimension","ESTRATEGICA")
      ->first()->value;
      $estrategica_networking_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_competencia","Networking")
      ->where("question_dimension","ESTRATEGICA")
      ->first()->value;

      $competencias["Networking"] = [
        "evaluadores" => $estrategica_networking_evaluadores,
        "autoevaluador" => $estrategica_networking_autoevaluador,
        "total" => $estrategica_networking_total,
        "diferencia" => $estrategica_networking_autoevaluador - $estrategica_networking_evaluadores,
      ];
      

      $dimension_estrategica_cliente_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Orientación al Cliente")
      ->where("rol","jefe")
      ->first()->value;
      $dimension_estrategica_cliente_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Orientación al Cliente")
      ->where("rol","colaborador")
      ->first()->value;
      $dimension_estrategica_cliente_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Orientación al Cliente")
      ->where("rol","companero")
      ->first()->value;
      $dimension_estrategica_cliente_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Orientación al Cliente")
      ->where("rol","otros")
      ->first()->value;

      $estrategica_cliente_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_competencia","Orientación al Cliente")
      ->where("question_dimension","ESTRATEGICA")
      ->first()->value;
      $estrategica_cliente_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
      ->where("question_competencia","Orientación al Cliente")
      ->where("question_dimension","ESTRATEGICA")
      ->first()->value;
      $estrategica_cliente_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_competencia","Orientación al Cliente")
      ->where("question_dimension","ESTRATEGICA")
      ->first()->value;

      $competencias["Orientación al Cliente"] = [
        "evaluadores" => $estrategica_cliente_evaluadores,
        "autoevaluador" => $estrategica_cliente_autoevaluador,
        "total" => $estrategica_cliente_total,
        "diferencia" => $estrategica_cliente_autoevaluador - $estrategica_cliente_evaluadores,
      ];

      $estrategica_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATEGICA")
        ->where("edad",$evaluacion->result->edad)
        ->first()->value;
      $estrategica_sector = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATEGICA")
        ->where("sector",$evaluacion->result->sector)
        ->first()->value;
      $estrategica_genero = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATEGICA")
        ->where("genero",$evaluacion->result->genero)
        ->first()->value;
      $estrategica_area = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATEGICA")
        ->where("area",$evaluacion->result->area)
        ->first()->value;
      $estrategica_funcion = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATEGICA")
        ->where("funcion",$evaluacion->result->funcion)
        ->first()->value;

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
      $interpersonal_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","INTERPERSONAL")
      ->where("edad",$evaluacion->result->edad)
      ->first()->value;
      $interpersonal_sector = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","INTERPERSONAL")
      ->where("sector",$evaluacion->result->sector)
      ->first()->value;
      $interpersonal_genero = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","INTERPERSONAL")
      ->where("genero",$evaluacion->result->genero)
      ->first()->value;
      $interpersonal_area = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","INTERPERSONAL")
      ->where("area",$evaluacion->result->area)
      ->first()->value;
      $interpersonal_funcion = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","INTERPERSONAL")
      ->where("funcion",$evaluacion->result->funcion)
      ->first()->value;

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
      $autogestion_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","AUTOGESTION")
      ->where("edad",$evaluacion->result->edad)
      ->first()->value;
      $autogestion_sector = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","AUTOGESTION")
      ->where("sector",$evaluacion->result->sector)
      ->first()->value;
      $autogestion_genero = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","AUTOGESTION")
      ->where("genero",$evaluacion->result->genero)
      ->first()->value;
      $autogestion_area = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","AUTOGESTION")
      ->where("area",$evaluacion->result->area)
      ->first()->value;
      $autogestion_funcion = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","AUTOGESTION")
      ->where("funcion",$evaluacion->result->funcion)
      ->first()->value;

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
   $autodesarrollo_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
   ->where("question_dimension","AUTODESARROLLO")
   ->where("edad",$evaluacion->result->edad)
   ->first()->value;
   $autodesarrollo_sector = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
   ->where("question_dimension","AUTODESARROLLO")
   ->where("sector",$evaluacion->result->sector)
   ->first()->value;
   $autodesarrollo_genero = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
   ->where("question_dimension","AUTODESARROLLO")
   ->where("genero",$evaluacion->result->genero)
   ->first()->value;
   $autodesarrollo_area = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
   ->where("question_dimension","AUTODESARROLLO")
   ->where("area",$evaluacion->result->area)
   ->first()->value;
   $autodesarrollo_funcion = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
   ->where("question_dimension","AUTODESARROLLO")
   ->where("funcion",$evaluacion->result->funcion)
   ->first()->value;

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


         $autoliderazgo_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
         ->where("question_dimension","AUTOGOBIERNO")
         ->where("edad",$evaluacion->result->edad)
         ->first()->value;
         $autoliderazgo_sector = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
         ->where("question_dimension","AUTOGOBIERNO")
         ->where("sector",$evaluacion->result->sector)
         ->first()->value;
         $autoliderazgo_genero = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
         ->where("question_dimension","AUTOGOBIERNO")
         ->where("genero",$evaluacion->result->genero)
         ->first()->value;
         $autoliderazgo_area = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
         ->where("question_dimension","AUTOGOBIERNO")
         ->where("area",$evaluacion->result->area)
         ->first()->value;
         $autoliderazgo_funcion = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
         ->where("question_dimension","AUTOGOBIERNO")
         ->where("funcion",$evaluacion->result->funcion)
         ->first()->value;

      $data = [
        "name" => $evaluacion->name,
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
        
        "estrategica_edad"                            => $estrategica_edad,
        "estrategica_sector"                          => $estrategica_sector,
        "estrategica_genero"                          => $estrategica_genero,
        "estrategica_area"                            => $estrategica_area,
        "estrategica_funcion"                         => $estrategica_funcion,

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
       
       "autoliderazgo_edad"                            => $autoliderazgo_edad,
       "autoliderazgo_sector"                          => $autoliderazgo_sector,
       "autoliderazgo_genero"                          => $autoliderazgo_genero,
       "autoliderazgo_area"                            => $autoliderazgo_area,
       "autoliderazgo_funcion"                         => $autoliderazgo_funcion,

       /* FIN 14C */
       //"competencias" => collect($competencias),
      ];

      $competencias_sobrevaloradas = collect($competencias)->sortByDesc("diferencia")->slice(0,4);
      foreach($competencias_sobrevaloradas as $competencia => $valores) {
        $valores['diferencia_total'] = $valores['total'] - $valores['evaluadores'];
        $competencias_sobrevaloradas[$competencia] = $valores;
      }
      $data['competencias_sobrevaloradas'] = $competencias_sobrevaloradas;

      $competencias_infravaloradas = collect($competencias)->sortBy("diferencia")->slice(0,4);
      foreach($competencias_infravaloradas as $competencia => $valores) {
        $valores['diferencia_total'] = $valores['total'] - $valores['evaluadores'];
        $competencias_infravaloradas[$competencia] = $valores;
      }
      $data['competencias_infravaloradas'] = $competencias_infravaloradas;

      
      $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
      'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
      'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
      'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
      'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );

      $competencias_masvaloradas = collect($competencias)->sortByDesc("evaluadores")->slice(0,3);
      foreach($competencias_masvaloradas as $competencia => $valores) {

        $dimension = with(clone $resultEval)->select(\DB::raw("question_dimension as value"))
        ->where("question_competencia",$competencia)
        ->first()->value;
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
        $valores['title']           = $competencia;
        $valores['otros']           = $dimension_autoliderazgo_networking_otros?$dimension_autoliderazgo_networking_otros:0;
        $valores['dimension']       = strtolower(strtr($dimension,$unwanted_array));

        $competencias_masvaloradas[$competencia] = $valores;

          
      }
      $competencias_peorvaloradas = collect($competencias)->sortBy("evaluadores")->slice(0,3);
      foreach($competencias_peorvaloradas as $competencia => $valores) {
        $dimension = with(clone $resultEval)->select(\DB::raw("question_dimension as value"))
        ->where("question_competencia",$competencia)
        ->first()->value;

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
        $valores['title']           = $competencia;
        $valores['otros']           = $dimension_autoliderazgo_networking_otros?$dimension_autoliderazgo_networking_otros:0;
        $valores['dimension']       = strtolower(strtr($dimension,$unwanted_array));
        $valores['frases']          = $frases[$competencia];
        $competencias_peorvaloradas[$competencia] = $valores;
     }
      $data['competencias_peorvaloradas'] = $competencias_peorvaloradas->toArray();
      $data['competencias_masvaloradas'] = $competencias_masvaloradas->toArray();

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

              $total = $estratega+$ejecutivo+$integrador;


     $data['motivos'] = [
      "estratega" => $estratega,
      "ejecutivo" => $ejecutivo,
      "integrador" => $integrador,
      "estratega_percent" => $estratega/$total*100,
      "ejecutivo_percent" => $ejecutivo/$total*100,
      "integrador_percent" => $integrador/$total*100,
     ];

     
     $profesionalidad = with(clone $resultEval)->select(\DB::raw("SUM(value) as value"))
     ->where("question_type", "motivo")
     ->where("question_categoria", "Cognición - Profesionalidad")
     ->where("no_analizable","=","0")
     ->first()->value;
     
     $logro = with(clone $resultEval)->select(\DB::raw("SUM(value) as value"))
      ->where("question_type", "motivo")
      ->where("question_categoria", "Resultados - Orientación al Logro")
      ->where("no_analizable","=","0")
      ->first()->value;
      
      $honestidad = with(clone $resultEval)->select(\DB::raw("SUM(value) as value"))
      ->where("question_type", "motivo")
      ->where("question_categoria", "Integridad - Honestidad")
      ->where("no_analizable","=","0")
      ->first()->value;

     $consistencia = with(clone $resultEval)->select(\DB::raw("SUM(value) as value"))
      ->where("question_type", "motivo")
      ->where("question_categoria", "Consistencia")
      ->where("no_analizable","=","0")
      ->first()->value;
      
      $confianza = with(clone $resultEval)->select(\DB::raw("SUM(value) as value"))
      ->where("question_type", "motivo")
      ->where("question_categoria", "Afectividad - Confianza")
      ->where("no_analizable","=","0")
      ->first()->value;
   

     $total_evaluadores = Result::where("is_evaluacion",1)
                                  ->where("evaluacion_id",$evaluacion->id)->count();

     $total_profesionalidad = 8*5*$total_evaluadores;
     $total_logro = 12*5*$total_evaluadores;
     $total_honestidad = 6*5*$total_evaluadores;
     $total_consistencia = 3*5*$total_evaluadores;
     $total_confianza = 7*5*$total_evaluadores;
     

     $data['impactos'] = [
      "profesionalidad" => $profesionalidad/$total_profesionalidad*100,
      "logro" => $logro/$total_logro*100,
      "honestidad" => $honestidad/$total_honestidad*100,
      "consistencia" => $consistencia/$total_consistencia*100,
      "confianza" => $confianza/$total_confianza*100,
     ];
   /*  echo $confianza."<br>";
     echo $total_confianza."<br>";
     echo $total_evaluadores."<br>";
     dd($data['impactos']);*/

     $profesionalidad = with(clone $resultTotal)->select(\DB::raw("SUM(value) as value"))
     ->where("question_type", "motivo")
     ->where("question_categoria", "Cognición - Profesionalidad")
     ->where("no_analizable","=","0")
     ->first()->value;
     
     $logro = with(clone $resultTotal)->select(\DB::raw("SUM(value) as value"))
      ->where("question_type", "motivo")
      ->where("question_categoria", "Resultados - Orientación al Logro")
      ->where("no_analizable","=","0")
      ->first()->value;
      
      $honestidad = with(clone $resultTotal)->select(\DB::raw("SUM(value) as value"))
      ->where("question_type", "motivo")
      ->where("question_categoria", "Integridad - Honestidad")
      ->where("no_analizable","=","0")
      ->first()->value;

     $consistencia = with(clone $resultTotal)->select(\DB::raw("SUM(value) as value"))
      ->where("question_type", "motivo")
      ->where("question_categoria", "Consistencia")
      ->where("no_analizable","=","0")
      ->first()->value;
      
      $confianza = with(clone $resultTotal)->select(\DB::raw("SUM(value) as value"))
      ->where("question_type", "motivo")
      ->where("question_categoria", "Afectividad - Confianza")
      ->where("no_analizable","=","0")
      ->first()->value;
   

     $total_evaluadores = Result::where("is_evaluacion",1)->whereOr("is_autoevaluado",1)->where("import",0)->count();

      

     $total_profesionalidad = 8*5*$total_evaluadores;
     $total_logro = 12*5*$total_evaluadores;
     $total_honestidad = 6*5*$total_evaluadores;
     $total_consistencia = 3*5*$total_evaluadores;
     $total_confianza = 7*5*$total_evaluadores;
     

     $data['impactos_total'] = [
      "profesionalidad" => $profesionalidad/$total_profesionalidad*100,
      "logro" => $logro/$total_logro*100,
      "honestidad" => $honestidad/$total_honestidad*100,
      "consistencia" => $consistencia/$total_consistencia*100,
      "confianza" => $confianza/$total_confianza*100,
     ];
     $data["evaluacion_id"] = $id_evaluacion;

     //dd($data);
     return $data;
    }
    static function getDataAutoevaluadoRapport($id_evaluacion) {
      $frases = [
        "Vision Estratégica" => [
          "Analiza la situación del mercado",
          "Analiza las tendencias y prácticas más relevantes del ámbito empresarial",
          "Conoce las innovaciones que producen ventaja competitiva",
          "Sabe describir en pocas líneas las características de su empresa ",
          "Sabe cuáles son las fortalezas y debilidades de su empresa ",
          "Busca información sobre el sector a nivel local, nacional e internacional",
          "Analiza los factores que crean ventaja competitiva",
          "Analiza el entorno para aprovechar las oportunidades",
          "Define los objetivos y prioridades estratégicas",
        ],
        "Visión de la Organización" => [
          "Conoce los resultados de otras áreas y/o departamentos",
          "Conoce la relación de su trabajo con el de otras áreas y/o departamentos",
          "Puede describir en pocas líneas las funciones de otras áreas y/o departamentos",
          "Informa de los temas de su área que puedan afectar a otros",
          "Acepta el feedback de otras áreas y/o departamentos",
          "Sabe que procesos inciden en otras áreas y /departamentos",
          "Respeta las funciones asignadas a otras áreas",
          "Facilita el trabajo a otras áreas y/o departamentos",
          "Concreta procesos de mejora más allá de su propia función",
          
        ],
        "Orientación al Cliente" => [
          "Resuelve las quejas y sugerencias buscando en qué y cómo mejorar",
          "Sabe ganarse el respeto y confianza de los clientes",
          "Orienta su trabajo a satisfacer las necesidades de los clientes",
          "Sabe escuchar, sin ofenderse, para conocer mejor a las personas y sus necesidades",
          "Establece y mantiene relaciones de confianza y respeto con los clientes",
          "Dedica tiempo a pensar cómo satisfacer mejor las necesidades reales (presentes y futuras)",
          "Se preocupa por mejorar constantemente la calidad de los servicios y productos",
          "Diseña los procesos y establece los plazos en función de las necesidades reales",
          "Cuida los detalles para ofrecer un buen servicio",
 
        ],
        "Networking" => [
          "Adopta una posición activa y mantiene contacto con personas clave",
          "Sabe pedir opinión a las personas adecuadas ante situaciones difíciles",
          "Algunas personas acuden habitualmente a Vd., de manera informal, para comentar asuntos profesionales",
          "Asiste con regularidad  a reuniones clave, congresos, etc.",
          "Reserva tiempo para mantener y desarrollar relaciones con profesionales de su área u otras áreas de conocimiento",
          "Mantiene reuniones informales en su empresa para estar al día de cuestiones relevantes",
          "Dedica tiempo a sus contactos ",
          "Sabe qué personas, eventos e instituciones son clave para su actividad",
          "Sabe pedir y hacer favores a sus conocidos",

        ],
        "Comunicación" => [
          "Organiza las ideas y selecciona la información",
          "Sus mensajes son concretos y tienen contenido",
          "Cuida la actitud, el lenguaje, y la expresión",
          "Adapta el mensaje a la preparación intelectual, emocional y/o edad del interlocutor...",
          "Es flexible y se asegura de que le han entendido",
          "Escoge el medio idóneo (reunión, entrevista...) y el momento adecuado",
          "Se esfuerza por entender el punto de vista del otro",
          "Muestra empatía y formula preguntas a lo largo de la conversación",
          "Deja hablar sin interrumpir, tratando de comprender y asimilar lo que le dicen",

        ],
        "Delegación" => [
          "Conoce las capacidades de sus colaboradores",
          "Sabe encajar a cada persona en el perfil del puesto más adecuado a sus capacidades",
          "Delega las tareas y proyectos en función de las capacidades de los colaboradores",
          "Establece objetivos y plazos y fomenta el sentido de responsabilidad y profesionalidad",
          "Planifica las tareas y proporciona la ayuda, los recursos y el seguimiento necesarios",
          "Transmite la información y establece límites y criterios generales de actuación",
          "Evita entrar en detalles minuciosos de cómo deben realizar su tarea",
          "Delega todo aquello que la situación lo permita, sin perder la dirección del proyecto",
          "Fomenta la iniciativa, dando el margen necesario",

        ],
        "Coaching" => [
          "Dedica tiempo y atención a sus colaboradores",
          "Está accesible y evita dejarse llevar por el exceso de trabajo o la falta de interés",
          "Pregunta y escucha para entender las circunstancias, intereses y expectativas",
          "Se centra en hechos concretos",
          "Corrige constructivamente, aportando posibles soluciones",
          "Destaca los aspectos positivos y basa su relación en la confianza",
          "Invierte tiempo en el desarrollo de las personas",
          "Ayuda a diagnosticar correctamente las fortalezas y áreas de mejora de las personas",
          "Establece una agenda de seguimiento periódico con sus colaboradores y la respeta",

        ],
        "Trabajo en Equipo" => [
          "Conoce los objetivos y la dinámica de las reuniones",
          "Participa activamente en la toma de decisiones y las asume personalmente",
          "Lleva a cabo las tareas que se le encomiendan",
          "Crea un ambiente proactivo",
          "Promueve el diálogo constructivo entre los miembros del equipo",
          "Evita las alusiones personales en los momentos de discrepancia",
          "Sabe integrar sus conocimientos y habilidades de modo que beneficien al equipo",
          "Basa su relación en la interdependencia y colaboración y disfruta de los logros de todos",
          "Confía en lo que hacen los demás miembros del equipo y escucha sus puntos de vista",

        ],
        "Gestión del Tiempo" => [
          "Prevé y decide el mejor momento para cumplir las tareas que le competen",
          "Dedica el tiempo necesario a cada tarea, respeta los plazos, es diligente",
          "Dispone de tiempo para sí mismo, la familia y los amigos",
          "Repasa periódicamente las tareas que debe hacer",
          "Sabe qué y cuándo debe hacer cada cosa",
          "Lleva su agenda con orden, respetando lo previsto",
          "Determina las prioridades de los diferentes compromisos",
          "Respeta los plazos y dedica el tiempo a lo importante, sin dejarse llevar por lo urgente",
          "Evita interrupciones innecesarias sin caer en la precipitación",

        ],
        "Gestión del Estrés" => [
          "Distingue las situaciones en las que aparece el estrés y sabe cómo hacerle frente ",
          "Sabe relajarse y utilizar las estrategias  adecuadas",
          "Ve las cosas en perspectiva evitando las circunstancias que le producen estrés",
          "Tiene voluntad para respetar los horarios de sueño, descanso...",
          "Tiene un horario para el trabajo, el descanso, la familia.... y procura cumplirlo",
          "Dedica tiempo a hobbies y ocupaciones más allá del trabajo",
          "Trata de establecer y de cuidar relaciones interpersonales profundas",
          "Es capaz de cortar con el trabajo cuando está con la familia o los amigos",
          "Dedica tiempo suficiente para hacer vida social",

        ],
        "Optimismo" => [
          "Está convencido de que las cosas saldrán",
          "Ve lo positivo de cada situación, sin dejarse llevar por el escepticismo o la experiencia",
          "Se muestra seguro cuando debe tomar decisiones",
          "No se desanima ante las dificultades ni desiste ante los obstáculos del entorno",
          "Sabe pasar página sin hundirse ante los reveses profesionales y personales",
          "Aprende de los errores y piensa más en los aciertos y éxitos que en los fracasos",
          "No se deja llevar por el pesimismo ante las primeras dificultades",
          "Saca lo mejor de cada situación",
          "Celebra las pequeñas victorias",

        ],
        "Iniciativa" => [
          "Actúa con independencia en su trabajo, sin consultar cada paso",
          "No se conforma con el estado actual de las cosas y busca cómo mejorarlas",
          "Asume nuevos retos",
          "No se deja llevar por las situaciones y cree que es posible cambiarlas",
          "No se conforma con lo que ya funciona y cree que hay margen para mejorar las cosas",
          "Dedica tiempo a pensar cómo mejorar y a encontrar nuevas formas de hacer las cosas",
          "No se conforma con la primera solución y genera diversas alternativas ",
          "Identifica posibilidades de cambio, sin dejarse dominar por el miedo al fracaso o al error",
          "Tiene una actitud de curiosidad y busca distintas soluciones para mejorar las cosas",

        ],
        "Aprendizaje" => [
          "Tiene un plan de formación a corto, medio y largo plazo",
          "Tiene un tiempo concreto para su formación personal y profesional",
          "Está al día de los conocimientos propios de sus funciones",
          "Tiene actualmente un objetivo claro y concreto de mejora personal y profesional",
          "Tiene constancia en la mejora de sus conocimientos, capacidades y habilidades",
          "Ha logrado en los últimos meses mejorar en algo concreto personal o profesional",
          "Adquirir nuevos conocimientos que le permiten mejorar",
          "Aprende nuevas formas de trabajar que le hacen más flexible",
          "Está disponible para asumir nuevas tareas o actividades laborales",

        ],
        "Autoconocimiento" => [
          "Dedica tiempo a reflexionar sobre sí mismo y su comportamiento",
          "Reflexiona sobre sus experiencias y su modo de hacer las cosas",
          "Sabe cuáles son sus puntos fuertes y sus áreas de mejora",
          "Contrasta lo que piensa de sí mismo con personas que le conocen y en las que confía",
          "Genera confianza para que le puedan decir las cosas que debe mejorar",
          "Agradece las sugerencias que le manifiestan los demás",
          "Sabe identificar y comprender sus reacciones emocionales (enfados, incomodidad...)",
          "Controla sus sentimientos de modo que no interfieran en su trabajo ni en el de los demás",
          "Sabe comportarse de acuerdo con su posición",

        ],
        "Autocrítica" => [
          "Acepta su responsabilidad ante los fallos, sin buscar otros culpables,  y pide disculpas",
          "Admite que hace cosas peor que otras y que hay errores que pueden evitarse",
          "Reconoce que hay aspectos de su actuación que puede mejorar",
          "Agradece el consejo de los demás y sabe pedir disculpas",
          "Acepta con sencillez la opinión de los demás sin ponerse a la defensiva",
          "Se deja ayudar en aquellos aspectos en los que necesita mejorar",
          "No tiene miedo a la opinión sincera ni a que los demás le conozcan",
          "Sabe reírse de sí mismo",
          "Sabe ver en las críticas razonadas oportunidades de mejora",

        ],
        "Ambición" => [
          "Asume retos difíciles pero alcanzables y los persigue con tenacidad",
          "Se propone objetivos a largo plazo, con metas concretas para alcanzarlos",
          "Sabe mantener el esfuerzo aunque el resultado no sea inmediato",
          "Acomete las tareas con decisión, sin desanimarse, acabando los proyectos hasta el final",
          "Defiende sus puntos de vista con determinación y respeto",
          "Ejercita su voluntad con pequeños retos diarios, sin dejar las cosas a medias",
          "No se conforma con la mediocridad y el continuismo",
          "Se plantea metas elevadas y las persigue con determinación",
          "Busca proyectos que le ilusionan y motivan, sin caer en la rutina",

        ],
        "Toma de Decisiones" => [
          "Selecciona la información relevante para establecer las causas del problema",
          "Dedica el tiempo suficiente a analizar las circunstancias y definir el problema",
          "Se centra en los hechos y evita caer en intuiciones o en percepciones subjetivas",
          "Desarrolla alternativas que eliminan una o varias causas principales del problema",
          "Analiza distintas alternativas y compara los pros y contras de cada una",
          "Prevé las posibles consecuencias que pueden tener las alternativas planteadas",
          "Determina qué criterios son relevantes para decidir entre diversas alternativas",
          "Escoge una alternativa en función de los criterios definidos",
          "Diseña un plan de acción realista y concreto",

        ],
        "Integridad" => [
          "No cambia su actuación en función de las circunstancias",
          "Presenta la verdad de forma amable, sin tapujos y en el momento adecuado",
          "Toma postura sin hacer promesas que no puede cumplir",
          "Es un ejemplo para los que trabajan con ella/él",
          "Hace lo que dice y asume los compromisos que ha adquirido",
          "No cambia sus principios y valores ante cualquier tipo de presión",
          "Recaba la versión de las partes implicadas y los datos precisos al hacer valoraciones",
          "Comprende y corrige en lugar de juzgar y criticar",
          "Busca el equilibrio entre el cumplimiento estricto de la norma y la flexibilidad",

        ],
        "Autocontrol" => [
          "No se deja llevar por lo que más le apetece en cada momento",
          "Se concentra a fondo en los temas, sin saltar de uno a otro",
          "Es capaz de superar  el cansancio ante tareas complejas",
          "Hace los sacrificios necesarios para lograr sus objetivos",
          "Mantiene los compromisos a pesar del esfuerzo y las dificultades  ",
          "Realiza las tareas hasta el final, procurando hacerlas bien y cuidando los detalles ",
          "No se deja engañar ni busca excusas para acometer acciones costosas",
          "Ejercita el autocontrol, haciendo lo que debe en cada momento",
          "Supera las dificultades que conlleva realizar las tareas programadas ",

        ],
        "Equilibrio Emocional" => [
          "Es paciente con las propias limitaciones y con las de los demás",
          "Apacigua los ánimos en momentos de especial tensión",
          "Ante las discusiones trata de tomar distancia y adoptar un papel conciliador, sin darse por aludido ante ataques personales",
          "Sabe ponerse en el lugar de la otra persona, buscando poder ayudar",
          "Es oportuno en sus comentarios y sabe encontrar el momento adecuado",
          "Trata de tomar distancia y adoptar un papel conciliador",
          "Evita explosiones de mal humor, manteniendo un ánimo estable",
          "Expresa sus sentimientos de manera natural, sin excentricidades ni exageraciones",
          "Reacciona de manera proporcionada ante circunstancias tensas",

        ],
      ];

      $evaluacion = \Tresfera\Talent\Models\Evaluacion::find($id_evaluacion);

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

      $resultTotal = Result::whereIn("quiz_id",[3,11])
                            ->where("tresfera_taketsystem_answers.duplicated",0)
                            ->where("tresfera_taketsystem_results.duplicated",0)                            
                            ->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id');

           
      $competencias = [];                      

      $dimension_estrategica_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","ESTRATEGICA")->first()->value;;
      $dimension_estrategica_auto = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","ESTRATEGICA")->first()->value;
      $dimension_estrategica_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))->where("question_dimension","ESTRATEGICA")->first()->value;      ;

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
      ->where("question_dimension","ESTRATEGICA")
      ->where("rol","jefe")
      ->first()->value;
      $dimension_estrategica_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("rol","colaborador")
      ->first()->value;
      $dimension_estrategica_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("rol","companero")
      ->first()->value;
      $dimension_estrategica_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("rol","otros")
      ->first()->value;

      $dimension_estrategica_estrategica_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Vision Estratégica")
      ->where("rol","jefe")
      ->first()->value;
      $dimension_estrategica_estrategica_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Vision Estratégica")
      ->where("rol","colaborador")
      ->first()->value;
      $dimension_estrategica_estrategica_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Vision Estratégica")
      ->where("rol","companero")
      ->first()->value;
      $dimension_estrategica_estrategica_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Vision Estratégica")
      ->where("rol","otros")
      ->first()->value;

      $estrategica_estrategica_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_competencia","Vision Estratégica")
      ->where("question_dimension","ESTRATEGICA")
      ->first()->value;
      $estrategica_estrategica_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
      ->where("question_competencia","Vision Estratégica")
      ->where("question_dimension","ESTRATEGICA")
      ->first()->value;
      $estrategica_estrategica_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_competencia","Vision Estratégica")
      ->where("question_dimension","ESTRATEGICA")
      ->first()->value;

      $competencias["Vision Estratégica"] = [
        "evaluadores" => $estrategica_estrategica_evaluadores,
        "autoevaluador" => $estrategica_estrategica_autoevaluador,
        "total" => $estrategica_estrategica_total,
        "diferencia" => $estrategica_estrategica_autoevaluador - $estrategica_estrategica_evaluadores,
      ];


      $dimension_estrategica_organizacion_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Visión de la Organización")
      ->where("rol","jefe")
      ->first()->value;
      $dimension_estrategica_organizacion_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Visión de la Organización")
      ->where("rol","colaborador")
      ->first()->value;
      $dimension_estrategica_organizacion_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Visión de la Organización")
      ->where("rol","companero")
      ->first()->value;
      $dimension_estrategica_organizacion_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Visión de la Organización")
      ->where("rol","otros")
      ->first()->value;

      $estrategica_organizacion_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_competencia","Visión de la Organización")
      ->where("question_dimension","ESTRATEGICA")
      ->first()->value;
      $estrategica_organizacion_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
      ->where("question_competencia","Visión de la Organización")
      ->where("question_dimension","ESTRATEGICA")
      ->first()->value;
      $estrategica_organizacion_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_competencia","Visión de la Organización")
      ->where("question_dimension","ESTRATEGICA")
      ->first()->value;
      $competencias["Visión de la Organización"] = [
        "evaluadores" => $estrategica_organizacion_evaluadores,
        "autoevaluador" => $estrategica_organizacion_autoevaluador,
        "total" => $estrategica_organizacion_total,
        "diferencia" => $estrategica_organizacion_autoevaluador - $estrategica_organizacion_evaluadores,
      ];

      $dimension_estrategica_networking_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Networking")
      ->where("rol","jefe")
      ->first()->value;
      $dimension_estrategica_networking_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Networking")
      ->where("rol","colaborador")
      ->first()->value;
      $dimension_estrategica_networking_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Networking")
      ->where("rol","companero")
      ->first()->value;
      $dimension_estrategica_networking_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Networking")
      ->where("rol","otros")
      ->first()->value;

      $estrategica_networking_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_competencia","Networking")
      ->where("question_dimension","ESTRATEGICA")
      ->first()->value;
      $estrategica_networking_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
      ->where("question_competencia","Networking")
      ->where("question_dimension","ESTRATEGICA")
      ->first()->value;
      $estrategica_networking_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_competencia","Networking")
      ->where("question_dimension","ESTRATEGICA")
      ->first()->value;

      $competencias["Networking"] = [
        "evaluadores" => $estrategica_networking_evaluadores,
        "autoevaluador" => $estrategica_networking_autoevaluador,
        "total" => $estrategica_networking_total,
        "diferencia" => $estrategica_networking_autoevaluador - $estrategica_networking_evaluadores,
      ];
      

      $dimension_estrategica_cliente_jefe = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Orientación al Cliente")
      ->where("rol","jefe")
      ->first()->value;
      $dimension_estrategica_cliente_colaborador = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Orientación al Cliente")
      ->where("rol","colaborador")
      ->first()->value;
      $dimension_estrategica_cliente_companero = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Orientación al Cliente")
      ->where("rol","companero")
      ->first()->value;
      $dimension_estrategica_cliente_otros = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","ESTRATEGICA")
      ->where("question_competencia","Orientación al Cliente")
      ->where("rol","otros")
      ->first()->value;

      $estrategica_cliente_evaluadores = with(clone $resultEval)->select(\DB::raw("AVG(value) as value"))
      ->where("question_competencia","Orientación al Cliente")
      ->where("question_dimension","ESTRATEGICA")
      ->first()->value;
      $estrategica_cliente_autoevaluador = with(clone $resultAuto)->select(\DB::raw("AVG(value) as value"))
      ->where("question_competencia","Orientación al Cliente")
      ->where("question_dimension","ESTRATEGICA")
      ->first()->value;
      $estrategica_cliente_total = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_competencia","Orientación al Cliente")
      ->where("question_dimension","ESTRATEGICA")
      ->first()->value;

      $competencias["Orientación al Cliente"] = [
        "evaluadores" => $estrategica_cliente_evaluadores,
        "autoevaluador" => $estrategica_cliente_autoevaluador,
        "total" => $estrategica_cliente_total,
        "diferencia" => $estrategica_cliente_autoevaluador - $estrategica_cliente_evaluadores,
      ];

      $estrategica_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATEGICA")
        ->where("edad",$evaluacion->result->edad)
        ->first()->value;
      $estrategica_sector = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATEGICA")
        ->where("sector",$evaluacion->result->sector)
        ->first()->value;
      $estrategica_genero = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATEGICA")
        ->where("genero",$evaluacion->result->genero)
        ->first()->value;
      $estrategica_area = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATEGICA")
        ->where("area",$evaluacion->result->area)
        ->first()->value;
      $estrategica_funcion = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
        ->where("question_dimension","ESTRATEGICA")
        ->where("funcion",$evaluacion->result->funcion)
        ->first()->value;

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
      $interpersonal_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","INTERPERSONAL")
      ->where("edad",$evaluacion->result->edad)
      ->first()->value;
      $interpersonal_sector = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","INTERPERSONAL")
      ->where("sector",$evaluacion->result->sector)
      ->first()->value;
      $interpersonal_genero = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","INTERPERSONAL")
      ->where("genero",$evaluacion->result->genero)
      ->first()->value;
      $interpersonal_area = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","INTERPERSONAL")
      ->where("area",$evaluacion->result->area)
      ->first()->value;
      $interpersonal_funcion = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","INTERPERSONAL")
      ->where("funcion",$evaluacion->result->funcion)
      ->first()->value;

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
      $autogestion_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","AUTOGESTION")
      ->where("edad",$evaluacion->result->edad)
      ->first()->value;
      $autogestion_sector = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","AUTOGESTION")
      ->where("sector",$evaluacion->result->sector)
      ->first()->value;
      $autogestion_genero = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","AUTOGESTION")
      ->where("genero",$evaluacion->result->genero)
      ->first()->value;
      $autogestion_area = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","AUTOGESTION")
      ->where("area",$evaluacion->result->area)
      ->first()->value;
      $autogestion_funcion = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
      ->where("question_dimension","AUTOGESTION")
      ->where("funcion",$evaluacion->result->funcion)
      ->first()->value;

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
   $autodesarrollo_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
   ->where("question_dimension","AUTODESARROLLO")
   ->where("edad",$evaluacion->result->edad)
   ->first()->value;
   $autodesarrollo_sector = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
   ->where("question_dimension","AUTODESARROLLO")
   ->where("sector",$evaluacion->result->sector)
   ->first()->value;
   $autodesarrollo_genero = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
   ->where("question_dimension","AUTODESARROLLO")
   ->where("genero",$evaluacion->result->genero)
   ->first()->value;
   $autodesarrollo_area = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
   ->where("question_dimension","AUTODESARROLLO")
   ->where("area",$evaluacion->result->area)
   ->first()->value;
   $autodesarrollo_funcion = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
   ->where("question_dimension","AUTODESARROLLO")
   ->where("funcion",$evaluacion->result->funcion)
   ->first()->value;

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


         $autoliderazgo_edad = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
         ->where("question_dimension","AUTOGOBIERNO")
         ->where("edad",$evaluacion->result->edad)
         ->first()->value;
         $autoliderazgo_sector = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
         ->where("question_dimension","AUTOGOBIERNO")
         ->where("sector",$evaluacion->result->sector)
         ->first()->value;
         $autoliderazgo_genero = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
         ->where("question_dimension","AUTOGOBIERNO")
         ->where("genero",$evaluacion->result->genero)
         ->first()->value;
         $autoliderazgo_area = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
         ->where("question_dimension","AUTOGOBIERNO")
         ->where("area",$evaluacion->result->area)
         ->first()->value;
         $autoliderazgo_funcion = with(clone $resultTotal)->select(\DB::raw("AVG(value) as value"))
         ->where("question_dimension","AUTOGOBIERNO")
         ->where("funcion",$evaluacion->result->funcion)
         ->first()->value;

      $data = [
        "name" => $evaluacion->name,
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
        
        "estrategica_edad"                            => $estrategica_edad,
        "estrategica_sector"                          => $estrategica_sector,
        "estrategica_genero"                          => $estrategica_genero,
        "estrategica_area"                            => $estrategica_area,
        "estrategica_funcion"                         => $estrategica_funcion,

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
       
       "autoliderazgo_edad"                            => $autoliderazgo_edad,
       "autoliderazgo_sector"                          => $autoliderazgo_sector,
       "autoliderazgo_genero"                          => $autoliderazgo_genero,
       "autoliderazgo_area"                            => $autoliderazgo_area,
       "autoliderazgo_funcion"                         => $autoliderazgo_funcion,

       /* FIN 14C */
       //"competencias" => collect($competencias),
      ];

      $competencias_sobrevaloradas = collect($competencias)->sortByDesc("diferencia")->slice(0,4);
      foreach($competencias_sobrevaloradas as $competencia => $valores) {
        $valores['diferencia_total'] = $valores['total'] - $valores['evaluadores'];
        $competencias_sobrevaloradas[$competencia] = $valores;
      }
      $data['competencias_sobrevaloradas'] = $competencias_sobrevaloradas;

      $competencias_infravaloradas = collect($competencias)->sortBy("diferencia")->slice(0,4);
      foreach($competencias_infravaloradas as $competencia => $valores) {
        $valores['diferencia_total'] = $valores['total'] - $valores['evaluadores'];
        $competencias_infravaloradas[$competencia] = $valores;
      }
      $data['competencias_infravaloradas'] = $competencias_infravaloradas;

      
      $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
      'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
      'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
      'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
      'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );

      $competencias_masvaloradas = collect($competencias)->sortByDesc("evaluadores")->slice(0,3);
      foreach($competencias_masvaloradas as $competencia => $valores) {

        $dimension = with(clone $resultAuto)->select(\DB::raw("question_dimension as value"))
        ->where("question_competencia",$competencia)
        ->first()->value;
 
        $valores['title']           = $competencia;
        $valores['otros']           = $dimension_autoliderazgo_networking_otros?$dimension_autoliderazgo_networking_otros:0;
        $valores['dimension']       = strtolower(strtr($dimension,$unwanted_array));

        $competencias_masvaloradas[$competencia] = $valores;

          
      }
      $competencias_peorvaloradas = collect($competencias)->sortBy("evaluadores")->slice(0,3);
      foreach($competencias_peorvaloradas as $competencia => $valores) {
        $dimension = with(clone $resultAuto)->select(\DB::raw("question_dimension as value"))
        ->where("question_competencia",$competencia)
        ->first()->value;

        $valores['dimension']       = strtolower(strtr($dimension,$unwanted_array));

     /*   eval("\$dimension_autoliderazgo_networking_jefe = \$dimension_".$valores['dimension']."_estrategica_jefe;");
        eval("\$dimension_autoliderazgo_networking_colaborador = \$dimension_".$valores['dimension']."_estrategica_colaborador;");
        eval("\$dimension_autoliderazgo_networking_companero = \$dimension_".$valores['dimension']."_estrategica_companero;");
        eval("\$dimension_autoliderazgo_networking_otros = \$dimension_".$valores['dimension']."_estrategica_otros;");*/

        $valores['title']           = $competencia;
        $valores['otros']           = $dimension_autoliderazgo_networking_otros?$dimension_autoliderazgo_networking_otros:0;
        $valores['dimension']       = strtolower(strtr($dimension,$unwanted_array));
        $valores['frases']          = $frases[$competencia];
        $competencias_peorvaloradas[$competencia] = $valores;
     }
      $data['competencias_peorvaloradas'] = $competencias_peorvaloradas->toArray();
      $data['competencias_masvaloradas'] = $competencias_masvaloradas->toArray();

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

              $total = $estratega+$ejecutivo+$integrador;


     $data['motivos'] = [
      "estratega" => $estratega,
      "ejecutivo" => $ejecutivo,
      "integrador" => $integrador,
      "estratega_percent" => $estratega/$total*100,
      "ejecutivo_percent" => $ejecutivo/$total*100,
      "integrador_percent" => $integrador/$total*100,
     ];

     
     $data["evaluacion_id"] = $id_evaluacion;

     //dd($data);
     return $data;
    }
    public function showRapport() {
      $evaluacion = \Tresfera\Talent\Models\Evaluacion::find(get("id"));
      if(in_array('autoevaluacion',$evaluacion->tipo)) {

        $data = SELF::getDataAutoevaluadoRapport(get("id"));

        //$data['competencias_masvaloradas'] = $competencias_masvaloradas->toArray();
   
        return PDF::loadTemplate('talent:autoevaluacion',$data)
                               ->setOptions(['isRemoteEnabled' => true,'dpi' => 150])
                               ->setPaper('a4', 'landscape')->stream();
      }
      $data = SELF::getDataRapport(get("id"));

     //$data['competencias_masvaloradas'] = $competencias_masvaloradas->toArray();

     return PDF::loadTemplate('renatio::invoice',$data)
                            ->setOptions(['isRemoteEnabled' => true,'dpi' => 150])
                            ->setPaper('a4', 'landscape')->stream();
    }

    public function onCompleted() {
      $evaluacion = \Tresfera\Talent\Models\Evaluacion::find(get("id"));
      $stats = $evaluacion->stats;
      $stats["numAnswered"]++;
      $stats[get("tipo")][get("email")]["completed"] = true;
      $stats[get("tipo")][get("email")]["completed_at"] = \Carbon\Carbon::now();
      $evaluacion->stats = $stats;
      if($stats["numAnswered"] == $stats["numTotal"]) {
        $evaluacion->estado = 3;
      }
      $evaluacion->save();
    }
    public function formExtendFields($form,$record)
    {
      if(isset($this->params[0])) {
        $evaluacion = \Tresfera\Talent\Models\Evaluacion::find($this->params[0]);
      }

      if($this->user->hasPermission(["talent.gestor"])) {
        return;
      }
      if($this->user->role_id == 3) {
        //dd($record['tipo']->config);
        if(isset($evaluacion->tipo))
          foreach($record['tipo']->config['options'] as $name=>$null)
            if(!in_array($name,$evaluacion->tipo))
              $form->removeField($name);

        $form->removeField('params[permissions]');
        if($form->model->estado == 1) {
          if(!is_array($record['params[permissions]']->value)) $record['params[permissions]']->value = [];
          if(!in_array("change_evaluadores",$record['params[permissions]']->value)) {
            
            $form->removeField('jefe');
            $form->removeField('companero');
            $form->removeField('colaborador');
            $form->removeField('otro');

          }
          if(!in_array("change_tipo",$record['params[permissions]']->value)) {
            $fields = $form->fields;
            foreach($form->fields as $name => $field) {
              if($name == 'tipo')
                $fields[$name]['readOnly'] = true;
              $form->removeField($name);
            }
            $form->addFields($fields);

            $form->removeField('stats_partial');
          }
        } else {
          $fields = $form->fields;
          foreach($form->fields as $name => $field) {
            $fields[$name]['readOnly'] = true;
            $form->removeField($name);
          }
          $form->addFields($fields);
          $form->removeField('jefe');
          $form->removeField('companero');
          $form->removeField('colaborador');
          $form->removeField('otro');

        }

      }
    }

    
}
