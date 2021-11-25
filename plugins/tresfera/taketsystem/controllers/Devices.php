<?php namespace Tresfera\Taketsystem\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Devices Back-end Controller
 */
class Devices extends Controller
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

        BackendMenu::setContext('Tresfera.Taketsystem', 'taketsystem', 'devices');
    }
    
    //Funcion que nos permite filtrar el listado
    
    public function listExtendQuery($query, $definition = null){ 
	   // $user = BackendAuth::getUser(); 
		//$query->where('client_id', '=', 1); 
	}
    
}