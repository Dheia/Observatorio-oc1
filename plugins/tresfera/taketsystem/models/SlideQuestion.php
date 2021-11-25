<?php namespace Tresfera\Taketsystem\Models;

use Model;
use Tresfera\Taketsystem\Models\Sector;
use Tresfera\Taketsystem\Models\Section;

/**
 * question Model
 */
class SlideQuestion extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_slidesquestions';

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
        'slide'     => ['Tresfera\Taketsystem\Models\Slide']
        ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

	public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];	
    public $translatable = ['title'];
	
	public function getId() {
		return $this->question->id;
	}
	public function getMaxAnswers() {
		return $this->question->num_answers;
	}
	public function getAnswers() {
		$slideQuestionAnswer = $this->question->getAnswers($this->slide_id, $this->field_id, $this->question_id);
		
	    return $slideQuestionAnswer;
	}
	
	public function getSectorIdOptions()
	{	
		$result = Sector::all()->lists('title', 'id');
		
	    return $result;
	}
	
	public function getSectionIdOptions()
	{	
		if(!isset(post("Question")['sector_id']))
			return Section::where('sector_id','=',1)->lists('title', 'id');
		else	
			return  Section::where('sector_id','=',post("Question")['sector_id'])->lists('title', 'id');
		
	}
}