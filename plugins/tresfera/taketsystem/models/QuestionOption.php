<?php

namespace Tresfera\Taketsystem\Models;

use Model;

/**
 * QuestionOption Model.
 */
class QuestionOption extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_question_options';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['label'];

    /**
     * Belongs To relations.
     *
     * @var array
     */
    public $belongsTo = [
        'question'  => ['Tresfera\Taketsystem\Models\Question'],
    ];
}
