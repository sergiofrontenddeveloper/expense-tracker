<?php

use App\Http\Controllers\AuthController; 
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/expenses', [ExpensesController::class, 'index'])->name('expenses');
    Route::post('/expenses', [ExpensesController::class, 'store'])->name('expenses.store');
    Route::put('/expenses/{expense}', [ExpensesController::class, 'update'])->name('expenses.update');
    Route::delete('/expenses/{expense}', [ExpensesController::class, 'destroy'])->name('expenses.destroy');

    Route::get('/revenue', [RevenueController::class, 'index'])->name('revenue');
    Route::post('/revenue', [RevenueController::class, 'store'])->name('revenue.store');
    Route::put('/revenue/{revenue}', [RevenueController::class, 'update'])->name('revenue.update');
    Route::delete('/revenue/{revenue}', [RevenueController::class, 'destroy'])->name('revenue.destroy');

    Route::get('/files', [FilesController::class, 'index'])->name('files');
    Route::post('/files', [FilesController::class, 'store'])->name('files.store');
    Route::get('/files/{file}/download', [FilesController::class, 'download'])->name('files.download');
    Route::delete('/files/{file}', [FilesController::class, 'destroy'])->name('files.destroy');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // 🚨 NUEVAS RUTAS DE NOTIFICACIONES Y PRESUPUESTO INTEGRADAS AQUÍ
    Route::post('/user/update-limit', [NotificationController::class, 'updateLimit'])->name('user.updateLimit');
    Route::get('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::get('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});
