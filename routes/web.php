<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/policy', function () {
    $policy = file_get_contents(storage_path('app/public/policy.html')); // exemplo
    return view('policy', compact('policy'));
});

Route::get('/terms', function () {
    $terms = file_get_contents(storage_path('app/public/terms.html')); // exemplo
    return view('terms', compact('terms'));
});

Route::get('/check', function () {
    return auth()->check() ? 'Autenticado' : 'Não autenticado';
});

Route::get('/test', function () {
    return view('test');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/calendar', [EventController::class, 'index'])->name('calendar');
    Route::get('/events', [EventController::class, 'events'])->name('events');
    Route::get('/events', [EventController::class, 'events'])->name('events');
});
