<?php namespace Tresfera\Statistics\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Backend\Models\User;
use Tresfera\Clients\Models\Client;
use Tresfera\Statistics\Models\Alert;
use BackendAuth;

/**
 * Alerts Back-end Controller
 */
class Alerts extends Controller
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
    }
      public function index()
	{
	    //
	    // Do any custom code here
	    //
	    $this->bodyClass = 'compact-container';
		$user = BackendAuth::getUser();
	    if(isset($user))
        if ($user->client_id) {
            $client = Client::find($user->client_id);
            //si tiene config vamos a updatearlo
            if(!isset($client->alerts->id)) {
	            return redirect(url('backend/tresfera/statistics/alerts/create'));
				
            } else {
	            return redirect(url('backend/tresfera/statistics/alerts/update/'.$client->alerts->id));
            }
            exit;
        } else {
	        // Call the ListController behavior index() method
			$this->asExtension('ListController')->index();
        }
	    
	}
}