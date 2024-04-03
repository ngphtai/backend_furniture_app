<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\PromotionsController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CommentsController;
use App\Http\Controllers\Api\NotificationsController;
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
Route::post('/categories/all', [CategoriesController::class, 'show_all']);
Route::get('/categories/show/{id}', [CategoriesController::class, 'show']); // lấy ra 1 category theo id CAAFN SUA

//promotion
Route::get('/promotions/all', [PromotionsController::class, 'index']);

//product
Route::post('/products/all', [ProductsController::class, 'showAll']);
Route::patch('/products/update/{id}',[ProductsController::class,'update']);

//user
Route::post('/users/update_avatar', [UsersController::class, 'update_avatar']);
Route::post('/users/create', [UsersController::class, 'create']);
Route::post('/users/profile', [UsersController::class, 'show']);
Route::post('/users/update_profile', [UsersController::class, 'update']);

//cart
Route::post('/carts/create', [CartController::class, 'addToCart']);
Route::post('/carts/update', [CartController::class, 'update']);
Route::post("/carts/delete", [CartController::class, 'delete']);
Route::get('/carts/show/', [CartController::class, 'get']);

//comment
Route::post('/comments/create', [CommentsController::class, 'create']);
Route::get('/comments/show/', [CommentsController::class, 'show']);
Route::post('/comments/addkey', [CommentsController::class, 'addForbiddeneywords']);
Route::delete('/comments/delete/', [CommentsController::class, 'delete']);


//Notification
Route::post('/notifications/create', [NotificationsController::class, 'create']);
Route::get('/notifications/show/', [NotificationsController::class, 'show']);
Route::get('/notifications/update/', [NotificationsController::class, 'update']);
