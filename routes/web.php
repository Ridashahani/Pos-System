<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/stock/in', [StockController::class, 'index'])->name('stock.in');
Route::get('/stock/out', function () {
    return view('stock.stock-out');
});
Route::get('/stock/transfer', function () {
    return view('stock.stock-transfer');
});

Route::resource('purchases', PurchaseController::class);
Route::resource('suppliers', SupplierController::class);
Route::resource('categories', CategoryController::class);
Route::resource('subcategories', SubcategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('vendors', VendorController::class);
Route::resource('branches', BranchController::class);
Route::resource('users', UserController::class);
Route::resource('roles', RoleController::class);
