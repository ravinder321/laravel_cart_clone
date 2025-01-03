<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacebookAuthController;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\GoogleAuthController;

Route::post('/register', [ApiController::class, 'register']);
Route::post('/login', [ApiController::class, 'login']);

Route::get('/category', [ApiController::class, 'datasend']);
Route::get('/products', [ApiController::class, 'product'])->name('login');
Route::get('/products/{categoryId}', [ApiController::class, 'productsByCategory']); 
Route::get('single_products/{productId}', [UserController::class, 'productByproducts']);
Route::middleware('auth:sanctum')->post('/cart/{id}', [CartController::class, 'addToCart']);


Route::post('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

Route::post('facebook/token', [FacebookAuthController::class, 'handleFacebookCallback']);