<?php

use App\Http\Controllers\IndexController;
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
Route::get('customers', [IndexController::class, 'customers']);
Route::get('lease', [IndexController::class, 'lease']);
Route::get('editProperty', [IndexController::class, 'editProperty']);
Route::get('editHouse', [IndexController::class, 'editHouse']);
Route::get('viewHouses', [IndexController::class, 'viewHouses']);
Route::get('addLease/{id}', [IndexController::class, 'addLease']);

Route::post('storeProperty', [IndexController::class, 'storeProperty']);
Route::post('storeHouse', [IndexController::class, 'storeHouse']);
Route::post('eProperty', [IndexController::class, 'eProperty']);
Route::post('ehouse', [IndexController::class, 'ehouse']);
Route::post('storeLease', [IndexController::class, 'storeLease']);

