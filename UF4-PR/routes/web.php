<?php

use Illuminate\Support\Facades\Route;

// Página de login
Route::get('/login', function () {
    return view('login');
});

// Página de productos
Route::get('/products', function () {
    return view('products');
});
