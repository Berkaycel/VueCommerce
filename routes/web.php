<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\RedirectAdminMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


## Admin Auth Routes
Route::middleware(RedirectAdminMiddleware::class)->prefix('admin')->group(function(){
    Route::get('login',[AdminAuthController::class,'showLoginForm'])->name('admin.login');
    Route::post('login',[AdminAuthController::class,'login'])->name('admin.login');
    Route::post('logout', [AdminAuthController::class,'logout'])->name('admin.logout');
});


## Admin Routes
Route::middleware(['auth',AdminMiddleware::class])->prefix('admin/v1')->group(function(){
    Route::get('dashboard',[AdminController::class,'index'])->name('admin.dashboard');
});

require __DIR__.'/auth.php';
