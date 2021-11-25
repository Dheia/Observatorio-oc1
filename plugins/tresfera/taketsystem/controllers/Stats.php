<?php

namespace Tresfera\Taketsystem\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Flash;
use Backend;
use Redirect;
use DB;
use Session;

/**
 * Stats Back-end Controller.
 */
class Stats extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Tresfera.Taketsystem', 'taketsystem', 'stats');
    }

    public function index()
	{
	    //
	    // Do any custom code here
	    //
		
	    // Call the ListController behavior index() method
	    $this->asExtension('ListController')->index();
	}
	
	public function getGroupBy() {
		// manipule session
		$numSession = "Taket.stats";
		
	    if(post('group_by')) {
		     Session::put($numSession, post('group_by'));
	    }
	    
	    $groupBy = Session::get($numSession);
	    if($groupBy == null) 
	    	$groupBy = 'device_id';
	    	
	    return $groupBy;
	}
	
	public function listExtendColumns($list)
    {			  
	   
	   $groupBy = $this->getGroupBy(); 
			    
		
	    $select = "name";
	    switch($groupBy) {
		    case 'device_id':
			    $list->removeColumn("question_title");
			    $list->removeColumn("shop_id");
			    $list->removeColumn("quiz_id");
		    break;
		    case 'city_id':
			    $list->removeColumn("device_id");
			    $list->removeColumn("question_title");
			    $list->removeColumn("shop_id");
			    $list->removeColumn("quiz_id");
		    break;
		    case 'region_id':
			    $list->removeColumn("device_id");
			    $list->removeColumn("city_id");
			    $list->removeColumn("shop_id");
			    $list->removeColumn("question_title");
			    $list->removeColumn("quiz_id");
		    break;
		    case 'shop_id':
			    $list->removeColumn("device_id");
			    $list->removeColumn("quiz_id");
			    $list->removeColumn("question_title");
		    break;
		    case 'question_title':
			    $list->removeColumn("region_id");
			    $list->removeColumn("quiz_id");
			    $list->removeColumn("result_id");
			    $list->removeColumn("device_id");
			    $list->removeColumn("city_id");
			    $list->removeColumn("shop_id");
		    break;
		    case 'quiz_id':
		    	$list->removeColumn("question_title");
		    	$list->removeColumn("device_id");
			    $list->removeColumn("city_id");
			    $list->removeColumn("shop_id");
			    $list->removeColumn("region_id");
		    break;
	    }
		
		
		/*$list->addColumns([
            $groupBy => [
                'label' => $label,
                'relation' => $relation,
                'select' => $select,
            ]
        ]);*/					
		
    }
	public function listExtendQuery($query, $scope)
	{
		$groupBy = $this->getGroupBy();
		
	    $query->join('tresfera_taketsystem_answers', 'tresfera_taketsystem_results.id', '=', 'tresfera_taketsystem_answers.result_id')
	    		->groupBy($groupBy);
	}
	public function onChangeDimension() {
		Stats::extendListColumns(function($list, $model) {

	        if (!$model instanceof MyModel)
	            return;
				
	        $this->listExtendColumns();
	
	    });
		
		return $this->listRefresh();
	}
}
