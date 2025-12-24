<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AuthenticateAdmin;
use Illuminate\Support\Facades\Route;

// Main website (ahes.test)
Route::domain(env("APP_DOMAIN"))->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
    Route::get('/know', [HomeController::class, 'know'])->name('know');
    Route::get('/service', [HomeController::class, 'service'])->name('service');

    // User Authentication Routes
    Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [UserAuthController::class, 'login'])->name('login.post');

    Route::get('/register', [UserAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [UserAuthController::class, 'register'])->name('register.post');

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');
    });

    // Contact form submission
    Route::post('/contact/store', [ContactController::class, 'store'])
    ->name('contact.store');
});

// Admin subdomain (admin.ahes.test)
// Route::domain(env("ADMIN_SUB_DOMAIN", 'admin') . "." . env("APP_DOMAIN"))->group(function () {
//     Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
//     Route::post('/login', [AuthController::class, 'login'])->name('admin.login.post');

//     // Register routes
//     Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('admin.register');
//     Route::post('/register', [AuthController::class, 'register'])->name('admin.register.post');

//     // Protected admin routes (requires auth:admin)
//     Route::middleware(AuthenticateAdmin::class)->group(function () {
//         Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
//         Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
//     });
// });
