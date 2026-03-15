<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Books\BooksController;
use App\Http\Controllers\Books\CategoryController;
use App\Http\Controllers\Members\MemberController;
use App\Http\Controllers\Books\BorrowReturnController;

Route::get('/', [AuthController::class, 'showLogin']);
// auth section
Route::controller(AuthController::class)
    ->prefix('auth')
    ->group(function () {
        Route::get('/login', 'showLogin')->name('login');
        Route::post('/login-submit', 'login')->name('login-submit');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
// dashboard
Route::middleware(['auth'])->group(function () {
    // logout
    // view dashboard
    Route::get('/dashboard', fn() => view('dashboard.main-dashboard'))->name('dashboard-main');
    // books section
    Route::controller(BooksController::class)
        ->prefix('books')
        ->group(function () {
            Route::get('/', 'viewBooksDashboard')->name('books-main-list');
            Route::get('/data', 'BooksDashboardDataHandler_AJAX')->name('books-main-list-get');
            Route::post('/data', 'BooksDashboardDataHandler_AJAX')->name('books-main-list-post');
            Route::get('/new', fn() => view('books.new-book'))->name('books-new-book');
            Route::post('/new-book', 'createNewBook')->name('books-create-new-book');
            Route::get('/view/{book_id}', 'viewBook')->name('books-view-book');
            Route::get('/edit/{book_id}', 'viewEditBook')->name('books-edit-book');
            Route::post('/save-edit/{book_id}', 'saveEditBook')->name('books-save-edit-book');
            Route::delete('/delete/{book_id}', 'deleteBook')->name('books-delete-book');
            Route::get('/ajax/dashboard/books', 'search_books_AJAX')->name('books-search-dashboard-ajax');
            Route::get('/ajax/dashboard/book/{book_id}', 'load_book_AJAX')->name('books-load-dashboard-ajax');
        });
    // members section
    Route::controller(MemberController::class)
        ->prefix('members')
        ->group(function () {
            Route::get('/', 'viewMemberDashboard')->name('members-main-list');
            Route::get('/data', 'MembersDashboardDataHandler_AJAX')->name('members-main-list-get');
            Route::post('/data', 'MembersDashboardDataHandler_AJAX')->name('members-main-list-post');
            Route::get('/new', fn() => view('members.new-member'))->name('members-new-member');
            Route::post('/new-member', 'createMember')->name('members-create-new-member');
            Route::get('/view/{member_id}', 'viewMember')->name('members-view-member');
            Route::get('/edit/{member_id}', 'viewEditMember')->name('members-edit-member');
            Route::post('/save-edit/{member_id}', 'saveEditMember')->name('members-save-edit-member');
            Route::delete('/delete/{member_id}', 'deleteMember')->name('members-delete-member');
            Route::get('/ajax/dashboard/members', 'search_members_AJAX')->name('members-search-dashboard-ajax');
            Route::get('/ajax/dashboard/member/{member_id}', 'load_member_AJAX')->name('members-load-dashboard-ajax');
        });

    // books borrow return
    Route::controller(BorrowReturnController::class)
        ->prefix('bbr')
        ->group(function () {
            Route::get('/check-bbr-prep', 'prepBookBorrowReturn_AJAX')->name('bbr-check-bbr-prep');
            Route::post('/borrow-book', 'BorrowBook_AJAX')->name('bbr-borrow-book');
            Route::post('/return-book', 'ReturnBook_AJAX')->name('bbr-return-book');
        });

    // GET-ajax routes
    Route::get('/ajax/category', [CategoryController::class, 'getCategory']);
});
