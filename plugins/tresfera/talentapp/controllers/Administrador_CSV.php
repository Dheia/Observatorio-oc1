<?php namespace Tresfera\Talentapp\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Administrador_CSV extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Tresfera\Talentapp\Controllers\ImportExportEvaluaciones',
    ];
    
    public $listConfig = 'config_list.yaml';
    public $importExportConfig = 'config_import_export.yaml';
    
    public function __construct()
    {
        parent::__construct();
    }
}
