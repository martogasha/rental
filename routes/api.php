<?php

use App\Http\Controllers\MpesaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//mpesa routes
Route::get('authenticate', [MpesaController::class, 'authenticate']);
Route::get('subscribe', [MpesaController::class, 'subscribe']);
Route::get('stkPush', [MpesaController::class, 'stkPush']);
Route::post('storeWebhooks', [MpesaController::class, 'storeWebhooks']);
