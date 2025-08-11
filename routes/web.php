<?php
// Common
use Illuminate\Support\Facades\Route;
// use App\Http\Middleware\SendEmailVerification;
// Legal: Terms and Policy
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
//Calendar
use App\Http\Controllers\EventController;
// Users
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\CoordinatorController;
// Groups
use App\Http\Controllers\GroupController;
// Courses
use App\Http\Controllers\CourseController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/policy', function () {
    $policy = Str::markdown(File::get(resource_path('markdown/policy.md')));
    return view('policy', compact('policy'));
})->name('policy.show');

Route::get('/terms', function () {
    $terms = Str::markdown(File::get(resource_path('markdown/terms.md')));
    return view('terms', compact('terms'));
})->name('terms.show');

// Rotas acessíveis a qualquer usuário autenticado e verificado
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// rotas do coordenador
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'access.level:3',
])->group(function () {
    // calendar
    Route::get('/calendar', [EventController::class, 'index'])->name('calendar');

    // users -> StudentController/Student.php ProfessorController/Professor.php CoordinatorController/Coordinator.php
    Route::get('/users/students', [StudentController::class, 'index'])->name('users.students-table');
    Route::get('/users/professors', [ProfessorController::class, 'index'])->name('users.professors-table');
    Route::get('/users/coordinators', [CoordinatorController::class, 'index'])->name('users.coordinators-table');

    // Groups -> GroupController/Group.php
    Route::get('/groups', [GroupController::class, 'index'])->name('groups-table');
    Route::get('/papers/{filename}', [GroupController::class, 'showPaper'])->name('papers.show');

    // Courses -> CourseController/Course.php
    Route::get('/courses', [CourseController::class, 'index'])->name('courses-table');

    Route::prefix(env('SECURE_POST_PREFIX')) // todas as rotas dentro desse grupo possuem o prefixo definido no.env
    ->middleware(['secure.ajax']) // middleware que traz camadas a mais de seguranças nas requisições ajax
    ->group(function () {
        // Calendar -> EventController/Event.php
        Route::get('/events/show', [EventController::class, 'events'])->name('events.show');

        // Students -> StudentController/Student.php
        Route::get('/students/show', [StudentController::class, 'show'])->name('students.show');
        Route::post('/students/save', [StudentController::class, 'store'])->name('students.store');
        Route::put('students/{id}/update', [StudentController::class, 'update'])->name('students.update');
        Route::put('/students/{id}/inactivate', [StudentController::class, 'inactivate'])->name('students.inactivate');
        Route::put('/students/{id}/activate', [StudentController::class, 'activate'])->name('students.activate');

        // Professors -> ProfessorController/Professor.php
        Route::get('/professors/show', [ProfessorController::class, 'show'])->name('professors.show');
        Route::post('/professors/save', [ProfessorController::class, 'store'])->name('professors.store');
        Route::put('professors/{id}/update', [ProfessorController::class, 'update'])->name('professors.update');
        Route::put('/professors/{id}/inactivate', [ProfessorController::class, 'inactivate'])->name('professors.inactivate');
        Route::put('/professors/{id}/activate', [ProfessorController::class, 'activate'])->name('professors.activate');

        // Coordinators -> CoordinatorController/Coordinator.php
        Route::get('/coordinators/show', [CoordinatorController::class, 'show'])->name('coordinators.show');
        Route::post('/coordinators/save', [CoordinatorController::class, 'store'])->name('coordinators.store');
        Route::put('/coordinators/{id}/update', [CoordinatorController::class, 'update'])->name('coordinators.update');
        Route::put('/coordinators/{id}/inactivate', [CoordinatorController::class, 'inactivate'])->name('coordinators.inactivate');
        Route::put('/coordinators/{id}/activate', [CoordinatorController::class, 'activate'])->name('coordinators.activate');

        // Groups -> GroupController/Group.php
        Route::get('/students/search', [GroupController::class, 'search'])->name('groups.search-students');
        Route::get('/groups/show', [GroupController::class, 'show'])->name('groups.show');
        Route::post('/groups/save', [GroupController::class,'store'])->name('groups.store');
        Route::put('/groups/{id}/update', [GroupController::class,'update'])->name('groups.update');
        Route::put('/groups/{id}/inactivate', [GroupController::class,'inactivate'])->name('groups.inactivate');
        Route::put('/groups/{id}/activate', [GroupController::class,'activate'])->name('groups.activate');

        // Courses -> CourseController/Course.php
        Route::get('/courses/show', [CourseController::class, 'show'])->name('courses.show');
        Route::post('/courses/save', [CourseController::class, 'store'])->name('courses.store');
        Route::put('/courses/{id}/update', [CourseController::class,'update'])->name('courses.update');
        Route::put('/courses/{id}/inactivate', [CourseController::class, 'inactivate'])->name('courses.inactivate');
        ROute::put('/courses/{id}/activate', [CourseController::class, 'activate'])->name('courses.activate');
    });
});

// Rotas do aluno
