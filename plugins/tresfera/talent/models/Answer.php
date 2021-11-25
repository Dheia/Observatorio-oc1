<?php

namespace Tresfera\Talent\Models;

use Model;
use DB;

/**
 * Answer Model.
 */
class Answer extends \Tresfera\Taketsystem\Models\Answer
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_talent_answers';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['value'];

    /**
     * Belongs To relations.
     *
     * @var array
     */
    public $belongsTo = [
        'result' => ['Tresfera\Talent\Models\Result'],
        'slide'  => ['Tresfera\Taketsystem\Models\Slide'],
    ];


}
