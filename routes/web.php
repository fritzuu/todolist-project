<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::resource('tasks', TaskController::class);
    Route::patch('tasks/{task}/toggle-status', [TaskController::class, 'toggleStatus'])->name('tasks.toggleStatus');
});
