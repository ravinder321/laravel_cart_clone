<?php

use Illuminate\Support\Facades\Route;
use App\Mail\SendMail;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApiController;
use App\Models\category;
use App\Models\product;


Route::get('/login', [UserController::class, 'login'])->name('users.login');
Route::post('/login', [UserController::class, 'user_login'])->name('users.enter');
Route::get('/register', [UserController::class, 'register'])->name('users.register');
Route::post('/submit', [UserController::class, 'create']);
Route::get('/logout', [UserController::class, 'logout'])->name('users.logout');
Route::get('/', [UserController::class, 'category'])->name('users.home');
Route::get('/product', [UserController::class, 'product']);
// web.php (routes file)
Route::get('/category/{id}', [UserController::class, 'show'])->name('category.show');
Route::get('/product/{id}', [UserController::class, 'product_show'])->name('product.show');
Route::get('/form', [UserController::class, 'form']);

//google login
use App\Http\Controllers\GoogleAuthController;

Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);


//facebook login
use App\Http\Controllers\FacebookAuthController;

Route::get('auth/facebook', [FacebookAuthController::class, 'redirectToFacebook']);
Route::get('auth/facebook/callback', [FacebookAuthController::class, 'handleFacebookCallback']);

use App\Http\Controllers\CartController;

Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::post('cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');

Route::post('/cart/update/{productId}', [CartController::class, 'update'])->name('cart.update');


// routes/web.php


Route::get('/categories', function () {
    return response()->json([
        'categories' => category::all(),
    ]);
});

Route::get('/products', function () {
    $products = Product::inRandomOrder()->take(6)->get();
    return response()->json([
        'products' => $products,
    ]);
});

Route::get('products/{categoryId}', [UserController::class, 'productsByCategory']); 


//register through react
Route::post('react/register', [UserController::class, 'react_register']);


use App\Http\Controllers\Auth\RegisterController;

Route::get('rregister', [RegisterController::class, 'showForm'])->name('register.form');
Route::post('register', [RegisterController::class, 'register'])->name('register.store');

