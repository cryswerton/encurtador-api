<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Link;
use App\Http\Controllers\LinkController;

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

Route::get('/links', [LinkController::class, 'index']);

Route::post('/links', [LinkController::class, 'store']);

Route::match(['put', 'patch'], '/links/{id}', [LinkController::class, 'update']);

Route::get('/links/{id}', [LinkController::class, 'show']);

Route::delete('/links/{id}', [LinkController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
