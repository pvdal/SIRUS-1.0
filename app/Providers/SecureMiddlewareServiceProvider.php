<?php

namespace App\Providers;

use App\Http\Middleware\EnsureTermsAccepted;
use App\Http\Middleware\EnsureUserHasAccessLevel;
use App\Http\Middleware\SecureAjaxRequest;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class SecureMiddlewareServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(Router $router): void
    {
        $router->aliasMiddleware('access.level', EnsureUserHasAccessLevel::class);
        $router->aliasMiddleware('secure.ajax', SecureAjaxRequest::class);

        if (config('secure.terms_accept')) {
            $router->pushMiddlewareToGroup('web', EnsureTermsAccepted::class);
        }
    }
}
