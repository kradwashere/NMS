<?php

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

Route::get('/', function () {return inertia('Auth/Login'); });
Route::middleware(['auth'])->group(function () {
    Route::resource('/home', App\Http\Controllers\HomeController::class);
    Route::resource('/transportations', App\Http\Controllers\TransportationController::class);
    Route::resource('/names', App\Http\Controllers\NameController::class);
    Route::resource('/loans', App\Http\Controllers\LoanController::class);
    Route::resource('/expenses', App\Http\Controllers\ExpenseController::class);
});

require __DIR__.'/auth.php';