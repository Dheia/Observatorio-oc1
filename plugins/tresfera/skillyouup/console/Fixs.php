<?php namespace Tresfera\Skillyouup\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Fixs extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'skillyouup:fixs';

    /**
     * @var string The console command description.
     */
    protected $description = 'No description provided yet...';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $results = \DB::table("tresfera_taketsystem_answers")
                    ->select(\DB::raw("COUNT(*) as num"), "result_id")
                    ->whereRaw("question_categoria <> '' AND (question_title = 'Reacciona de modo similar ante problemas análogos' OR question_title = 'Su comportamiento sigue una lógica' OR question_title = 'Su comportamiento es predecible' OR question_title='')")
                    ->groupBy("result_id")->get();
        $tipos = [
            "Confianza General" => [
                "Confío plenamente",
                "Me gustaría poder confiar más",
                "Nunca estoy seguro de cómo va actuar",
            ],
            "Consistencia"=> [
                "Su comportamiento es predecible",
                "Su comportamiento sigue una lógica",
                "Reacciona de modo similar ante problemas análogos",
            ],
            "Cognición - Profesionalidad"=> [
                "Está preparado/a y es competente",
                "Trabaja con dedicación y profesionalidad",
                "Resuelve las dudas que se le plantean ",
                "Aplica su conocimiento y experiencia en el trabajo",
                "Domina las prácticas profesionales más relevantes",
                "Está al día en su profesión",
            ],
            "Toma de Decisiones - Orientación a las Personas"=> [
                "Escoge la alternativa que beneficia a las personas",
                "Escoge la alternativa que le conviene a nivel personal",
                "Nunca engañaría para sacar provecho de la situación",
            ],
            "Resultados - Orientación al Logro"=> [
                "Consigue los resultados que la empresa le propone",
                "Prioriza las tareas para lograr los resutados",
                "Trabaja en varias tareas a a vez",
                "Gestiona con éxito los proyectos",
                "Establece tareas y plazos realistas ",
                "Alienta a los demás a superar las metas",
                "Le importan las personas tanto como los resultados",
                "Le importan más los resultados que las personas",
            ],
            "Integridad - Honestidad"=> [
                "Siempre cumple sus promesas",
                "Trata a las personas con honestidad",
                "Siempre dice la verdad",
                "Siempre actúa de manera justa",
            ],
            "Afectividad - Confianza"=> [
                "Ideas, sentimientos e ilusiones",
                "Dificultades laborales",
                "Dificultades personales",
                "Hace sacrificios personales si alguien lo necesita",
                "Responde constructivamente ante los errores",
                "Admite puntos de vista diferentes a los suyos",
                "Atiende las sugerencias",
            ],
        ];
        foreach($results as $result) {

            if($result->num > 34) { //tenemos que borrar los sobrantes
                //buscamos cual es el tipo que tiene mal los registros
                echo $result->result_id ." ". $result->num."\n";
                foreach($tipos as $tipo=>$numRequired) {
                    $result2 = \Tresfera\TaketSystem\Models\Answer::
                                    where("question_categoria",$tipo)
                                    ->where("result_id",$result->result_id)
                                    ->get();
                    if(count($numRequired) < count($result2)) {
                        echo $tipo ." ". count($result2)."\n";
                        \Tresfera\TaketSystem\Models\Answer::
                                    where("question_categoria",$tipo)
                                    ->where("result_id",$result->result_id)
                                    ->limit(count($result2) - count($numRequired))
                                    ->delete();
                    }
                }
            }

               /* foreach($tipos as $tipo=>$numRequired) {

                    $result2 = \Tresfera\TaketSystem\Models\Answer::
                                    where("question_categoria",$tipo)
                                    ->where("result_id",$result->result_id)
                                    ->get();
                    $i = 0;
                    foreach($result2 as $answer) {
                        if(!isset($tipos[$tipo][$i])) continue;
                        $answer->question_title = $tipos[$tipo][$i];
                        $answer->save();
                        echo $answer->question_title."\n";
                        $i++;
                    }
                        
                }*/
                

            //}
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
