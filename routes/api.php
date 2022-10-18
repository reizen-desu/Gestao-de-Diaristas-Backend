<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiaristaController;

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

// Path: routes\api.php

// Get all diaristas
Route::get('diaristas/', [DiaristaController::class, 'getDiarista'])->name('diaristas');

// Get diarista by id
Route::get('diaristas/{id}', [DiaristaController::class, 'getDiaristaById'])->name('diaristas');

// Add diarista
Route::post('diaristas/', [DiaristaController::class, 'addDiarista'])->name('diaristas');