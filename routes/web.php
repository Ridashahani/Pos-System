<?php

use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;

Route::get('/', function () {
    return view('dashboard');
});

Route::resource('purchases', PurchaseController::class);
Route::resource('categories', CategoryController::class);
Route::resource('subcategories', SubcategoryController::class);
// Route::view('/category', 'category.index');
