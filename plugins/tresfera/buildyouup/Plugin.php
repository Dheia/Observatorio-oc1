<?php namespace Tresfera\Buildyouup;

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
     /* return [
          'printpartial' => function($args = [ ]) {

            foreach( $args as $key => $arg ) {
                  $vars[$key] = $arg;
              }
              $file = $vars['file'];
              $partal = 'tresfera/buildyouup/controllers/evaluaciones/partials/' .  $file . '.htm';
              return Twig::parse($partial, $vars);
          },
      ]; */
    }

    public function registerSchedule($schedule)
    {
       /* $schedule->command('buildyouup:sendevaluadoresavisos')->dailyAt('8:00');	
        $schedule->command('buildyouup:sendinformesproyectos')->dailyAt('00:00');*/	
    }

    public function register()
    {
       /* $this->registerConsoleCommand('buildyouup.sendevaluadores', 'Tresfera\Buildyouup\Console\SendEvaluadores');
        $this->registerConsoleCommand('buildyouup.sendevaluadoresavisos', 'Tresfera\Buildyouup\Console\SendEvaluadoresAvisos');
        $this->registerConsoleCommand('buildyouup.sendevaluadoresnotcompleted', 'Tresfera\Buildyouup\Console\SendEvaluadoresNotCompleted');
        $this->registerConsoleCommand('buildyouup.fixs', 'Tresfera\Buildyouup\Console\Fixs');
        $this->registerConsoleCommand('buildyouup.actualizaestadoevaluaciones', 'Tresfera\Buildyouup\Console\ActualizaEstadoEquipos');
        $this->registerConsoleCommand('buildyouup.sendinformesproyectos', 'Tresfera\Buildyouup\Console\SendInformesProyectos');
        $this->registerConsoleCommand('buildyouup.pruebas', 'Tresfera\Buildyouup\Console\Pruebas');
       // require __DIR__.'/vendor/autoload.php';
       */
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
                if(!is_array($value)) return;
                foreach($value as $row) {
                  foreach($row as $column => $val) {
                    if(!is_array($val))
                      $return[$column] = $val;
                  }
                }
              } else
                $return[] = "No hay";
              
              if(is_array($return))
              return implode("<br>",$return);

              return "No hay";
            }
        ];
    }

    public function evalUppercaseListColumn($value, $column, $record)
    {
        return strtoupper($value);
    }
}
