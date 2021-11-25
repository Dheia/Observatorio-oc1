<?php

namespace Tresfera\Buildyouup\Classes\Http\Controllers;

use Illuminate\Routing\Controller;
use Tresfera\Taketsystem\Models\Device;
use Tresfera\Taketsystem\Models\DeviceLog;
use Request;
use Response;
use Route;
use Carbon\Carbon;

class API extends Controller
{
    protected $device;
    protected $shop;
    protected $client;

    /**
     * Find shop & device by token.
     */
    protected function tokenAuth()
    {
        $this->device = Device::with('shop', 'client')->token(Request::get('token'))->first();
        if(isset($this->device->id)) {
          $this->shop = $this->device->shop;
          $this->client = $this->device->shop->client;

          // Save request date
          $this->device->last_request = Carbon::now();
          $this->device->save();
        }


    }

    /**
     * Json response.
     *
     * @param array $data
     *
     * @return Response
     */
    protected function response($data = array())
    {
        // Log
        $log = new DeviceLog();
        //$log->device()->associate($this->device);
        $log->action = Route::getCurrentRoute()->getActionName();
        $log->save();

        return Response::json(['result' => 'ok'] + $data);
    }
}
