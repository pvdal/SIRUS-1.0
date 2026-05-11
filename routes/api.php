<?php

use App\Http\Controllers\Api\Bi\AcademicBiController;
use App\Http\Controllers\Api\Bi\EvaluationBiController;
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

    Route::get('/events', [EventController::class, 'events']);

    Route::get('/students/filter', [StudentController::class, 'filter']);
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {

    // Rota de teste de conectividade e validação do token do coordenador
    Route::get('/status', function (Request $request) {
        return response()->json([
            'service' => 'SIRUS BI Analytics API',
            'version' => 'v1',
            'user' => $request->user()->name,
            'status' => 'active'
        ]);
    });

    /**
     * DOMÍNIO: AVALIAÇÕES E DESEMPENHO (Notas e Rubricas)
     * Controller: EvaluationBiController
     */
    Route::prefix('evaluations')->group(function () {
        // Desempenho
        Route::get('/groups/flat', [EvaluationBiController::class, 'getGroupEvaluationsFlat']);
        Route::get('/individuals/flat', [EvaluationBiController::class, 'getIndividualPerformance']);

        // Rubricas e Rankings
        Route::get('/rubrics/matrix', [EvaluationBiController::class, 'getRubricMatrix']);
        Route::get('/leaderboard', [EvaluationBiController::class, 'getLeaderboard']);

        // Comportamento do Corpo Docente
        Route::get('/evaluators/strictness', [EvaluationBiController::class, 'getEvaluatorStrictness']);

        // Fatos
        Route::get('/flat-facts', [EvaluationBiController::class, 'getFlatFacts']);
    });

    /**
     * DOMÍNIO: ACADÊMICO E DEMOGRÁFICO (Volumes e Engajamento)
     * Controller: AcademicBiController
     */
    Route::prefix('academic')->group(function () {
        // Demografia
        Route::get('/demographics/students', [AcademicBiController::class, 'getDemographics']);

        // Volume de Produção Acadêmica
        Route::get('/papers/evolution', [AcademicBiController::class, 'getPapersEvolution']);

        // Operação do Evento
        Route::get('/committees/workload', [AcademicBiController::class, 'getCommitteeWorkload']);
    });

    Route::prefix('general')->group(function () {


    });

});
