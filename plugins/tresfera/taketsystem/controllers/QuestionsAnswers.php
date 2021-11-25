<?php namespace Tresfera\Taketsystem\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Questions Answers Back-end Controller
 */
class QuestionsAnswers extends Controller
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

        BackendMenu::setContext('Tresfera.Taketsystem', 'taketsystem', 'questionsanswers');
    }
}