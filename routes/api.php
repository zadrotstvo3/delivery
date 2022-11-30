<?php

use App\Http\Controllers\DeliveryController;
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

Route::get('/delivery', [DeliveryController::class, 'index'])->name('delivery.index');
Route::get('/delivery/{id}', [DeliveryController::class, 'show'])->name('delivery.show');
Route::post('/delivery', [DeliveryController::class, 'store'])->name('delivery.store');
Route::put('/delivery/{id}', [DeliveryController::class, 'update'])->name('delivery.update');






