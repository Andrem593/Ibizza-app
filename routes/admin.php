<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admi\homeController;

Route::get('',[homeController::class,'index']);

