<?php

namespace Tresfera\Taketsystem;

use Backend;
use System\Classes\PluginBase;
use Backend\Models\User as UserModel;

use SaurabhDhariwal\Revisionhistory\Classes\Diff as Diff;
use System\Models\Revision as Revision;
/**
 * Taketsystem Plugin Information File.
 */
class Plugin extends PluginBase
{
    /**
     * @var bool Determine if this plugin should have elevated privileges.
     */
    public $elevated = true;

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Taket System',
            'description' => 'Plan de negocio',
            'author'      => '3fera',
            'icon'        => 'icon-rocket',
        ];
    }

    /**
     * Boot event.
     */
    public function boot()
    {
        // User extension
        UserModel::extend(function ($model) {
            $model->hasMany['quizzes']  = ['Tresfera\Taketsystem\Models\Quiz'];
            $model->belongsTo['client'] = ['Tresfera\Taketsystem\Models\Client'];
        });
    
      /* Extetions for revision */
      Revision::extend(function($model){
        /* Revison can access to the login user */
        $model->belongsTo['user'] = ['Backend\Models\User'];
    
        /* Revision can use diff function */
        $model->addDynamicMethod('getDiff', function() use ($model){
          return Diff::toHTML(Diff::compare($model->old_value, $model->new_value));
        });
      });
    }
    /**
     * Load composer components.
     */
    public function register()
    {
        // Plugin's vendor packages
        $this->registerConsoleCommand('taket.reloadrequests', 'Tresfera\Taketsystem\Console\ReloadRequestsCommand');
        $this->registerConsoleCommand('taket.informescofidis', 'Tresfera\Taketsystem\Console\InformesCofidis');
        $this->registerConsoleCommand('taket.metricascofidis', 'Tresfera\Taketsystem\Console\MetricasCofidis');
        
        require __DIR__.'/vendor/autoload.php';
    }
    
    /**
     * Components.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Tresfera\Taketsystem\Components\Template' => 'taketsystemTemplate',
            'Tresfera\Taketsystem\Components\Progreso' => 'Progreso',
            'Tresfera\Taketsystem\Components\Rankings' => 'Rankings',
            'Tresfera\Taketsystem\Components\Timing' => 'Timing',
            'Tresfera\Taketsystem\Components\Informe' => 'Informe',
        ];
    }

    /**
     * Form Widgets registration.
     *
     * @return array
     */
    public function registerFormWidgets()
    {
        return [
            'Tresfera\Taketsystem\FormWidgets\SlideTemplateSelector' => [
                'label' => 'Slide Template selector',
                'code'  => 'slidetemplateselector',
            ],
            'Tresfera\Taketsystem\FormWidgets\QuizTemplateSelector' => [
                'label' => 'Quiz Template selector',
                'code'  => 'quiztempalteselector',
            ],
        ];
    }
    
    /**
     * Form Widgets registration.
     *
     * @return array
     */
    public function registerReportWidgets()
    {
        return [
            'Tresfera\Taketsystem\ReportWidgets\Welcome' => [
                'label' => 'Bienvenido a Taket',
                'context' => 'dashboard'
            ]
        ];
    }

    /**
     * Permisions.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'tresfera.taketsystem.acces_clients' => ['label' => 'Acceder a la gestión de clientes'],
            'tresfera.taketsystem.quizzes' => ['label' => 'Gestionar cuestionarios'],
        ];
    }

    /**
     * Returns navigation info.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'taketsystem' => [
                'label'       => 'Creator',
                'url'         => Backend::url('tresfera/taketsystem/quizzes'),
                'icon'        => 'icon-rocket',
                'order'       => 100,
                'permissions' => ['tresfera.taketsystem.quizzes'],

                'sideMenu'    => [
                    'quizzes' => [
                        'label'       => 'Encuestas',
                        'icon'        => 'icon-info',
                        'url'         => Backend::url('tresfera/taketsystem/quizzes'),
                        'permissions' => ['tresfera.taketsystem.quizzes'],
                    ],
                    'segmentaciones' => [
                        'label'       => 'Segmentaciones',
                        'icon'        => 'icon-question',
                        'url'         => Backend::url('tresfera/taketsystem/segmentaciones/'),
                        'permissions' => ['tresfera.taketsystem.quizzes'],
                    ],
                ],

            ],
        ];
    }
}
