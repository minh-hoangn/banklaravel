<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;



//show input form và list account id và balance
Route::get('/balance', [AccountController::class, 'getBalance'])->name('balance');
//reset data trong table accounts
Route::post('/reset', [AccountController::class, 'resetAccount'])->name('reset');
//tạo account, nộp tiền, rút tiền và chuyển tiền
Route::post('/event', [AccountController::class, 'createAccountBalance'])->name('event');
