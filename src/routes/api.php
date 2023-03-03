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

Route::get("/login", function(){
    return "Todo API";
});

Route::post("/register", [\App\Http\Controllers\API\UserApiController::class, "store"])->name("api.registration");
Route::post("/login", [\App\Http\Controllers\API\UserApiController::class, "login"])->name("login");

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout',
        [\App\Http\Controllers\API\UserApiController::class, 'logout']
    )->name('api.logout');

    Route::apiResource('todos', \App\Http\Controllers\API\TodoApiController::class);
    Route::apiResource('tasks', \App\Http\Controllers\API\TaskApiController::class);

});
