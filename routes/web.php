<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KalenderController;
use App\Http\Controllers\TugasController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [KalenderController::class, 'index'])->name('kalender');
    Route::get('/tugas', [TugasController::class, 'belumSelesai'])->name('tugas.belum');

    Route::resource('agenda', AgendaController::class)->except(['index', 'show']);
    Route::patch('/agenda/{agenda}/selesai', [AgendaController::class, 'toggle'])->name('agenda.toggle');
});