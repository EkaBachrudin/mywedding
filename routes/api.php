<?php

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

//User Area
Route::group(['middleware' => ['auth']], function () {
});
