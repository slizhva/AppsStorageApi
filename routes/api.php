<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/data/get/{set_id}/{token}', [\App\Http\Controllers\DataApiController::class, 'get'])->name('data.get');
Route::post('/data/set/{set_id}/{token}', [\App\Http\Controllers\DataApiController::class, 'set'])->name('data.set');
