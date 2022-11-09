<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiaristaController;
use App\Http\Controllers\VisitanteController;
use App\Http\Controllers\SolicitationController;

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

// Autenticação

// Registar
Route::post('diaristas/register', [DiaristaController::class, 'registerDiarista'])->name('diaristas');

// Login
Route::post('/diaristas/login', [DiaristaController::class, 'loginDiarista']);

// My Profile
Route::get('/diarista/profile', [DiaristaController::class, 'userProfile'])->middleware('auth:sanctum');

// Logout
Route::post('diarista/logout', [DiaristaController::class, 'logout'])->name('diaristas');

// Update password
Route::put('/diaristas/actualizar-senha/{id}', [DiaristaController::class, 'updateDiaristaPassword'])->middleware('auth:sanctum');


// -----------------------------

// Get all diaristas
Route::get('diaristas/', [DiaristaController::class, 'getDiarista'])->name('diaristas');

// Get diarista by id
Route::get('diaristas/{id}', [DiaristaController::class, 'getDiaristaById'])->name('diaristas');

// Add diarista
Route::post('diaristas/register', [DiaristaController::class, 'registerDiarista'])->name('diaristas');

// Update diarista
Route::put('diaristas/{id}', [DiaristaController::class, 'updateDiarista'])->name('diaristas');

// Update profile picture
Route::put('diaristas/{id}/foto-perfil', [DiaristaController::class, 'updateDiaristaPhoto'])->name('diaristas')->middleware('auth:sanctum');


// Search diarista
Route::get('diaristas/search/{nome}', [DiaristaController::class, 'searchDiaristas'])->name('diaristas');

// Delete diarista
Route::delete('diaristas/{id}', [DiaristaController::class, 'deleteDiarista'])->name('diaristas');

// Search diarista by name
Route::get('diaristas/search/{nome}', [DiaristaController::class, 'searchDiarista'])->name('diaristas');



// ********** FOR VISITANTES ENDPOINT **********
// Path: /visitantes
// Route::apiResource('visitantes', VisitanteController::class); // Isto faz tudo o que está abaixo

// Autenticação

// Register
Route::post('visitantes/register', [VisitanteController::class, 'store'])->name('visitantes');

// Login
Route::post('visitantes/login', [VisitanteController::class, 'login'])->name('visitantes');

// My Profile
Route::get('visitante/profile', [VisitanteController::class, 'userProfile'])->middleware('auth:sanctum');

// logout
Route::post('visitantes/logout', [VisitanteController::class, 'logout'])->name('visitantes');

// Update password
Route::post('visitantes/actualizar-senha', [VisitanteController::class, 'updatePassword'])->name('visitantes');

// ------------------------------
Route::group(['middleware' => 'auth:sanctum'], function () {
    // Get all visitantes
    Route::get('visitantes', [VisitanteController::class, 'index'])->name('visitantes');

    // Get visitante by id
    Route::get('visitantes/{id}', [VisitanteController::class, 'show'])->name('visitantes');

    // Update visitante
    Route::put('visitantes/{id}', [VisitanteController::class, 'update'])->name('visitantes');

    // Update profile picture
    Route::put('visitantes/{id}/foto-perfil', [VisitanteController::class, 'updatePhoto'])->name('visitantes');

    // Delete visitante
    Route::delete('visitantes/{id}', [VisitanteController::class, 'destroy'])->name('visitantes');

    // Search visitante by name
    Route::get('visitantes/search/{nome}', [VisitanteController::class, 'searchVisitante'])->name('visitantes');
});

// ############################# SOLICITATION ENDPOINT #############################
// Path: /solicitacoes

Route::group(['middleware' => 'auth:sanctum'], function () {

    // Send a notification to diarista
    Route::post('visitante/solicitacoes/{id_diarista}', [SolicitationController::class, 'enviarSolicitacao'])->name('solicitacoes');

    // List all solicitations from visitantes
    Route::get('diarista/solicitacoes', [SolicitationController::class, 'listarSolicitacoes'])->name('solicitacoes');

    // Accept a solicitation as diarista
    Route::post('diarista/solicitacoes/aceitar/{id_solicitacao}', [SolicitationController::class, 'aceitarSolicitacao'])->name('solicitacoes');

    // Reject a solicitation as diarista
    Route::post('diarista/solicitacoes/rejeitar/{id_solicitacao}', [SolicitationController::class, 'rejeitarSolicitacao'])->name('solicitacoes');

    // List all unread solicitations
    Route::get('solicitacoes/nao-lidas', [SolicitationController::class, 'listarSolicitacoesNaoLidas'])->name('solicitacoes');

    // List all rejected solicitations
    Route::get('solicitacoes/rejeitadas', [SolicitationController::class, 'listarSolicitacoesRejeitadas'])->name('solicitacoes');

    // List all accepted solicitations
    Route::get('solicitacoes/aceites', [SolicitationController::class, 'listarSolicitacoesAceites'])->name('solicitacoes');
});





// FALLBACK ROUTE
Route::fallback(function () {
    return response()->json([
        'message' => 'Não existe nenhuma rota com essa rota. Verifique a sua URL.'
    ], 404);
});
