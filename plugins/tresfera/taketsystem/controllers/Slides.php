<?php

namespace Tresfera\Taketsystem\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Flash;
use Backend;
use Redirect;



use RainLab\Translate\Classes\EventRegistry;
use Event;

/**
 * Slides Back-end Controller.
 */
class Slides extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();

        $this->addCss('/plugins/tresfera/taketsystem/assets/css/taket.css');
        $this->addCss('/plugins/tresfera/taketsystem/assets/css/slides.css');
        BackendMenu::setContext('Tresfera.Taketsystem', 'taketsystem', 'slides');
    }

    //
    // Create
    //

    public function index_onCreateForm()
    {
        $this->asExtension('FormController')->create();

        return $this->makePartial('create_form');
    }

    public function index_onCreate()
    {
        return $this->asExtension('FormController')->create_onSave();
    }
	
	/*public function formAfterSave($model) {
		return Backend::redirect(('backend/tresfera/taketsystem/slides/update/'.$model->id."?incrust=1".get("incrust")));
	}*/
	
	public function create_onSave($context = null)
	{
	
	   // my code here
	   $redirect = $this->getClassExtension('Backend.Behaviors.FormController')->create_onSave();
	   
	   
	   return Redirect::to(($redirect->headers->get("location")."?new=1&incrust=".get("incrust").""));
	}
	
    /**
     * Add dynamic syntax fields.
     */
    /**
     * Add dynamic syntax fields.
     */
	public function formExtendFieldsBefore($host)
    {
        if (!in_array($host->getContext(), ['update'])) {
            return;
        }
        $fields = $host->model->getFormSyntaxFields();
		if (!is_array($fields)) {
            return;
		}
        $fff = $host->tabs;
        foreach($fields as $key=>$field) {
            $fff['fields'][$key] = $field;
            $fff['fields'][$key]['tab'] = isset($field['tab'])?$field['tab']:"General";
        }
		$host->tabs = $fff;
		

        //$host->addTabFields($fields);
       // $this->fireSystemEvent('backend.form.extendFieldsBefore', [$host]);
       
    }
    public function formExtendFields($host)
    {
        if (!in_array($host->getContext(), ['update'])) {
            return;
        }

       /* $fields = $host->model->getFormSyntaxFields();
        if (!is_array($fields)) {
            return;
        }

		foreach($fields as $i=>$fields) {
			$fields[$i]['tab'] = "General";
		}
        $host->addTabFields($fields);*/
        $fields = $host->fields;
        $tabFields = [];
        switch($host->model->page) {
	        	
	        case 'slides/sondeo':
	        	$fields["images_sondeos"] = [
					"label" => "Imágenes del sondeo",
					"type" => "fileupload",
					"commentAbove" => "Le recomendamos no añadir más de 4 imágenes",
		        ];
	        break;
          case 'slides/segmentacion_custom':
	        	$fields["segmentacion"] = [
				        "type" => "dropdown",
				        "label" => "Segmentación",
		        ];
	        break;
	        case 'slides/multiquiz':
	        	$fields["images_sondeos"] = [
				        "type" => "partial",
				        "path" => "$/tresfera/taketsystem/controllers/slides/_list_quizzes.htm",
			        
		        ];
	        break;
	        
	        case 'slides/sondeo2':
	        	$fields['images_sondeos'] = [
			        "images_sondeos" => [
				        "type" => "partial",
				        "path" => "$/tresfera/taketsystem/controllers/slides/_list_quizzes.htm",
			        ]
		        ];
	        break;
        }
		//dd($fields);

		/*$tabFields["code"] = [
			"type" => "codeeditor",
			"size" => "huge",
			"language" => "html",
			"tab" => "Código"
		];*/
		$host->addTabFields($tabFields);
		$host->addFields($fields);

    }
}
