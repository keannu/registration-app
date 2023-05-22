<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', function () {
    return view('login');
})->name('login')->middleware('authLoggedInChecker');

Route::middleware([ 'authChecker' ])->prefix('/dashboard')->group(function () {
    $aParameters = [
        'username' => Cache::get('username'),
        'is_admin' => Cache::get('is_admin'),
        'user_no'  => Cache::get('user_no')
    ];

    Route::get('/', function () use ($aParameters) {
        return view('dashboard', $aParameters);
    })->name('dashboard.main');

    Route::get('/list', function () use ($aParameters) {
        return view('dashboard', $aParameters);
    })->name('dashboard.list')->middleware('checkIsAdmin');
});