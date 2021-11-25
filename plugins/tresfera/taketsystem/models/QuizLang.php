<?php

namespace Tresfera\Taketsystem\Models;

use Model;

/**
 * QuizType Model.
 */
class QuizLang extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_quiz_types';

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
        'quizzes'  => ['Tresfera\Taketsystem\Models\Quiz', 'key' => 'type_id'],
    ];
}
