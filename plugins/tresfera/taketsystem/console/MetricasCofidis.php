<?php namespace Tresfera\Taketsystem\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use RainLab\User\Models\User;
use Tresfera\Taketsystem\Models\Timming;
use DB;
use Tresfera\Taketsystem\Models\Progreso;

class MetricasCofidis extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'taketsystem:metricascofidis';

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
        
        $users = User::all();
        foreach($users as $user) {
            $data = [];
            //Número de horas totales de conexión por competencia.
            for($i=1;$i<=5;$i++) {
                $data['conexion_competencia']['competencia'.$i] = Timming::where("page","/cofidis/app/competencia".$i)->sum("time") / 60;
            }
            //Número de personas conectadas por franja horaria, por competencia.
            for($i=1;$i<=5;$i++) {
                $data['franja_horaria_competencia']['competencia'.$i] = Timming::where("page","/cofidis/app/competencia".$i)
                                ->select(DB::raw('hour(created_at) as hora'), DB::raw('COUNT(id) as numero'))
                                ->groupBy(DB::raw('hour(created_at)'))->get()->toArray();
            }
            $data['franja_horaria'] = Timming::select(DB::raw('hour(created_at) as hora'), DB::raw('COUNT(id) as numero'))
                                ->groupBy(DB::raw('hour(created_at)'))->get()->toArray();
            //Número de personas que han finalizado la experiencia, por competencia.
            for($i=1;$i<=5;$i++) {
                $data['finalizado_competencia']['competencia'.$i] = count(Progreso::where("quiz","cofidis-competencia".$i)
                                ->where("pag","30")
                                ->groupBy("user_id")->get());
            }
            //Tiempo promedio entre el número de personas y el total de horas, para saber cuánto tiempo han estado haciendo la experiencia.
            for($i=1;$i<=5;$i++) {
                $list = Progreso::where("quiz","cofidis-competencia".$i)
                                ->where("pag","30")
                                ->groupBy("user_id")->lists("user_id","user_id");
                $data['promedo_tiempo_finish']['competencia'.$i] = Timming::whereIn("user_id",$list)->where("page","/cofidis/app/competencia".$i)->sum("time") / 60;

            }
            //Número de personas que han completado todos los retos por competencia, por día.
            for($i=1;$i<=5;$i++) {
                $data['finish_por dia']['competencia'.$i] = Progreso::select(DB::raw('DAY(created_at) as dia'),DB::raw('count(DISTINCT user_id) as usuarios'))->where("quiz","cofidis-competencia".$i)
                                                                            ->where("pag","30")
                                                                            ->groupBy(DB::raw('DAY(created_at)'))->get()->toArray();

            }
            dd($data);
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
