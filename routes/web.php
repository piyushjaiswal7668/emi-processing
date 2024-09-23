<?php

use App\Http\Controllers\LoanDetailsController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();
Route::get('/home', [LoanDetailsController::class, 'index'])->name('loan.details');
Route::post('/process-emi', [LoanDetailsController::class, 'processEmi'])->name('process.emi');

Route::get('/logout', function() {
    Auth::logout();
    return redirect('/login');
})->name('logout');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
