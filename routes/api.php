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
use App\Http\Controllers\Api\OrdersController;
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

//user
Route::post('/users/update_avatar', [InforUsersController::class, 'update_avatar']);
Route::post('/users/create', [InforUsersController::class, 'create']);
Route::post('/users/profile', [InforUsersController::class, 'show']);
Route::post('/users/update_profile', [InforUsersController::class, 'update']);
Route::post('/users/checklock', [InforUsersController::class, 'checklock']);
// Route::get('bam', [UsersController::class, 'bam']);

//cart
// Route::post('/carts/add', [CartController::class, 'add']);
Route::post('/carts/add', [CartController::class, 'addToCart']);
Route::post('/carts/update', [CartController::class, 'update']);
Route::post('/carts/show/', [CartController::class, 'get']);
Route::post('/carts/delete/', [CartController::class, 'delete']);
Route::post('/carts/checkout', [CartController::class, 'afterCheckout']);


//comment
Route::post('/comments/create', [CommentsController::class, 'create']);
Route::post('/comments/show/', [CommentsController::class, 'show']);
Route::post('/comments/delete/', [CommentsController::class, 'delete']);


//Notification
Route::post('/notifications/create', [NotificationsController::class, 'create']);
Route::post('/notifications/show/', [NotificationsController::class, 'show']);
Route::post('/notifications/update/', [NotificationsController::class, 'update']);

//Payment Stripe
Route::Any('checkout', [PaymentController::class, 'checkout']);
Route::Any('webGoHook', [PaymentController::class, 'webGoHook']);
Route::post('success', [PaymentController::class, 'success']);
Route::post('cancel', [PaymentController::class, 'cancel']);
//VNPay

Route::any('vnpay-return', [VnpayController::class, 'vnpayReturn']);
Route::post('payment-vnpay', [VnpayController::class, 'pay']);
Route::get('test', [VnpayController::class, 'totalPrice']); // test for total price order

//Direct
Route::post('payment-direct', [PaymentController::class, 'direct']);

//Orders
Route::any('/orders/allByUid', [OrdersController::class, 'allByUid']);
Route::post('/orders/show/', [OrdersController::class, 'updatedone']);
Route::any('/search', [OrdersController::class, 'search']);
Route::any('/success/{id}',[OrdersController::class, 'success']);
Route::any('/cancel/{id}',[OrdersController::class, 'cancel']);
//test




