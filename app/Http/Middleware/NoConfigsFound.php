<?php

namespace App\Http\Middleware;

use Closure;
use App\Config;

class NoConfigsFound
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Config::where('name', 'API_KEY')->first() == null) {
            return redirect('FirstTime');
        }
    }
}
