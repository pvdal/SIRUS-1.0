<?php
// Common
use Illuminate\Support\Facades\Route;
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
    /*
    $policy = file_get_contents(storage_path('app/public/policy.html')); // exemplo
    return view('policy', compact('policy'));*/
    $policy = Str::markdown(File::get(resource_path('markdown/policy.md')));
    return view('policy', compact('policy'));
})->name('policy.show');

Route::get('/terms', function () {
    $terms = Str::markdown(File::get(resource_path('markdown/terms.md')));
    return view('terms', compact('terms'));
})->name('terms.show');

// rotas acessíveis a qualquer usuário autenticado e verificado
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
    Route::get('/events', [EventController::class, 'events'])->name('events');

    // users -> StudentController/Student.php ProfessorController/Professor.php CoordinatorController/Coordinator.php
    Route::get('/users/students', [StudentController::class, 'index'])->name('users.students-table');
    Route::get('/users/professors', [ProfessorController::class, 'index'])->name('users.professors-table');
    Route::get('/users/coordinators', [CoordinatorController::class, 'index'])->name('users.coordinators-table');

    // Groups -> GroupController/Group.php
    Route::get('/groups', [GroupController::class, 'index'])->name('groups-table');

    // Courses -> CourseController/Course.php
    Route::get('/courses', [CourseController::class, 'index'])->name('courses-table');
});


// Rotas do aluno
