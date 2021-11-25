<?php namespace Tresfera\Taketsystem\Models;

use Model;
use RainLab\Translate\Models\Locale;

/**
 * question Model
 */
class QuestionAnswer extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_questions_answers';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['*'];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'question'     => ['Tresfera\Taketsystem\Models\Question'],
        ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

	public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];	
    public $translatable = ['title'];
	
	function beforeSave() {
		$this->title = post('RLTranslate')['ES']['title'];
		$this->type = post('QuestionAnswer')["type"];
		
		
		/*if(isset(post('RLTranslate')))
		foreach(post('RLTranslate') as $code=>$value) {
			$slideQuestionAnswer->setTranslateAttribute( 'title', $value['title'], $code );
		}*/
		
	}
	public function getCountTranslateAttribute() {
		$langs = Locale::listEnabled();
		$html = "";
		foreach($langs as $code => $lang) {
			if($code == "ES") continue;
			
			$class = "line-through";
			if(($this->getTranslateAttribute('title',$code)!="")) $class = "none";
			
			$html .= "<span style='display:block; text-decoration:".$class."'><b>".$code."</b>: ".$this->getTranslateAttribute('title',$code)."</span> ";
			 
		}
		return $html;
	}	
	function getTypeViewAttribute() {
		$html="";
		switch($this->type) {
			case '1':
				$html = 'Insatisfecho';
			break;
			case '2':
				$html = 'Neutro';
			break;
			case '3':
				$html = 'Satisfecho';
			break;
		}
		return $html;
	}
}