<?php

namespace Tresfera\Taketsystem\Classes\Http\Middleware\API;

use Closure;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Applicaion;
use App;
use Tresfera\Taketsystem\Models\Device;

class Auth
{
    /**
     * Run the request filter.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Mac?
        if (! $token = $request->input('token')) {
            App::abort(403, 'Token is not present.');
        } else {
            if($token == 'hd79S1PFMISQAiSV6bAQmbgBCwwA8Oy1') {
              return $next($request);
            } elseif (!Device::token($token)->count()) {
                App::abort(403, 'Invalid token');
            }
        }

        return $next($request);
    }
}
