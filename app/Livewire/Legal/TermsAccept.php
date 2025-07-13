<?php

namespace App\Livewire\Legal;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TermsAccept extends Component
{
    public bool $show = false;
    public bool $accepted = false;

    public function mount()
    {
        $this->show = Auth::check() && is_null(Auth::user()->terms_accepted_at);
    }

    public function accept()
    {
        if ($this->accepted && Auth::check()) {
            $user = Auth::user();
            $user->terms_accepted_at = now();
            $user->save();

            // Garante que a sessão reflita o novo estado
            Auth::setUser($user);

            $this->show = false;
        }
    }

    public function refuse()
    {
        auth()->guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect(route('home'));
    }

    public function render()
    {
        return view('livewire.legal.terms-accept');
    }
}
