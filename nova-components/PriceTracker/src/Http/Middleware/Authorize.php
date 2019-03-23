<?php

namespace Acme\PriceTracker\Http\Middleware;

use Acme\PriceTracker\PriceTracker;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return resolve(PriceTracker::class)->authorize($request) ? $next($request) : abort(403);
    }
}
