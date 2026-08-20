<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReporteExcelController;
use App\Http\Controllers\ClienteController;

Route::get('/', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin', [AdminController::class, 'index'])
    ->middleware('auth')
    ->name('admin');

Route::get('/cliente', function () {
    return view('cliente.dashboard');
})->middleware('auth');

// Rutas de usuario (resource incluye index, store, update, destroy)
Route::resource('usuario', UsuarioController::class)->except(['create', 'edit', 'show']);

Route::get('/admin/reportes/usuarios/excel', [ReporteExcelController::class, 'usuariosExcel'])
    ->name('reportes.usuarios.excel');

Route::get('/admin/reportes/productos/excel', [ReporteExcelController::class, 'productosExcel'])
    ->name('reportes.productos.excel');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard admin
    Route::get('/admin/dashboard', [ProductoController::class, 'index'])
        ->name('admin.dashboard');

    // Registrar producto
    Route::post('/admin/productos', [ProductoController::class, 'store'])
        ->name('productos.store');

    // Actualizar producto
    Route::put('/admin/productos/{producto}', [ProductoController::class, 'update'])
        ->name('productos.update');

    // Eliminar producto
    Route::delete('/admin/productos/{producto}', [ProductoController::class, 'destroy'])
        ->name('productos.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/cliente', [ClienteController::class, 'index'])
        ->name('cliente.dashboard');

    Route::post('/cliente/carrito', [ClienteController::class, 'agregarAlCarrito'])
        ->name('cliente.carrito.agregar');

    Route::put('/cliente/carrito/{carrito}', [ClienteController::class, 'actualizarCarrito'])
        ->name('cliente.carrito.actualizar');

    Route::delete('/cliente/carrito/{carrito}', [ClienteController::class, 'quitarDelCarrito'])
        ->name('cliente.carrito.quitar');

    Route::delete('/cliente/carrito', [ClienteController::class, 'vaciarCarrito'])
        ->name('cliente.carrito.vaciar');

    Route::post('/cliente/checkout', [ClienteController::class, 'finalizarCompra'])
        ->name('cliente.checkout');
});

require __DIR__.'/auth.php';