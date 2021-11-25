<?php namespace Tresfera\Envios\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Datos extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'envios:acceso' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Tresfera.Envios', 'envios', 'datos');
    }
}
