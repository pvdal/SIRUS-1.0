<?php

namespace App\Providers;

use App\Models\Committee;
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

        Gate::define('evaluate-paper', function (User $user, Committee $committee) {
            // Bloqueia acesso direto para nível 1
            if($user->access_level === 1) {
                return false;
            }

            // Verifica se o usuário faz parte da banca passada como parâmetro
            $member =  UserCommittee::where('committee_id', $committee->id)
                ->where('user_id', $user->id)
                ->first();

            // Se não é membro, não pode avaliar
            if (!$member) {
                return false;
            }

            // Só pode avaliar se ainda não tiver avaliado
            return $member->evaluated_at === null;
        });

        Gate::define('view-evaluation', function ($user, Committee $committee) {
            // Usuário nível 3 tem acesso total de leitura
            if($user->isAdmin()) {
                return true;
            }

            if($user->access_level === 2) {
                // Verifica se o usuário faz parte da banca passada como parâmetro
                return UserCommittee::where('committee_id', $committee->id)
                    ->where('user_id', $user->id)
                    ->exists();
            }

            if($user->access_level === 1) {
                // Caso o usuário tenha nível 1, só pode ver a avaliação caso seja membro
                // do grupo que detém o paper submetido à banca
                $studentGroupId = $user->student->group_id;
                $paper = $committee->paper;
                if (!$paper) {
                    return false; // A banca não tem trabalho associado
                }
                
                return $paper->group_id === $studentGroupId;
            }

            return false;
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
