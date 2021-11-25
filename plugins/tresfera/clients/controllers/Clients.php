<?php

namespace Tresfera\Clients\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Clients Back-end Controller.
 */
class Clients extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $requiredPermissions = ['tresfera.taketsystem.acces_clients'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Tresfera.Clients', 'clients', 'clients');
    }
}
