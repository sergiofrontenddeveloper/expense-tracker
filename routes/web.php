<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::view('/dashboard', 'dashboard.index')->name('dashboard');
Route::view('/expenses', 'expenses.index')->name('expenses');
Route::view('/revenue', 'revenue.index')->name('revenue');
Route::view('/files', 'files.index')->name('files');
Route::view('/profile', 'profile.index')->name('profile');
Route::view('/register', 'auth.register')->name('register');
Route::view('/', 'auth.login')->name('login');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
