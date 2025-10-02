<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\POS\POSDashboardController;
use App\Http\Controllers\POS\POSLoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Customer Portal Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Customer Dashboard (requires authentication and customer role)
Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Portal Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    
    // Admin Authentication Routes (guest only)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'create'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'store']);
    });

    // Admin Protected Routes (requires authentication and admin role)
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminLoginController::class, 'destroy'])->name('logout');

        // User Management Routes
        Route::resource('users', UserManagementController::class);
        Route::post('users/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])
            ->name('users.toggle-status');
        Route::post('users/{user}/update-password', [UserManagementController::class, 'updatePassword'])
            ->name('users.update-password');
    });
});

/*
|--------------------------------------------------------------------------
| POS Portal Routes
|--------------------------------------------------------------------------
*/

Route::prefix('pos')->name('pos.')->group(function () {
    
    // POS Authentication Routes (guest only)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [POSLoginController::class, 'create'])->name('login');
        Route::post('/login', [POSLoginController::class, 'store']);
    });

    // POS Protected Routes (requires authentication and pos role)
    Route::middleware(['auth', 'pos'])->group(function () {
        Route::get('/dashboard', [POSDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [POSLoginController::class, 'destroy'])->name('logout');
    });
});

// Include customer authentication routes (register, login, password reset)
require __DIR__.'/auth.php';
