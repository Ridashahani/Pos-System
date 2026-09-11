<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\BranchController;

Route::get('/', function () {
    return view('dashboard');
});

// Route::view('/category', 'category.index');

Route::get('/stock/in', function () {
    return view('stock.stock-in');
});

Route::get('/stock/out', function () {
    return view('stock.stock-out');
});

Route::get('/stock/transfer', function () {
    return view('stock.stock-transfer');
});

Route::resource('categories', CategoryController::class);
Route::resource('subcategories', SubcategoryController::class);
// Route::view('/category', 'category.index');