<?php

use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
// use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\BranchController;

Route::get('/', function () {
    return view('dashboard');
});

Route::resource('purchases', PurchaseController::class);
Route::resource('categories', CategoryController::class);
Route::resource('subcategories', SubcategoryController::class);
// Route::view('/category', 'category.index');
Route::resource('categories', CategoryController::class);
Route::resource('subcategories', SubcategoryController::class);
// Route::resource('products', ProductController::class);
Route::resource('vendors', VendorController::class);
Route::resource('branches', BranchController::class);
