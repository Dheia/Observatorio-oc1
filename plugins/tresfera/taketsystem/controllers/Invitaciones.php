<?php namespace Tresfera\Taketsystem\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use BackendAuth;

/**
 * Invitaciones Back-end Controller
 */
class Invitaciones extends Controller
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

        BackendMenu::setContext('Tresfera.Taketsystem', 'taketsystem', 'invitaciones');
    }
    public function listExtendQuery($query)
	{
	    $user = BackendAuth::getUser();
	    if ($user->client_id) {
		   $query->where("client_id","=",$user->client_id); 
		}
	}
}