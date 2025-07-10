<?php
// Common
use Illuminate\Support\Facades\Route;
//Calendar
use App\Http\Controllers\EventController;
// Users
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\CoordinatorController;

Route::get('/', function () {
    return view('home');
});

Route::get('/policy', function () {
    $policy = file_get_contents(storage_path('app/public/policy.html')); // exemplo
    return view('policy', compact('policy'));
});

Route::get('/terms', function () {
    $terms = file_get_contents(storage_path('app/public/terms.html')); // exemplo
    return view('terms', compact('terms'));
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    //  calendar
    Route::get('/calendar', [EventController::class, 'index'])->name('calendar');
    Route::get('/events', [EventController::class, 'events'])->name('events');

    //  users -> StudentController/Student.php ProfessorController/Professor.php CoordinatorController/Coordinator.php
    Route::get('/users/students', [StudentController::class, 'index'])->name('users.students-table');
    Route::get('/users/professors', [ProfessorController::class, 'index'])->name('users.professors-table');

    Route::get('/users/coordinators', [CoordinatorController::class, 'index'])->name('users.coordinators-table');
});
