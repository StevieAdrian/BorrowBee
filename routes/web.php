<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowedBookController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Mail;
use App\Http\Middleware\IsLoginMiddleware;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/register', [AuthController::class, 'registerForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'loginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('books', BookController::class)->only(['index', 'show']);

Route::middleware([AdminMiddleware::class])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('authors', AuthorController::class);
    Route::resource('books', BookController::class)->except(['index', 'show']);
});

Route::middleware([IsLoginMiddleware::class])->group(function () {
    Route::post('/borrow', [BorrowedBookController::class, 'borrow'])->name('borrow.book');
    Route::post('/return', [BorrowedBookController::class, 'returnBook'])->name('return.book');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile', [UserController::class, 'update'])->name('profile.update');
});

Route::get('/books/{id}', [HomeController::class, 'show'])->name('books.show');

Route::get('/otp', [AuthController::class, 'otpForm'])->name('otp.form');
Route::post('/otp', [AuthController::class, 'verifyOtp'])->name('otp.verify');
Route::get('/otp/resend', function () {
    return back();
})->name('otp.resend');


