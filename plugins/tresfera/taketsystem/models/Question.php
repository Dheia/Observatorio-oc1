<?php namespace Tresfera\Taketsystem\Models;

use Model;
use Tresfera\Taketsystem\Models\Sector;
use Tresfera\Taketsystem\Models\Section;
use Tresfera\Taketsystem\Models\SlideQuestionAnswer;
use RainLab\Translate\Models\Locale;

/**
 * question Model
 */
class Question extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_questions';

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
    public $hasMany = [
	    'answers'     => ['Tresfera\Taketsystem\Models\QuestionAnswer', 'order' => 'type']
		];
    public $belongsTo = [
      'section'     => ['Tresfera\Taketsystem\Models\Section'],
      'sector'     => ['Tresfera\Taketsystem\Models\Sector']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

	public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];
    public $translatable = ['title'];

	protected static $nameList = null;

	public function getId() {
		return $this->id;
	}
	public function getMaxAnswers() {

		return $this->num_answers;
	}
	public function getAnswers($slide_id, $field_id, $question_id=null) {

	    $answers = $this->answers()->orderBy('order','ASC')->get();



		foreach($answers as $answer) {

			//echo $slide_id . " " . $field_id . " " . $answer->id."\n";
			$slideQuestionAnswer = SlideQuestionAnswer::where("slide_id", "=", $slide_id)
	    							->where("field_id", "=", $field_id)
	    							->where("answer_id", "=", $answer->id)
	    							->where("slidequestion_id", "=", $this->id)->first();

	    	if(isset($slideQuestionAnswer->id)) {
		    	$answer->title = $slideQuestionAnswer->title;
		    	$answer->type = $slideQuestionAnswer->type;
	    	}

		}

	    return $answers;
	}

	public static function getNameList($section_id = null, $type = "question")
    {
	    if($type != "question")
	    	return self::where('type','=',$type)->lists('title', 'id');
	    if(!$section_id)
        	return self::all()->lists('title', 'id');
		else
			return self::where('section_id','=',$section_id)->orderBy('num_answers','DESC')->lists('title', 'id');
    }

	public function getSectorIdOptions()
	{
		$result = Sector::all()->lists('title', 'id');

	    return $result;
	}
	public function getSectionIdOptions($section_id = null)
	{

		if(!isset(post("Question")['sector_id'])) {
			$sector_id = $this->sector_id;
		} else {
			$sector_id = post("Question")['sector_id'];
		}

		if(!isset($sector_id))
			return Section::where('sector_id','=',1)->lists('title', 'id');
		else
			return  Section::where('sector_id','=',$sector_id)->lists('title', 'id');

	}

	public function getCountAnswersAttribute() {
		return $this->answers()->count();
	}
	public function getCountTranslateAttribute() {
		$langs = Locale::listEnabled();
		$html = "";
		foreach($langs as $code => $lang) {
			if($code == "ES") continue;

			$class = "line-through";
			if(($this->getTranslateAttribute('title',$code))) $class = "none";

			$html .= "<span style='display:block; text-decoration:".$class."'><b>".$code."</b>: ".$this->getTranslateAttribute('title',$code)."</span> ";

		}
		return $html;
	}
}
