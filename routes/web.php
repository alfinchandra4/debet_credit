<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DebitController;
use App\Http\Controllers\HistoryController;
use App\Models\DebitCredit;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('dashboard')->group(function() {
    Route::get('/', [DashboardController::class, 'index']);
});

Route::prefix('debit')->group(function() {
    Route::get('/', [DebitController::class, 'index'])->name('debit');
    Route::post('/', [DebitController::class, 'store'])->name('debit-store');
    Route::get('/delete/{debit_id}', [DebitController::class, 'delete'])->name('debit-delete');
});

Route::prefix('credit')->group(function() {
    Route::get('/', [CreditController::class, 'index'])->name('credit');
    Route::post('/', [CreditController::class, 'store'])->name('credit-store');
    Route::get('/delete/{credit_id}', [CreditController::class, 'delete'])->name('credit-delete');
});

Route::prefix('history')->group(function() {
    Route::get('/', [HistoryController::class, 'index'])->name('history');
    Route::post('/check', [HistoryController::class, 'check'])->name('history-check');
});

Route::prefix('category')->group(function() {
    Route::get('/', [CategoryController::class, 'index'])->name('category');
    Route::post('/', [CategoryController::class, 'store'])->name('category-store');
    Route::get('/delete/{category_id}', [CategoryController::class, 'delete'])->name('category-delete');
});

//
