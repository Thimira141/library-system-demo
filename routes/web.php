<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::get('/', [AuthController::class, 'showLogin']);
// login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login-submit', [AuthController::class, 'login'])->name('login-submit');
// dashboard
Route::middleware(['auth'])->group(function () {
    // logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    // view dashboard
    Route::get('/dashboard', fn() => view('dashboard.main-dashboard'))->name('dashboard-main');
    // books section
    Route::get('/books', fn() => view('books.main-list'))->name('books-main-list');
    Route::get('/books/new', fn() => view('books.new-book'))->name('books-new-book');
    Route::get('/books/view', fn() => view('books.view-book'))->name('books-view-book');
});
