<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Accounting\AuthController;
use App\Http\Controllers\Accounting\DashboardController;
use App\Http\Controllers\Accounting\CoaController;
use App\Http\Controllers\Accounting\JurnalController;
use App\Http\Controllers\Accounting\BukuBesarController;
use App\Http\Controllers\Accounting\LabaRugiController;
use App\Http\Controllers\Accounting\NeracaController;

Route::prefix('accounting')->name('accounting.')->middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])   ->name('login');
    Route::post('/login',    [AuthController::class, 'login'])       ->name('login.post');
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])    ->name('register.post');
});

Route::prefix('accounting')->name('accounting.')->middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/',          [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.alias');

    Route::prefix('coa')->name('coa.')->group(function () {
        Route::get('/',          [CoaController::class, 'index'])  ->name('index');
        Route::get('/create',    [CoaController::class, 'create']) ->name('create');
        Route::post('/',         [CoaController::class, 'store'])  ->name('store');
        Route::get('/{id}/edit', [CoaController::class, 'edit'])   ->name('edit');
        Route::put('/{id}',      [CoaController::class, 'update']) ->name('update');
        Route::delete('/{id}',   [CoaController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('jurnal')->name('jurnal.')->group(function () {
        Route::get('/',           [JurnalController::class, 'index'])    ->name('index');
        Route::get('/export-pdf', [JurnalController::class, 'exportPdf'])->name('export-pdf');
        Route::get('/{id}/edit',  [JurnalController::class, 'edit'])     ->name('edit');
        Route::put('/{id}',       [JurnalController::class, 'update'])   ->name('update');
        Route::delete('/{id}',    [JurnalController::class, 'destroy'])  ->name('destroy');
    });

    Route::prefix('buku-besar')->name('buku-besar.')->group(function () {
        Route::get('/',           [BukuBesarController::class, 'index'])    ->name('index');
        Route::get('/export-pdf', [BukuBesarController::class, 'exportPdf'])->name('export-pdf');
    });

    Route::prefix('laba-rugi')->name('laba-rugi.')->group(function () {
        Route::get('/',           [LabaRugiController::class, 'index'])    ->name('index');
        Route::get('/export-pdf', [LabaRugiController::class, 'exportPdf'])->name('export-pdf');
    });

    Route::prefix('neraca')->name('neraca.')->group(function () {
        Route::get('/',           [NeracaController::class, 'index'])    ->name('index');
        Route::get('/export-pdf', [NeracaController::class, 'exportPdf'])->name('export-pdf');
    });
});