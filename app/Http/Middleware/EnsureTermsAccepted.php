<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Log;

class EnsureTermsAccepted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        /* Storage/logs/laravel.log
        Log::debug('Middleware rodando', [
            'rota' => $request->path(),
            'is_livewire' => $request->header('X-Livewire'),
        ]);*/

        if($user && is_null($user->terms_accepted_at) && !$request->is('dashboard'))
        {
            $livewireRequest = $request->header('X-Livewire') !== null;
            $allowedRoutes = [
                'livewire.update',
                'policy.show',
                'terms.show',
                'verification.send',
                'verification.notice',
                'profile.show',
                'login',
                'logout',
                'two-factor.login',
            ];
            // Permitir chamadas do Livewire (como o accept)
            if ($livewireRequest ||
                $request->routeIs(...$allowedRoutes) ||
                $request->is('email/*', 'reset-password/*')){

                return $next($request);
            }
            // Redirecionar se não for uma dessas rotas
            return redirect()->route('dashboard');
        }
        return $next($request);
    }
}
