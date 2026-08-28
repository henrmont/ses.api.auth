<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['api'])
    ->prefix('auth')
    ->name('auth.')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('login', 'login')->name('login');
        Route::get('me', 'me')->name('me');
        Route::post('logout', 'logout')->name('logout'); // Alterado para POST por ser boa prática
        Route::post('refresh', 'refresh')->name('refresh'); // Alterado para POST por ser boa prática
    });
