<?php

namespace Tresfera\Taketsystem\Models;

use Model;
use Tresfera\Taketsystem\Classes\Libs\Pusher;

/**
 * Device Model.
 */
class Device extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_devices';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['mac', 'push_token'];

    /**
     * @var array Dates
     */
    protected $dates = ['last_request'];

    /**
     * Has Many relations.
     *
     * @var array
     */
    public $hasMany = [
        'results' => ['Tresfera\Taketsystem\Models\Result'],
    ];

    /**
     * Belongs To relations.
     *
     * @var array
     */
    public $belongsTo = [
        'client' => ['Tresfera\Taketsystem\Models\Client'],
        'shop'   => ['Tresfera\Taketsystem\Models\Shop'],
        'city'   => ['Tresfera\Taketsystem\Models\City'],
        'region'   => ['Tresfera\Taketsystem\Models\Region'],
    ];

    /**
     * Belongs To Many relations.
     *
     * @var array
     */
    public $belongsToMany = [
        'quizzes' => [
            'Tresfera\Taketsystem\Models\Quiz',
            'table' => 'tresfera_taketsystem_quiz_devices',
            'timestamps' => true,
        ],
    ];

    /**
     * Before create event.
     */
    public function beforeCreate()
    {
        // Uppercase the mac
        $this->mac = strtoupper($this->mac);
    }

    /**
     * Before save event.
     */
    public function beforeSave()
    {
        // New link?
        if ($this->isDirty('shop_id') || $this->isDirty('shop_id')) {
            $this->link();
        }
    }

    /**
     * Generate a new session Token (used by API).
     *
     * @return bool
     */
    public function generateToken()
    {
        do {
            $token = str_random(32);
        } while (self::token($token)->count());

        $this->token = $token;

        return $this->save();
    }

    /**
     * Unauthorize.
     *
     * @return bool
     */
    public function unauth()
    {
        $this->token = null;
        $this->client_id = null;
        $this->shop_id = null;
        $this->save();

        // Send push
        return Pusher::notify($this->push_token, 'unauth');
    }

    /**
     * Link device.
     *
     * @return bool
     */
    public function link()
    {
        if (!$this->token) {
            $this->generateToken();
        }

        // Send push
        if ($this->push_token) {
            return Pusher::notify($this->push_token, 'link', $this->token);
        }
    }

    //
    // getAttributes
    //

    public function getCityAttribute()
    {
        if (isset($this->shop->city->name)) {
            return $this->shop->city->name;
        } else {
            return $this->shop_id;
        }
    }

    public function getProvinciaAttribute()
    {
        if (isset($this->shop->city->region->name)) {
            return $this->shop->city->region->name;
        } else {
            return $this->shop_id;
        }
    }

    /**
     * Find a device by mac.
     *
     * @param Query  $query
     * @param string $mac
     *
     * @return Query
     */
    public function scopeMac($query, $mac)
    {
        return $query->where('mac', strtoupper($mac));
    }

    /**
     * Find a device by token.
     *
     * @param Query  $query
     * @param string $token
     *
     * @return Query
     */
    public function scopeToken($query, $token)
    {
        return $query->where('token', $token);
    }

    /**
     * Find a device by token.
     *
     * @param Query  $query
     * @param string $token
     *
     * @return Query
     */
    public function scopeCity($query, $city_id)
    {
        return $query->where('city_id', $city_id);
    }
}
