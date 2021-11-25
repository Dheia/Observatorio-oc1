<?php namespace Tresfera\Envios;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }
    public function register()
    {
        // Plugin's vendor packages
        $this->registerConsoleCommand('envios.enviar', 'Tresfera\Envios\Console\Enviar');
        
    }
    public function registerSchedule($schedule)
    {
        $schedule->command('envios:enviar')->everyMinute()->withoutOverlapping();
    }
    
    public function registerSettings()
    {
    }
}
