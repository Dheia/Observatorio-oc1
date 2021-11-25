<?php

namespace Tresfera\Taketsystem\Models;

use Model;

/**
 * Region Model.
 */
class Region extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_regions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Has Many relations.
     *
     * @var array
     */
    public $hasMany = [
        'cities'    => ['Tresfera\Taketsystem\Models\City'],
    ];
}
