<?php namespace Tresfera\Taketsystem\Components;

use Cms\Classes\ComponentBase;
use Renatio\DynamicPDF\Classes\PDF;
use Tresfera\Taketsystem\Models\ProgresoAnswer;
use RainLab\User\Models\User;

class Informe extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Informe Component',
            'description' => 'No description provided yet...'
        ];
    }

    static function getData($user, $competencia) {
        $data = [];
        $data['name'] = $user->name;
        $data['team'] = $user->company;
        $data['date'] = date("d-m-Y");
        
        for($i=1;$i<=5;$i++) {
            $var = ProgresoAnswer::addSelect(\DB::raw("SUM( points*peso/100 ) as puntos"))
            ->where("user_id",$user->id)
            ->where("quiz","cofidis-competencia".$i)->groupBy("user_id")->first();
            if(isset($var->puntos))
                $data['points_user_comp'.$i] = $var->puntos;
        }
        
            

        $var = ProgresoAnswer::addSelect(\DB::raw("SUM( points*peso/100 ) as puntos"))
                        ->where("user_id",$user->id)->groupBy("user_id")->first();      
        if(isset($var->puntos))
            $data['points_user_total'] = $var->puntos;

        for($i=1;$i<=5;$i++) {
            $points_teams_comp = User::leftjoin("tresfera_taketsystem_progresos_answers","users.id","=","tresfera_taketsystem_progresos_answers.user_id")
                                        ->addSelect(\DB::raw("SUM( points*peso/100 )/count(DISTINCT users.id) as points"))
                                        ->addSelect(\DB::raw("company as team"))
                                        ->where("quiz","cofidis-competencia".$i)
                                        ->groupBy("company")
                                        ->orderBy("points","DESC")->get();
            $data['points_teams_comp'.$i] = 0;
            $data['ranking_teams_comp'.$i] = 0;
            foreach($points_teams_comp as $points) {
                $data['ranking_teams_comp'.$i]++;
                if($points->team == $user->company) {
                    $data['points_teams_comp'.$i] = $points->points;
                    break;
                }
            }
        }
        $points_teams_total = User::leftjoin("tresfera_taketsystem_progresos_answers","users.id","=","tresfera_taketsystem_progresos_answers.user_id")
                                    ->addSelect(\DB::raw("SUM( points*peso/100 )/count(DISTINCT users.id) as points"))
                                    ->addSelect(\DB::raw("company as team"))
                                    ->groupBy("company")
                                    ->orderBy("points","DESC")->get();
        $data['points_teams_total'] = 0;
        $data['ranking_teams_total'] = 0;
        foreach($points_teams_total as $points) {
            $data['ranking_teams_total']++;
            if($points->team == $user->company) {
                $data['points_teams_total'] = $points->points;
                break;
            }
        }
        $data['total_teams'] = count(User::groupBy("company")->get());   
        switch($competencia) {
            case 'competencia1':
                $data['reto1'] = ProgresoAnswer::where("user_id",$user->id)
                            ->addSelect(\DB::raw("value"))
                            ->where("quiz","cofidis-".$competencia)
                            ->where("bonus",0)
                            ->where("pag","cofidis-competencia1-pag3")->groupBy("value")->get()->toArray();
                $data['reto2_1'] = ProgresoAnswer::where("user_id",$user->id)
                            ->addSelect(\DB::raw("value"))
                            ->where("bonus",0)
                            ->where("quiz","cofidis-".$competencia)
                            ->orderBy("created_at")
                            ->whereIn("pag",["cofidis-competencia1-pag8","cofidis-competencia1-pag9","cofidis-competencia1-pag10","cofidis-competencia1-pag11","cofidis-competencia1-pag12"])->groupBy("value")->get()->toArray();
                $data['reto2_2'] = ProgresoAnswer::where("user_id",$user->id)
                            ->addSelect(\DB::raw("value"))
                            ->where("bonus",0)
                            ->orderBy("created_at")
                            ->where("quiz","cofidis-".$competencia)
                            ->whereIn("pag",["cofidis-competencia1-pag15"])->groupBy("value")->get()->toArray();

                $var = ProgresoAnswer::where("user_id",$user->id)
                            ->addSelect(\DB::raw("value"))
                            ->where("bonus",0)
                            ->orderBy("created_at")
                            ->where("quiz","cofidis-".$competencia)
                            ->where("question","Cuenta brevemente alguna situación (propia o ajena), en la que, tras haber cometido un error, la persona haya aplicado los aprendizajes derivados de ese error adoptando una actitud de mejora ")->first();      
                if(isset($var->value))                         
                $data['reto2_3'] = $var->toArray();
                        
                $data['reto2_3_palabras'] = [
                "error","aprender","práctica", "ideas","mejorar"
                ];
                $data['reto2_3_palabras_ok'] = [];
                if(isset($data['reto2_3']))
                foreach($data['reto2_3_palabras'] as $palabra) {
                if ( strstr( strtolower($data['reto2_3']['value']), $palabra ) ) {
                $data['reto2_3_palabras_ok'][] = $palabra;
                }
                }

                $data['reto3_1'] = ProgresoAnswer::where("user_id",$user->id)
                            ->addSelect(\DB::raw("value"))
                            ->addSelect(\DB::raw("question"))
                            ->where("bonus",0)
                            ->where("quiz","cofidis-".$competencia)
                            ->whereIn("pag",["cofidis-competencia1-pag25"])->groupBy("value")->get()->toArray(); 

                $feedback = [
                "¿Cómo reaccionas ante situaciones de cambio que impliquen incertidumbre?" => [
                "Me agobio" => "Aprende a vivir sin tener toda la infomración y repite 3 veces “puedo improvisar”.",
                "Me pongo nervioso" => "Activa tu modo “keepcalm” y disfruta la sorpresa.",
                "Me adapto sin más" => "Vas muy bien ¿y si además le pusieras curiosidad?",
                "Me estimula" => "¡Vaya crac! Es una suerte que te manejes tan bien en la incertidumbre.",
                ],
                "¿Cuánto tardas en aceptar las novedades y adaptarte?" => [
                "Mucho" => "¡No te lo pienses demasiado! Cuanto antes te pongas, mejor para ti.",
                "Necesito mi tiempo" => "¡Acelera! Se trata de aprender ágilmente ¿recuerdas?",
                "Le doy alguna vuelta" => "Tómate tu tiempo pero no se te ocurra dormirte.",
                "Soy rápido/a" => "¡Súper! Adaptarse rápido es una habilidad de gran valor.",
                ],
                "¿Qué haces para conseguirlo?" => [
                "Nada" => "Uyyy, qué peligro. Abre tu mente, hay que adaptarse o adaptarse. ",
                "Esperar a acostumbrarme" => "Busca la palabra proactividad en el diccionario y ponte en marcha, por favor. Lo conseguirás.",
                "Busco más información" => "Modo curioso activado y se inicia la adaptación. Avanzaaa",
                "Lo consigo fácilmente" => "¿Quizás eres de los que te estimulan los cambios? Felicidades, estás en línea con los tiempos.",
                ],
                "¿Qué es lo que más te molesta de tener que tomar decisiones sin disponer de toda la información?" => [
                "No puedo decidir así" => "Si puedes si aceptas la posibilidad de equivocarte y aprender y aprender y aprender.",
                "Me cuesta decidir sin información" => "Analiza la información que tengas aunque sea escasa, escucha a tu intuición y ¡Atrévete!",
                "Me molesta la posibilidad de error" => "Se aventurero. Acepta el error como una llave que abre puertas a otras proyecciones.",
                "No me molesta" => "Eres agua, my friend. Capaz de adaptarte y normalizar el cambio.",
                ],
                ];
                $data['feedback'] = $feedback;
                $data['reto3_2'] = ProgresoAnswer::where("user_id",$user->id)
                            ->addSelect(\DB::raw("value"))
                            ->where("bonus",0)
                            ->where("quiz","cofidis-".$competencia)
                            ->whereIn("pag",["cofidis-competencia1-pag27"])->groupBy("value")->get()->toArray(); 

                $data['reto3_2_feedback'] = [
                1 => '"Tu vida no mejora por casualidad, mejora por el cambio."',
                2 => '"Eres tan joven como la última vez que cambiaste tu mente."',
                3 => '“La mente es como un paracaídas, sólo funciona si se abre.”',
                4 => '“El guerrero que tiene mayor facilidad para adaptarse a lo inesperado es el que vive más tiempo.”',
                5 => '“Saborea de igual manera un trozo de pan sentado al borde de un río como una comida en el mejor de los restaurantes.”',
                6 => '"Si cambias el modo que miras las cosas, las cosas que miras cambian."',
                ];
                $data['reto3_3'] = ProgresoAnswer::where("user_id",$user->id)
                            ->addSelect(\DB::raw("value"))
                            ->where("bonus",0)
                            ->where("quiz","cofidis-".$competencia)
                            ->whereIn("pag",["cofidis-competencia1-pag29"])->groupBy("value")->get()->toArray(); 
            break;
            case 'competencia2':
                $data['reto1_1'] = ProgresoAnswer::where("user_id",$user->id)
                            ->addSelect(\DB::raw("value"))
                            ->where("bonus",0)
                            ->where("quiz","cofidis-".$competencia)
                            ->orderBy("created_at")
                            ->whereIn("pag",["cofidis-competencia2-pag4","cofidis-competencia2-pag5","cofidis-competencia2-pag6"])->groupBy("value")->get()->toArray();
                $data['reto2_1'] = ProgresoAnswer::where("user_id",$user->id)
                            ->addSelect(\DB::raw("value"))
                            ->addSelect(\DB::raw("question"))
                            ->where("bonus",0)
                            ->where("quiz","cofidis-".$competencia)
                            ->orderBy("created_at")
                            ->whereIn("pag",["cofidis-competencia2-pag11"])->lists("value","question");
                $data['reto2_2'] = ProgresoAnswer::where("user_id",$user->id)
                            ->addSelect(\DB::raw("value"))
                            ->addSelect(\DB::raw("question"))
                            ->where("bonus",0)
                            ->where("quiz","cofidis-".$competencia)
                            ->orderBy("created_at")
                            ->whereIn("pag",["cofidis-competencia2-pag14"])->groupBy("value")->lists("value","question");
                          
                $data['reto2_2_feedback'] = [
                    1 => '"Siempre parece imposible, hasta que se hace."',
                    2 => '"Insistir, persistir, resistir, y nunca desistir."',
                    3 => '“Conseguir el éxito no es hacer más, es hacer mejor.”',
                    4 => '“Cuanto más grande es el reto, mayor es la oportunidad.”',
                    5 => '“Si deseas algo que nunca has tenido, deberás hacer algo que nunca has hecho.”',
                    6 => '"No he fracasado, he encoontrado diez mil maneras en las que esto no funciona."',
                ];
                $data['reto2_3'] = ProgresoAnswer::where("user_id",$user->id)
                            ->addSelect(\DB::raw("value"))
                            ->addSelect(\DB::raw("question"))
                            ->where("bonus",0)
                            ->where("quiz","cofidis-".$competencia)
                            ->orderBy("created_at")
                            ->whereIn("pag",["cofidis-competencia2-pag17"])->groupBy("question")->lists("value","question");
                $data['reto3_1'] = ProgresoAnswer::where("user_id",$user->id)
                            ->addSelect(\DB::raw("value"))
                            ->addSelect(\DB::raw("question"))
                            ->where("bonus",0)
                            ->where("quiz","cofidis-".$competencia)
                            ->orderBy("created_at")
                            ->whereIn("pag",["cofidis-competencia2-pag21","cofidis-competencia2-pag22"])->groupBy("question")->lists("value","question");
                $data['reto3_2_1'] = ProgresoAnswer::where("user_id",$user->id)
                            ->addSelect(\DB::raw("value"))
                            ->addSelect(\DB::raw("question"))
                            ->where("bonus",0)
                            ->where("quiz","cofidis-".$competencia)
                            ->orderBy("created_at")
                            ->whereIn("pag",["cofidis-competencia2-pag25"])->groupBy("question")->orderBy("id")->lists("value","question");
                $data['reto3_2_2'] = ProgresoAnswer::where("user_id",$user->id)
                            ->addSelect(\DB::raw("value"))
                            ->addSelect(\DB::raw("question"))
                            ->where("bonus",0)
                            ->where("quiz","cofidis-".$competencia)
                            ->orderBy("created_at")
                            ->whereIn("pag",["cofidis-competencia2-pag26"])->groupBy("question")->orderBy("id")->lists("value","question");
            break;
            case 'competencia3':
                $data['reto1_1'] = ProgresoAnswer::where("user_id",$user->id)
                            ->addSelect(\DB::raw("value"))
                            ->where("bonus",0)
                            ->where("quiz","cofidis-".$competencia)
                            ->orderBy("created_at")
                            ->whereIn("pag",["cofidis-competencia3-pag4"])->groupBy("value")->get()->toArray();

                $data['reto2_1'] = ProgresoAnswer::where("user_id",$user->id)
                            ->addSelect(\DB::raw("value"))
                            ->addSelect(\DB::raw("question"))
                            ->where("bonus",0)
                            ->where("quiz","cofidis-".$competencia)
                            ->orderBy("value")
                            ->whereIn("pag",["cofidis-competencia3-pag9"])->lists("question","value");
                $data['reto2_2'] = ProgresoAnswer::where("user_id",$user->id)
                            ->addSelect(\DB::raw("value"))
                            ->addSelect(\DB::raw("question"))
                            ->where("bonus",0)
                            ->where("quiz","cofidis-".$competencia)
                            ->orderBy("created_at")
                            ->whereIn("pag",["cofidis-competencia3-pag12"])->groupBy("value")->get()->toArray();
                $data['reto2_3'] = ProgresoAnswer::where("user_id",$user->id)
                            ->addSelect(\DB::raw("value"))
                            ->addSelect(\DB::raw("question"))
                            ->where("bonus",0)
                            ->where("quiz","cofidis-".$competencia)
                            ->orderBy("created_at")
                            ->whereIn("pag",["cofidis-competencia3-pag22"])->groupBy("value")->get()->toArray();
                $data['reto2_3_feedback'] = [
                    '/storage/app/media/cofidis/competencia3/3p/13.1 Sabelotodo.png' => [
                        'Es curioso y busca en diferentes medios para estar bien informado. Está pendiente de los nuevos productos del mercado, compara beneficios, precios, etc. No le gusta que le acribillen a preguntas. Se puede llegar a él ofreciendo la mayor información posible.',
                        'El Sabelotodo'
                    ],
                    '/storage/app/media/cofidis/competencia3/13.2 Inseguro.png' => [
                        'Cambia mucho de marca. Se muestra indeciso y le cuesta saber qué le gusta más. Es fácil captar su atención pues se cuestiona constantemente. <br>Una forma de atraerlo es guiándole o invitándole a comparar o probar.',
                        'El Inseguro'
                    ],
                    '/storage/app/media/cofidis/competencia3/13.3 Amable.png' => [
                        'Simpático y cortés, comprensivo y tolerante. Abierto a dar su opinión, contestar encuestas, conocer cosas nuevas y probar.<br>La manera de acercarse a él para generar preferencia es mostrar interés por su opinión y crear una relación cercana.',
                        'El Amable'
                    ],
                    '/storage/app/media/cofidis/competencia3/13.4 Especial.png' => [
                        'Le gusta ser diferente y ser tratado como tal. Valora mucho la reputación y prestigio de la marca.<br>Una forma de llegarle es ofreciendo datos interesantes, innovadores y sorprendentes en su contenido.',
                        'El Especial'
                    ],
                    '/storage/app/media/cofidis/competencia3/13.5 Gruñón.png' => [
                        'Es exigente e impaciente y reacciona mal cuando algo no sale como espera. Amenaza con no volver.<br>Se inclina por aquella marca que es detallista y le ofrece garantías o resultados exactos, por lo general medibles.',
                        'El Gruñón'
                    ],
                    '/storage/app/media/cofidis/competencia3/13.6 Aprovechado.png' => [
                        'No muestra atención más que por el precio y las condiciones. Pide descuento, regatea, quiere trato de favor y no se pone en el lugar de nadie que no sea él mismo.<br>Hay que plantearle el mejor trato pposible mostrando algún punto de flexibilidad.',
                        'El Aprovechado'
                    ]
                ];
                $data['reto3_1'] = ProgresoAnswer::where("user_id",$user->id)
                            ->addSelect(\DB::raw("value"))
                            ->addSelect(\DB::raw("question"))
                            ->where("bonus",0)
                            ->where("quiz","cofidis-".$competencia)
                            ->orderBy("created_at")
                            ->whereIn("pag",["cofidis-competencia3-pag26"])->groupBy("question")->lists("value","question");
                $data['reto3_2'] = ProgresoAnswer::where("user_id",$user->id)
                            ->addSelect(\DB::raw("value"))
                            ->addSelect(\DB::raw("question"))
                            ->where("bonus",0)
                            ->where("quiz","cofidis-".$competencia)
                            ->orderBy("created_at")
                            ->whereIn("pag",["cofidis-competencia3-pag28"])->groupBy("question")->orderBy("id")->lists("value","question");
                $data['reto3_3'] = ProgresoAnswer::where("user_id",$user->id)
                            ->addSelect(\DB::raw("value"))
                            ->addSelect(\DB::raw("question"))
                            ->where("bonus",0)
                            ->where("quiz","cofidis-".$competencia)
                            ->orderBy("created_at")
                            ->whereIn("pag",["cofidis-competencia3-pag30"])->groupBy("question")->orderBy("id")->lists("value","question");

            break;
        }
        //dd($data);
        return $data;
    }

    public function onRun() {
        $user = \Auth::getUser();
        $data = SELF::getData($user,$this->property('competencia'));

        return PDF::loadTemplate('cofidis-'.$this->property('competencia'),$data)
                ->setOptions(['isRemoteEnabled' => true,'dpi' => 300])
                ->stream();
    }
    public function defineProperties()
    {
        return [
            'competencia' => [
                'title'             => 'Competencia',
                'description'       => 'Competencia que se va a generar el informe',
                'default'           => 'competencia1',
                'type'              => 'string',
           ]
        ];
    }
}
