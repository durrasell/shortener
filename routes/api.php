<?php

use App\Http\Controllers\LinkController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\StatisticController;
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
Route::get('check', [MainController::class, 'check']);
Route::any('create', [LinkController::class, 'create']);
Route::get('show/{shortLink}', [LinkController::class, 'get']);
Route::post('statistics', [StatisticController::class, 'statistics']);
