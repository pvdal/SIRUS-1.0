<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class SendEmailVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (
            $user &&
            $user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&
            !$user->hasVerifiedEmail()
        ) {
            // Envia via fila
            event(new Registered($user));
        }

        return $next($request);
    }
}
