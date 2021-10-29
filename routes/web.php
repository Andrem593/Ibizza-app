<?php

use App\Http\Controllers\Admi\homeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\EmpresariaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\PremioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\webController;

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

//RUTAS PAGINA PRINCIPAL

Route::get('/', webController::class)->name('web');
Route::post('/store', [webController::class,'addToCart']);
Route::post('/delete', [webController::class,'deleteToCart']);
Route::get('/carrito', function () {
    return view('web.carrito');
});

// RUTAS DASHBOARD
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

Route::middleware(['auth:sanctum', 'verified'])
->get('/producto/estilos', [ProductoController::class,'productoEstilos'])
->name('producto.estilos');

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

// CATALOGO

Route::resource('catalogos', CatalogoController::class)
->middleware(['auth:sanctum', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])
->post('/catalogo/datatable', [CatalogoController::class,'catalogoDataTable'])
->name('catalogo.datatable');

Route::middleware(['auth:sanctum', 'verified'])
->get('/catalogo/catalogoProducto', [CatalogoController::class,'catalogoProducto'])
->name('catalogo.catalogoProducto');

Route::middleware(['auth:sanctum', 'verified'])
->post('/catalogo/asignarProducto', [CatalogoController::class,'asignarProducto'])
->name('catalogo.asignarProducto');

// PREMIO

Route::resource('premios', PremioController::class)
->middleware(['auth:sanctum', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])
->post('/premio/datatable', [PremioController::class,'premioDataTable'])
->name('premio.datatable');

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

// EMPRESARIA

Route::resource('empresarias', EmpresariaController::class)
->middleware(['auth:sanctum', 'verified']);

Route::middleware(['auth:sanctum', 'verified'])
->post('/empresaria/ciudad', [EmpresariaController::class,'consultarCiudad'])
->name('empresaria.ciudad');

Route::middleware(['auth:sanctum', 'verified'])
->post('/empresaria/datatable', [EmpresariaController::class,'empresariaDatatable'])
->name('empresaria.datatable');
