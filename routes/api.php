<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Middleware\IsLoginMiddleware;

Route::post('/transactions/notification', [TransactionController::class, 'notification'])
    ->name('transactions.notification');
