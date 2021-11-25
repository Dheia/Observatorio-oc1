<?php

namespace Tresfera\Taketsystem\Models;

use Model;

/**
 * Shop Model.
 */
class Shop extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_shops';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['name', 'postcode', 'address'];

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
        'devices'  => ['Tresfera\Taketsystem\Models\Device'],
    ];

    /**
     * Belongs To relations.
     *
     * @var array
     */
    public $belongsTo = [
        'client' => ['Tresfera\Taketsystem\Models\Client'],
        'city'   => ['Tresfera\Taketsystem\Models\City'],
    ];

    /**
     * Before create event.
     */
    public function beforeCreate()
    {
        // Generate a random secret
        $this->secret = self::generateSecret();
    }

    /**
     * Generate a unique hash string.
     *
     * @return string
     */
    public static function generateSecret()
    {
        $i = 5;
        do {
            $i++;
            $secret = strtoupper(str_random($i));
        } while (self::secret($secret)->count());

        return $secret;
    }

    /**
     * Find a shop by secret.
     *
     * @param Query  $query
     * @param string $secret
     *
     * @return Query
     */
    public function scopeSecret($query, $secret)
    {
        return $query->where('secret', strtoupper($secret));
    }
}
