<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Livewire::component('profile.update-profile-information-form', \App\Livewire\Profile\UpdateProfileInformationForm::class);
        // Impede usuários que não possuem nível de acesso === 3 criar ‘tokens’ de API
        PersonalAccessToken::saving(function ($token) {
            if ($token->tokenable->access_level !== 3) {
                // ‘Log’ para auditoria
                Log::warning("Usuário: {$token->tokenable->name}, id:{$token->tokenable->id}, tentou criar token sem permissão.");
                // Retorna exceção
                throw new \Exception('Não autorizado a criar tokens');
            }
        });
        // Impede usuários que não possuem nível de acesso === 3 deletar ‘tokens’ de API
        PersonalAccessToken::deleting(function ($token) {
            if($token->tokenable->access_level !== 3) {
                // Log para auditoria
                Log::warning("Usuário: {$token->tokenable->name}, id: {$token->tokenable->id} tentou deletar token sem permissão");

                throw new \Exception ('Não autorizado a deletar tokens');
            }
        });
    }
}
