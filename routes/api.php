<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Reset data in database table accounts
Route::post('/reset', [AccountController::class, 'resetAccount']);
// Get balance for non-existing account
Route::get('/balance', [AccountController::class, 'getBalance']);
// Create account with initial balance
Route::post('/event', [AccountController::class, 'createAccountBalance']);


