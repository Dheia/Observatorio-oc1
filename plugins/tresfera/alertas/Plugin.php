<?php namespace Tresfera\Alertas;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }
    public function registerSchedule($schedule)
    {
        $schedule->command('alertas:send')->dailyAt('10:00');	
    }

    public function register()
    {
      $this->registerConsoleCommand('alertas.send', 'Tresfera\Alertas\Console\Send');
      //require __DIR__.'/vendor/autoload.php';
    }
    public function registerSettings()
    {
    }
}
