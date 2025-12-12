<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowedBookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TransactionController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Mail;
use App\Http\Middleware\IsLoginMiddleware;

Route::middleware(['locale'])->group(function () {
    Route::get('/', function () {
        return view('landing');
    })->name('landing');
    
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::resource('books', BookController::class)->only(['index', 'show', 'create']);
    
    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('categories', CategoryController::class);
        Route::resource('authors', AuthorController::class);
        Route::resource('books', BookController::class)->except(['index', 'show', 'create']);
    });
    
    Route::middleware([IsLoginMiddleware::class])->group(function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::post('/borrow', [BorrowedBookController::class, 'borrow'])->name('borrow.book');
        Route::post('/return', [BorrowedBookController::class, 'returnBook'])->name('return.book');
        Route::get('/my-books', [BorrowedBookController::class, 'myBooks'])->middleware('auth')->name('mybooks');
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::post('/profile', [UserController::class, 'update'])->name('profile.update');
        Route::post('/transactions/create', [TransactionController::class, 'createTransaction'])->name('transactions.create');
        Route::get('/transactions/success', [TransactionController::class, 'success'])->name('transactions.success');
    
    });
    
    Route::get('/books/{id}', [HomeController::class, 'show'])->name('books.show');
    Route::get('/authors/{author}', [AuthorController::class, 'profile'])->name('author.profile');
    Route::post('/authors/{author}/follow', [AuthorController::class, 'toggleFollow'])->name('author.follow')->middleware('auth');
    Route::post('/follow/{id}', [UserController::class, 'toggleFollow'])->name('user.follow')->middleware('auth');

    Route::get('/otp', [AuthController::class, 'otpForm'])->name('otp.form');
    Route::post('/otp', [AuthController::class, 'verifyOtp'])->name('otp.verify');
    Route::get('/otp/resend', function () {
        return back();
    })->name('otp.resend');
    
    
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::get('/reviews/{id}', [ReviewController::class, 'review'])->name('review.create');
    Route::post('/reviews/{id}/store', [ReviewController::class, 'store'])->name('review.store');
    Route::get('/reviews-list', [ReviewController::class, 'index'])->name('review.list');
    Route::get('/reviews-show/{id}', [ReviewController::class, 'showReview'])->name('review.show');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('review.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('review.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('review.destroy');
    Route::post('/review/{id}/like', [ReviewController::class, 'toggleLike'])->middleware('auth')->name('review.like');
    Route::post('/review/{id}/dislike', [ReviewController::class, 'toggleDislike'])->middleware('auth')->name('review.dislike');

    Route::middleware([IsLoginMiddleware::class])->group(function () {
      Route::post('/borrow', [BorrowedBookController::class, 'borrow'])->name('borrow.book');
      Route::post('/return', [BorrowedBookController::class, 'returnBook'])->name('return.book');
      Route::get('/my-books', [BorrowedBookController::class, 'myBooks'])->middleware('auth')->name('mybooks');

      Route::get('/profile', [UserController::class, 'profile'])->name('profile');
      Route::post('/profile', [UserController::class, 'update'])->name('profile.update');

      Route::get('/privacy', [UserController::class, 'privacy'])->name('privacy');
      Route::post('/privacy', [UserController::class, 'updatePrivacy'])->name('privacy.update');

      Route::get('/buy/{book}', [BookController::class, 'createBuyView'])->name('transactions.create_view');

      Route::post('/transactions/create', [TransactionController::class, 'createTransaction'])->name('transactions.create');
      Route::get('/transactions/success', [TransactionController::class, 'success'])->name('transactions.success');
    });

  Route::get('/books/{id}', [HomeController::class, 'show'])->name('books.show');

  Route::get('/otp', [AuthController::class, 'otpForm'])->name('otp.form');
  Route::post('/otp', [AuthController::class, 'verifyOtp'])->name('otp.verify');
  Route::get('/otp/resend', function () {
      return back();
  })->name('otp.resend');



  Route::post('/books', [BookController::class, 'store'])->name('books.store');
  Route::get('/reviews/{id}', [ReviewController::class, 'review'])->name('review.create');
  Route::post('/reviews/{id}/store', [ReviewController::class, 'store'])->name('review.store');
  Route::get('/reviews-list', [ReviewController::class, 'index'])->name('review.list');
  Route::get('/reviews-show/{id}', [ReviewController::class, 'showReview'])->name('review.show');

});

Route::get('/localization/{loc}', [LocalizationController::class, 'localization'])->name('loc');

Route::get('/books/{book}/access-pdf', [BookController::class, 'accessPdf'])
     ->name('book.access_pdf');

Route::get('/books/{book}/view-only', [BookController::class, 'viewOnly'])->middleware('auth')->name('book.view_only');