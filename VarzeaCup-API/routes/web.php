<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Rotas públicas de autenticação
Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'store'); // Login
    Route::post('/logout', 'destroy')->middleware('auth'); // Logout (protegido)
});

// Rotas protegidas da API
Route::middleware('auth')->group(function () {
    // Rotas de usuários
    Route::apiResource('users', UserController::class);

    // Rotas de times
    Route::apiResource('teams', TeamController::class);

    // Rotas de jogos
    Route::apiResource('games', GameController::class);
});

// Rotas públicas da API (sem autenticação)
// Route::apiResource('users', UserController::class); // Rotas de usuários
// Route::apiResource('teams', TeamController::class); // Rotas de times
// Route::apiResource('games', GameController::class); // Rotas de jogos