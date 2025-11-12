<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AspersionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FincaController;
use App\Http\Controllers\ProductController;


// Rutas públicas
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Rutas protegidas
Route::middleware('finca.auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    
    // Aspersiones
    Route::resource('aspersions', AspersionController::class);
    
    // Rutas solo para admin
    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('fincas', FincaController::class);
        Route::post('fincas/{finca}/password', [FincaController::class, 'setPassword']);
        Route::resource('products', ProductController::class);
        
        // Reportes
        Route::get('/reports/excel', [ReportController::class, 'excel'])->name('reports.excel');
        Route::get('/reports/fincas', [ReportController::class, 'fincas'])->name('reports.fincas');
    });
});
