<?php 
	
namespace Tresfera\Statistics;

use Backend;
use System\Classes\PluginBase;
use Backend\Models\User as UserModel;
use BackendMenu;
use BackendAuth;

/**
 * statistics Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
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
            'name'        => 'Estadísticas',
            'description' => 'No description provided yet...',
            'author'      => 'tresfera',
            'icon'        => 'icon-chart'
        ];
    }
	
	public function boot()
    {
       // BackendMenu::registerContextSidenavPartial('Tresfera.Statistics', 'statistics', 'sidebar');
       // BackendMenu::registerContextSidenavPartial('Tresfera.Datos', 'datos', 'sidebar');
    }
	public function registerSchedule($schedule)
    {
	    //Informe semanal
        $schedule->command('taket:generaterapports', ['period' => 'weekly'])->weekly()->mondays()->at('11:00');
	    //Informe quinzenal
        $schedule->command('taket:generaterapports', ['period' => 'fortnightly'])->daily()->at('11:00')->when(function () {
		    if(date("j") == 16 || date("j") == 1)
		    	return true;
		    else 
		        return false;
		});
	    //Informe mensual
        $schedule->command('taket:generaterapports', ['period' => 'monthly'])->daily()->at('11:00')->when(function () {
		    if(date("j") == 1)
		    	return true;
		    else 
		        return false;
		});
    }
	public function register()
    {
        $this->registerConsoleCommand('taket.generaterapports', 'Tresfera\Statistics\Console\GenerateRapportsCommand');
        $this->registerConsoleCommand('taket.testing', 'Tresfera\Statistics\Console\Testing');

        // Plugin's vendor packages
        require __DIR__.'/../taketsystem/vendor/autoload.php';
    }
	/**
     * Register PDF templates in CMS settings
     *
     * @return array
     */
    public function registerSettings()
    {
        return [
            'config.informes' => [
                'label'       => 'Configuración básica',
                'description' => 'Colores',
                'category'    => 'Estadísticas',
                'icon'        => 'icon-files-o',
                'url'         => Backend::url('tresfera/statistics/configs'),
                'order'       => 500,
                'keywords'    => 'informe',
                'permissions' => ['tresfera.statistics.informes'],
            ]
        ];
    }	
     /**
     * Register permissions
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'tresfera.statistics.informes' => [
                'tab'   => 'Taket',
                'label' => 'Configuración de informes periódicos'
            ],
            'tresfera.statistics.alerts' => [
                'tab'   => 'Taket',
                'label' => 'Configuración de alertas operativas'
            ],
        ];
    }
	/**
     * Returns navigation info.
     *
     * @return array
     */
    public function registerNavigation()
    {
	    $user = BackendAuth::getUser();
	    $client = $user->client;
	    
	    $num_shops = null;

	    if(isset($client->shops) != false) {
		    $num_shops = $client->shops->count();
	    }
	    
	    $menu = [
           /* 'rapportsperiod' => [
                'label'       => 'Informes',
                'url'         => Backend::url('tresfera/statistics/rapportsperiod/'),
                'icon'        => 'icon-list-ol',
                'order'       => 494,
								
            ],*/
            'statistics' => [
                'label'       => 'Estadísticas',
                'url'         => Backend::url('tresfera/statistics/stats/dashboard'),
                'icon'        => 'icon-area-chart',
                'order'       => 493,

                'sideMenu'    => [
                    /* 'stats_dashboard' => [
                        'label'       => 'Visión global',
                        'icon'        => 'icon-dashboard',
                        'url'         => Backend::url('tresfera/statistics/stats/dashboard'),
                        'group'		  => 'Análisis',
                        'description' => ''
                    ],
                     'stats_ciudad' => [
                        'label'       => 'Estadístiques por zonas',
                        'icon'        => 'icon-sitemap',
                        'url'         => Backend::url('tresfera/statistics/stats/?group_by=citycp_name'),
                        'group'		  => 'Análisis',
                        'description' => ''
                    ],
                    'stats_tienda' => [
                        'label'       => 'Estadístiques por puntos de venta',
                        'icon'        => 'icon-sitemap',
                        'url'         => Backend::url('tresfera/statistics/stats/?group_by=shop_id'),
                        'group'		  => 'Análisis',
                        'description' => ''
                    ],
                    'stats_contenido' => [
                        'label'       => 'Estadístiques por preguntas',
                        'icon'        => 'icon-line-chart',
                        'url'         => Backend::url('tresfera/statistics/stats/?group_by=question_title'),
                        'group'		  => 'Análisis',
                        'description' => ''
                    ],
                    'stats_quizzes' => [
                        'label'       => 'Estadístiques por cuestionarios',
                        'icon'        => 'icon-line-chart',
                        'url'         => Backend::url('tresfera/statistics/stats/?group_by=quiz_id'),
                        'group'		  => 'Análisis',
                        'description' => ''
                    ],
                    'stats_comparativas' => [
                        'label'       => 'Comparativas de métricas',
                        'icon'        => 'icon-area-chart',
                        'url'         => Backend::url('tresfera/statistics/stats/comparativas/'),
                        'group'		  => 'Comparativas',
                        'description' => ''
                    ],
                    'stats_ranking' => [
                        'label'       => 'Ranking de puntos de venta',
                        'icon'        => 'icon-bar-chart',
                        'url'         => Backend::url('tresfera/statistics/stats/ranking/'),
                        'group'		  => 'Comparativas',
                        'description' => ''
                    ],
                    'stats_comments' => [
                        'label'       => 'Comentarios',
                        'icon'        => 'oc-icon-comment',
                        'url'         => Backend::url('tresfera/statistics/stats/?group_by=free'),
                        'group'		  => 'Comentarios',
                        'description' => ''
                    ],*/
              ],
            ]
        ];
	    if($num_shops == 1) {
		    unset($menu['statistics']['sideMenu']['stats_tienda']);
	    }
        return $menu; 
    }
}
