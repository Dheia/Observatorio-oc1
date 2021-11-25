<?php

namespace Tresfera\Taketsystem\Models;

use Model;

/**
 * QuestionType Model.
 */
class QuestionType extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_question_types';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['name'];

    /**
     * Has Many relations.
     *
     * @var array
     */
    public $hasMany = [
        'questions'  => ['Tresfera\Taketsystem\Models\Question', 'key' => 'type_id'],
    ];
}
