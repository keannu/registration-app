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

Route::middleware('authChecker')->prefix('/user')->group(function () {
    Route::get('/', [ UserController::class, 'getUserList' ])->middleware('checkIsAdmin');
    Route::get('/logout', [ UserController::class, 'logoutUser' ]);
    Route::get('/{iUserNo}', [ UserController::class, 'getUserByNo' ]);
    Route::put('/{iUserNo}', [ UserController::class, 'updateUser' ]);
    Route::delete('/{iUserNo}', [ UserController::class, 'deleteUser' ]);
});

Route::middleware('authLoggedInChecker')->prefix('/user')->group(function () {
    Route::post('/login', [ UserController::class, 'loginUser' ]);
    Route::post('/', [ UserController::class, 'createUser' ]);
});
