<?php

namespace Tresfera\Taketsystem\Models;

use Model;
use DB;
use BackendAuth;
use Tresfera\Taketsystem\Models;

/**
 * QuizType Model.
 */
class Section extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_sections';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['*'];
	
    /**
     * Has Many relations.
     *
     * @var array
     */
    public $belongsTo = [
        'sector'     => ['Tresfera\Taketsystem\Models\Sector']
        ];
    public $hasMany = [
        'questions'  => ['Tresfera\Taketsystem\Models\Question'],
    ];
    
	public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];	
    public $translatable = ['title', 'title2'];	
    
    /**
     * @var array Cache for nameList() method
     */
    protected static $nameList = null;
    public static function getNameList()
    {
	    $user = BackendAuth::getUser();
	    $client = Client::find($user->client_id);
	    if(isset($client))
        	return self::where("sector_id", "=", $client->sector_id)->lists('title', 'id');
        else
        	return self::lists('title', 'id');
    }
    
    function beforeSave() {
		$this->title = post('RLTranslate')['ES']['title'];
		$this->title2 = post('RLTranslate')['ES']['title2'];		
		
		/*if(isset(post('RLTranslate')))
		foreach(post('RLTranslate') as $code=>$value) {
			$slideQuestionAnswer->setTranslateAttribute( 'title', $value['title'], $code );
		}*/
		
	}
	public function getTitle($lang='ES') {
		$return = $this->getTranslateAttribute('title2',$lang);
		if(!$return) $return = $this->getTranslateAttribute('title',$lang);
		
		return $return;
	}
   /* public static function formSelect($name, $countryId = null, $selectedValue = null, $options = [])
    {
        return Form::select($name, self::getNameList($countryId), $selectedValue, $options);
    }*/
}
