<?php

use App\Http\Middleware\EnsureUserHasAccessLevel;
use App\Http\Middleware\EnsureTermsAccepted;
use App\Http\Middleware\SecureAjaxRequest;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Middleware que identifica o nível de acesso do usuário: App\Http\Middleware\EnsureUserHasAccessLevel
        $middleware->alias([
            'access.level' => EnsureUserHasAccessLevel::class,
            'secure.ajax' => SecureAjaxRequest::class,
        ]);
        // Adiciona o middleware ao grupo web, junto com os padrões já existentes
        $middleware->appendToGroup('web', EnsureTermsAccepted::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
