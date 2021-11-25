<?php

namespace Tresfera\Taketsystem\Models;

use Model;

/**
 * SlideType Model.
 */
class SlideType extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_slide_types';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['name', 'code'];

    /**
     * Has Many relations.
     *
     * @var array
     */
    public $hasMany = [
        'slides'  => ['Tresfera\Taketsystem\Models\Slide', 'key' => 'type_id'],
    ];
}
