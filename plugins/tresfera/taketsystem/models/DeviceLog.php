<?php

namespace Tresfera\Taketsystem\Models;

use Model;

/**
 * DeviceLog Model.
 */
class DeviceLog extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tresfera_taketsystem_device_logs';

    /**
     * Belongs To relations.
     *
     * @var array
     */
    public $belongsTo = [
        'device' => ['Tresfera\Taketsystem\Models\Device'],
    ];
}
