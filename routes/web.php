<?php
// Common
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\Legal\LegalController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

// Rota para homePage
Route::get('/', function () {
    return view('home-page');
})->name('home');

// Rotas para políticas de privacidade e termos de uso
Route::get('/policy', [LegalController::class, 'showPolicies'])->name('policy.show');
ROute::get('/terms', [LegalController::class, 'showTerms'])->name('terms.show');

// Rotas comuns de login e logout
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Rotas acessíveis a qualquer usuário autenticado e verificado
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    /*Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');*/
    // Calendar -> EventController/Event.php
    Route::get('/calendar', [EventController::class, 'index'])->name('calendar');
    Route::get('/events/show', [EventController::class, 'events'])->name('events.show');

    // Groups -> GroupController/Group.php
    Route::get('/papers/{filename}', [GroupController::class, 'showPaper'])->name('papers.show');
});

// rotas do coordenador
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'access.level:3',
])->group(function () {
    // users -> StudentController/Student.php ProfessorController/Professor.php CoordinatorController/Coordinator.php
    Route::get('/users/students', [StudentController::class, 'index'])->name('users.students-table');
    Route::get('/users/professors', [ProfessorController::class, 'index'])->name('users.professors-table');
    Route::get('/users/coordinators', [CoordinatorController::class, 'index'])->name('users.coordinators-table');

    // Groups -> GroupController/Group.php
    Route::get('/groups', [GroupController::class, 'index'])->name('groups-table');

    // Courses -> CourseController/Course.php
    Route::get('/courses', [CourseController::class, 'index'])->name('courses-table');

    // calendar -> CommitteeController/Committee.php
    Route::get('/committees', [CommitteeController::class, 'index'])->name('committees-table');

    // Operações CRUD das tabelas e cards
    Route::prefix(env('SECURE_POST_PREFIX')) // todas as rotas dentro desse grupo possuem o prefixo definido no.env
    ->middleware(['secure.ajax']) // middleware que traz camadas a mais de seguranças nas requisições ajax
    ->group(function () {
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
        /*
        Route::get('/students/search', [GroupController::class, 'search'])->name('groups.search-students');
        */
        Route::get('/groups/show', [GroupController::class, 'show'])->name('groups.show');
        Route::post('/groups/save', [GroupController::class, 'store'])->name('groups.store');
        Route::put('/groups/{id}/update', [GroupController::class, 'update'])->name('groups.update');
        Route::put('/groups/{id}/{action}', [GroupController::class, 'toggleStatus'])->name('groups.toggle-status');

        // Courses -> CourseController/Course.php
        Route::get('/courses/show', [CourseController::class, 'show'])->name('courses.show');
        Route::post('/courses/save', [CourseController::class, 'store'])->name('courses.store');
        Route::put('/courses/{id}/update', [CourseController::class,'update'])->name('courses.update');
        Route::put('/courses/{id}/{action}', [CourseController::class, 'toggleStatus'])->name('courses.toggle-status');

        // calendar -> CommitteeController/Committee.php
        /*
        Route::get('/members/search', [CommitteeController::class, 'search'])->name('committees.search-members');
        */
        Route::get('/committees/show', [CommitteeController::class, 'show'])->name('committees.show');
        Route::post('/committees/save', [CommitteeController::class, 'store'])->name('committees.store');
        Route::put('/committees/{id}/update', [CommitteeController::class, 'update'])->name('committees.update');
        Route::put('/committees/{id}/{action}', [CommitteeController::class, 'toggleStatus'])->name('committees.toggle-status');
    });
});

// Rotas do aluno
