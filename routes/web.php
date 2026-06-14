<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\ProfileController;

Route::get('/', [AuthController::class, 'login'])->name('login');

Route::get('/register', [AuthController::class, 'register'])->name('register');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/expenses', [ExpensesController::class, 'index'])->name('expenses');

Route::get('/revenue', [RevenueController::class, 'index'])->name('revenue');

Route::get('/files', [FilesController::class, 'index'])->name('files');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
