<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\Api\PromotionsController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\testController;
use App\Http\Controllers\Api\UsersController;
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
Route::get('/',[HomePageController::class,'index']);
Route::get('/test',[testController::class,'index']);

Route::group([] ,function(){

    Route::get('/logout',[UsersController::class,'Logout']);

    Route::group(['prefix' => '/products'],function(){
        Route::get('/index',[ProductsController::class,'index']);
        Route::post('/create',[ProductsController::class,'create']) -> name ('product.create');
        Route::post('/store',[ProductsController::class,'store']) -> name ('product.store');
        Route::get('/edit/{id}',[ProductsController::class,'edit'])-> name('product.edit');
        Route::post('/update/{id}',[ProductsController::class,'update'])-> name('product.update');
        Route::post('/delete/{id}',[ProductsController::class,'delete'])-> name('product.delete');
    });

    Route::group(['prefix'=> '/promotions'],function(){
        Route::get('/index',[PromotionsController::class,'index']) -> name('promotion.index');
        Route::get('/search',[PromotionsController::class,'search'])       ;
        // Route::get('/create',[PromotionsController::class,'create']) -> name('promotion.create');
        Route::post('/store',[PromotionsController::class,'store']) -> name('promotion.store');
        Route::get('/edit/{id}',[PromotionsController::class,'edit']) -> name('promotion.edit');
        Route::post('/update/{id}',[PromotionsController::class,'update']) -> name('promotion.update');
        Route::get('/delete/{id}',[PromotionsController::class,'destroy'])   -> name('promotion.destroy');
    });

   Route::group(["prefix"=>'/categories'],function(){
       Route::get('/index',[CategoriesController::class,'index']);
       Route::get('/create',[CategoriesController::class,'create'])       -> name('category.create') ;
       Route::post('/store',[CategoriesController::class,'store'])        -> name('category.store');
       Route::get('/edit/{id}',[CategoriesController::class,'edit'])      -> name('category.edit');
       Route::post('/update/{id}',[CategoriesController::class,'update']) -> name('category.update');
       Route::get('/delete/{id}',[CategoriesController::class,'destroy'])  -> name('category.destroy');
   });


   Route::group(["prefix"=>'/users'],function(){
       Route::get('/index',[UsersController::class,'index']);
       Route::get('/create',[UsersController::class,'create']) -> name('user.create');
       Route::post('/store',[UsersController::class,'store']) -> name('user.store');
       Route::get('/edit/{id}',[UsersController::class,'edit']) -> name('user.edit');
       Route::post('/update/{id}',[UsersController::class,'update']) -> name('user.update');
       Route::get('/delete/{id}',[UsersController::class,'delete']) -> name('user.delete');
   });


});
