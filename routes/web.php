<?php
// Common
use App\Http\Controllers\AxisController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\ManualController;
use App\Http\Controllers\RubricController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Legal\LegalController;
use App\Http\Controllers\PaperController;
use App\Http\Controllers\EventController;
// Coordenação
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\StudentController;
// Rotas nativas de token de API pública
use Laravel\Jetstream\Jetstream;
use Laravel\Jetstream\Http\Controllers\Livewire\ApiTokenController;
// use App\Http\Controllers\Auth\AuthenticatedSessionController;


// Rota para homePage
Route::get('/', function () {
    return view('home-page');
})->name('home');

// Rotas para políticas de privacidade e termos de uso
Route::get('/legal/policy', [LegalController::class, 'showPolicies'])->name('policy.show');
Route::get('/legal/terms', [LegalController::class, 'showTerms'])->name('terms.show');

//  Rota para as páginas do manual do usuário
//Route::get('/manual/{page}', [ManualController::class, 'show'])
//   ->where('page', '[A-Za-z0-9\-]+')
//    ->name('manual.show');

//  Rota para as páginas do manual do usuário
Route::get('/manual', [ManualController::class, 'show'])
    ->middleware('auth:sanctum')->name('manual.show');

// Rotas comuns de login e logout. Isso sobrepõe as rotas laravel padrão, é possível setar elas globalmente em /config/fortify.php
// OBS: Isso sobrescreve as rotas default do vendor e será mantido de lado por enquanto não é necessário uma tela diferente para
// cada perfil de usuário
//Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
//Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// rotas do coordenador
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'access.level:3',
])->group(function () {
    // Retirado do vendor: isso limita a rota à usuários de nível 3
    if (Jetstream::hasApiFeatures()) {
        Route::get('/user/api-tokens', [ApiTokenController::class, 'index'])->name('api-tokens.index');
    }

    // users -> StudentController/Student.php ProfessorController/Professor.php CoordinatorController/Coordinator.php
    Route::get('/users/students', [StudentController::class, 'index'])->name('users.students-table');
    Route::get('/users/professors', [ProfessorController::class, 'index'])->name('users.professors-table');
    Route::get('/users/coordinators', [CoordinatorController::class, 'index'])->name('users.coordinators-table');

    // Groups -> GroupController/Group.php
    Route::get('/groups', [GroupController::class, 'index'])->name('groups-table');

    // Courses -> CourseController/Course.php
    Route::get('/courses', [CourseController::class, 'index'])->name('courses-table');

    // Evaluations -> CommitteeController/Committee.php
    Route::get('/evaluation/criteria', [CriteriaController::class, 'index'])->name('evaluation.criteria-table');
    Route::get('/evaluation/axis', [AxisController::class, 'index'])->name('evaluation.axis-table');
    Route::get('/evaluation/rubric', [RubricController::class, 'index'])->name('evaluation.rubric-table');

    // Papers -> PapersController/Paper.php
    Route::get('/papers', [PaperController::class, 'index'])->name('papers-content');

    Route::prefix(config('secure.request_prefix'))
        ->group(function () {
            Route::get('/papers/download/{year}/{semester}', [PaperController::class, 'download'])->name('paper.download');
        });

    // Operações CRUD das tabelas e cards -> API privada
    Route::prefix(config('secure.request_prefix')) // todas as rotas dentro desse grupo possuem o prefixo definido no.env
    ->middleware('secure.ajax') // middleware que traz camadas a mais de seguranças nas requisições ajax
    ->group(function () {
        // Calendar -> EventController/Committee.php
        Route::put('/events/{id}/update', [EventController::class, 'update'])->name('events.update');

        // Students -> StudentController/Student.php
        Route::get('/students/show', [StudentController::class, 'show'])->name('students.show');
        Route::post('/students/save', [StudentController::class, 'store'])->name('students.store');
        Route::put('/students/{id}/update', [StudentController::class, 'update'])->name('students.update');
        Route::put('/students/{id}/{action}', [StudentController::class, 'toggleStatus'])->name('students.toggle-status');

        // Professors -> ProfessorController/Professor.php
        Route::get('/professors/show', [ProfessorController::class, 'show'])->name('professors.show');
        Route::post('/professors/save', [ProfessorController::class, 'store'])->name('professors.store');
        Route::put('/professors/{id}/update', [ProfessorController::class, 'update'])->name('professors.update');
        Route::put('/professors/{id}/{action}', [ProfessorController::class, 'toggleStatus'])->name('professors.toggle-status');

        // Coordinators -> CoordinatorController/Coordinator.php
        Route::get('/coordinators/show', [CoordinatorController::class, 'show'])->name('coordinators.show');
        Route::post('/coordinators/save', [CoordinatorController::class, 'store'])->name('coordinators.store');
        Route::put('/coordinators/{id}/update', [CoordinatorController::class, 'update'])->name('coordinators.update');
        Route::put('/coordinators/{id}/{action}', [CoordinatorController::class, 'toggleStatus'])->name('coordinators.toggle-status');

        // Groups -> GroupController/Group.php
        Route::get('/students/search', [GroupController::class, 'search'])->name('groups.search-students');
        Route::get('/groups/show', [GroupController::class, 'show'])->name('groups.show');
        Route::post('/groups/save', [GroupController::class, 'store'])->name('groups.store');
        Route::put('/groups/{id}/update', [GroupController::class, 'update'])->name('groups.update');
        Route::put('/groups/{id}/{action}', [GroupController::class, 'toggleStatus'])->name('groups.toggle-status');

        // Courses -> CourseController/Course.php
        Route::get('/courses/show', [CourseController::class, 'show'])->name('courses.show');
        Route::post('/courses/save', [CourseController::class, 'store'])->name('courses.store');
        Route::put('/courses/{id}/update', [CourseController::class,'update'])->name('courses.update');
        Route::put('/courses/{id}/{action}', [CourseController::class, 'toggleStatus'])->name('courses.toggle-status');

        // Committees -> CommitteeController/Committee.php
        Route::get('/rubrics/search', [CommitteeController::class, 'searchRubrics'])->name('committees.search-rubrics');
        Route::get('/members/search', [CommitteeController::class, 'searchMembers'])->name('committees.search-members');
        Route::post('/committees/save', [CommitteeController::class, 'store'])->name('committees.store');
        Route::put('/committees/{id}/update', [CommitteeController::class, 'update'])->name('committees.update');
        Route::put('/committees/{id}/{action}', [CommitteeController::class, 'toggleStatus'])->name('committees.toggle-status');

        // Criterion -> CriteriaController/Criterion.php
        Route::get('/criteria/show', [CriteriaController::class, 'show'])->name('criteria.show');
        Route::post('/criteria/save', [CriteriaController::class, 'store'])->name('criteria.store');
        Route::put('/criteria/{id}/update', [CriteriaController::class, 'update'])->name('criteria.update');
        Route::put('/criteria/{id}/{action}', [CriteriaController::class, 'toggleStatus'])->name('criteria.toggle-status');
        Route::get('/criteria/search', [CriteriaController::class, 'search'])->name('search-criteria');

        // Axis -> AxisController/Axes.php
        Route::get('/axis/show', [AxisController::class, 'show'])->name('axis.show');
        Route::post('/axis/save', [AxisController::class, 'store'])->name('axis.store');
        Route::put('/axis/{id}/update', [AxisController::class, 'update'])->name('axis.update');
        Route::put('/axis/{id}/{action}', [AxisController::class, 'toggleStatus'])->name('axis.toggle-status');
        Route::get('/axis/search', [AxisController::class, 'search'])->name('axis.search-axes');

        // Rubric -> RubricController/Rubric.php
        Route::get('/rubrics/show', [RubricController::class, 'show'])->name('rubric.show');
        Route::post('/rubrics/save', [RubricController::class, 'store'])->name('rubric.store');
        Route::put('/rubrics/{id}/update', [RubricController::class, 'update'])->name('rubric.update');
        Route::put('/rubrics/{id}/{action}', [RubricController::class, 'toggleStatus'])->name('rubric.toggle-status');

        // Paper -> PaperController/Paper.php
        Route::get('/papers/show', [PaperController::class, 'show'])->name('paper.show');
        Route::get('/papers/years', [PaperController::class, 'years'])->name('paper.years');
        Route::post('/papers/save', [PaperController::class, 'store'])->name('paper.store');
        Route::put('/papers/{id}/update', [PaperController::class, 'update'])->name('paper.update');
        Route::put('/papers/{id}/{action}', [PaperController::class, 'toggleStatus'])->name('paper.toggle-status');
    });
});

// Rotas acessíveis a qualquer usuário autenticado e verificado
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    /*Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');*/
    Route::get('/rubrics/{rubric}/model-view', [RubricController::class, 'showModelView'])->name('rubrics.model_view');
    // Groups -> PaperController/Paper.php -> Quem chama essa rota é o iframe em groups.blade.php
    Route::get('/papers/{filepath}', [PaperController::class, 'showPaper'])
        ->where('filepath', '.*')
        ->name('papers.show');

    // Calendar -> EventController/Committee.php
    Route::get('/calendar', [EventController::class, 'index'])->name('calendar');

    // Committees -> CommitteeController/Committee.php
    Route::get('/committees', [CommitteeController::class, 'index'])->name('committees-table');

    // Evaluation -> EvaluationController/Evaluation.php
    //Route::post('/evaluation/store', [EvaluationController::class, 'store'])->name('evaluations.store');
    Route::get('/evaluation/{committee}', [EvaluationController::class, 'index'])
        ->name('evaluations.index');

    Route::prefix(config('secure.request_prefix')) // todas as rotas dentro desse grupo possuem o prefixo definido no.env
    ->middleware('secure.ajax') // middleware que traz camadas a mais de seguranças nas requisições ajax
    ->group(function () {
        // Evaluation -> EvaluationController/Evaluation.php
        Route::post('/evaluation/store', [EvaluationController::class, 'store'])->name('evaluations.store');

        // Calendar -> EventController/Committee.php
        Route::get('/events/show', [EventController::class, 'show'])->name('events.show');

        // Committees -> CommitteeController/Committee.php
        Route::get('/committees/show', [CommitteeController::class, 'show'])->name('committees.show');
    });
});
