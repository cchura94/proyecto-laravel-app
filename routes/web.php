<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(["auth"])->prefix('admin')->group(function(){
    // /admin
    Route::get("/", function(){
        return view("admin.index");
    });
    // /admin/users
    Route::get("/users", function(){
        return view("admin.usuarios.lista");
    });

    // nuevas rutas
    
    // /admin/categoria
    Route::resource("/categoria", CategoriaController::class);
    Route::resource("/producto", ProductoController::class);
    Route::resource("/cliente", ClienteController::class);
    Route::resource("/pedido", PedidoController::class);


});
