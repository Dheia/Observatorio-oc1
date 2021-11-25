<?php namespace Tresfera\Alertas\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Alertas extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'alertas.acceso' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Tresfera.Alertas', 'alertas');
    }
}
