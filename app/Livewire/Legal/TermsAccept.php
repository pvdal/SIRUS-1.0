<?php

namespace App\Livewire\Legal;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TermsAccept extends Component
{
    public bool $show = false;
    public bool $accepted = false;

    /*
     * Se o usuário estiver logado e tiver o campoo terms_accepted_at nulo, $show retorna true e o modal de aceite
     * e o modal é exibido.
     */
    public function mount(): void
    {
        $this->show = Auth::check() && is_null(Auth::user()->terms_accepted_at);
    }

    // Caso o usuário aceite os termos, será salvo o datetime atual no banco na coluna referente a isso
    public function accept(): void
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
    // Caso o usuário recuse os termos, terá sua sessão encerrada e será redirecionado para a home
    public function refuse(): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        auth()->guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect(route('home'));
    }
    // Renderiza a view de aceite dos termos (modal)
    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.legal.terms-accept');
    }
}
