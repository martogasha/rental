<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MpesaController;
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

Route::get('hh', function () {
    return view('welcome');
});
Route::get('/', [IndexController::class, 'index']);
Route::get('property', [IndexController::class, 'property']);
Route::get('houses/{id}', [IndexController::class, 'houses']);
Route::get('transaction', [IndexController::class, 'transaction']);
Route::get('billing', [IndexController::class, 'billing']);
Route::get('lease', [IndexController::class, 'lease']);
Route::get('editProperty', [IndexController::class, 'editProperty']);
Route::get('editHouse', [IndexController::class, 'editHouse']);
Route::get('viewHouses', [IndexController::class, 'viewHouses']);
Route::get('addLease/{id}', [IndexController::class, 'addLease']);
Route::get('mpesaTransaction', [MpesaController::class, 'mpesaTransaction']);
Route::get('bankTransaction', [MpesaController::class, 'bankTransaction']);
Route::get('chequeTransaction', [MpesaController::class, 'chequeTransaction']);
Route::get('customer/{id}', [MpesaController::class, 'customer']);
Route::get('customerPaid/{id}', [MpesaController::class, 'customerPaid']);
Route::get('invoice/{id}', [MpesaController::class, 'invoice']);
Route::get('invoicePaid/{id}', [MpesaController::class, 'invoicePaid']);
Route::get('paidInvoice', [MpesaController::class, 'paidInvoice']);
Route::get('sendMail', [MailController::class, 'sendMail']);

Route::post('storeProperty', [IndexController::class, 'storeProperty']);
Route::post('storeHouse', [IndexController::class, 'storeHouse']);
Route::post('eProperty', [IndexController::class, 'eProperty']);
Route::post('ehouse', [IndexController::class, 'ehouse']);
Route::post('storeLease', [IndexController::class, 'storeLease']);
Route::post('storeBill', [IndexController::class, 'storeBill']);
Route::post('storeTransaction', [IndexController::class, 'storeTransaction']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
