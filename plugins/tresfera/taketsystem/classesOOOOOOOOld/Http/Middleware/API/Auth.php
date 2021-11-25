<?php

namespace Tresfera\Taketsystem\Classes\Http\Middleware\API;

use Illuminate\Contracts\Routing\Middleware;
use Closure;
use App;
use Tresfera\Taketsystem\Models\Device;

class Auth implements Middleware
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
            if (!Device::token($token)->count()) {
                App::abort(403, 'Invalid token');
            }
        }

        return $next($request);
    }
}
