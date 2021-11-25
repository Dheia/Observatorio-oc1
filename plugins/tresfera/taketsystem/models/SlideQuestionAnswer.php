<?php namespace Tresfera\Taketsystem\Models;

use Model;
use Tresfera\Taketsystem\Models\Sector;
use Tresfera\Taketsystem\Models\Section;

/**
 * question Model
 */
class SlideQuestionAnswer extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_slide_question_answers';

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
        'slidequestion'     => ['Tresfera\Taketsystem\Models\SlideQuestion'],
        'answer'     => ['Tresfera\Taketsystem\Models\Answer']
        ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

	public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];	
    public $translatable = ['title'];
	
	
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