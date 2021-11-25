<?php 
	
namespace Tresfera\Datos;

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
            'name'        => 'Datos',
            'description' => 'No description provided yet...',
            'author'      => 'tresfera',
            'icon'        => 'icon-line-chart'
        ];
    }
	
	public function boot()
    {
       // BackendMenu::registerContextSidenavPartial('Tresfera.Datos', 'datos', '@/plugins/tresfera/taketsystem/partials/_sidebar.htm');
    }
	public function registerSchedule($schedule)
    {
	  
    }
	public function register()
    {
    
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
      
    }	
     /**
     * Register permissions
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'tresfera.datos.datos' => [
                'tab'   => 'Datos',
                'label' => 'Menú de tratamiento de datos'
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
	    
	    $menu = [
            'datos' => [
                    'label'       => 'Datos',
                    'url'         => Backend::url('tresfera/datos/datos/dashboard'),
                    'icon'        => 'icon-th',
                    'order'       => 494,
                    'sideMenu'    => [
                        'datos' => [
                            'label'       => 'Listado',
                            'icon'        => 'icon-bars',
                            'url'         => Backend::url('tresfera/datos/datos/dashboard'),
                            'group'		  => 'Análisis',
                            'description' => ''
                        ],
                        'cloud' => [
                            'label'       => 'Nube de palabras',
                            'icon'        => 'icon-cloud',
                            'url'         => Backend::url('tresfera/datos/datos/cloud'),
                            'group'		  => 'Análisis',
                            'description' => ''
                        ],
                        'datos-csv' => [
                            'label'       => 'Descargar CSV',
                            'icon'        => 'icon-file-excel-o',
                            'url'         => Backend::url('tresfera/datos/datos/csv'),
                            'group'		  => 'Análisis',
                            'description' => ''
                        ],

                    ],
                ],
        ];
        return $menu; 
    }
}
