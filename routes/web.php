<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EMIController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/loan-details', [EMIController::class, 'showLoanDetails'])->name('loan_details');
Route::post('/process-emi-data', [EMIController::class, 'processEMIData'])->name('process_emi_data');

Route::get('/emi-data', [EMIController::class, 'showEMIPage'])->name('emi-data');