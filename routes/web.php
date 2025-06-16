<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\dashboard\AdminController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ColorController;
use App\Http\Controllers\dashboard\InformationController;
use App\Http\Controllers\dashboard\MessageController as DashboardMessageController;
use App\Http\Controllers\dashboard\OrderController as DashboardOrderController;
use App\Http\Controllers\dashboard\ProductController as DashboardProductController;
use App\Http\Controllers\dashboard\ZipCodeController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Front\MessageController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\Front\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Handle Not found Routes
Route::fallback(function () {
    if (Auth::guard('admin')->check())
        return to_route('dashboard');
    return to_route('home');
});

// Auth Routes
Route::controller(AuthController::class)->group(function () {
    Route::middleware("redirectIfAuthenticated")->group(function () {
        Route::get('/register', 'showRegister')->name('register.show');
        Route::post('/register', 'register')->name('register');
        Route::get('/login', 'showLogin')->name('login.show');
        Route::post('/login', 'login')->name('login');
    });
    Route::post('/logout', 'logout')->name('logout');
});

// Front Routes
Route::middleware("redirectIfAdmin")->group(function () {
    Route::controller(FrontController::class)->group(function () {
        Route::get('/', 'home')->name('home');
        Route::get('/about', 'about')->name('about');
    });
    Route::prefix("/products")->controller(ProductController::class)->group(function () {
        Route::get('/', 'index')->name('products.index');
        Route::get('/{product}', 'show')->name('products.show');
    });
    Route::middleware("auth:web")->group(function () {
        Route::controller(MessageController::class)->group(function () {
            Route::get('/contact', 'create')->name('messages.create');
            Route::post('/contact', 'store')->name('messages.store');
        });
        Route::controller(CartController::class)->group(function () {
            Route::get('/cart', 'index')->name('cart.index');
            Route::post('/cart', 'store')->name('cart.store');
            Route::put('/cart', 'update')->name('cart.update');
            Route::delete('/cart', 'destroy')->name('cart.destroy');
        });
        Route::resource('/orders', OrderController::class)->only(['index', 'show', 'create', 'store']);
    });
});

// Dashboard  Routes
Route::middleware("auth:admin")->prefix("admin/")->group(function () {
    Route::get("/", function () {
        return view("dashboard.index");
    })->name("dashboard");
    Route::resource("adminProducts", DashboardProductController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource("categories", CategoryController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::get("categories/{category}/products", [CategoryController::class, 'products'])->name("categories.products");
    Route::resource("admins", AdminController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource("colors", ColorController::class)->only(['index', 'show', 'store', 'edit', 'update', 'destroy']);
    Route::resource("messages", DashboardMessageController::class)->only(['index', 'destroy']);
    Route::put('/messages/{id}', [DashboardMessageController::class, 'readMessage'])->name("messages.readMessage");
    Route::prefix("/information")->controller(InformationController::class)->group(function () {
        Route::get("/edit", 'edit')->name("information.edit");
        Route::put("/edit", 'update')->name('information.update');
    });
    Route::resource('/zip_code', ZipCodeController::class)->only(['store', 'edit', 'update', 'destroy']);
    Route::prefix('/orders')->controller(DashboardOrderController::class)->group(function () {
        Route::get('/', 'index')->name('adminOrders.index');
        Route::get('/{order}', 'show')->name('adminOrders.show');
        Route::put("{order}", 'changeStatusToDelivered')->name('adminOrders.changeStatus');
    });
});
