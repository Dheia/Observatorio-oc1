<?php namespace Tresfera\Envios\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Tresfera\Envios\Models\Envio;
use Tresfera\Envios\Models\Dato;

class Enviar extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'envios:enviar';

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
        $this->output->writeln('Buscamos envios no procesados');
        $envios = Envio::has('datos', '<', 1)->has("import_file")->get();
        foreach($envios as $envio) {
            $this->output->writeln('Procesando envio: '.$envio);
            $envio->import();
        }
        $this->output->writeln('Buscamos envios');
        echo date('Y-m-d h:i:s');
        $envios = Envio::whereRaw(\DB::raw("send_at <= '".date('Y-m-d H:i:s')."'"))->get();
        foreach($envios as $envio) {
            $datos = Dato::where("envio_id",$envio->id)->where("enviado",0)->get();
            foreach($datos as $dato) {
                $this->output->writeln('Enviamos: '.$dato->email);
                $dato->runSend();
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
