<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;


Route::get('/login/{lang?}', LoginController::class)
                ->middleware('guest')
                ->name('login');

Route::post('/login/operator', [LoginController::class, 'authLogin'])
                ->name('auth.login');

Route::post('/logout', [LoginController::class, 'authLogout'])
                ->name('logout');