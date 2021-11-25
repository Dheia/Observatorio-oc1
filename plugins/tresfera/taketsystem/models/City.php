<?php

namespace Tresfera\Taketsystem\Models;

use Model;

/**
 * City Model.
 */
class City extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_cities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'code', 'dc'];

    /**
     * Belongs To relations.
     *
     * @var array
     */
    public $belongsTo = [
        'region' => ['Tresfera\Taketsystem\Models\Region'],
    ];

    /**
     * Has Many relations.
     *
     * @var array
     */
    public $hasMany = [
        'shops' => ['Tresfera\Taketsystem\Models\Shop'],
    ];
}
