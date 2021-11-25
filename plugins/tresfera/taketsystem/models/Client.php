<?php

namespace Tresfera\Taketsystem\Models;

use Model;

/**
 * Client Model.
 */
class Client extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_clients';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['name', 'max_devices'];

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
    public $hasMany = [
        'campaigns' => ['Tresfera\Taketsystem\Models\Campaign'],
        'quizzes'   => ['Tresfera\Taketsystem\Models\Quiz'],
        'users'     => ['Backend\Models\User'],
        'devices'   => ['Tresfera\Taketsystem\Models\Device'],
    ];
}
