<?php

namespace Tresfera\Taketsystem\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Tresfera\Taketsystem\Models\Slide;
use BackendAuth;
use Request;
use DB;
use Tresfera\Taketsystem\Models\Quiz;
use Tresfera\Taketsystem\Models\Question;
use Tresfera\Statistics\Models\Result;
use Tresfera\Taketsystem\Models\Answer;
use Carbon\Carbon;
use Tresfera\Devices\Models\Device;

/**
 * Quizzes Back-end Controller.
 */
class QuizzesMulti extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $bodyClass = 'compact-container';

    public function __construct()
    {
        parent::__construct();
        
        $this->addCss('/plugins/tresfera/taketsystem/assets/css/taket.css');
        $this->addCss('/plugins/tresfera/taketsystem/assets/tutorialize/css/tutorialize.css');
        $this->addJs('/plugins/tresfera/taketsystem/assets/tutorialize/js/jquery.tutorialize.min.js');
        
        BackendMenu::setContext('Tresfera.Taketsystem', 'taketsystem', 'quizzes');
    }

    /*
    |--------------------------------------------------------------------------
    | Slides
    |--------------------------------------------------------------------------
    */

}
