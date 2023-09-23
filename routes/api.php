<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Link;

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

Route::get('/links', function () {
    return response()->json(Link::all());
});

Route::post('/links', function (Request $request) {
    $link = Link::create($request->all());

    return response()->json($link, 201);
});

Route::match(['put', 'patch'], '/links/{id}', function ($id, Request $request) {
    $link = Link::find($id);

    $link->update($request->all());

    return response()->json($link);
});

Route::get('/links/{id}', function ($id) {
    $link = Link::find($id);
    return response()->json($link);
});

Route::delete('/links/{id}', function ($id) {
    $link = Link::find($id);
    $link->delete();
    return response()->json([], 204);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
