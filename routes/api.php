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
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\VnpayController;
use App\Http\Controllers\Api\InforUsersController;
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
Route::post('/categories/show/{id}', [CategoriesController::class, 'show']); // lấy ra 1 category theo id CAAFN SUA

//promotion
Route::post('/promotions/all', [PromotionsController::class, 'showAll']); // k cần

//product
Route::post('/products/all', [ProductsController::class, 'all']);
Route::post('/products/show', [ProductsController::class, 'show']); // detail product
Route::post('/products/search', [ProductsController::class, 'search']);
// Route::post('/products/categoryId', [ProductsController::class, 'showByCategory']);
// Route::post('/products/update/{id}',[ProductsController::class,'update']);
// update product khi order  xong thì cập nhật lại số lượng sp,sl bán , sau khi xác nhận thành công thì cập nhật lại

//user
Route::post('/users/update_avatar', [InforUsersController::class, 'update_avatar']);
Route::post('/users/create', [InforUsersController::class, 'create']);
Route::post('/users/profile', [InforUsersController::class, 'show']);
Route::post('/users/update_profile', [InforUsersController::class, 'update']);
Route::post('/users/checklock', [InforUsersController::class, 'checklock']);
Route::get('bam', [UsersController::class, 'bam']);

//cart
Route::post('/carts/create', [CartController::class, 'addToCart']);
Route::post('/carts/update', [CartController::class, 'update']);
Route::post("/carts/delete", [CartController::class, 'delete']);
Route::get('/carts/show/', [CartController::class, 'get']);

//comment
Route::post('/comments/create', [CommentsController::class, 'create']);
Route::post('/comments/show/', [CommentsController::class, 'show']);
Route::post('/comments/addkey', [CommentsController::class, 'addForbiddeneywords']);
Route::post('/comments/delete/', [CommentsController::class, 'delete']);


//Notification
Route::post('/notifications/create', [NotificationsController::class, 'create']);
Route::post('/notifications/show/', [NotificationsController::class, 'show']);
Route::post('/notifications/update/', [NotificationsController::class, 'update']);

//Payment Stripe
Route::Any('checkout', [PaymentController::class, 'checkout']);
Route::Any('webGoHook', [PaymentController::class, 'webGoHook']);
Route::Any('success', [PaymentController::class, 'success']);
Route::Any('cancel', [PaymentController::class, 'cancel']);
//VNPay

Route::any('vnpay-return', [VnpayController::class, 'vnpayReturn']);
Route::post('payment-vnpay', [VnpayController::class, 'pay']);


