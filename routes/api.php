<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

Route::post('/transactions/notification', [TransactionController::class, 'notification'])
    ->name('transactions.notification');


