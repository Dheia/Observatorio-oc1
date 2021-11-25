<?php

namespace Tresfera\Taketsystem\Models;

use Model;
use RainLab\Translate\Models\Locale;

/**
 * Shop Model.
 */
class QuizMulti extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_quiz_multi';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['*'];
	public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];	
    public $translatable = ['title'];

    /**
     * @var array Rules
     */
    public $rules = [
        'name' => 'required',
    ];

    /**
     * Has Many relations.
     *
     * @var array
     */
    public $hasOne = [
        
    ];

    /**
     * Belongs To relations.
     *
     * @var array
     */
    public $belongsTo = [
        'slide'  => ['Tresfera\Taketsystem\Models\Slide'],
		'quizzes'  => ['Tresfera\Taketsystem\Models\Quiz', 'key' => 'quiz_id'],
     ];    

	public $attachOne = [ 'icon' => ['System\Models\File'] ];
}
