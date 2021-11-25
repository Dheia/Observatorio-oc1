<?php namespace Tresfera\Clients;

use System\Classes\PluginBase;
use Backend\Models\User as UserModel;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }
    public function boot()
    {
        // User extension
        UserModel::extend(function ($model) {
            $model->belongsTo['client'] = ['Tresfera\Clients\Models\Client'];
        });
    }
}
