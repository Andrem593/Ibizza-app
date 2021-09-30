<?php

use App\Http\Controllers\Admi\homeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MarcaController;

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

Route::middleware(['auth:sanctum', 'verified'])
->get('/producto/upload', [ProductController::class,'productoUpload'])
->name('producto.upload');

Route::middleware(['auth:sanctum', 'verified'])
->get('/producto/create', [ProductController::class,'store'])
->name('producto.store');

Route::resource('marcas', MarcaController::class)
->middleware(['auth:sanctum', 'verified']);

// Route::middleware(['auth:sanctum', 'verified'])
// ->get('/marca', [MarcaController::class,'index'])
// ->name('marca.index');

Route::middleware(['auth:sanctum', 'verified'])
->get('/usuario/create/', [homeController::class,'userCreate'])
->name('usuario.create');

Route::middleware(['auth:sanctum', 'verified'])
->post('/usuario/create', [userController::class,'store'])
->name('new.user');