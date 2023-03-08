<?php

use App\Http\Controllers\DoorParamController;
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

Route::name('door-params')->prefix('door-params')->group(function () {
    Route::get('', [DoorParamController::class, 'getDoorParams']);
    Route::post('send', [DoorParamController::class, 'sendNotification']);
});