<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Kategori Produk
Route::resource('categories', CategoryController::class)->except(['show']);
