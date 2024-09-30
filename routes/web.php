<?php

use App\Http\Controllers\UserController;
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

Route::get('/', function () {    
    return view('register');
});

Route::view('/login', 'login')->name('login');
Route::post('/register', [UserController::class, 'store'])->name('register');
Route::post('/login', [UserController::class, 'authenticate'])->name('login.post');
Route::get('/dashboard', [UserController::class, 'dashboardPage'])->name('dashboard')->middleware('auth');
Route::get('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');