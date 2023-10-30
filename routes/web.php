<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::group(['middleware' => ['prevent-back-history']], function () {
    // Home 
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Auth (login & logout)
    Route::get('/login', [AuthController::class, 'index'])->middleware('guest');
    Route::post('/login', [AuthController::class, 'authenticate'])->middleware('guest')->name('login');
    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
});