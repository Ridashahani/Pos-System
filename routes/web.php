<?php

use Illuminate\Support\Facades\Route;

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