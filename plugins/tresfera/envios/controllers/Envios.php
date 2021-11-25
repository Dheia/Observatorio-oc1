<?php namespace Tresfera\Envios\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Envios extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',     'Backend.Behaviors.RelationController',   'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';
    
    public $requiredPermissions = [
        'envios:acceso' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Tresfera.Envios', 'envios');
    }
}
