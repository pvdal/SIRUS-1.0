<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// auth:sanctum limita o acesso a essas rotas ao uso do bearer token gerado no laravel pelo coordenador
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/events/show', [EventController::class, 'events']);

    Route::get('/students/show', [StudentController::class, 'show']);
});
