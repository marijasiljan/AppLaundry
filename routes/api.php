<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend;

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


Route::middleware(['token'])->group(function () {
    Route::post('/logout', [Backend\Auth\AuthController::class, 'logout']);

    //Users
    Route::group(['prefix' => '/users'], function () {
        Route::get('/', [Backend\UserController::class, 'index']);
        Route::get('/admins', [Backend\UserController::class, 'getAdmin']);
        Route::get('/employees', [Backend\UserController::class, 'getEmployee']);
        Route::get('/businesses', [Backend\UserController::class, 'getBusiness']);
        Route::get('/workplace', [Backend\UserController::class, 'getWorkPlace']);
        Route::get('/accountants', [Backend\UserController::class, 'getAccountant']);
        Route::post('/store', [Backend\UserController::class, 'store']);
        Route::delete('/{id}/delete', [Backend\UserController::class, 'destroy']);
        Route::put('/{id}/delete', [Backend\UserController::class, 'destroy']);
        Route::put('/{id}/restore', [Backend\UserController::class, 'restore']);
    });

    //Business
    Route::group(['prefix' => '/business'], function () {
        Route::get('/', [Backend\BusinessController::class, 'index']);
        Route::post('/store', [Backend\BusinessController::class, 'store']);
        Route::delete('/{id}/delete', [Backend\BusinessController::class, 'destroy']);
        Route::put('/{id}/delete', [Backend\BusinessController::class, 'destroy']);
        Route::put('/{id}/restore', [Backend\BusinessController::class, 'restore']);
    });

    //Products
    Route::group(['prefix' => '/products'], function () {
        Route::get('/', [Backend\ProductsController::class, 'index']);
        Route::post('/store', [Backend\ProductsController::class, 'store']);
        Route::delete('/{id}/delete', [Backend\ProductsController::class, 'destroy']);
        Route::put('/{id}/delete', [Backend\ProductsController::class, 'destroy']);
    });

    //Orders
    Route::group(['prefix' => '/orders'], function () {
        Route::get('/', [Backend\OrdersController::class, 'index']);
        Route::post('/store', [Backend\OrdersController::class, 'store']);
        Route::delete('/{id}/delete', [Backend\OrdersController::class, 'destroy']);
        Route::put('/{id}/delete', [Backend\OrdersController::class, 'destroy']);
        Route::put('/{id}/restore', [Backend\OrdersController::class, 'restore']);
    });

    //Business Stock
    Route::group(['prefix' => '/business-stock'], function () {
        Route::get('/', [Backend\BusinessStockController::class, 'index']);
        Route::post('/store', [Backend\BusinessStockController::class, 'store']);
        Route::delete('/{id}/delete', [Backend\BusinessStockController::class, 'destroy']);
        Route::put('/{id}/delete', [Backend\BusinessStockController::class, 'destroy']);
        Route::put('/{id}/restore', [Backend\BusinessStockController::class, 'restore']);
    });

    //Order Items
    Route::group(['prefix' => '/order-items'], function () {
        Route::get('/', [Backend\OrderItemsController::class, 'index']);
        Route::post('/store', [Backend\OrderItemsController::class, 'store']);
        Route::delete('/{id}/delete', [Backend\OrderItemsController::class, 'destroy']);
        Route::put('/{id}/delete', [Backend\OrderItemsController::class, 'destroy']);
        Route::put('/{id}/restore', [Backend\OrderItemsController::class, 'restore']);
    });

    //Transactions
    Route::group(['prefix' => '/transactions'], function () {
        Route::get('/', [Backend\TransactionsController::class, 'index']);
        Route::post('/store', [Backend\TransactionsController::class, 'store']);
        Route::delete('/{id}/delete', [Backend\TransactionsController::class, 'destroy']);
        Route::put('/{id}/delete', [Backend\TransactionsController::class, 'destroy']);
        Route::put('/{id}/restore', [Backend\TransactionsController::class, 'restore']);
    });
});

Route::post('/register', [Backend\Auth\AuthController::class, 'register']);
Route::post('/login', [Backend\Auth\AuthController::class, 'login']);

Route::get('/qr', [Backend\BusinessController::class, 'show']);

