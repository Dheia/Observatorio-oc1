<?php namespace Tresfera\Organizaciones\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use BackendAuth;

class Departamentos extends Controller
{
    public $implement = [        
        'Backend\Behaviors\ListController',             
        'Backend.Behaviors.RelationController',
        'Backend\Behaviors\FormController',
        'Backend.Behaviors.ReorderController',
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';
    public $reorderConfig = 'config_reorder.yaml';
    
    public $requiredPermissions = [
        'organizaciones.manage' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Tresfera.Organizaciones', 'organizaciones', 'departamentos');
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
