<?php namespace Tresfera\Organizaciones\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use BackendAuth;

class Empresas extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'organizaciones.manage' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Tresfera.Organizaciones', 'organizaciones', 'empresas');
    }
    public function listExtendQuery($query)
	{
        // Permisions
        $user = BackendAuth::getUser();

        // Permisions
        if (!$user->is_superuser) {
            return $query->where('client_id', $this->user->client->id);
        }
	}
}
