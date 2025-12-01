<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AspersionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FincaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CodigoController;
use App\Http\Controllers\MezcalController;
use App\Http\Controllers\ReportController;

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
    Route::post('/api/mix-codes', [AspersionController::class, 'getMixCodes'])->name('api.mix-codes');
    Route::post('/api/codigo-products', [AspersionController::class, 'getCodigoProducts'])->name('api.codigo-products');
    Route::post('/aspersions/get-codigo-products', [AspersionController::class, 'getCodigoProducts'])
    ->name('aspersions.get-codigo-products');
    
    // Rutas solo para admin
    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('fincas', FincaController::class);
        Route::post('fincas/{finca}/password', [FincaController::class, 'setPassword']);
        Route::resource('products', ProductController::class);
        Route::resource('codigos', CodigoController::class);
        Route::get('codigos/{codigo}/productos', [CodigoController::class, 'productos'])->name('codigos.productos');
        Route::post('codigos/{codigo}/productos', [CodigoController::class, 'storeMultipleProductos'])->name('codigos.productos.store');
        Route::delete('codigos/{codigo}/productos/{producto}', [CodigoController::class, 'destroyProducto'])->name('codigos.productos.destroy');
        Route::resource('mezclas', MezcalController::class);
        
        // Reportes
        // Report routes temporarily disabled until ReportController is implemented.
        // Route::get('/reports/excel', [ReportController::class, 'excel'])->name('reports.excel');
        // Route::get('/reports/fincas', [ReportController::class, 'fincas'])->name('reports.fincas');
    });
});