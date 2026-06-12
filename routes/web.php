<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CocinaController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\MesaController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| CLIENTE
|--------------------------------------------------------------------------
*/

Route::get(
    '/menu/{codigo_qr}',
    [ClienteController::class, 'menu']
)->name('menu');

Route::post('/agregar-carrito', [ClienteController::class, 'agregarCarrito'])
    ->name('agregar.carrito');

Route::get('/carrito', [ClienteController::class, 'carrito'])
    ->name('carrito');

Route::post('/pedido/confirmar', [ClienteController::class, 'confirmarPedido'])
    ->name('pedido.confirmar');

/*
|--------------------------------------------------------------------------
| COCINA
|--------------------------------------------------------------------------
*/

Route::get('/cocina', [CocinaController::class, 'index'])
    ->name('cocina');

Route::post('/cocina/{pedido}/estado', [CocinaController::class, 'cambiarEstado'])
    ->name('cocina.estado');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    Route::resource('productos', ProductoController::class);

    Route::resource('categorias', CategoriaController::class);

    Route::resource('mesas', MesaController::class);
});

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get(
    '/admin/mesas-dashboard',
    [DashboardController::class, 'mesas']
)->name('dashboard.mesas');
