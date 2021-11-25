<?php

namespace Tresfera\Taketsystem\Classes\Http\Controllers;

use Illuminate\Routing\Controller;
use Tresfera\Taketsystem\Models\Device;
use Tresfera\Taketsystem\Models\DeviceLog;
use Request;
use Response;
use Route;
use Carbon\Carbon;
use Input;

class API extends Controller
{
    protected $device;
    protected $shop;
    protected $client;
    protected $log;

   
    /**
     * Find shop & device by token.
     */
    protected function tokenAuth()
    {
      
        //lo primero de todo es guardar la info de entrada  
       
        
        $this->device = Device::with('shop', 'client')->token(Request::get('token'))->first();
      /*if($this->device->semaforo == 1) {
            \Log::debug("Device: ".$this->device->id." Semaforo en rojo: ".Route::getCurrentRoute()->getActionName());
            exit;
        }*/
        
      //  \Log::debug("Token: ".Request::get('token'));


       /* $this->shop = $this->device->shop;
        $this->client = $this->device->shop->client;
*/
        $this->log = new DeviceLog();
        $this->log->device_id = 1;
        $this->log->action = Route::getCurrentRoute()->getActionName();
        $this->log->get = Response::json(Input::all());
        $this->log->save();
        

        // \Log::debug("action: ".$this->log->action);
  
        // Save request date
        //$this->device->last_request = Carbon::now();
        //$this->device->save();
    }

    /**
     * Json response.
     *
     * @param array $data
     *
     * @return Response
     */
    protected function response($data = array(), $get = array())
    {
        // Log
       

       if(isset($this->log->id)) {
       
    //    \Log::debug("Log: ".$this->log->id);
      //  \Log::debug("request: ".Response::json(['result' => 'ok'] + $data));
        
        $this->log->request =  Response::json(['result' => 'ok'] + $data) ;
        $this->log->save();
       }
        
        
        return Response::json(['result' => 'ok'] + $data);
    }
     
}
