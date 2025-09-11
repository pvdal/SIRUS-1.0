<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'state' => 1,
        ], $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => __('As credenciais fornecidas não foram encontradas.'),
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        return redirect()->intended(
            match ($user->access_level) {
                3 => '/calendar',
                2 => '/calendar',
                default => '/calendar',
            }
        );
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
