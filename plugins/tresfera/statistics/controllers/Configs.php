<?php namespace Tresfera\Statistics\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Backend\Models\User;
use Tresfera\Clients\Models\Client;
use BackendAuth;
use Tresfera\Statistics\Models\Config;
/**
 * Configs Back-end Controller
 */
class Configs extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();
		
		$this->addCss('/plugins/tresfera/taketsystem/assets/css/taket.css');
		
        BackendMenu::setContext('October.System', 'system', 'settings');
        //SettingsManager::setContext('Tresfera.Statistics', 'config.informes');
    }
    public function index()
	{
	    //
	    // Do any custom code here
        //
        
        $config = Config::find(1);
        if(!isset($config->id)) {
            $config = new Config();
            $config->id = 1;
            $config->save();
        }

        return redirect(url('backend/tresfera/statistics/configs/update/1'));
	    
	}
}