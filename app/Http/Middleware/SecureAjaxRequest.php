<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecureAjaxRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->ajax()) {
            abort(403, 'Apenas requisições AJAX são permitidas.');
        }

        $tokenHeader = $request->header('X-Dynamic-Session-Token');
        $tokenSession = session('dynamic_token');

        if (empty($tokenHeader) || $tokenHeader !== $tokenSession) {
            abort(403, 'Token de sessão inválido ou ausente.');
        }

        return $next($request);
    }
}
