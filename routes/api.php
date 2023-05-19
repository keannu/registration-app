<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;

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

Route::prefix('/user')->group(function() {
    Route::get('/', [ UserController::class, 'getUserList' ]);
    Route::get('/{id}', [ UserController::class, 'getUserByNo' ]);
});

Route::prefix('/user')->group(function() {
    Route::post('/login', [ UserController::class, 'loginUser' ]);
    Route::post('/', [ UserController::class, 'createUser' ]);
});
