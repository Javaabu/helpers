<?php

namespace Javaabu\Helpers\Http\Middleware;

use Closure;
use Javaabu\Helpers\Exceptions\JsonOnlyException;

class JsonOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure                  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->method() != 'GET' && (!$request->isJson())) {
            throw new JsonOnlyException('Only JSON requests allowed');
        }

        return $next($request);
    }
}
