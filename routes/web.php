<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
Route::get('/login',[UserController::class,'login'])->name('login');

Route::get('auth/google', [UserController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [UserController::class, 'handleGoogleCallback']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard',[DashboardController::class,'index']);
    Route::get('/logout', [UserController::class, 'logout']);

    Route::get('customer/exportcsv', [DashboardController::class, 'exportCSV'])->name('customer.exportcsv');
    Route::post('customer/import',  [DashboardController::class, 'importCSV'])->name('customer.import');
});

