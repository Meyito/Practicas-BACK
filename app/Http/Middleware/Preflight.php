<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class Preflight {

    public function handle($request, Closure $next) {
        $response = $next($request);
        if ($request->getMethod() == 'OPTIONS' && $response->getStatusCode() == 405) {
            return new Response('', 204, $response->headers->all());
        }

        return $response;
    }

}