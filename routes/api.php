<?php

use App\Http\Controllers\usr\GreetingsController;
use App\Http\Controllers\usr\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('getuser/{random_string}', [UserController::class, 'getUser']);
Route::get('count-atten', [UserController::class, 'countAttenConfirm']);
Route::post('attent-confirm', [UserController::class, 'attentConfirm']);
Route::post('attent-unconfirm', [UserController::class, 'attentUnConfirm']);

Route::get('greetings', [GreetingsController::class, 'getAllGreetings']);
Route::post('greeting', [GreetingsController::class, 'sendGreetings']);




//User Area
Route::group(['middleware' => ['auth']], function () {
});
