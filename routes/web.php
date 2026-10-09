<?php

use Illuminate\Support\Facades\Route;
use App\Models\StoreSetting;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NotificationController;

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\StoreStatusController;

use App\Http\Controllers\Driver\DriverAuthController;
use App\Http\Controllers\Driver\DriverOrderController;
use App\Http\Controllers\Driver\DriverDashboardController;

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DriverMiddleware;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/


// Home / Food Dashboard

Route::get('/', [
    ProductController::class,
    'index',
])->name('home');


// Store Status Page

Route::get('/status', function () {

    $setting = StoreSetting::first();

    $isOpen = $setting
        ? $setting->is_open
        : true;

    return view(
        'pages.status',
        compact('isOpen')
    );

})->name('status');


// Tutorial

Route::view('/tutorial', 'pages.tutorial')
    ->name('tutorial');


// Support

Route::view('/support', 'pages.support')
    ->name('support');


// About Us

Route::view('/about-us', 'pages.about')
    ->name('about');


// Product Details

Route::get('/products/{product}', [
    ProductController::class,
    'show',
])->name('products.show');


/*
|--------------------------------------------------------------------------
| Customer Authentication Routes
|--------------------------------------------------------------------------
*/


Route::middleware('guest')->group(function () {


    // Customer Login

    Route::get('/login', [
        AuthController::class,
        'showLogin',
    ])->name('login');


    Route::post('/login', [
        AuthController::class,
        'login',
    ])->name('login.store');


    // Customer Registration

    Route::get('/register', [
        AuthController::class,
        'showRegister',
    ])->name('register');


    Route::post('/register', [
        AuthController::class,
        'register',
    ])->name('register.store');

});


// Customer Logout

Route::post('/logout', [
    AuthController::class,
    'logout',
])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/


Route::middleware('guest')->group(function () {


    // Admin Login Page

    Route::get('/admin/login', [
        AdminAuthController::class,
        'showLogin',
    ])->name('admin.login');


    // Admin Login Submission

    Route::post('/admin/login', [
        AdminAuthController::class,
        'login',
    ])->name('admin.login.store');

});


// Admin Logout

Route::post('/admin/logout', [
    AdminAuthController::class,
    'logout',
])
    ->middleware([
        'auth',
        AdminMiddleware::class,
    ])
    ->name('admin.logout');


/*
|--------------------------------------------------------------------------
| Driver Authentication Routes
|--------------------------------------------------------------------------
*/


Route::get('/driver/login', [
    DriverAuthController::class,
    'showLogin',
])->name('driver.login');


Route::post('/driver/login', [
    DriverAuthController::class,
    'login',
])->name('driver.login.store');


Route::post('/driver/logout', [
    DriverAuthController::class,
    'logout',
])
    ->middleware([
        'auth',
        DriverMiddleware::class,
    ])
    ->name('driver.logout');


/*
|--------------------------------------------------------------------------
| Cart Routes
|--------------------------------------------------------------------------
*/


Route::get('/cart', [
    CartController::class,
    'index',
])->name('cart.index');


Route::get('/cart/data', [
    CartController::class,
    'data',
])->name('cart.data');


Route::post('/cart/add/{product}', [
    CartController::class,
    'add',
])->name('cart.add');


Route::patch('/cart/update/{product}', [
    CartController::class,
    'update',
])->name('cart.update');


Route::delete('/cart/remove/{product}', [
    CartController::class,
    'remove',
])->name('cart.remove');


Route::delete('/cart/clear', [
    CartController::class,
    'clear',
])->name('cart.clear');


/*
|--------------------------------------------------------------------------
| Checkout & Customer Order Routes
|--------------------------------------------------------------------------
*/


Route::middleware('auth')->group(function () {


    // Checkout

    Route::get('/checkout', [
        CheckoutController::class,
        'index',
    ])->name('checkout.index');


    Route::post('/checkout', [
        CheckoutController::class,
        'store',
    ])->name('checkout.store');


    // Customer Orders

    Route::get('/orders', [
        OrderController::class,
        'index',
    ])->name('orders.index');


    Route::get('/orders/{order}', [
        OrderController::class,
        'show',
    ])->name('orders.show');

});


/*
|--------------------------------------------------------------------------
| Notification Routes
|--------------------------------------------------------------------------
*/


Route::middleware('auth')->group(function () {


    Route::get(
        '/notifications/{notification}/open',
        [
            NotificationController::class,
            'open',
        ]
    )->name('notifications.open');


    Route::patch(
        '/notifications/read-all',
        [
            NotificationController::class,
            'markAllAsRead',
        ]
    )->name('notifications.read-all');

});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Authentication + AdminMiddleware
|
|--------------------------------------------------------------------------
*/


Route::prefix('admin')
    ->name('admin.')
    ->middleware([
        'auth',
        AdminMiddleware::class,
    ])
    ->group(function () {


        /*
        |--------------------------------------------------------------------------
        | Admin Dashboard
        |--------------------------------------------------------------------------
        */


        Route::get('/dashboard', [
            DashboardController::class,
            'index',
        ])->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Admin Store Status
        |--------------------------------------------------------------------------
        */


        Route::get('/store-status', [
            StoreStatusController::class,
            'edit',
        ])->name('store-status.edit');


        Route::patch('/store-status', [
            StoreStatusController::class,
            'update',
        ])->name('store-status.update');


        /*
        |--------------------------------------------------------------------------
        | Admin Orders
        |--------------------------------------------------------------------------
        */


        Route::get('/orders', [
            AdminOrderController::class,
            'index',
        ])->name('orders.index');


        Route::get('/orders/{order}', [
            AdminOrderController::class,
            'show',
        ])->name('orders.show');


        Route::patch('/orders/{order}/status', [
            AdminOrderController::class,
            'updateStatus',
        ])->name('orders.update-status');


        Route::patch('/orders/{order}/driver', [
            AdminOrderController::class,
            'assignDriver',
        ])->name('orders.assign-driver');


        /*
        |--------------------------------------------------------------------------
        | Admin Driver Management
        |--------------------------------------------------------------------------
        */


        Route::get('/drivers', [
            DriverController::class,
            'index',
        ])->name('drivers.index');


        Route::get('/drivers/create', [
            DriverController::class,
            'create',
        ])->name('drivers.create');


        Route::post('/drivers', [
            DriverController::class,
            'store',
        ])->name('drivers.store');


        Route::patch('/drivers/{driver}/status', [
            DriverController::class,
            'toggleStatus',
        ])->name('drivers.toggle-status');


        /*
        |--------------------------------------------------------------------------
        | Admin Menu Management
        |--------------------------------------------------------------------------
        */

Route::get('/menu', [
    MenuController::class,
    'index',
])->name('menu.index');


Route::get('/menu/create', [
    MenuController::class,
    'create',
])->name('menu.create');


Route::post('/menu', [
    MenuController::class,
    'store',
])->name('menu.store');


Route::get('/menu/{product}/edit', [
    MenuController::class,
    'edit',
])->name('menu.edit');


Route::put('/menu/{product}', [
    MenuController::class,
    'update',
])->name('menu.update');


Route::delete('/menu/{product}', [
    MenuController::class,
    'destroy',
])->name('menu.destroy');

    });


/*
|--------------------------------------------------------------------------
| Driver Routes
|--------------------------------------------------------------------------
|
| Authentication + DriverMiddleware
|
|--------------------------------------------------------------------------
*/


Route::prefix('driver')
    ->name('driver.')
    ->middleware([
        'auth',
        DriverMiddleware::class,
    ])
    ->group(function () {


        /*
        |--------------------------------------------------------------------------
        | Driver Dashboard
        |--------------------------------------------------------------------------
        */


        Route::get('/dashboard', [
            DriverDashboardController::class,
            'index',
        ])->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Driver Order Cancellation
        |--------------------------------------------------------------------------
        */


        Route::patch('/orders/{order}/cancel', [
            DriverOrderController::class,
            'cancel',
        ])->name('orders.cancel');


        /*
        |--------------------------------------------------------------------------
        | Driver Order Status
        |--------------------------------------------------------------------------
        */


        Route::patch('/orders/{order}/status', [
            DriverOrderController::class,
            'updateStatus',
        ])->name('orders.update-status');

    });