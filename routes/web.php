<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\Api\PromotionsController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\api\ChatboxController;
use App\Http\Controllers\testController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\CommentsController;
use App\Http\Controllers\Api\ColorsController;
use App\Http\Controllers\Api\OrdersController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\Api\RefundRequestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// cái này là rou
Route::get('/', [HomePageController::class, 'Login']);
Route::post('/admin/login', [HomePageController::class, 'actionLogin']);
Route::group(['middleware'=> 'checkAdminLogin' ],function () {

    Route::get('/homepage',[HomePageController::class,'index']);
    Route::get('/logout', [HomePageController::class, 'actionLogout'])-> name ('logout');


    Route::get('/admin/profile', [UsersController::class, 'profile'])->name('admin.profile');
    Route::post('/admin/profile', [UsersController::class, 'profile'])->name('admin.profile');

    Route::group(['prefix' => '/promotions'], function () {
        Route::get('/index', [PromotionsController::class, 'index'])->name('promotion.index');
        Route::get('/search', [PromotionsController::class, 'search_admin'])->name('promotion.search');;
        Route::get('/edit', [PromotionsController::class, 'edit'])->name('promotion.edit');
        Route::post('/store', [PromotionsController::class, 'store'])->name('promotion.store');
        Route::post('/update/{id}', [PromotionsController::class, 'update'])->name('promotion.update');
        Route::get('/delete/{id}', [PromotionsController::class, 'destroy']);
        //api cần get promotion theo id và tất cả thôi
    }); //done

    Route::group(["prefix" => '/categories'], function () {
        Route::get('/index', [CategoriesController::class, 'index'])->name('category.index');
        Route::get('/search', [CategoriesController::class, 'search'])->name('category.search');;
        Route::get('/edit', [CategoriesController::class, 'edit'])->name('category.edit');
        Route::post('/store', [CategoriesController::class, 'create'])->name('category.store');
        Route::post('/update/{id}', [CategoriesController::class, 'update'])->name('category.update');
        Route::get('/delete/{id}', [CategoriesController::class, 'destroy']);
    });

    Route::group(["prefix" => '/users'], function () {
        Route::get('/index', [UsersController::class, 'index'])->name('user.index');
        Route::post('/index', [UsersController::class, 'index'])->name('user.index');
        Route::get('/search', [UsersController::class, 'search'])->name('user.search');;
        Route::post('/store', [UsersController::class, 'addNewUser'])->name('user.store');
        Route::get('/block/{id}', [UsersController::class, 'block']);
        Route::post('/update', [UsersController::class, 'update'])->name('user.update');
        Route::post('/changePass', [UsersController::class, 'changePass'])->name('user.changePass');

    });

    Route::group(['prefix' => '/products'], function () {
        Route::get('/index', [ProductsController::class, 'index'])->name('product.index');
        Route::get('/detail/{id}', [ProductsController::class, 'detail'])->name('product.detail');
        Route::get('/addproduct', [ProductsController::class, 'addProduct'])->name('product.addProduct');
        Route::get('/search', [ProductsController::class, 'search_admin'])->name('product.search_admin');
        Route::post('/create', [ProductsController::class, 'store'])->name('product.store');
        Route::any('/update/{id}', [ProductsController::class, 'update'])->name('product.update');
        Route::get('/delete/{id}', [ProductsController::class, 'destroy'])->name('product.delete');
    });


    Route::group(['prefix' => '/comments'], function () {
        Route::get('/index', [CommentsController::class, 'index'])->name('comment.index');
        Route::get('/search', [CommentsController::class, 'search'])->name('comment.search');
        Route::post('/add_forbidden_keywords', [CommentsController::class, 'addForbiddeneywords'])->name('comment.add_keyword');
        Route::get('/delete/key', [CommentsController::class, 'delete'])->name('comment.delete_keyword');
    });


    Route::group(['prefix' => '/colors'], function () {
        Route::post('/add', [ColorsController::class, 'add'])->name('color.add');
        Route::get('/edit', [ColorsController::class, 'edit'])->name('color.edit');
    });
    Route::get('/chatbox', [ChatboxController::class, 'index']);

    Route::group(['prefix'=> '/orders'], function(){
        Route::get('/index/v0', [OrdersController::class, 'index'])->name('order.index');
        Route::get('/index/v1', [OrdersController::class, 'index_1'])->name('order.index.v1');
        Route::get('/index/v2', [OrdersController::class, 'index_2'])->name('order.index.v2');
        Route::get('/index/v3', [OrdersController::class, 'index_3'])->name('order.index.v3');
        Route::get('/index/v4', [OrdersController::class, 'index_4'])->name('order.index.v4');
        Route::get('/index/v5', [OrdersController::class, 'index_5'])->name('order.index.v5');
        Route::get('/index/v6', [OrdersController::class, 'index_6'])->name('order.index.v6');

        Route::get('/search', [OrdersController::class, 'search'])->name('order.search');
        Route::get('/detail', [OrdersController::class, 'show'])->name('order.detail');
        Route::get('product/detail1', [ProductsController::class, 'detail1'])->name('product.detail1');
        Route::any('/updatenextdone', [OrdersController::class, 'updatedone'])->name('order.update-next-is-done');
        Route::any('/updateretreatdone', [OrdersController::class, 'updateretreatdone'])->name('order.update-retreat-is-done');
        Route::any('/updateOrder', [OrdersController::class, 'updateIsDone'])->name('order.updateOrder');
        Route::any('/approveRefund', [RefundRequestController::class, 'update'])->name('order.approveRefund');
        Route::any('/approve', [RefundRequestController::class, 'index'])->name('order.approve');
        Route::get('/request/search', [RefundRequestController::class, 'search'])->name('request.searchRequest');

        Route::get('/toPDF/{id}', [OrdersController::class, 'toPDF'])->name('order.toPDF');
    });

    Route::get('/generate-pdf', [PdfController::class, 'generatePDF'])-> name('generate-pdf');
});

Route::get('/test', [PdfController::class, 'index']);


