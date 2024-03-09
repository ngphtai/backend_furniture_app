<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\PromotionsController;
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

Route::post('/auth/register', [UserController::class, 'createUser']);
Route::post('/auth/login', [UserController::class, 'loginUser']);


//categories
Route::post('/categories/create', [CategoriesController::class, 'create']);
Route::get('/categories/all', [CategoriesController::class, 'index']);
Route::get('/categories/show/{id}', [CategoriesController::class, 'show']); // lấy ra 1 category theo id
Route::patch('/categories/{id}', [CategoriesController::class, 'update']); // cập nhật 1 category theo id
Route::delete('/categories/delete/{id}', [CategoriesController::class, 'destroy']);

//promotion

Route::post('/promotions/create', [PromotionsController::class, 'create']);
Route::get('/promotions/all', [PromotionsController::class, 'index']);
Route::get('/promotions/show/{id}', [PromotionsController::class, 'show']);
Route::put('/promotions/{id}', [PromotionsController::class, 'update']);
Route::delete('/promotions/delete/{id}', [PromotionsController::class, 'destroy']);

// test function

