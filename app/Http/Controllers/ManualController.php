<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ManualController extends Controller
{
    private const array ALL_ACCESS_LEVELS = [
        User::COORDINATOR,
        User::PROFESSOR,
        User::STUDENT
    ];
    private array $chapters = [
        'introduction' => [
            'label' => '1. Introdução',
            'access_levels' => self::ALL_ACCESS_LEVELS
        ],
        'access' => [
            'label' => '2. Acesso ao Sistema',
            'access_levels' => self::ALL_ACCESS_LEVELS
        ],
        'security' => [
            'label' => '3. Segurança',
            'access_levels' => self::ALL_ACCESS_LEVELS
        ],
        'schedule' => [
            'label' => '4. Agenda de Avaliações',
            'access_levels' => self::ALL_ACCESS_LEVELS
        ],
        'users' => [
            'label' => '5. Gerenciamento de Usuários',
            'access_levels' => [
                User::COORDINATOR,
            ],
        ],
        'institutional' => [
            'label' => '6. Configurações Institucionais',
            'access_levels' => [
                User::COORDINATOR,
                User::STUDENT,
            ],
        ],
        'rubrics-evaluation' => [
            'label' => '7. Rubricas e Processo de Avaliação',
            'access_levels' => self::ALL_ACCESS_LEVELS
        ],
        'evaluations-calculations' => [
            'label' => '8. Cálculos das avaliações',
            'access_levels' => [
                User::COORDINATOR,
            ],
        ],
        'paper' => [
            'label' => '9. Trabalhos',
            'access_levels' => [
                User::COORDINATOR,
            ],
        ],
        'profile' => [
            'label' => '10. Perfil',
            'access_levels' => self::ALL_ACCESS_LEVELS
        ],
        'accessibility' => [
            'label' => '11. Acessibilidade',
            'access_levels' => self::ALL_ACCESS_LEVELS
        ],
        'api-tokens' => [
            'label' => '12. Tokens de API',
            'access_levels' => [
                User::COORDINATOR,
            ],
        ],
    ];

    public function index(?string $chapter = null): View
    {
        $userAccessLevel = auth()->user()->access_level;

        $chapter ??= 'introduction';

        if (!isset($this->chapters[$chapter])) {
            abort(404);
        }

        if (
            !in_array(
                $userAccessLevel,
                $this->chapters[$chapter]['access_levels']
            )
        ) {
            abort(403);
        }

        $filteredChapters = array_filter(
            $this->chapters,
            fn ($chapter) => in_array(
                $userAccessLevel,
                $chapter['access_levels']
            ),
        );

        return view("user-manual.index", [
            'chapter' => $chapter,
            'chapters' => $filteredChapters,
        ]);
    }
}
