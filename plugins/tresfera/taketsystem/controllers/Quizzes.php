<?php

namespace Tresfera\Taketsystem\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Tresfera\Taketsystem\Models\Slide;
use Tresfera\Taketsystem\Models\Quiz;

/**
 * Quizzes Back-end Controller.
 */
class Quizzes extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
      //  'DamianLewis.SortableRelations.Behaviors.SortableRelations'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';
  //  public $sortableRelationConfig = 'config_sortable_relation.yaml';

    public $bodyClass = 'compact-container';

    public function onDuplicate(){

        foreach (post("checked") as $value) {
          $quiz = Quiz::find($value);
          $newQuiz = $quiz->replicate();
          $newQuiz->type = "replicate";
          $newQuiz->save();
          if ($slides = $quiz->slides) {
              //primero borramos todos los slides
              foreach($newQuiz->slides as $slide) {
                $slide->delete();
              }
              foreach ($slides as $slide) {
                  //$slide->load('questions.options');
                  $newSlide = $slide->replicate();
                  //$newSlide->dont_rebuild = 1;
                  $newSlide->quiz()->associate($newQuiz);
                  $newSlide->save();
  
                  //duplicamos las preguntas y respuestas modificadas si las hubiera
                  /*$slideQuestions = \Tresfera\Taketsystem\Models\SlideQuestion::where("slide_id",$slide->id)->get();
                  foreach($slideQuestions as $slideQuestion) {
                    $newSlideQuestion = $slideQuestion->replicate();
                    $newSlideQuestion->slide_id = $newSlide->id;
                    $newSlideQuestion->save();
                    $slideQuestionsAnswers = \Tresfera\Taketsystem\Models\SlideQuestionAnswer::where("slidequestion_id",$slideQuestion->id)->get();
                    foreach($slideQuestionsAnswers as $slideQuestionsAnswer) {
                      $newSlideQuestionAnswer = $slideQuestionsAnswer->replicate();
                      $newSlideQuestionAnswer->slidequestion_id = $newSlideQuestion->id;
                      $newSlideQuestionAnswer->save();
                    }
                  }*/
                  if($slide->page == "slides/segmentacion" || $slide->page == "slides/informacion") {
                    $syntax_data = [];
                    if(!is_array($newQuiz->options))
                      continue;
                    foreach($slide->getSyntaxData() as $option=>$value) {
                        if(in_array($option, $newQuiz->options))
                          $syntax_data[$option] = 1;
                        else
                          $syntax_data[$option] = 0;
                    }
                    $newSlide->syntax_data = $syntax_data;
                  }
                  if($slide->page == "slides/sondeo") {
                    if($newQuiz->sondeo == 0)
                      continue;
                  }
                  if($slide->page == "slides/sondeo2" || $slide->page == "slides/multiquiz") {
                    //replicamos las respuestas de los sondeos
                    $quizMultis = \Tresfera\Taketsystem\Models\QuizMulti::where("slide_id",$slide->id)->get();
                    foreach($quizMultis as $quizMulti) {
                      $newQuizMultis = $quizMulti->replicate();
                      $newQuizMultis->slide_id = $newSlide->id;
                      $newQuizMultis->save();
                    }
                  }
                  $newSlide->save();
              }
          }
        }
        return $this->listRefresh();
  
     }
    public function relationExtendViewWidget($widget, $field, $model)
    {               
        // Make sure the model and field matches those you want to manipulate
        if (!$model instanceof \Tresfera\Taketsystem\Models\Quiz || $field != 'slides')
            return;
    
        // Will not work!
      //  $widget->removeColumn('my_column');
    
       

        // This will work
        $widget->bindEvent('form.ExtendFields', function ($host) use($widget) {
            if (!in_array($host->getContext(), ['update'])) {
                return;
            }
    
            $fields = $host->model->getFormSyntaxFields();
            if (!is_array($fields)) {
                return;
            }
    
            $host->addFields($fields);
        });
    }

    public function __construct()
    {
        parent::__construct();

        $this->addCss('/plugins/tresfera/taketsystem/assets/css/quiz.css');
        $this->addCss('/plugins/tresfera/taketsystem/assets/css/taket.css');

        BackendMenu::setContext('Tresfera.Taketsystem', 'taketsystem', 'quizzes');
    }

    /*
    |--------------------------------------------------------------------------
    | Slides
    |--------------------------------------------------------------------------
    */

    /**
     * Add dynamic syntax fields.
     */
    public function formExtendFields($host)
    {
        $fields = null;

        /*if(post('_relation_field') == 'slides') {
            if(!empty(post('manage_id'))) {
                $model = Slide::find(post('manage_id'))->first();
                $fields = $model->getFormSyntaxFields();
            }
            else
                $fields = Slide::getFormSyntaxFields();

        }*/
        //$fields = $host->model->getFormSyntaxFields();

        if (!in_array($host->getContext(), ['update'])) {
            return;
        }
        //Generate tabs with slides
        if ($slides = $host->model->slides) {

            foreach ($slides as $slide) {
                $fields['slide.'.$slide->id] = [
                    'tab'    => $slide->name,
                    'type'    => 'partial',
                    'path'    => '$/tresfera/taketsystem/controllers/quizzes/_show_slide.htm',
                    'stretch'    => 'true',
                    'span'    => 'full',
                ];
            }
        }
       /* $fields['slide.new'] = [
            'tab'    => 'Nueva página',
            'type'    => 'partial',
            'path'    => '$/tresfera/taketsystem/controllers/quizzes/_create_slide.htm',
            'stretch'    => 'true',
            'span'    => 'full',
        ];
        */
         $tab['slides'] = [
            'tab'    => 'Pantallas',
            'type'    => 'partial',
            'path'    => '$/tresfera/taketsystem/controllers/quizzes/_none.htm',
            'stretch'    => 'true',
            'span'    => 'full',
        ];
        if(is_array($fields)) {
	        $host->addTabFields($tab);
	        $host->addSecondaryTabFields($fields);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    */


    /**
     * Form query extension.
     * Force Clients to edit only their Client Quizzes.
     *
     * @param object $query
     *
     * @return object
     */
    public function formExtendQuery($query)
    {
        // Permisions
        if (!$this->user->hasAccess('tresfera.taketsystem.acces_clients')) {
          if(isset($this->user->client->id))
            return $query->where('client_id', $this->user->client->id);
        }
    }

    /**
     * Remove list columns.
     * Delete Client column on Quizzes list.
     *
     * @param List $list
     */
    public function listExtendColumns($list)
    {
        // Permisions
        if (!$this->user->hasAccess('tresfera.taketsystem.acces_clients')) {
            $list->removeColumn('client');
        }
    }
}
