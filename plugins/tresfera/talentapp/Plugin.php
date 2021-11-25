<?php namespace Tresfera\Talentapp;

use System\Classes\PluginBase;
use Twig;

class Plugin extends PluginBase
{
 /*   public function onFilterUpdate() {
        return Redirect::refresh();
    }

    public function onFilter() {
        return Redirect::refresh();
    }
*/
    public function boot()
    {
        \Event::listen('backend.list.overrideColumnValue', function($list, $record, $column, $value) {
            return html_entity_decode($value, ENT_QUOTES, "utf-8");
        });
    }

    

    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }
    public function registerMarkupTags() {
      return [
          'printpartial' => function($args = [ ]) {

            foreach( $args as $key => $arg ) {
                  $vars[$key] = $arg;
              }
              $file = $vars['file'];
              $partal = 'tresfera/talentapp/controllers/evaluaciones/partials/' .  $file . '.htm';
              return Twig::parse($partial, $vars);
          },
      ];
    }

    public function registerSchedule($schedule)
    {
       /* $schedule->command('talentapp:sendevaluadoresavisos')->dailyAt('8:00');	
        $schedule->command('talentapp:sendinformesproyectos')->dailyAt('00:00');*/	
    }

    public function register()
    {
        $this->registerConsoleCommand('talentapp.sendevaluadores', 'Tresfera\TalentApp\Console\SendEvaluadores');
        $this->registerConsoleCommand('talentapp.sendevaluadoresavisos', 'Tresfera\TalentApp\Console\SendEvaluadoresAvisos');
        $this->registerConsoleCommand('talentapp.sendevaluadoresnotcompleted', 'Tresfera\TalentApp\Console\SendEvaluadoresNotCompleted');
        $this->registerConsoleCommand('talentapp.fixs', 'Tresfera\TalentApp\Console\Fixs');
        $this->registerConsoleCommand('talentapp.actualizaestadoevaluaciones', 'Tresfera\TalentApp\Console\ActualizaEstadoEvaluaciones');
        $this->registerConsoleCommand('talentapp.sendinformesproyectos', 'Tresfera\TalentApp\Console\SendInformesProyectos');
        $this->registerConsoleCommand('talentapp.pruebas', 'Tresfera\TalentApp\Console\Pruebas');
        require __DIR__.'/vendor/autoload.php';
    }
    public function registerListColumnTypes()
    {
        return [
            'buttons-evaluaciones' => function($value,$column,$model) {
              $return = '';
              if($model->estado == 1) {
                  $return .= '<button
                                  type="button"
                                  class="oc-icon-send-o btn-icon pull-left"
                                  data-request="onSend"
                                  data-request-data="id: '.$model->id.'"
                                  data-load-indicator="Enviando"
                                  data-request-confirm="Vamos a proceder al envío de esta evaluación. ¿Estás seguro?">
                              </button>';
              }

              return $return;
            },
            // Using an inline closure
            'repeater' => function($value) {
              if(count($value)) {
                $return = [];
                foreach($value as $row) {
                  foreach($row as $column => $val) {
                    $return[$column] = $val;
                  }
                }
              } else
                $return[] = "No hay";

              return implode("<br>",$return);
            }
        ];
    }

    public function evalUppercaseListColumn($value, $column, $record)
    {
        return strtoupper($value);
    }
}
