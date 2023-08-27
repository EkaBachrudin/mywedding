<?php

use App\Http\Controllers\adm\AdminContoller;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Admin Area
Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/', [Controller::class, 'index']);
    Route::get('/administrator', [AdminContoller::class, 'administrator']);
    Route::post('createguest', [AdminContoller::class, 'customRegistration']);
    Route::get('getguest/{id}', [AdminContoller::class, 'getGust']);
    Route::post('updateguest/{id}', [AdminContoller::class, 'updateGuest']);
    Route::post('deleteguests', [AdminContoller::class, 'deleteGuest']);
});

require __DIR__ . '/auth.php';
