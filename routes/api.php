<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\ImageController;
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

Route::middleware('auth:sanctum')->group(function (){

    Route::post('/images', [ImageController::class, 'upload']);
    Route::get('/images', [ImageController::class, 'index']);
    Route::get('/images/{image}', [ImageController::class, 'show']);
    Route::delete('/images/{image}', [ImageController::class, 'destroy']);

    Route::post('logout', [AuthController::class, 'logout']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

