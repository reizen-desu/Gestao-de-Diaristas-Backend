<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiaristaController;
use App\Http\Controllers\VisitanteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ********** FOR DIARISTAS  ENDPOINT **********
// Path: /diaristas
// Route::get('/diaristas', [DiaristaController::class, 'getDiarista']); Isto faz tudo o que está em baixo


// Get all diaristas
Route::get('diaristas/', [DiaristaController::class, 'getDiarista'])->name('diaristas');

// Get diarista by id
Route::get('diaristas/{id}', [DiaristaController::class, 'getDiaristaById'])->name('diaristas');

// Add diarista
Route::post('diaristas/', [DiaristaController::class, 'addDiarista'])->name('diaristas');

// Update diarista
Route::put('diaristas/{id}', [DiaristaController::class, 'updateDiarista'])->name('diaristas');

// Delete diarista
Route::delete('diaristas/{id}', [DiaristaController::class, 'deleteDiarista'])->name('diaristas');




// ********** FOR VISITANTES ENDPOINT **********
// Path: /visitantes
// Route::apiResource('visitantes', VisitanteController::class); // Isto faz tudo o que está abaixo

// Get all visitantes
Route::get('visitantes/', [VisitanteController::class, 'index'])->name('visitantes');

// Get visitante by id
Route::get('visitantes/{id}', [VisitanteController::class, 'show'])->name('visitantes');

// Add visitante
Route::post('visitantes/', [VisitanteController::class, 'store'])->name('visitantes');

// Update visitante
Route::put('visitantes/{id}', [VisitanteController::class, 'update'])->name('visitantes');

// Delete visitante
Route::delete('visitantes/{id}', [VisitanteController::class, 'destroy'])->name('visitantes');


// FALLBACK ROUTE

Route::fallback(function () {
    return response()->json([
        'message' => 'Não existe nenhuma rota com essa rota. Verifique a sua URL.'], 404);
});