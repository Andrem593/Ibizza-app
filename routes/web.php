<?php

use App\Http\Controllers\Admi\homeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;

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
->get('/producto/upload', [homeController::class,'productoUpload'])
->name('producto.upload');

Route::middleware(['auth:sanctum', 'verified'])
->get('/usuario/create', [homeController::class,'userCreate'])
->name('usuario.create');

Route::middleware(['auth:sanctum', 'verified'])
->post('/usuario/create', [userController::class,'store'])
->name('new.user');