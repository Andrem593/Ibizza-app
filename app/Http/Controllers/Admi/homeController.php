<?php

namespace App\Http\Controllers\Admi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class homeController extends Controller
{
    public function index(){
        return view('admin.index');
    }
}
