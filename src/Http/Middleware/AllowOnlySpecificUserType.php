<?php

namespace Javaabu\Helpers\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Model;

class AllowOnlySpecificUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $authenticable
     * @return mixed
     * @throws AuthorizationException
     */
    public function handle($request, Closure $next, $authenticable = 'user')
    {
        $authenticable_class = Model::getActualClassNameForMorph($authenticable);

        if (auth()->user() instanceof $authenticable_class) {
            return $next($request);
        }

        if (expects_json($request)) {
            throw new AuthorizationException('Disallowed user type');
        } else {
            $url = with(new $authenticable_class)->loginUrl();
            return redirect()->to($url);
        }
    }

}
