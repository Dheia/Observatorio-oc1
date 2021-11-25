<?php namespace Tresfera\Flex360\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Proyectos extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Tresfera.Flex360', 'flex360');
    }
}
