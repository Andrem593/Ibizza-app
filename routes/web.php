<?php

use App\Http\Controllers\Admi\homeController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;

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

Route::middleware(['can:dashboard','auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// PRODUCTO

Route::middleware(['auth:sanctum', 'verified'])
->get('/producto/upload', [ProductoController::class,'productoUpload'])
->name('producto.upload');

Route::middleware(['auth:sanctum', 'verified'])
->post('/producto/datatable', [ProductoController::class,'productoDataTable'])
->name('producto.datatable');

Route::resource('productos', ProductoController::class)
->middleware(['auth:sanctum', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])
->post('/producto/saveExcel/', [ProductoController::class,'saveExcel'])
->name('producto.saveExcel');

// MARCA

Route::resource('marcas', MarcaController::class)
->middleware(['auth:sanctum', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])
->post('/marca/datatable', [MarcaController::class,'marcaDataTable'])
->name('marca.datatable');

// PROVEEDOR

Route::resource('proveedores', ProveedorController::class)
->middleware(['auth:sanctum', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])
->post('/proveedor/datatable', [ProveedorController::class,'proveedorDataTable'])
->name('proveedor.datatable');

// USUARIO

Route::middleware(['auth:sanctum', 'verified'])
->get('/usuario/create/', [homeController::class,'userCreate'])
->name('usuario.create');

Route::middleware(['auth:sanctum', 'verified'])
->post('/usuario/create', [userController::class,'store'])
->name('new.user');

// ROL

Route::resource('roles', RoleController::class)
->middleware(['auth:sanctum', 'verified'])
->names('admin.roles');