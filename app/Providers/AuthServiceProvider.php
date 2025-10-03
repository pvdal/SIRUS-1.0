<?php

namespace App\Providers;

use App\Models\Paper;
use App\Models\Student;
use App\Models\User;
use App\Models\UserCommittee;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
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
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('is-admin', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('manage-events', function ($user) {
            return $user->canManageEvents();
        });

        Gate::define('manage-api-tokens', function ($user) {
            return $user->canManageApiTokens();
        });

        Gate::define('evaluate', function ($user) {
            return $user->canEvaluate();
        });

        Gate::define('view-paper', function (User $user, Paper $paper) {
            if ($user->isAdmin()) {
                return true;
            }

            // Caso o usuário seja aluno
            if ($user->access_level === 1) {
                $student = Student::where('user_id', $user->id)->first();
                return $student && $student->group_id === $paper->group_id;
            }

            // Caso o usuário seja professor ou coordenador
            if ($user->access_level === 2 || $user->access_level === 3) {
                return UserCommittee::where('user_id', $user->id)
                    ->whereHas('committee', function ($q) use ($paper) {
                        $q->where('paper_id', $paper->id);
                    })
                    ->exists();
            }

            // Se não for aluno nem professor, negar acesso
            return false;
        });
    }
}
