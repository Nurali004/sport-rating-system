<?php

use Illuminate\Support\Facades\Route;

Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

Route::get('/athletes', [\App\Http\Controllers\Api\AthleteController::class, 'index'])
    ->middleware('auth:api');
