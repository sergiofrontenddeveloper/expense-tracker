<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'auth.login');

Route::view('/register', 'auth.register');

Route::view('/dashboard', 'dashboard.index');

Route::view('/expenses', 'expenses.index');

Route::view('/revenue', 'revenue.index');

Route::view('/files', 'files.index');

Route::view('/profile', 'profile.index');
