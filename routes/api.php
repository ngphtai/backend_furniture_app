<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\PromotionsController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\UsersController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/




//categories
Route::post('/categories/store', [CategoriesController::class, 'store']);
Route::get('/categories/all', [CategoriesController::class, 'show_all']);
Route::get('/categories/show/{id}', [CategoriesController::class, 'show']); // lấy ra 1 category theo id
Route::patch('/categories/{id}/update', [CategoriesController::class, 'update']); // cập nhật 1 category theo id
Route::delete('/categories/delete/{id}', [CategoriesController::class, 'destroy']);

//promotion

Route::post('/promotions/create', [PromotionsController::class, 'create']);
Route::get('/promotions/all', [PromotionsController::class, 'index']);
Route::patch('/promotions/{id}/update', [PromotionsController::class, 'update']);
Route::delete('/promotions/delete/{id}', [PromotionsController::class, 'destroy']);

//product
Route::post('/products/create', [ProductsController::class, 'create']);
Route::get('/products/all', [ProductsController::class, 'showAll']);
Route::patch('/products/update/{id}',[ProductsController::class,'update']);
//user
Route::get('/users/all', [UsersController::class, 'index']);
Route::patch('/users/update_avatar', [UsersController::class, 'update_avatar']);
Route::post('/users/create', [UsersController::class, 'create']);
Route::post('/users/profile', [UsersController::class, 'show']);
Route::post('/users/update_profile', [UsersController::class, 'update']);

