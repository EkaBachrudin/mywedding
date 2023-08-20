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
    Route::get('/administrator', [AdminContoller::class, 'index']);
    Route::post('createguest', [AdminContoller::class, 'customRegistration']);
});

//User Area
Route::group(['middleware' => ['auth']], function () {
});

require __DIR__ . '/auth.php';
