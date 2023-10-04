<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Link;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\AuthController;

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


// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/links', [LinkController::class, 'index']);
    Route::post('/links', [LinkController::class, 'store']);
    Route::match(['put', 'patch'], '/links/{id}', [LinkController::class, 'update']);
    Route::get('/links/{id}', [LinkController::class, 'show']);
    Route::delete('/links/{id}', [LinkController::class, 'destroy']);

    Route::post('/logout', [AuthController::class, 'logout']);
});
