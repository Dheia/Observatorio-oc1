<?php namespace Tresfera\Talent;

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
              $partal = 'tresfera/talent/controllers/evaluaciones/partials/' .  $file . '.htm';
              return Twig::parse($partial, $vars);
          },
      ];*/
    }

    public function registerSchedule($schedule)
    {
        $schedule->command('talent:sendevaluadoresavisos')->dailyAt('8:00');	
        $schedule->command('talent:sendinformesproyectos')->dailyAt('00:00');	
    }

    public function register()
    {
      $this->registerConsoleCommand('talent.test', 'Tresfera\Talent\Console\Test');
      //require __DIR__.'/vendor/autoload.php';
    }
    public function registerListColumnTypes()
    {
        return [
            'buttons_evaluaciones' => function($value,$column,$model) {
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
            'repeaterx' => function($value) {
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
