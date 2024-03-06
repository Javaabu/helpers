<?php

namespace Javaabu\Helpers\Foundation\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected function shouldReturnJson($request, Throwable $e)
    {
        return $request->is(config('app.api_prefix').'/*') || $request->expectsJson();
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->shouldReturnJson($request, $exception)
            ? response()->json(['message' => $exception->getMessage()], 401)
            : redirect()->guest($exception->redirectTo($request) ?? $this->getGuestRedirectPath($exception));
    }

    protected function getGuestRedirectPath(AuthenticationException $exception)
    {
        $guard = $exception->guards()[0] ?? null;

        $provider = config("auth.guards.{$guard}.provider");
        $model = config("auth.providers.{$provider}.model");

        if ($model) {
            return with(new $model)->loginUrl();
        }

        return '/login';
    }
}
