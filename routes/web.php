<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Books\BooksController;
use App\Http\Controllers\Books\CategoryController;
use App\Http\Controllers\Members\MemberController;

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
    Route::get('/books', [BooksController::class, 'viewBooksDashboard'])->name('books-main-list');
    Route::get('/books/data', [BooksController::class, 'BooksDashboardDataHandler_AJAX'])->name('books-main-list-get');
    Route::post('/books/data', [BooksController::class, 'BooksDashboardDataHandler_AJAX'])->name('books-main-list-post');
    Route::get('/books/new', fn() => view('books.new-book'))->name('books-new-book');
    Route::post('/books/new-book', [BooksController::class, 'createNewBook'])->name('books-create-new-book');
    Route::get('/books/view/{book_id}', [BooksController::class, 'viewBook'])->name('books-view-book');
    Route::get('/books/edit/{book_id}', [BooksController::class, 'viewEditBook'])->name('books-edit-book');
    Route::post('/books/save-edit/{book_id}', [BooksController::class, 'saveEditBook'])->name('books-save-edit-book');
    Route::delete('/books/delete/{book_id}', [BooksController::class, 'deleteBook'])->name('books-delete-book');
    // members section
    Route::get('/members', [MemberController::class, 'viewMemberDashboard'])->name('members-main-list');
    Route::get('/members/data', [MemberController::class, 'MembersDashboardDataHandler_AJAX'])->name('members-main-list-get');
    Route::post('/members/data', [MemberController::class, 'MembersDashboardDataHandler_AJAX'])->name('members-main-list-post');
    Route::get('/members/new', fn() => view('members.new-member'))->name('members-new-member');
    Route::post('/members/new-member', [MemberController::class, 'createMember'])->name('members-create-new-member');
    Route::get('/members/view/{member_id}', [MemberController::class, 'viewMember'])->name('members-view-member');
    Route::get('/members/edit/{member_id}', [MemberController::class, 'viewEditMember'])->name('members-edit-member');
    Route::post('/members/save-edit/{member_id}', [MemberController::class, 'saveEditMember'])->name('members-save-edit-member');
    Route::delete('/members/delete/{member_id}', [MemberController::class, 'deleteMember'])->name('members-delete-member');

    // GET-ajax routes
    Route::get('/ajax/category', [CategoryController::class, 'getCategory']);
});
