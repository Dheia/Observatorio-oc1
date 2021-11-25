<?php namespace Tresfera\Taketsystem\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Tresfera\Taketsystem\Components\Informe;
use RainLab\User\Models\User;
use Renatio\DynamicPDF\Classes\PDF;

class InformesCofidis extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'taketsystem:informescofidis';

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
            $data = Informe::getData($user,"competencia1");
            echo $user->name." - ";
            $file = base_path("/informes/"."cofidis_competencia1_".str_slug($user->name).".pdf");
            $url = url("/informes/"."cofidis_competencia1_".str_slug($user->name).".pdf");
            PDF::loadTemplate('cofidis-competencia1',$data)
                ->setOptions(['isRemoteEnabled' => true,'dpi' => 300])
                ->save($file);
            echo $url."\n";
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
