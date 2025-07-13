<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasAccessLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$levels): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'Usuário não autenticado.');
        }

        if (!in_array($user->access_level, $levels)) {
            return redirect('/login');
        }

        return $next($request);
    }

}
