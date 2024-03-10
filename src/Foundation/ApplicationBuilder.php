<?php

namespace Javaabu\Helpers\Foundation;

use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Configuration\ApplicationBuilder as BaseApplicationBuilder;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Events\DiagnosingHealth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Javaabu\Helpers\Foundation\Exceptions\Handler;
use Laravel\Folio\Folio;

class ApplicationBuilder extends BaseApplicationBuilder
{
    /**
     * Create the routing callback for the application.
     *
     * @param  string|null    $web
     * @param  string|null    $api
     * @param  string|null    $pages
     * @param  string|null    $health
     * @param  string         $apiPrefix
     * @param  callable|null  $then
     * @return \Closure
     */
    protected function buildRoutingCallback(
        ?string   $web,
        ?string   $api,
        ?string   $pages,
        ?string   $health,
        string    $apiPrefix,
        ?callable $then)
    {
        return function () use ($web, $api, $pages, $health, $apiPrefix, $then) {
            if (is_string($api) && realpath($api) !== false) {
                Route::middleware('api')->as('api.')->prefix($apiPrefix)->group($api);
            }

            if (is_string($health)) {
                Route::middleware('web')->get($health, function () {
                    Event::dispatch(new DiagnosingHealth);

                    return View::file(__DIR__ . '/../resources/health-up.blade.php');
                });
            }

            if (is_string($web) && realpath($web) !== false) {
                Route::middleware('web')->group($web);
            }

            if (is_string($pages) &&
                realpath($pages) !== false &&
                class_exists(Folio::class)) {
                Folio::route($pages, middleware: $this->pageMiddleware);
            }

            if (is_callable($then)) {
                $then($this->app);
            }
        };
    }

    public function withMiddleware(?callable $callback = null)
    {
        $this->app->afterResolving(HttpKernel::class, function ($kernel) use ($callback) {
            $middleware = (new Middleware);


            if (!is_null($callback)) {
                $callback($middleware);
            }

            $this->pageMiddleware = $middleware->getPageMiddleware();
            $kernel->setGlobalMiddleware($middleware->getGlobalMiddleware());
            $kernel->setMiddlewareGroups($middleware->getMiddlewareGroups());
            $kernel->setMiddlewareAliases($middleware->getMiddlewareAliases());

            if ($priorities = $middleware->getMiddlewarePriority()) {
                $kernel->setMiddlewarePriority($priorities);
            }
        });

        return $this;
    }

    public function withExceptions(?callable $using = null)
    {
        $this->app->singleton(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            Handler::class
        );

        $using ??= fn() => true;

        $this->app->afterResolving(
            Handler::class,
            fn($handler) => $using(new Exceptions($handler)),
        );

        return $this;
    }
}
