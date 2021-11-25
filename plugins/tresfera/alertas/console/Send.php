<?php namespace Tresfera\Alertas\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Tresfera\Alertas\Models\Alerta;
use Tresfera\Envios\Models\Dato;

class Send extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'alertas:send';

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
        $this->info('Buscamos alertas de datos');
        foreach(Alerta::where("event","envios")->get() as $alerta) {
            try {
                $this->info($alerta->name." ".$alerta->num_dias);
                $this->info('Buscamos datos a enviar con las condiciones indicadas');
                $query = Dato::whereRaw(\DB::raw("DATE(enviar_at) = DATE((CURDATE() - INTERVAL ".($alerta->num_dias)." DAY))"));
                foreach($alerta->conditions as $condition) {
                    if($condition['status'] == "send") {
                        $this->info('Enviado: '.$condition['status_on']);
                        if($condition['status_on']) {
                            $query->whereNotNull("enviado_at");
                        } else {
                            $query->whereNull("enviado_at");
                        }
                    }
                    if($condition['status'] == "open") {
                        $this->info('Abierto: '.$condition['status_on']);
                        if($condition['status_on']) {
                            $query->whereNotNull("apertura_at");
                        } else {
                            $query->whereNull("apertura_at");
                        }
                    }
                    if($condition['status'] == "completed") {
                        $this->info('Completado: '.$condition['status_on']);
                        if($condition['status_on']) {
                            $query->whereNotNull("completado");
                        } else {
                            $query->whereNull("completado");
                        }
                    }
                }
                $datos_ok = $query->get();
                foreach($datos_ok as $dato) {
                    $this->info($dato->email);
                    $alerta->send($dato);
                }
            } catch(\Exception $ex) {
                trace_log("Error en el envio de alerta de 'Envios': ".$ex->getMessage());
                $this->error("Error en el envio de alerta de 'Envios': ".$ex->getMessage());
            }
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
